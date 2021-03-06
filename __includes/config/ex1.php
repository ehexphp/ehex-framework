<?php
/**
 * Created by PhpStorm.
 * User: samtax
 * Date: 08/07/2018
 * Time: 11:00 AM
 */


class exApp1{
    /**
     * App debug status
     * @return bool
     */
    static function isDebugMode(){ return is_debug_mode(); }

}

class exClass1 {
    /**
     * @param bool $removePage
     * @return array
     */
    static function appModelList($removePage = true){ return app_model_list($removePage); }

    /**
     * @return array
     */
    static function appControllerList(){ return app_controller_list(); }

    /**
     * @return array
     */
    static function appApiList(){  return app_api_list(); }

    /**
     * @return array
     */
    static function appPageList(){ return app_page_list(); }

    /**
     * @return array
     */
    static function appDashboardList(){ return app_dashboard_list(); }
}



class exBlade1 {
    // View
    static $LOADED_VIEW_AND_CACHE_LIST = [];
    static $CURRENT_LAYOUT_PATH = null; // editted in Blade->Compiler.php or Factory.php

    /**
     * return active theme path
     * @see /Applications/MAMP/htdocs/Project-Ehex/includes/__PhpLibrary/blade-5.4/src/Compilers/Concerns/CompilesLayouts.php
     */
    static function getLoadedViewAndCachedPath(){  return self::$LOADED_VIEW_AND_CACHE_LIST; }

    /**
     * get Compiled View from Blade Path
     * @see view_make()
     * @param $view_name
     * @param array $param
     * @return string
     * @throws Throwable
     */
    static function getCompiledView($view_name, $param = []){  return view_make($view_name, $param); }

    /**
     * get Compiled View from String
     * @see view_maker()
     * @param $bladeString
     * @param array $param
     * @return string
     */
    static function getCompiled($bladeString, $param = []){  return view($bladeString, $param); }


    /**
     * Show and Render Compiled View
     * @see view()
     * @param $view_name
     * @param array $param
     */
    static function renderView($view_name, $param = []){  view($view_name, $param); }

    /**
     * Convert a normal file Path to View (. including view path), Used when you are getting all view and you needs to convert them to real view path for route to access
     * @see get_all_view_in_directory()
     * @see exBlade1::getAllViewInDirectory()
     * @see exBlade1::convertViewPathToPath()
     * @param $fileFullPath
     * @return mixed
     */
    static function convertPathToViewPath($fileFullPath){  return path_to_viewpath($fileFullPath); }

    /**
     * Opposite of path_to_viewpath() convert view to it equal file system path
     * @see exBlade1::convertPathToViewPath()
     * @param $viewPath
     * @return string
     */
    static function convertViewPathToPath($viewPath){  return viewpath_to_path($viewPath); }

    /**
     * Used to list all view in certain directory
     * @param $fileFullPath
     * @param bool $viewNameOnly
     * @param bool $recursive
     * @return array|null
     */
    static function getAllViewInDirectory($fileFullPath, $viewNameOnly = false, $recursive = false){  return get_all_view_in_directory($fileFullPath, $viewNameOnly, $recursive); }
}



class exForm1{
    /**
     * Used in Db Smart Error Handler... to Create table or reset it on the Go
     * @param string $className Must extend ServerRequest, Api1, Controller or Model1
     * @param string $functionName , method to Run
     * @param null $titleName
     * @return string
     */
    static function makeRunnableForm($className = Controller1::class, $functionName = '', $titleName = null){
        return  "<form action='".Form1::callController($className, $functionName)."' method='post'>".form_token()."<button style='padding:10px; border:5px solid #2295bc;font-size:12px;border-radius:20px;' type='submit' type='btn btn-primary'>".($titleName? $titleName: "Run ".$className."::$functionName Now")."</button></form>";
        //<a href='".Form1::callController($className, $functionName).'?_token='.token()."'> Run </a>
    }
}




class exUrl1 extends Url1 {

