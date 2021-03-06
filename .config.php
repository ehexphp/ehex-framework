<?php
/**
 * Project Configuration
 *
 * Framework : Ehex (https://github.com/ehexphp/ehex-framework)
 * Description : Simple, Clean and Comprehensive Framework
 * Author :  Samson Oyetola (hello@samsonoyetola.com)
 * Version : version 2.0
 *
 * This file contains the following configurations:
 *  - Global Environment Variable
 *  - App Life Cycle
 *  - Database/MySQL cofig
 *  - Mail and thirdparties config 
 * @package Ehex
 */









class Config1{

    // Database Settings
    //public static $no_db = true;
    const DB_DRIVER = 'mysql'; //sqlite //mysql
    const DB_HOST= 'localhost';
    const DB_NAME= 'project_ex';
    const DB_USER = 'root';
    const DB_PASSWORD = '';

    // APP Information
    const APP_KEY = 'base64:jxq0fX+1/CQEyvB1kl+xVvW97kvENMT';
    const APP_TITLE ='Ehex (ex)';
    const APP_FANCY_TITLE = '<strong>Ehex</strong> <span>Framework</span>';
    const APP_DESCRIPTION = 'Powerful and Friendly Framework';

    // Options
    const DEBUG_MODE = true;
    const DEBUG_IP = [];
    const MAINTENANCE_MODE = false;
    const MODELS_CLF_CALLABLE_LIST = ['*']; 
    const ACCESS_CONTROL_ALLOW_ORIGINAL = ['*'];
    const AUTO_PAGE_WRAPPER = true;    // RECOMMENDED for auto includes of Page1::start(), Page1::end() for every page and JQUERY.

    // auto load
    const INCLUDES_PATH = '__includes';
    const ENABLE_INCLUDES_SHARED = true;
    const EXCLUDE_CLASS = [];

    // APP developer
    const APP_DEVELOPER_NAME = 'Samson Oyetola';
    const APP_DEVELOPER_EMAIL = 'hello@samsonoyetola.com';
    const APP_DEVELOPER_WEBSITE = 'https://samsonoyetola.com';

    // Mail Settings
    const MAIL_HOST = 'smtp.gmail.com'; //; smtp1.example.com; smtp2.example.com
    const MAIL_SMTP_ENCRYPTION = 'tls';
    const MAIL_EMAIL = '@gmail.com';
    const MAIL_PASSWORD = '';
    const MAIL_PORT= '587';
    /*const MAIL_HOST = 'mail.inbata.com';
    const MAIL_SMTP_ENCRYPTION = 'tls';
    const MAIL_EMAIL = 'hello@inbata.com';
    const MAIL_PASSWORD = '***';
    const MAIL_PORT= '26';*/

    // imgur
    const IMGUR_CLIENT_ID = '9c85d34fc4a2ec9';
    const IMGUR_CLIENT_SECRET = '2cc1a5c790ad8dc43fda840da25ea14f6966f1e8';







    /**
     * Application Page Route
     * @param exRoute1 $route
     */
    static function onRoute($route) {

        /**
         * Turn a view directory to route
         */
        //$route->directory('pages.common');


        /**
         * Home Page
         */
        $route->view('/', 'pages.homepage.index');


        /**
         * Compile all model's route
         */
        Dashboard::onRoute($route);

        /**
         * For Dashboard route, Error 404 and Site Under-Construction
         */
        $route->fixed([
            'dashboard_route'=>'dashboard',
            'error404'=>'pages.common.error404',
            'maintenance'=>'pages.common.maintenance_mode'
        ]);

    }


    /**
     * Route Passage
     *
     * @param RouteRequest $req
     * @return bool
     */
    static function onMiddleware(RouteRequest $req) {
        return true;
    }



    /**
     * Execute before page renders
     * All keys will become global variable.
     * @return array (of shared variables)
     */
    static function onPageStart() {
        return ['page_title'=>''];
    }


    /**
     * Execute after page renders
     */
    static function onPageEnd() {}



    /**
     * Create, Alter or Destroy Database model here. 
     * Execute only when DEBUG_MODE is set to TRUE
     */
    static function onDebug(){
       // Db1::tableCreateAll();
         if(isset($_REQUEST['db_init'])) {
            //Db1::tableCreateAll();
            //$firstUser = User::find("user", "role");
            //if($firstUser) $firstUser->update(['role'=>'admin']);
        }
        
    }



    /**
     * Execute when login is successful
     * @param $user : i.e User::getLogin() instance
     */
    static function onLogin(User $user) {  }



    /**
     * Execute when logout
     */
    static function onLogout() { }
    



    /**
     * Widget Configuration
     * Common Widget Located in exWidget1.
     * e.g echo exWidget1::getJivoLiveChat()
     * @param $key
     * @return mixed
     */
    static function widget($key){
        return [
            'disqus'=>'ehex',
            'google_analytics'=>'UA-131446983-1',
            'jivo_livechat'=>'RR6Sdm1ShQ',
            'tawk_livechat'=>'5c40202cab5284048d0d52cd',
            'file_manager_password'=>Config1::DB_PASSWORD
        ][$key];
    }




    /************************************************
     *  Language
     *      Set A list of Language in config -> language()...
     *      Then at the beginning of your page, use set_language(from, to) to set a default language to use
     *          e,g set_language('en', 'ru');
     *      Usage
     *       get_language('signup')
     *       Or  __('signup')
     *          You can also translate a new word
     *          __('Hello world')
     ***********************************************
     * @return array
     */
    static function language(){
        return [
            'lost_password'=>'Lost Your Password',
            'confirm'=>'Are you sure?',
            'signup'=>  [
                'default'=>'Register',
                'ru'=>'kola',
                'yr'=>'dara pomo wa',
            ],
            'login'=>  [
                'default'=>'Login',
                'ru'=>'adLouqd',
                'yr'=>'wole si wa',
            ],
        ];
    }

}
