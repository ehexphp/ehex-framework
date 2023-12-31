<?php




/**
 * @backupGlobals disabled
 */
class Testimony extends Model1 implements Model1ActionInterface{

    public $id = 0;

    public $star = 4;
    public $full_name = '';
    public $email = '';
    public $description = null;
    public $is_active = true;






    /**
     * @return mixed|Xcrud
     */
    static function manage(){
        // Html Form
        $content = new Html1(function(){
            $old = isset($_REQUEST['id'])? Testimony::find($_REQUEST['id']): Testimony::findOrInit($_REQUEST);//dd($old->is_active);
            echo "<br/><h5>Share a Testimony <a href='".Dashboard::getManageUrl(static::class)."' class='btn btn-primary float-right'>Add New</a></h5>".
                "<form class='row' method='post' action='".Form1::callController("Testimony", "processSave")."'>".
                    form_token().
                    HtmlForm1::addHidden('id', $old->id).
                    HtmlForm1::addHidden('star', 5).
                    "<div class='col-md-4'>".HtmlForm1::addInput('<h6>Your Full Name</h6>', ['name'=>'full_name', 'value'=>String1::isSetOr($old->full_name, Auth1::user()->full_name)])."</div>
                    <div class='col-md-8'>".HtmlForm1::addInput('<h6>Your Email Address</h6>', ['name'=>'email', 'value'=>String1::isSetOr($old->email, Auth1::user()->email)])."</div>
                    <div class='col-md-12'>".HtmlForm1::addTextArea('<h6>Your Testimony</h6>', ['name'=>'description', 'value'=>$old->description, 'rows'=>'10', '+class'=>'richeditor'])."</div>
                    <div class='col-md-12'>".HtmlForm1::addInput("Is Active", ['name'=>'is_active', 'type'=>'checkbox', $old->is_active == 1 ? 'checked': ''])."</div>
                    <div class='col-md-12 mb-5'><button class='btn btn-primary btn-lg btn-block'> Publish Testimony </button></div>
                </form>";
        });

        // Html Table [with role Condition]
        if(User::isRoleWithin( User::getRolesFrom('staff'))){
            $content->append(function(){
                echo "<div class='col-md-12'>
                <br/><h5>Testimony List</h5>".
                self::xcrud()
                    ->columns('updated_at, created_at, id, star', true)
                    ->fields('created_at, updated_at', true)
                    ->order_by('is_active', 'desc')
                    ->highlight('is_active', '=', '1', '#ff845b')
                    ->highlight('is_active', '=', '0', '#8eff60')
                    ->button(Dashboard::getManageUrl(self::class)."&id={id}", 'Edit', 'icon-pencil')
                    ->unset_edit()
                    ->unset_add()
                    ->unset_title().
              "</div>";
            });
        }

        return $content;
    }



    /**
     * @return mixed|array
     */
    static function getMenuList() {
        return [
            'Testimony'=>[
                Dashboard::getManageUrl(self::class)=>'<i class="fa fa-book"></i><span> Testimony</span>',
            ]
        ];
    }


    static function onRoute($route){}


    /**
     * Dashboard Menu
     * @return array
     */
    static function getDashboard() {
        return [];
    }



    /**
     * Save  Model Information
     * @param $id
     */
    static function processSave($id = null) { //dd(request());
        // insert data to db
        $result = self::insertOrUpdate(request([], ['is_active']));
        if($result && isset($_FILES['image']) && !empty($_FILES['image']['name'])) $result->uploadFile(request()->image, $result->id);
        Session1::setStatus('Action Successful', $result->getMessage());
    }


}