    /**
     * Get any sent request like $_GET, $_POST and $_FILES... Also all value are being normalized.
     * Checkbox value are set to either true of false, and files are well arrange, in Parameter, Set the Names
     * @param array $insertOrReplaceKeyValue :override any request data or add new one to it
     * @param array $filterCheckBoxNameList : convert boolean on and off to php boolean true and false
     * @param array $filterFileUploadNameList ; normalize file name very well, use in Ehex Sample blog
     * @return mixed
     */
    static function request(array $insertOrReplaceKeyValue = [], array $filterCheckBoxNameList = [], array $filterFileUploadNameList = []){ return request($insertOrReplaceKeyValue, $filterCheckBoxNameList, $filterFileUploadNameList); }


    /**
     * Create Route
     * @param $name
     * @param $function\
     */
    static function makeRoute($name, $function){ make_route($name, $function); }


    /**
     * Return all Menu, can be accessed through routes()->login
     * @param array $except
     * @param bool $listAsMenu
     * @param array $renameLinkName_oldName_equals_newName
     * @return ArrayObject|mixed
     */
    static function routes($except = [], $listAsMenu = false, $renameLinkName_oldName_equals_newName = []){ return routes($except, $listAsMenu, $renameLinkName_oldName_equals_newName); }

    /**
     * @param null $path
     * @return string
     */
    static function url($path = null){ return url($path); }

    /**
     * @param $viewPageName
     * @param array $param
     * @param bool $actionResult
     * @param array $trueMessage
     * @param array $falseMessage
     * @return string
     */
    static function redirectToView($viewPageName, array $param = [], $actionResult = false, $trueMessage = [], $falseMessage = []){ return redirect_to_view($viewPageName, $param, $actionResult, $trueMessage, $falseMessage); }

    /**
     * Navigate to any menu
     * @param $name
     * @param array $param_data
     * @return Route|RouteSystem|string
     */
    static function route($name, $param_data = []){ return route($name, $param_data); }

    /**
     * @return RouteRequest
     */
    static function getCurrentRoute(){ return RouteRequest::instance(); }

    /**
     * @param $inputVariable
     * @param $default
     * @return mixed|string
     */
    static function old($inputVariable, $default){ return old($inputVariable, $default); }

    /**
     * @param $view_name
     * @param array $param
     */
    static function view($view_name, $param = []){  view($view_name, $param); }


    /**
     * delete all cache
     */
    static function pathClearCache(){ path_clear_cache(); }

    /**
     * Get Assets files
     * @param string $path
     * @param bool $findInSharedAssets
     * @return string
     */
    static function asset($path = '', $findInSharedAssets = false){ return asset($path, $findInSharedAssets); }

    /**
     * Add to Every Template to Register Template/assets folder for layout_assets(...) method use.
     * @param null $optional_layoutViewPath_or_layoutFullPath
     * @param int $backtrace_index
     * @return string
     */
    static function registerPathForLayoutAsset($optional_layoutViewPath_or_layoutFullPath = null, $backtrace_index = 1){ return register_path_for_layout_asset($optional_layoutViewPath_or_layoutFullPath, $backtrace_index); }

    /**
     * Locate Layout assets path automatically with the help of passed in exUrl1::registerPathForLayoutAsset()
     * @see exUrl1::registerPathForLayoutAsset()
     * @param string $filename
     * @param null $layout_name
     * @param string $assets_folder_name
     * @return string
     *
     */
    static function layoutAsset($filename = '', $layout_name = null, $assets_folder_name = 'assets'){ return layout_asset($filename, $layout_name, $assets_folder_name); }

    /**
     * Use in your layout  to get current location of layout assets
     * @see current_layout_asset()
     * @param string $file_path_name
     * @param string $assets_folder_name
     * @return mixed
     *
     */
    static function currentLayoutAsset($file_path_name = '', $assets_folder_name = 'assets'){  return current_resources_asset_path($file_path_name, $assets_folder_name, '/resources/views/layouts/',  '/shared/resources/views/',  'layout_list', 1); }

    /**
     * Use in your plugin to get current location of plugin assets
     * @see current_plugin_asset()
     * @param string $file_path_name
     * @param string $assets_folder_name
     * @return mixed
     *
     */
    static function currentPluginAsset($file_path_name = '', $assets_folder_name = 'assets'){  return current_resources_asset_path($file_path_name, $assets_folder_name, '/resources/plugins/', '/shared/resources/plugins/', 'plugin_list', 1); }

