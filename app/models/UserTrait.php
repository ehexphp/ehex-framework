<?php

/**
 * @backupGlobals disabled
 */
trait UserTrait {

    /**
     * @return array
     */
    static function getRoles(){ return ['developer', 'admin', 'staff', 'user']; }


    /*
     * Dashboard
     * For Auto Dashboard [ Model1ActionInterface ]
     */
    static function getDashboard(){
        return [
                ['name'=>'All User',    'icon'=>'fa fa-user', 'value'=>User::count(), 'linkName'=>'Visit', 'linkUrl'=>'/user/manage'],
                ['name'=>'Admin',       'icon'=>'fa fa-user', 'value'=>User::count('where role = "admin"'), 'linkName'=>'Visit', 'linkUrl'=>'/user/manage'],
                ['name'=>'Customer',    'icon'=>'fa fa-user', 'value'=>User::count('where role = "user"'), 'linkName'=>'Visit', 'linkUrl'=>'/user/manage'],
                ['name'=>'Editor',      'icon'=>'fa fa-user', 'value'=>User::count('where role = "editor"'), 'linkName'=>'Visit', 'linkUrl'=>'/user/manage'],
            ];
    }

    /**
     * @return HtmlForm1|mixed|Xcrud
     * For Auto Dashboard [ Model1ActionInterface ]
     */
    static function manage(){ return 
    	self::xcrud()
    	->columns('email, user_name, full_name, role, phone_number, sex, address')
    	->unset_title()
        ->limit(50)
    	->change_type('role', 'select', null, Array1::reUseValueAsKey(static::getRoles()))
    	->change_type('sex', 'select', null, Array1::reUseValueAsKey(['male', 'female']))
    	->column_callback('title', [self::class, 'blogTitleAndCommentTotal'])
        ->button(url("/inbox?track_id=".Auth1::id().",{id}"), 'Chat', 'fa fa-wechat');
    	//->unset_add()
        //->unset_print()
        //->unset_csv()
        //->unset_limitlist()
        //->limit(1000)
        //->button(url('/user/edit/{id}'), 'Edit', 'icon-pencil')
    }


    /**
     * Send Activation Email
     * @param string $email
     * @param string $userName
     * @param bool $alert
     * @return ResultStatus1
     */
    static function sendVerificationMail($email = '', $userName = '', $alert = false){
        // $mail_body = "<h3>Welcome to ".Config1::APP_TITLE.".</h3> <p>".Config1::APP_DESCRIPTION."</p> We are happy to have you here...  Please, Kindly verify your account now. $verifyLink <br/><br/><h5>-- Regards from ".Config1::APP_TITLE." --</h5>";
        // $mailResult = exMail1::mailerSendMailToList([$result['email'] => $result['user_name']], Config1::APP_TITLE.' - Account Created Successfully', $mail_body);
        $result = exMail1::mailerSendMailToList([$email => $userName], 'Account Created Successfully', view_make('pages.auth.mail.verify', ['url'=> Form1::callController(static::class.'@processVerifyAccount('.encode_data($email).')') ]));
        if($alert) Session1::setStatus("Mail Result", $result->getMessage(), 'info');
        return $result;
    }









    /**
     * Login Existing User
     */
    static function processLogin(){
        // validate
        Validation1::validate( ['user_name', 'password'], ['user_name'=>'required',  'password'=>'required'], [], [],true);

        // login
        $result = User::login($_REQUEST['user_name'], $_REQUEST['password'], ['user_name', 'id', 'email'], ['password'], true);

        // no result, return with error
        if(!$result){
            return Url1::redirect(Url1::backUrl(), ['Failed', $result->getMessage(), 'error'], $_REQUEST);
        }

        // Send email to user
        // exMail1::mailerSendMailToList([$result->email => $result->user_name], 'Login Successfully', view_make('pages.emails.login')); //null, null, null, true

        // Redirect user to dashboard
        Url1::redirectIf(Session1::getLastAuthUrl(true, routes()->dashboard), '', $result);
    }



