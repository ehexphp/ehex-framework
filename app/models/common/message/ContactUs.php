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
        if(empty($_REQUEST['description']) || empty($_REQUEST['email'])) return Session1::setStatus('Field Missing', "Fill all the missing Field");
        // insert data to db
        $result = self::insertOrUpdate(request(['is_active']));
        Session1::setStatus('Message Sent', $result->getMessage());
    }


}