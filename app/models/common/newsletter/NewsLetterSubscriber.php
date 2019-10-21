<?php

/**
 * @backupGlobals disabled
 */
class NewsLetterSubscriber extends Model1 implements Model1ActionInterface {


    public $id = 0;
    public $full_name = '';
    public $phone_number = '';
    public $email = '';

    public $is_active = 1;
    public $is_unsubscribed = 0;
    public $unsubscribed_reason = null;



    /**
     * @return mixed|Xcrud
     */
    static function manage(){
        return self::xcrud()
            ->columns('updated_at, created_at, id', true)
            ->fields('created_at, updated_at', true)
            ->unset_title();
    }



    /**
     * @return mixed|array
     */
    static function getMenuList() {
        return Auth1::isAdmin()? [
            'Newsletter'=>[ Dashboard::getManageUrl(self::class)=>'<i class="fa fa-book"></i><span> Subscribers Emails</span>', ]
        ]: [];
    }


    static function onRoute($route){

    }



    /**
     * Dashboard Menu
     * @return array
     */
    static function getDashboard() { return []; }



    /**
     * Save  Model Information
     * @param $id
     * @return null
     *
     */
    static function processSave($id = null){
        // validate and inset
        if(!empty(request()->email) && !Validation1::validateEmail(request()->email)) return Session1::setStatus('Invalid Email Address!', 'Please include a valid email', 'error');
        if(empty(request()->email) && empty(request()->phone_number)) return Session1::setStatus('No Data Set!', 'Please set Email address or Phone number', 'error');

        // add full name if null
        $_REQUEST['full_name'] = String1::isset_or($_REQUEST['full_name'], Form1::extractUserName($_REQUEST['email'], false));
        if(isset($_REQUEST['is_unsubscribed'])){
            $_REQUEST['is_active'] = 0;
            $_REQUEST['is_unsubscribed'] = 1;
            $status = ['UnSubscribed Successful', 'We have removed you from our mail list, we will miss you, please subscribe back if you change your mind', 'success'];
        }else{
            $_REQUEST['is_active'] = 1;
            $_REQUEST['is_unsubscribed'] = 0;
            $status = ['Thanks for subscribing', 'We will mail you from now on', 'success'];
        }

        // save
        $result = self::insertOrUpdate($_REQUEST, [], 'AND', !empty(request()->email)? 'email': 'phone_number');
        if(!$result) $status = ['Failed', $result->getMessage(), 'error'];
        return Session1::setStatusFrom($status);
    }


}