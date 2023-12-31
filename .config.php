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
 *  - Mail and thirdParties config
 * @package Ehex
 */









class Config1{

    /**
     * Override Config base on the current hostName
     * Retrieve with e.g env("DB_NAME") or getConfig("DB_NAME")
     */
    const ENVs = [
        '.env'=>['https://sampletrade.local', 'http://localhost'],
        '.prod.env'=>['https://oaktreefinances.com', 'https://test.oaktreefinances.com']
    ];


    // APP Information
    const APP_KEY = 'base64:jxq0fX+1/CQEyvB1kl+xVvW97kvENMT';
    const APP_TITLE ='OakTreeFinances';
    const APP_FANCY_TITLE = '<strong class="text-light" style="font-weight: 800; font-size: 0.7em"> OAK TREE <img style="width: 45px" src="/assets/logo/45.gif" alt="logo" /> FINANCES </strong>';
    const APP_DESCRIPTION = 'OakTreeFinances';

    // auto load
    const MODELS_CLF_CALLABLE_LIST=["*"];
    const AUTO_PAGE_WRAPPER = true;    // RECOMMENDED for auto includes of Page1::start(), Page1::end() for every page and JQUERY.
    const ENABLE_INCLUDES_SHARED = true;
    const EXCLUDE_CLASS = [];

    // APP developer
    const APP_DEVELOPER_NAME = 'iNetTravel';
    const APP_DEVELOPER_EMAIL = 'contact@inettravel.ca';
    const APP_DEVELOPER_WEBSITE = 'https://inettravel.ca';

    // imgur
    const IMGUR_CLIENT_ID = '9c85d34fc4a2ec9';
    const IMGUR_CLIENT_SECRET = '2cc1a5c790ad8dc43fda840da25ea14f6966f1e8';


    /**
     * Application Page Route
     * @param exRoute1 $route
     */
    static function onRoute($route) {
        // Test Email Template
        /*$route->get('/', function(){
            echo view_make('emails.verify', [
                'url'=> Form1::callController(User::class.'@processVerifyAccount('.encode_data('hell@gmail.com').')'),
                'content'=> "Hi, <br>Take control of yoe",
            ]);
        });*/

        $route->view('/', 'index');
        $route->view('/tokenization', 'home_tokenization');
        $route->view('/ai-trading', 'home_ai_trading');
        $route->view('/401k-crypto-investment', 'home_401k_investment');
        $route->view('/terms-and-conditions', 'terms_and_condition');
        $route->view('/privacy-policy', 'privacy_policy');
        $route->view('/about', 'about');
        $route->view('/dashboard', 'dashboard');

        $route->view('/admin', 'admin');

        $route->view('/contact', 'contact');
        $route->view('/login', 'login');
        $route->view('/register', 'register');
        $route->view('/profile', 'profile');


        $route->view('/deposit', 'deposit');
        $route->view('/withdraw', 'withdraw');
        $route->view('/transactions/history', 'transactions');

        $route->view('/investments/create', 'create_investment');
        $route->view('/investments/transactions', 'investments');


        $route->get('/logout', function(){
            echo "redirecting...";
            User::logout('/login');
        });

        /**
         * Compile all model's route
         */
        // Dashboard::onRoute($route);

        /**
         * For Dashboard route, Error 404 and Site Under-Construction
         */
        $route->fixed([
            // 'dashboard_route'=>'dashboard',
            // '/error404'=>'common/error404',
            '/error404'=>'common.error404',
            '/maintenance'=>'common.maintenance_mode'
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