    /**
     * Register New User
     */
    static function processRegister(){
        // validate
        Validation1::validate( ['user_name', 'email', 'password'],
            [
                'user_name'=>'required|alpha_num',
                'email'=>'required|email',
                'password'=>'required|min:6',
            ], [], [],true);

        // Register
        $result = User::register($_REQUEST, ['email', 'user_name'], true);

        if(!$result){
            return Url1::redirect(Url1::backUrl(), ['Error Occurred', $result->getMessage(), 'error'], $_REQUEST);
        }

        // save referral
        //UserReferral::createReferral($result->id);

        // upload avatar
        $result->uploadAvatar($_FILES['dp_avatar']['tmp_name']);

        // login
        $login = (boolean) User::login(String1::isset_or($_REQUEST['email'], $_REQUEST['user_name']),  $_REQUEST['password'], ['user_name', 'id', 'email'], ['password'], true);

        // mail
        if(String1::isset_or($result['email'], null)) {
            User::sendVerificationMail($result['email'], $result['user_name']);
        }

        Url1::redirectIf(routes()->dashboard, ['Success', 'Account Successfully Created, Please verify your email'],  $login);
    }


    /**
     * Verify Registered User
     * @param string $email
     */
    static function processVerifyAccount($email = ''){
        $email = @decode_data($email);
        $result =  $email? User::find($email, 'email'): null;
        if($result) $result->update(['status'=>'active']);
        redirect('/dashboard', [$result? 'Account Verified!': 'Failed to Verify Account', $result? 'Welcome back '.$result->full_name.', You are now a full member of '.Config1::APP_TITLE: 'Failed to Verify your Account', $result? 'success': 'error']); // on error, set status
    }




    /**
     * Update User Account
     * @param null $id
     */
    static function processSave($id = null){
        $userInfo = User::getLogin();

        // change profile user name
        if($_POST['user_name'] !== $userInfo->user_name){
            $dataExists = User::selectMany(false, "WHERE (user_name = '".trim($_POST['user_name'])."' OR email = '".trim($_POST['user_name'])."') and not id = $userInfo->id limit 1");
            if (!empty($dataExists)) $_POST['user_name'] = $userInfo->user_name;
        }

        // change profile email
        if($_POST['email'] !== $userInfo->email){
            $dataExists = User::selectMany(false, "WHERE (email = '".trim($_POST['email'])."' OR user_name = '".trim($_POST['email'])."') and not id = $userInfo->id limit 1");
            if (!empty($dataExists)) $_POST['email'] = $userInfo->email;
        }

        // change avatar
        if(isset($_FILES['dp_avatar'])) $userInfo->uploadAvatar($_FILES['dp_avatar']['tmp_name']);

        // filter and disabled primary data
        unset($_POST['avatar'], $_POST['role']);

        // save profile
        if($userInfo->update($_POST)){
            Session1::setStatus('Updated!', 'Profile Updated Successfully', 'success');
            User::re_login();
        }

        // change password
        if(String1::isset_or($_POST['new_password'], null)){
            if(encrypt_validate($_POST['old_password'], $userInfo->password)) {
                $_POST['password'] = encrypt_data($_POST['new_password']);
                Session1::setStatus('Password Re-set', 'Please, Use your new password to Re-login now', 'success');
                $userInfo->update(['password'=>$_POST['password']]);
                Session1::setLastAuthUrl();
                User::re_login();
            }
            else Session1::setStatus('Password not Match', 'Password not Match, Please ensure your old password', 'error');
        }

        Url1::redirect(Url1::backUrl());
    }



    /**
     * Delete Account and Account Data
     */
    static function processDelete(){
        $user_id =  Auth1::id();
        if(!$user_id || $user_id <= 0 ) return;
        //foreach ([UserLocation::class, ] as $model) $model::deleteMany(['user_id'=>$user_id]);
        User::getLogin()->delete(true);
    }