    /**
     * Verify if url exists or use default
     * @param string $url
     * @param string $default
     * @return string
     */
    static function pathUrlExistsOr($url = '', $default = '...'){ return path_url_exists_or($url, $default); }


    /**
     * Get APp Path
     * @param string $path
     * @return string
     */
    static function pathApp($path = ''){ return path_app($path); }



    /**
     * Main Project DIrectory
     * @param string $path
     * @return string
     */
    static function pathMain($path = ''){ return path_main($path); }

    /**
     * @param string $path
     * @return string
     */
    static function pathAsset($path = ''){ return path_asset($path); }

    /**
     * @param string $path
     * @param bool $findInSharedAssets
     * @return string
     */
    static function pathAssetUrl($path = '', $findInSharedAssets = false){ return path_asset_url($path, $findInSharedAssets); }

    /**
     * @param string $path
     * @return string
     */
    static function pathMainUrl($path = ''){ return path_main_url($path); }


    /**
     * shared path
     * @param string $path
     * @param string $directory
     * @return string
     */
    static function pathShared($path = '', $directory = ''){ return path_shared($path, $directory); }

    /**
     * @param string $path
     * @return string
     */
    static function pathSharedResources($path = ''){ return path_shared_resources($path); }


    /**
     * @param string $path
     * @return string
     */
    static function pathSharedApp($path = ''){ return path_shared_app($path); }

    /**
     * @param string $path
     * @return string
     */
    static function pathSharedAssetUrl($path = ''){ return path_shared_asset_url($path); }


    // resource path
    static function resourcesPath() { return resources_path(); }

    /**
     * @return string
     */
    static function resourcesPathView() { return resources_path_view(); }

    /**
     * @return string
     */
    static function resourcesPathCache() { return resources_path_cache(); }

    /**
     * @return string
     */
    static function resourcesPathAsset() { return resources_path_asset(); }

    /**
     * @param string $isShared
     * @return string
     */
    static function resourcesPathPlugin($isShared = ''){ return resources_path_plugin($isShared); }

   /**
     * @param string $isShared
     * @return string
     */
    static function resourcesPathViewLayout($isShared = ''){ return resources_path_view_layout($isShared); }


    /**
     * get all model path
     * @return array
     */
    static function appClassPaths(){ return app_class_paths(); }

    /**
     * get all list of class type in app
     * @param array $typeList
     * @return array
     */
    static function appClassList($typeList = [Model1::class, Controller1::class, Api1::class]){ return app_class_list($typeList); }


    /**
     * @param $path
     * @return mixed
     *  convert PATH: /application/htdoc/project/image.jpg
     *      to  URL: http://mysite.com/image.jpg
     */
    static function convertPathToUrl($path){ return String1::replaceStart($path, path_main(), path_main_url()); }

    /**
     *  convert URL: http://mysite.com/image.jpg
     *      to  PATH: /application/htdoc/project/image.jpg
     * @param $url
     * @return mixed
     */
    static function convertUrlToPath($url){ return String1::replaceStart($url, path_main_url(), path_main()); }
}

class exRoute1{

    static function instance(){ return RouteApp::instance(); }
    /**
     * @return exRoute1|RouteSystem
     */
    static function getRoute(){ return route(); }
    static function any($name, $action){ return route()->any($name, $action); }
    static function get($name, $action){  return route()->get($name, $action); }
    static function post($name, $action){  return route()->post($name, $action); }
    static function view($name, $viewName, $dataParam = []){ return route()->view($name, $viewName, $dataParam); }
    static function fixed($arrayList = ['error404'=>'pages.common.error404', 'maintenance'=>'layouts.coming_soon.index']){ return route()->fixed($arrayList); }
    static function getDashboardRoute($default = null){ return route()->getDashboardRoute($default); }

    /**
     * Use Model Controller To Fill Route Name Automatically, Your class must implement Controller1RouteInterface
     *  modelName/,   modelName/{id},   modelName/search/{name},   modelName/create,  modelName/{id}/edit, e.t.c
     * @param $name
     * @param string $controllerOrModelClassName
     * @param array $option
     * @return \Illuminate\Routing\PendingResourceRegistration|string
     */
    static function resource($name, $controllerOrModelClassName = '', array $option = []){ return route()->resource($name,  $controllerOrModelClassName, $option); }


