<?php




/**
 * @backupGlobals disabled
 */
class Callback extends Model1 implements Model1ActionInterface  {

    public static $HEADER_TITLE = 'Callback Request';

    public $id = 0;
    public $full_name = '';
    public $phone_number = '';
    public $is_active = true;


    /**
     * @return string
     */
    static function getActiveCount(){ return self::count('where is_active = 1').' / '.self::count(); }












    /**
     * @return mixed|array
     */
    static function onRoute($route){}      static function getMenuList(){
        return Auth1::isAdmin()? [
            'Messages'=>[ Dashboard::getManageUrl(self::class)=>'<i class="fa fa-hashtag"></i><span> Callback Numbers </span>', ],
        ]: [];
    }



    /**
     * @return mixed|Xcrud
     */
    static function manage(){
        // turn read on
        self::updateMany(['is_active'=>0]);

        // fetch old data
        return self::xcrud()
            ->columns('updated_at, created_at, id', true)
            ->fields('created_at, updated_at', true)
            ->order_by('is_active', 'desc')
            //->column_name('is_active', 'As Called')
            ->highlight('is_active', '=', '0', '#ff845b')
            ->highlight('is_active', '=', '1', '#8eff60')
            ->unset_title();
    }





    /**
     * Dashboard Menu
     * @return array
     */
    static function getDashboard(){   return []; }

    /**
     * Save New Model Information
     */
    static function processSave($id = null){
        if( !String1::isSetOr(request()->phone_number) ) return Session1::setStatus('No Phone Number!', 'Please include your phone number', 'error');
        $result = self::insert(request([], ['is_active']));
        if($result)  return Session1::setStatus('Call Request Sent', 'We\'ll call give you a call shortly');
        else return Session1::setStatus('Failed', $result->getMessage(), 'error');
    }
}