    /**
     * process request
     * Send Credential Mail to User
     */
    static function processForgotPassword(){
        $result =  static::findIn($_REQUEST['user_name'], ['user_name', 'email', 'id']);
        if($result && isset($result[0]['email'])) {
            $result = $result[0];
            $newAccessToken = String1::compressMD5(Math1::getUniqueId());
            User::withId($result['id'])->update(['access_token'=>$newAccessToken]);

            // send mail
            $mail_body = "<h3>Password Reset Requested.</h3> You have requested a password reset, but you can ignore this email if you did not. <a href='".url('/reset_password?access_token='.urlencode($newAccessToken))."'>Click here to reset</a> or Copy this Access Token <h4>".$newAccessToken."</h4> Click reset password menu or 'I have Access Token' on password reset page and input this token along with your new password to reset your account password. <br/><br/><h5>-- Regards from ".Config1::APP_TITLE." --</h5>";
            $mailResult = exMail1::mailerSendMailToList([$result['email'] => $result['user_name']], Config1::APP_TITLE.' - Reset Account Password', $mail_body);
            Url1::redirect(url($mailResult? '/reset_password': '/forgot_password'), ['Password Reset Mail', $mailResult->getMessage()]);    // on success redirect
        }else{
            Session1::setStatus('Account not found', "User with [$_REQUEST[user_name]] not found, Please input a valid user", 'error'); // on error, set status
        }
    }




    /**
     * process request
     * Reset User Account Password
     */
    static function processResetPassword(){
        if(empty(request()->access_token) || empty(request()->password))  return  Session1::setStatus('All Field Required!', 'fill all field please', 'info');

        // fetch user with similar access
        $user = User::find(request()->access_token, 'access_token');
        if(!$user) return  Session1::setStatus('Invalid Token!', 'Token is not valid', 'error');

        // update account
        if($user->update(['password'=>encrypt_data(request()->password), 'access_token'=>''])){
            exMail1::mailerSendMailToList([$user['email'] => $user['user_name']], Config1::APP_TITLE.' - Account Password Reset', '<h2>Password reset successful.</h2> You have successfully reset your account password');
            redirect(url('/login'), ['Password Updated!', ['Profile Updated Successfully', 'Click on login to sign in with your new password'], 'success']);
        }

        return null;
    }





    /**
     * For Auto Dashboard [ Model1ActionInterface ]
     * @return mixed|array
     */
     static function getMenuList() {
        $defaultMenu = [
        	 // include # at the front of the category, to make it expand in the sidebar menu
            '#<span> Dashboard Menu</span>'=>[
                url('/')=>'<i class="fa fa-home"></i><span> Home</span>',
                url('/dashboard')=>'<i class="fa fa-dashboard"></i> <span> Dashboard</span>',
                url('/profile')=>'<i class="fa fa-user"></i><span> Profile</span>',
                url('/logout')=>'<i class="fa fa-sign-out"></i><span> Logout</span>',
            ],
        ];

        if(Auth1::isAdmin()){
            $defaultMenu += ['User List' => [Dashboard::getManageUrl(self::class)=>'<i class="fa fa-user"></i><span> Manage User</span>']];
        }

        return $defaultMenu;
    }




    /**
     * @param exRoute1 $route
     */
    static function onRoute($route){
        $route->view('/user/manage', 'pages.common.dashboard.admin.manage_user');    // manage user
        $route->get('/dashboard', function (){
            echo view( User::isAdmin()? 'pages.common.dashboard.admin.index': 'pages.common.dashboard.user.index');
        });
        $route->view('/user/dashboard',  'pages.common.dashboard.user.index');
        $route->view('/profile', 'pages.common.dashboard.user.profile');

        // auth
        $route->view('/forgot_password','pages.auth.forgot_password');
        $route->view('/reset_password', 'pages.auth.reset_password');

        $isLoginFound = function () use ($route){
            if(User::isLoginExist()) {
                Url1::redirect(url('dashboard'), ['Welcome Back', 'You have logged in already, please Logout out first and try again', 'error']);
            }
            return false;
        };

        $route->get('/register', function() use ($isLoginFound){
            if(!$isLoginFound()) echo view('pages.auth.register');
        });
        $route->get('/login', function() use ($isLoginFound){
            if(!$isLoginFound()) echo view('pages.auth.login');
        });
        $route->get('/logout', function() {
            echo "redirecting...";
            User::logout('/login');
        });
        $route->get('/delete_account', function() {
            User::getLogin(false)->delete();
        });
    }
}