    /**
     * Convert all View in Directory to Route. Using the view name as route name
     * @param $viewPath_or_fullPath (path of view e.g pages.auth)
     * @param bool $recursive (allow deep convert)
     * @param string $groupName (group your route, so there won't be name conflict)
     * @param string $routeListHolder (specify return name, in-case you want to add it to be listed out in menu.) e.g  HtmlWidget1::listAndMarkActiveLink(  $allRoute... )
     * @param array $renameRouteName_oldName_equals_newName (re adjust route name)
     */
    static function directory($viewPath_or_fullPath, $recursive = false, $groupName = '/', $routeListHolder = 'route_list', $renameRouteName_oldName_equals_newName = [], $returnOriginalName = false){  route()->directory($viewPath_or_fullPath, $recursive, $groupName, $routeListHolder, $renameRouteName_oldName_equals_newName, $returnOriginalName); }

    /**
     * Get Route Information
     * @see exUrl1::getCurrentRoute() for current route information
     * @return Route|RouteSystem|string
     */
    static function getRoutes(){ return route(); }

    /**
     * Is Certain Route name Exists
     * @param $route
     * @return false|int
     */
    static function isExists($route){ return route()->isExists($route); }
}




class exData1 {

    /**
     * Output
     * @param $records
     * @param int $perPage
     * @param bool $asInfiniteLoad
     * @param array $infiniteLoadConfig
     * @param null $adapterType
     * @param array $config
     * @param string $paginationTemplateClass
     * @param string $pageKeyName
     * @return Paginator|\Strana\RecordSet
     */
    static function paginate($records, $perPage = 10, $asInfiniteLoad = false, $infiniteLoadConfig = [], $adapterType = null, $config = [],  $paginationTemplateClass = DefaultPaginationTemplate::class, $pageKeyName = 'page'){ return paginate($records, $perPage, $asInfiniteLoad , $infiniteLoadConfig, $adapterType, $config,  $paginationTemplateClass, $pageKeyName); }

}


class exTranslate1{
    // Translate Language
    /**
     * @see set_language()
     * @param string $oldLanguage
     * @param string $newLanguage
     * @param string $defaultKey
     */
    static function setLanguage($oldLanguage = 'en', $newLanguage = 'en', $defaultKey = 'default'){  set_language($oldLanguage, $newLanguage, $defaultKey); }

    /**
     * @see get_language()
     * @param $languageText_or_translateKey
     * @return mixed|null|string|string[]
     */
    static function getLanguage($languageText_or_translateKey){ return get_language($languageText_or_translateKey); }

    /**
     * @see get_language()
     * @param $language
     * @return mixed|null|string|string[]
     */
    static function translate($language){ return get_language($language); }

}


class exMail1{
    /**
     * Get View From Template
     * @param string $view_name
     * @param array $param
     * @return string
     * @throws Throwable
     */
    static function getTemplate($view_name = 'emails.welcome', $param = ['userName'=>'Samson Iyanu', 'password'=>'12345']){ return view_make($view_name, $param);  }

    /**
     * @param null $path
     * @return Mailer|\PHPMailer\PHPMailer\PHPMailer
     */
    static function mailer($path = null){ return mailer_config($path); }

    /**
     * @param array $toUserEmail_and_UserName_keyValue
     * @param string $subject
     * @param string $htmlMessageContent
     * @param null $attachmentPath
     * @param null $fromEmail
     * @param null $fromUserName
     * @param bool $exception
     * @param $mailer_instance
     * @return ResultStatus1
     */
    static function mailerSendMailToList($toUserEmail_and_UserName_keyValue = [], $subject = '', $htmlMessageContent ='', $attachmentPath = null, $fromEmail = null, $fromUserName = null, $exception = false, $mailer_instance = null){ return mailer_send_mail_to_list($toUserEmail_and_UserName_keyValue, $subject, $htmlMessageContent, $attachmentPath, $fromEmail, $fromUserName, $exception, $mailer_instance); }

    /**
     * @param $emailName
     * @return string
     */
    static function fakeMailAddress_fromSiteAddress($emailName){ return $emailName.'@'.explode('//', Url1::getSiteMainAddress())[1]; }
}


/**
 * Kindly Find Widget Config Key In .config.php file widget() method
 * Class exWidget1
 */
