<?php

/**
 * @backupGlobals disabled
 */
class ContactUs extends Model1 implements Model1ActionInterface {

    public $id = 0;
    public $full_name = '';
    public $phone_number = '';
    public $subject = null;
    public $description = null;
    public $email = '';
    public $is_active = true;


    /**
     * @return int
     */
    static function getActiveCount(){ return self::count('where is_active = 1').' / '.self::count(); }




    static function getMenu(){
        $content = <<<HTML
            <nav> 
                <ul class="list-group">
                    <li class="list-group-item">Email Us</li>
                    <li class="list-group-item">Call Us</li>
                </ul>
            </nav>
HTML;
        die($content);
    }









    /**
     * @return mixed|array
     */
    static function getMenuList(){
        return Auth1::isAdmin()? [
            'Messages'=>[ Dashboard::getManageUrl(self::class)=>'<i class="fa fa-briefcase"></i><span> Contact Us </span>', ],
        ]: [];
    }


    /**
     * Model Route List
     * @param $route
     */
    static function onRoute($route){
       exRoute1::view('/contact', 'pages.common.contact.index');
    }


    /**
     * @return mixed|Xcrud
     */
    static function manage(){
        self::updateMany(['is_active'=>0]);
        return self::xcrud()
            ->columns('updated_at, created_at, id', true)
            ->fields('created_at, updated_at', true)
            ->unset_title();
    }



    /**
     * Dashboard Menu
     * @return array
     */
    static function getDashboard(){
        return [
            ['name'=>'Total Messages',    'icon'=>'fa fa-user', 'value'=>self::count(), 'linkName'=>'Visit', 'linkUrl'=>'#'],
            ['name'=>'Unread Messages',       'icon'=>'fa fa-user', 'value'=>self::count('where is_active = "1"'), 'linkName'=>'Visit', 'linkUrl'=>'#'],
            ['name'=>'Read Messages',       'icon'=>'fa fa-user', 'value'=>self::count('where is_active = "0"'), 'linkName'=>'Visit', 'linkUrl'=>'#'],
        ];
    }

    /**
     * Save New Model Information
     */
    static function processSave($id = null) {
        if(empty($_REQUEST['description']) || empty($_REQUEST['email']))
            return Session1::setStatus('Field Missing', "Fill all the missing Field");


        $result = Url1::sendEmail(Config1::MAIL_EMAIL, "Message from ".Config1::APP_TITLE, "
            FullName: $_REQUEST[full_name] \n
            Email: $_REQUEST[email] \n
            description: $_REQUEST[description] \n
        ", $_REQUEST["email"], $_REQUEST["full_name"]);

        // insert data to db
        $result2 = self::insertOrUpdate(request(['is_active']));

        if(!$result)
            Session1::setStatus('Message Saved', "We failed to send an email at the moment, but we have saved a copy into our system where we can see it. You can also contact us via ".Config1::MAIL_EMAIL." should you have emergency", "success");
        else
            Session1::setStatus('Message Sent', "We will get back to you shortly", "success");
        return null;
    }



}