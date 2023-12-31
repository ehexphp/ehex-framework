<?php


/**
 * A Customisable Settings for every page. This model can contain the site
 * social network handles, email addresses, site phone numbers and so on.
 * This model settings does not save to database but instead to file system
 * directly as a file session. This can be manipulated "Model1PageInterface" methods.
 * Please read on Model1PageInterface in documentation. To manipulate and
 * Create similar class
 *
 *
 * This  also serve as a settings class for app theme layout.
 * It generate the settings to use for all layout.
 * You can edit this to suit your need.
 * Class FrontendPage
 */
class FrontendPage  extends Model1 implements Model1PageInterface {

    public $founder = 'XIIP';
    public $about_company = Config1::APP_FANCY_TITLE.'<p>'.Config1::APP_DESCRIPTION.'</p>';

    public $footer_about_us = 'Powerful and Friendly Framework';
    public $footer_terms = '';
    public $footer_privacy = Config1::APP_FANCY_TITLE.' will not in any way or form divulge information gathered during our investigations for our client to a third-party except it has the written consent of such client or required by law.';

    public $privacy_policy = '<p>This website does not share personal information with third parties nor do we store any information about your visit to this website other than to analyze and optimize your content and reading experience through the use of cookies.</p>
        <p>You can turn off the use of cookies at any time by changing your specific browser settings.</p>
        <p>We are not responsible for republished content from this Website on other Websites or websites without our permission.</p>
        <p>This privacy policy is subject to change without notice and was last updated on January 10, 2019. If you have any questions feel free to contact us</p>';

    public $user_access_demo = 2000;
    public $total_happy_customer_demo = 600;
    public $total_review_demo = 489;
    public $total_successful_project_demo = 486;


    // Contact Info
    public $contact_phone_number = '';
    public $contact_address = '';
    public $contact_email = "";
    public $contact_work_hour = "";

    // Social List
    public $social_facebook = 'https://facebook.com/ehex';
    public $social_twitter = 'https://twitter.com/ehexphp';
    public $social_google_plus = 'https://googleplus.com/ehex';
    public $social_instagram = 'https://';
    public $social_pinterest= 'https://pinterest.com/ehex';
    public $social_linked_in = 'https://';
    public $social_youtube= 'https://';
    public $social_github= 'https://';
    public $social_flickr= 'https://';
    public $rss_feed = 'https://';



    /**
     * Save Model Data on Page Update Call
     */
    static function processUpdatePage(){
        Session1::setStatusFrom(static::saveDefault($_POST)? ['Updated', 'Page Updated!', 'success']: ['Failed', 'Failed to Updated Page', 'error']);
    }


    /**
     * Edit Page Variable.
     * This help to maintain dynamic website page
     *   to Use on any web-page, add $frontendPage = FrontendPage::getDefault();
     *   and get model instant data through $frontendPage->variableName
     * e.g
     *  $frontendPage = FrontendPage::getDefault();
     *  echo $frontendPage->about_company;
     * @return HtmlForm1|mixed|Xcrud
     */
    static function manage(){
        return new Html1(function(){
            echo HtmlForm1::open(self::class.'@processUpdatePage()');
            echo self::getDefault()->form([], ['rss_feed'])->setFieldAttribute([
                    'footer_about_us,
                             footer_terms, 
                             footer_privacy,
                             privacy_policy,
                             '=>['type'=>'textarea', 'style'=>'height:300px;width:100%'],
                ])->render();
            echo HtmlForm1::close("Save Page");
        });
    }






    /**
     * Dashboard Logo
     * @return string
     */
    static function logoOnly(){ return asset('images/favicon.png'); }
    static function logoWithText(){ return asset('images/favicon_with_text.png'); }










    /************************************************************************************************************************
     *
     *  MENU
     *
     ************************************************************************************************************************/


    /**
     * Common Menu for layout "ignite_blog"
     * @return array
     */
    static function getMenuCommon(){
        $menuList = [];


        if(Auth1::isGuest()) $menuList = array_merge($menuList, [
            url('login')=>'Login',
            url('register')=>'Register',
            url('#break2')=>'<div style="border:1px solid silver"><!--break----> </div>',
            url('forgot_password')=>'Forgot Password',
            url('reset_password')=>'Reset Password',
            url('#break3')=>'<div style="border:1px solid silver"><!-- break---------> </div>',
        ]);
        else $menuList = array_merge($menuList, [
            url('/dashboard')=>'Dashboard',
            url('#break4')=>'<div style="border:1px solid silver"> <!-- break------> </div>',
            'http://ehex.xamtax.com'=>'Documentation',
        ]);



        $menuList = array_merge($menuList, [
            url('/')=>'Home',
            url('#break5')=>'<div style="border:1px solid silver"><!-- -break- ----> </div>',
            url('contact')=>'Contact Us',
            url('about')=>'About',
            url('founder')=>'About Founder',
            url('#break6')=>'<div style="border:1px solid silver"><!-- break-- -- ----> </div>',
            url('terms_and_condition')=>'Term and Condition',
            url('privacy_policy')=>'Privacy policy',
        ]);

        return $menuList;
    }



    /**
     * Top Menu Header Menu List
     */
    static function getMenuHeaderTop(){
        return [
            url('/')=>'Home',
            url('/product')=>'Products',
            url('/portfolio')=>'Portfolio',
            url('/about')=>'About',
            url('/contact')=>'Contact',
            url('/blog')=>'Blog',
        ];
    }








    /**
     * Header Menu List
     */
    static function getMenuHeader(){
        return [
            url('/home')=>'Home',
            url('/product')=>'Product',
            url('/dashboard')=>'Account',
            url('/blog')=>'Blog',
            url('/about')=>'About',
            url('/contact')=>'Contact',
        ];
    }


    /**
     * Header Menu List
     */
    static function getMenuFooter(){
        return [
            url('/home')=>'Home',
            url('/blog')=>'Blog',
            url('/about')=>'About',
            url('/contact')=>'Contact',
            url('/privacy_policy')=>'Privacy Policy',
            url('/terms_and_condition')=>'Terms And Condition',
            url('/site_map')=>'Sitemap',
        ];
    }


    /**
     * Footer Menu List
     */
    static function getFooterCopyrightBody(){
        return '<strong>Xamtax Technology</strong> All rights reserved - '.date('Y').' &copy; Powered by <a href="'.url('/ehex').'" target="_blank" title="Ehex (ex)">Xamtax Ehex</a>.';
    }

}

