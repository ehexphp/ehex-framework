<?php



/**
 * This is a dynamic settings class for your site. if you are using the default dashboard and you want everything to be automatic.
 * It generate the settings to use for dashboard(e.g Dashboard Sidebar menu, And Knows when menu is active, And for admin Page, e.t.c).
 * You can edit this to suit your need.
 * Class Dashboard
 */
class Dashboard {

    /**
     * Model Class to exclude from showing in dashboard and route.
     * @var array
     */
    public static $exclude_models = [];


     /**
     * Dashboard Search
     * @return string
     */
    static function search(){ return redirect('/search?q='.request()->q, null); }

    /**
     * Dashboard Logo
     * @return string
     */
    static function logo(){ return asset('favicon.png', false); }


    /**
     * For Dashboard Notification
     * @return array
     */
    static function getNotification(){
        return [
            'count'=>2,
            'link'=>url('/inbox'),
            'message'=>[
                ['title'=>'Account is Active', 'description'=>'Your Account is Active', 'link'=>'#'],
                ['title'=>'How to use your Dashboard', 'description'=>'Visit Ehex Shards Dashboard Documentation for Your Dashboard tutorial', 'link'=>'#']
            ]
        ];
    }


    /**
     * List of Quick Link
     * For Auto Dashboard [ Model1ActionInterface ]
     * @return array
     */
    static function getDashboard(){
        return [
            ['name'=>'All User',    'icon'=>'fa fa-user',   'value'=>User::count(), 'linkName'=>'Visit', 'linkUrl'=>Dashboard::getManageUrl(User::class)],
        ];
    }










    /************************************************************************************************************************
     *
     * DASHBOARD UTIL
     *
     ************************************************************************************************************************/


   /**
     * For Dashboard optional toggle table management
     * e.g Dashboard::renderOnClick(Car::class,  null, String1::contains(url('/car/manage'), Url1::getPageFullUrl())) 
     * @param $model_name
     * @param $buttonName
     * @param bool $render
     * @return string
     */
    static function renderOnClick($model_name, $buttonName = null, $render = false){
        return "<a name='$model_name'></a>" . ((isset($_GET[$model_name]) || $render)? $model_name::manage()->render(): "<a class='btn-render' style='margin:10px;' href='?allow_xcrud&$model_name#$model_name'>".($buttonName? $buttonName: "Manage ".ucwords(String1::convertToSnakeCase($model_name, ' ')))."</a>");
    }


    /**
     * For Dashboard optional toggle
     * @param $content
     * @param $uniqueButtonName
     * @return string
     */
    static function showOnClick($content, $uniqueButtonName){
        $uniqueHashName = 'view_'.String1::convertWordToSlug($uniqueButtonName, '_');
        return "<a name='$uniqueHashName'></a>" . (isset($_GET["$uniqueHashName"])? $content: "<a style='margin:10px;' href='?allow_xcrud&$uniqueHashName#$uniqueHashName'>".$uniqueButtonName."</a>");
    }



    /**
     * Manage Model On the go with the model Manage Method. A page is already created in dashboard template to handle this
     * @param $modelName
     * @param array $urlParam
     * @return string
     */
    static function getManageUrl($modelName, $urlParam = null){
        $urlParam = $urlParam? array_merge(Url1::getParameter(true), $urlParam? $urlParam: []): null;
        unset($urlParam['model']);
        return  url("/dashboard/manage?model=".urlencode($modelName).(!empty($urlParam)? "&".Url1::buildParameter($urlParam): '').Url1::getLastHashFragment());
    }




    /**
     * Manage Model On the go with permitted user role
     * @return array
     */
    static function getManagePageConfig(){
        return [
            'role'=>User::getRolesFrom('admin'),
            'bypass_model_list'=>["Testimony"],
        ];
    }





















    /************************************************************************************************************************
     *
     *  Compiler for MENU and ROUTE
     *
     ************************************************************************************************************************/

