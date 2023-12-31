<?php
/**
 * Project Configuration
 *
 * Framework : Ehex (https://github.com/ehexphp/ehex-framework)
 * Description : Simple, Clean and Comprehensive Framework
 * Author :  Samson Oyetola (samson.oyetola@xamtax.com)
 *
 * This file contains the following configurations:
 *  - Global Environment Variable
 *  - App Life Cycle
 *  - Database/MySQL cofig
 *  - Mail and thirdParties config
 * @package Ehex
 */





class Config1{

    /**
     * Override Config base on the current hostName
     * Retrieve with e.g env("DB_NAME") or getConfig("DB_NAME")
     */
    const ENVs = [
        '.env'=>['http://localhost', 'https://myapp.local'],
        '.prod.env'=>['https://myapp.com']
    ];


    /**
     * Password Encryption Hash. Can generate a new one when you run Db1::help();
     */
    const APP_KEY = 'base64:jxq0fX+1/CQEyvB1kl+xVvW97kvENMT';

    /**
     * Simply Application title
     */
    const APP_TITLE ='Ehex (ex)';

    /**
     * Application title that can include html and css
     */
    const APP_FANCY_TITLE = '<strong>Ehex</strong> <span>Framework</span>';

    /**
     * Website description
     */
    const APP_DESCRIPTION = 'Powerful and Friendly Framework';

    /**
     * Enable CLF Access to class functions.
     */
    const MODELS_CLF_CALLABLE_LIST=["*"];

    /**
     * Add JQUERY to every page automatically. It will add Page1::start(), Page1::end() for every page.
     */
    const AUTO_PAGE_WRAPPER = true;

    /**
     * By default, classes are auto-loaded ahead-of-time. However, you can specify classes to ignore
     */
    const EXCLUDE_AUTOLOAD_CLASS = [];

    /**
     * Developer company info. Optional
     */
    const APP_DEVELOPER_NAME = 'Ehex';
    const APP_DEVELOPER_EMAIL = 'ehex.framework@xamtax.com';
    const APP_DEVELOPER_WEBSITE = 'https://ehex.xamtax.com';


    /**
     * Application Page Route
     * @param exRoute1 $route
     */
    static function onRoute($route) {
        // Test Email Template
        /*$route->get('/', function(){
            echo view_make('pages.emails.verify', [
                'url'=> Form1::callController(User::class.'@processVerifyAccount('.encode_data('hell@gmail.com').')'),
                'content'=> "Hi, <br>Take control of yoe",
            ]);
        });
        return;*/



        /**
         * Turn a view directory to route
         */
        // $route->directory('pages.common');


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
     * @param $req
     * @return bool
     */
    static function onMiddleware($req) {
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
            'file_manager_password'=>env('DB_PASSWORD')
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