class exWidget1{
    static function getDisqusCommentBox($key = null){ return "<div id='disqus_thread'></div><script> (function() {  var d = document, s = d.createElement('script'); s.src = 'https://".($key? $key: Config1::widget('disqus')).".disqus.com/embed.js'; s.setAttribute('data-timestamp', +new Date()); (d.head || d.body).appendChild(s); })(); </script><noscript>Please enable JavaScript to view the <a href=\"https://disqus.com/?ref_noscript\">EX Comments powered by Disqus.</a></noscript>"; }

    static function getGoogleAnalytics($google_analytics = null){ return "<script async src=\"https://www.googletagmanager.com/gtag/js?id=".($google_analytics? $google_analytics: Config1::widget('google_analytics'))."\"></script> <script>  window.dataLayer = window.dataLayer || [];  function gtag(){dataLayer.push(arguments);}  gtag('js', new Date()); gtag('config', '".Config1::widget('google_analytics')."'); gtag('ip', '".Url1::getIPAddress()."'); gtag('website', '".Url1::getPageFullUrl()."'); gtag('user_id', '".Auth1::id() ."'); gtag('user_name', '".Auth1::get('user_name', 'guess')."') </script>";}

    static function getJivoLiveChat($jivo_livechat = null){
        return "
        <!-- BEGIN JIVOSITE CODE {literal} --> <script type='text/javascript'>
           (function(){ 
                var widget_id = '".($jivo_livechat? $jivo_livechat: Config1::widget('jivo_livechat'))."';var d=document;var w=window;function l(){
                var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
            
        </script>
        <script>
            function jivo_onOpen() {
                jivo_api.setContactInfo({
                    'name': ".isset_or(Auth1::user()['full_name']).",
                    'email': ".isset_or(Auth1::user()['email']).",
                    'phone': ".isset_or(Auth1::user()['phone_number']).",
                    'description': User Id : ".isset_or(Auth1::user()['id']).", UserName:  ".isset_or(Auth1::user()['user_name'])."
                });
            }
        </script>
        <!-- {/literal} END JIVOSITE CODE -->
        ";
    }

    static function getTawkLiveChat($tawk_livechat = null){
        return "<!--Start of Tawk.to Script--><script type=\"text/javascript\"> var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){ var s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];s1.async=true; s1.src='https://embed.tawk.to/".($tawk_livechat?$tawk_livechat: Config1::widget('tawk_livechat'))."/default'; s1.charset='UTF-8'; s1.setAttribute('crossorigin','*'); s0.parentNode.insertBefore(s1,s0);})();
        </script><!--End of Tawk.to Script-->
        ";
    }
}






/**
 * Class exApiController1
 *  Inbuilt Secured Api caller. because it is using controller1, therefore, it cannot be accessed from outside the app.
 *  Because token is always required.
 */
class exApiController1 extends Api1 {


    /**
     * Auto delete Controller used in deleting model assets. HtmlWidget1::fileDeleteBox()
     * Required :
     *      file_locator_id=$model1FileLocatorId
     *      file_path=/public_html/image.png
     * @return bool
     */
    static function deleteFile(){
        $result = (isset($_REQUEST['file_locator_id']) && $_REQUEST['file_locator_id'] > 0)? Model1FileLocator::delete_fromDb_byFieldName($_REQUEST['file_locator_id'], 'id'): true;
        $result =  @FileManager1::delete(urldecode($_REQUEST['file_path'])) || @$result;
        if($result) Session1::setStatus($result? 'Deleted': 'Action Failed', $result? 'File Deleted!': 'Failed to delete File', $result? 'success': 'error');
        return $result;
    }

    /**
     * could be used to refresh used Model1FileLocator on the go like in exDropZone Plugins
     * Required  model_name, model_id
     * @return bool
     */
    static function fileLocatorReSaveLocalFilesToDb(){ return !!(Model1FileLocator::insertAll_fromFile_toDb( $_REQUEST['model_name']::withId($_REQUEST['model_id']) )); }

    /**
     * could be used to delete all Model1FileLocator image for model on the go like in exDropZone Plugins
     * @return bool
     */
    static function fileLocatorDeleteAllFiles(){ return !!(Model1FileLocator::deleteAll( $_REQUEST['model_name']::withId($_REQUEST['model_id']) )); }
}