    /**
     * This is for Edit Page Menu, It will list all model and use there manage() function to render them
     * @return array
     */
    static function getPageList(){
        $allModel = app_class_list([AuthModel1::class, Model1::class]);
        $pages = Array1::endsWith($allModel, 'Page');
        return [ '<i class="fa fa-book" aria-hidden="true"></i> Pages List'=> $pages,  '<i class="fa fa-database" aria-hidden="true"></i> Models'=> array_diff($allModel, $pages), ];
    }


    /**
     * get all dashboard model
     * @return array
     */
    static function getDashboardModelList(){
        $all_model = app_class_with_interface(Model1ActionInterface::class, [AuthModel1::class, Model1::class]);
        return array_diff($all_model, self::$exclude_models);
    }

    /**
     * Auto Menu from all Model, Dynamic Menu List
     * @return array
     */
     static function getMenuList(){
         $all_model = self::getDashboardModelList();

        // sidebar compile menu
        $menuBuff = [];
        foreach ($all_model as $model) {
            $menuList = $model::getMenuList();
            if(!is_array($menuList) || empty($menuList)) continue;
            foreach (array_keys($menuList) as $key) {
                $menuItem = $menuList[$key];
                foreach ($menuItem as $menuItemKey=>$menuItemValue){
                    $menuBuff[$key][$menuItemKey] = $menuItemValue;
                }
            }
        }
        return array_merge($menuBuff,  (class_exists("AppSettings")? AppSettings::getMenuList(): []) );
    }



    /**
     * Merge all dashboard model route together
     * @param exRoute1 $route
     */
    static function onRoute($route){
        // dashboard model route
        $all_model = self::getDashboardModelList();
        foreach ($all_model as $model){
            if(method_exists($model, 'onRoute')){
                $model::onRoute($route);
            }
        }

        // app settings
        if(class_exists("AppSettings")) {
            AppSettings::onRoute($route);
        }

        // others and view only route
        $others = [
            // For Quick Model Manage Navigation
            '/dashboard/manage'=> 'layouts.shards_dashboard.pages.manage',
            // others
            '/about'=> 'pages.common.about.index',
            '/terms_and_condition'=> 'pages.common.policy.terms_and_condition',
            '/privacy_policy'=> 'pages.common.policy.privacy_policy',
        ];

        foreach ($others as $url=>$view){
            $route->view($url, $view);
        }
    }












    /************************************************************************************************************************
     *
     *  MENU
     *
     ************************************************************************************************************************/


    /**
     * Compile menu list for admin/user dashboard
     * Side Bar Menu
     * @return array
     */
    static function getMenuSideBar(){
        return static::getMenuList();
    }


    /**
     * Header Menu List
     */
    static function getMenuHeader(){
        $menu = [
            url('/dashboard')=>'<i class="fa fa-user"></i> Dashboard',
            url('/profile')=>'<i class="fa fa-gear"></i> Settings',
            url('/blog')=>'<i class="fa fa-globe"></i> Blog',
        ];
        if(User::isAdmin()){
            $menu[url('blog/manage')] = '<i class="fa fa-picture-o"></i> Manage Blog';
            $menu[url('blog/create')] = '<i class="fa fa-edit"></i> Create Blog';
        }
        return $menu;
    }


    /**
     * Footer Menu List
     */
    static function getMenuFooter(){
        return [
            url('/')=>'Home',
            url('/about')=>'About',
            url('/dashboard')=>'Dashboard',
            url('/contact')=>'Contact',
            url('/blog')=>'Blog',
        ];
    }


    /**
     * Footer Copyright link
     */
    static function getFooterCopyrightBody(){
        return 'Copyright © '.date('Y').' <a href="'.Url1::getDomainName().'" rel="nofollow">'.Config1::APP_TITLE.'</a> Designed by <a href="'.Config1::APP_DEVELOPER_WEBSITE.'" rel="nofollow">'.Config1::APP_DEVELOPER_NAME.'</a>. <br/>Proudly Powered by <a href="https://ehex.xamtax.com" rel="nofollow">Ehex</a>&nbsp;';
    }

}

