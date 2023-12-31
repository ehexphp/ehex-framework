<?php




class CopyrightInfringement extends Model1 implements Model1ActionInterface {

    public static $HEADER_TITLE = 'Copyright Infringement';

    public $id = 0;
    public $product_link = '';
    public $official_website = '';
    public $description = null;
    public $email = '';
    public $is_active = 1;


    /**
     * @return int
     */
    static function getActiveCount(){ return self::count('where is_active = 1').' / '.self::count(); }


    /**
     * @return mixed|array
     */
    static function getMenuList(){ return []; }
    static function onRoute($route){
        $route->view('/copyright_infringement', 'pages.common.policy.copyright_infringement');
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
        return Auth1::isAdmin()? [
            'Copyright Infringement'=>[ Dashboard::getManageUrl(self::class)=>'<i class="fa fa-book"></i><span> Report List</span>' ]
        ]: [];
    }

    /**
     * Save New Model Information
     * @param null $id
     * 
     */
    static function processSave($id = null) {
        // insert data to db
        $result = self::insertOrUpdate(request(['is_active']));
        Session1::setStatus('Message Sent', $result->getMessage());
    }


}