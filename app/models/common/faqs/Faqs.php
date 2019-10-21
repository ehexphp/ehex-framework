<?php

/**
 * @backupGlobals disabled
 */
class Faqs extends Model1 implements Model1ActionInterface {

    public $id = 0;
    public $title = '';
    public $category = '';
    public $description = null;
    public $is_active = true;


    /**
     * @return int
     */
    static function getActiveCount(){ return self::count('where is_active = 1');}


    /**
     * Model menu list
     * @return array|mixed
     */
    static function getMenuList() {
        return Auth1::isAdmin()? [
            'FAQs'=> [url('/faqs/create')=>'<i class="fa fa-gear"></i><span> Manage FAQs</span>',]
        ]: [];
    }

    /**
     * Model Route List
     * @param $route
     */
    static function onRoute($route){
        if(Auth1::isAdmin()){
            $route->view('/faqs/create', 'pages.common.faqs.admin.edit');
            $route->get('/faqs/edit/?', function($id){ return view('pages.common.faqs.admin.edit', ['id'=>$id]); });
        } exRoute1::view('/faqs','pages.common.faqs.index');
    }



    /**
     * @return mixed|Xcrud
     */
    static function manage(){
        return self::xcrud()
            // enabled field
            ->columns('updated_at, created_at, id', true)
            ->fields('created_at, updated_at', true)
            // is Active
            ->highlight('is_active', '=', '1', '#4C9F90')
            ->highlight('is_active', '!=', '1', '#F2A24E')
            // edit
            ->button(url('/faqs/edit/{id}'), 'Edit', 'icon-pencil')
            // distraction
            ->unset_edit()
            ->unset_title();
    }



    /**
     * Dashboard Menu
     * @return array
     */
    static function getDashboard(){   return []; }


    /**
     * Save New Model Information
     * @param null $id
     */
    static function processSave($id = null){
        $result = self::insertOrUpdate(request([],['is_active']));
        Session1::setStatus('Done', $result->getMessage());
    }


}