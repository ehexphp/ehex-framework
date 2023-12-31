<?php



/**
 * @backupGlobals disabled
 */
class User extends AuthModel1 implements Model1ActionInterface {

    // CLF config
    public static $CLF_BYPASS_TOKEN_LIST = ['processVerifyAccount', 'sendVerificationMail'];
    //public static $CLF_CALLABLE_LIST = [];


    // import User trait
    use UserTrait;

    // Basic Field
    public $id = 0;
    public $email = '';
    public $sex = '';
    public $avatar = '';
    public $full_name= '';
    public $user_name = '';
    public $phone_number = '';
    public $password = '';

    // Secondary Field
    public $status = 'inactive';
    public $as_paid = false;
    public $role = 'user';
    public $zip_code = '';
    public $country = '';
    public $state = '';
    public $city = '';
    public $address = null;
    public $access_token = '';
    public $birth_date = null;
    public $work_title = '';

    // Others Information
    public $followers_id_list = null;
    public $following_id_list = null;
    public $about = null;
    public $website = '';
    public $office_number = '';

    // link information (for ex_socialite OAuth)
    public $registered_via = null;
    public $facebook_user_id = '';
    public $github_user_id = '';
    public $google_user_id = '';
//    public $linkedin_user_id = '';
//    public $outlook_user_id = '';
//    public $weibo_user_id = '';
//    public $qq_user_id = '';
//    public $wechat_user_id = '';
//    public $douban_user_id = '';


    // Custom Fields
    public $account_balance = 0;





    public function getApplication(){
        $application = Application::find($this->id, "user_id");
        return empty($application)? new Application(): $application;
    }

    public function getTotalBalance(){
       return $this->account_balance + Investment::count("where user_id = '$this->id' ", ["sum(gain_amount) as data"], true);
    }

}