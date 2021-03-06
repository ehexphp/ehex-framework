<?php

/************************************************
 *  Ehex Helper Function
 ***********************************************/
global $__ENV; $__ENV = [];//Class1::getClassStaticVariables(Config1::class);


/**
 * When trying to get config property, The config($key) first check the $__ENV global variable,
 * if not found, it then check the config class const variables if const is defined, otherwise, it just use the default_value.
 * Override the config from the app startup page with config_init($keyValueArray)
 * Access config data through $__ENV or config();
 * @param null $key
 * @param string $default_value
 * @return Config1|mixed
 */
function config($key, $default_value = null){
    global $__ENV;
    if(isset($__ENV['__config_constant'][$key])) return $__ENV['__config_constant'][$key];
    $configVar = "Config1::$key";
    if(defined($configVar)) return constant($configVar);
    return $default_value;
}

/**
 * Put this in your config onPageStart() to override the default config const variables
 * @param array $keyValueArray
 */
function config_init($keyValueArray = []){
    global $__ENV;
    foreach ($keyValueArray as $key=>$value) $__ENV['__config_constant'][$key] = $value;
}


//=======[ Break and Print ]===========

/**
 * Get Frame work Info
 * @return array
 */
function framework_info(){
    return Object1::toArrayObject(true, [
        'name'=>'ehex',
        'alias'=>'ex',
        'description'=>'friendly, fast, simple and powerful php framework',
        'version'=>'2.0',
        'website'=>'https://ehex.xamtax.com',
        'author'=>[
            'name'=>'Samson Oyetola',
            'alias'=>'Samtax',
            'email'=>'hello@samsonoyetola.com',
            'website'=>'https://xamtax.com',
        ],
    ]);
}

/**
 * Use for debugging and end page
 * @param mixed ...$logArr
 * @return string '';
 */
function dd(...$logArr){
    echo "<script> dd(".Array1::toJSON($logArr).") </script>";
    Page1::$FLAG_SHOW_LOAD_TIME = true;
    Page1::start();
    foreach ($logArr as $data) {
        Util1::var_dump($data);
    }
    Page1::end([], false);
    return ''.die('');
}

/**
 * Use for debugging but don't end page
 * @param mixed ...$logArr
 */
function d(...$logArr){ foreach ($logArr as $data) Util1::var_dump($data); }

/**
 * if data is set and data not null
 * @param $data
 * @param string $defaultValue_IfNotSet
 * @return string
 */
function isset_or(&$data, $defaultValue_IfNotSet = ""){ return Value1::isset_or($data, $defaultValue_IfNotSet); }






//=======[  instance class App ]=====================
/**
 * Get App Route and RequestInformation
 * @param null $c
 * @return RouteApp|RouteRequest
 */
function app($c = null) {
    $app = RouteApp::instance();
    if ($c) return $app->$c;
    return $app;
}

function auth(){ return Auth1::class; }


/**
 * app full class path list
 * @return array
 */
function app_class_paths(){
    global $__ENV;
    if(!empty($__ENV['app_class_paths'])) return $__ENV['app_class_paths'];
    $all_path = $__ENV['app_class_paths'] =  array_merge(
        [PATH_APP], // Application Folders

        // include App Layout Dynamic Class Profile
        @FileManager1::getDirectoriesFolders([rtrim(PATH_LAYOUTS, DS), rtrim(PATH_PLUGINS, DS)], '', 'inc/'),
        Config1::ENABLE_INCLUDES_SHARED ?
                array_merge(
                    [PATH_SHARED_APP],
                    FileManager1::getDirectoriesFolders([PATH_SHARED_RESOURCE.'views/layouts', PATH_SHARED_RESOURCE.'plugins'], '', 'inc/')
                ): [] // include Main Layout Dynamic Class Profile
    );
    return ($all_path);
}






/**
 * all known app class.
 *  e.g AuthModel1::class, Model1::class, Controller1::class, Api1::class;
 * @param array $typeList
 * @return array
 */
function app_class_list($typeList = [AuthModel1::class, Model1::class, Controller1::class, Api1::class]){
    global $__ENV;
    $key = implode('_', $typeList);
    if(!empty($__ENV['app_class_with_interface'][$key])) return $__ENV['app_class_with_interface'][$key];
    $model = [];
    foreach (FileManager1::getDirectoriesFiles(app_class_paths(), ['php'], [], -1, true) as $modelFile){
        $name = FileManager1::getFileName($modelFile);
        $name = str_replace( '.php', '', str_replace( '.class.php', '', $name ));
        if( in_array(get_parent_class($name), Array1::toArray($typeList))) $model[] = $name;
    }
    $model = array_diff($model, Config1::EXCLUDE_CLASS);
    return $__ENV['app_class_with_interface'][$key] = $model;
}


/**
 * @param string $interfaceName
 * @param array $classTypeList
 * @return array
 */
function app_class_with_interface($interfaceName = Model1ActionInterface::class, $classTypeList =  [AuthModel1::class, Model1::class]){
    global $__ENV;
    if(!empty($__ENV['app_class_with_interface'][$interfaceName])) return $__ENV['app_class_with_interface'][$interfaceName];
    // get all dashboard model
    $app_dashboard = [];
    foreach (app_class_list($classTypeList) as $key) if(Class1::isInterfaceImplementExistIn($key, $interfaceName)) $app_dashboard[] = $key;
    return $__ENV['app_class_with_interface'][$interfaceName] = $app_dashboard;
}

/**
 * app controller list
 * @return array
 */
function app_controller_list(){ return app_class_list([Controller1::class]); }

/**
 * get list of api class
 * @return array
 */
function app_api_list(){ return app_class_list([Api1::class]); }

/**
 * get model with page interface.
 * E.g FrontendPage::class, DashboardPage::class
 * @return array
 */
function app_page_list(){ return app_class_with_interface(Model1PageInterface::class); }

/**
 * get model with Dashboard Interface
 * @return array
 */
function app_dashboard_list(){ return app_class_with_interface(Model1ActionInterface::class); }


/**
 * get all model list
 * @param bool $remove_page
 * @param bool $withDbTableName
 * @return array
 */
function app_model_list($remove_page = true, $withDbTableName = false){
    $modelList = array_diff(array_merge(app_class_list([Model1::class, AuthModel1::class]), [Model1FileLocator::class]), $remove_page? array_merge(app_page_list(), ['Dashboard']): []);
    if(!$withDbTableName) return $modelList;
    $buffer = [];
    array_map(function($modelName) use (&$buffer){ $buffer[$modelName] = $modelName::getTableName(); }, $modelList);
    return $buffer;
}

/**
 * Get Existing Model and Table List
 * @param bool $withModelName
 * @return array
 */
function app_db_table_list($withModelName=true){ return Db1::getExistingTables($withModelName); }

/**
 * Existing Model with table List
 * @return array
 *
 */
function app_db_model_list(){ return Db1::getExistingModels(); }






/************************************************
 *  Date Function
 ***********************************************/
/**
 * return current date and time information
 * @param bool $pretty DATE (  as Number = 'Y-m-d')  or (as Text = 'Y-M-D'); and TIME ( as AM/PM or 24hours)
 * @return false|string
 */
function now($pretty = false){ return DateManager1::now($pretty); }
/**
 * Current date information
 * @param bool $pretty (  as Number = 'Y-m-d')  (as Text = 'Y-M-D');
 * @return string
 */
function now_date($pretty = false){ return DateManager1::nowDate($pretty); }
/**
 * current time information
 * @param bool $pretty ( as AM/PM or 24hours)
 * @return string
 */
function now_time($pretty = false){ return DateManager1::nowTime($pretty); }





/************************************************
 *  hold on to last request
 ***********************************************/
/*
 *
 */
if(($_SERVER['REQUEST_METHOD'] == 'POST')){
    $request = $_REQUEST;
    unset($request['password']);
    Session1::set('__old', array_merge(isset($_SESSION['__old'])? $_SESSION['__old']:[],  $request));
    // Keep Involved Request
    Page1::$FLAG_KEEP_OLD_REQUEST = true;
}

/**
 * All Last Request, Select From Last Request of No Parameter to return all.
 * @param string $inputName (control name)
 * @param string $defaultValueOnFailed (default value if not exists or form not sent yet)
 * @return mixed|string
 */
function old($inputName = '', $defaultValueOnFailed = ''){ return String1::is_empty($inputName)? Object1::toArrayObject(true, Session1::get('__old')) :   String1::isset_or(Session1::get('__old')[$inputName], String1::isset_or($_REQUEST[$inputName], $defaultValueOnFailed));} //   isset()? $_SESSION['__old'][$inputVariable]: $default; }


/**
 * Get any sent request like $_GET, $_POST and $_FILES... Also all value are being normalized.
 * Checkbox value are set to either true of false, and files are well arrange, in Parameter, Set the Names
 * @param array $insertOrReplaceKeyValue :override any request data or add new one to it
 * @param array $filterCheckBoxNameList : convert boolean on and off to php boolean true and false
 * @param array $filterFileUploadNameList ; normalize file name very well, use in Ehex Sample blog
 * @return mixed
 */
function request(array $insertOrReplaceKeyValue = [], array $filterCheckBoxNameList = [], array $filterFileUploadNameList = []){
    $request = Object1::toArrayObject(true, array_merge($_REQUEST, $_FILES, (empty($_POST)? Array1::makeArray(@json_decode(file_get_contents('php://input'))): []), $insertOrReplaceKeyValue));
    if(!empty($filterCheckBoxNameList))  foreach ($filterCheckBoxNameList as $value) $request[$value] = isset($request[$value])? 1 : 0;
    if(!empty($filterFileUploadNameList))  foreach ($filterFileUploadNameList as $value) $request[$value] = Array1::normalizeLinearRequestList($_FILES[$value]);
    return $request;
}

/**
 * Get Request headers
 * @param null $key
 * @param null $default
 * @return mixed
 */
function request_headers($key = null, $default = null){
    $header = Function1::runAndCache( "getallheaders");
    if(!$key) return Object1::toArrayObject($header);
    else return isset_or($header[$key], $default);
}



/************************************************
 *  Validating Security Token
 ***********************************************/

/**
 * Encrypt any string or password
 * @param string $data
 * @return bool|string
 */
function encrypt_data($data = ''){
    if(!function_exists("password_hash")) die(Console1::println('encrypt_data() says PASSWORD HASH NOT EXISTS'));
    return password_hash(Config1::APP_KEY.$data.Config1::APP_KEY, 1);
}

/**
 * @param $original_data
 * @param $encrypted_data
 * @return bool|string
 */
function encrypt_validate($original_data, $encrypted_data){
    if(!function_exists("password_verify")) die(Console1::println('encrypt_validate() says PASSWORD VERIFY NOT EXISTS'));
    return password_verify(Config1::APP_KEY.$original_data.Config1::APP_KEY, $encrypted_data);
}

/**
 * Encode any string or large file
 * @see decode_data() to decode data
 * @see String1::encodeData() for custom declaration
 * @param string $data
 * @param string $password
 * @return string
 */
function encode_data($data = '', $password = Config1::APP_KEY){ if (OPENSSL_VERSION_NUMBER <= 268443727) throw new RuntimeException('OpenSSL Version too old'); $iv_size  = openssl_cipher_iv_length('aes-256-cbc'); $iv = openssl_random_pseudo_bytes($iv_size);  $ciphertext     = openssl_encrypt($data, 'aes-256-cbc', $password, OPENSSL_RAW_DATA, $iv); $ciphertext_hex = bin2hex($ciphertext); $iv_hex         = bin2hex($iv); return "$iv_hex:$ciphertext_hex"; }


/**
 * Decode encoded string or large file
 * @see encode_data() to encode data
 * @see String1::decodeData() for custom declaration
 * @param string $cipheredData
 * @param string $password
 * @return string
 */
function decode_data($cipheredData = '', $password = Config1::APP_KEY) { $parts = explode(':', $cipheredData); $iv = hex2bin($parts[0]);$ciphertext = hex2bin($parts[1]); return openssl_decrypt($ciphertext, 'aes-256-cbc', $password, OPENSSL_RAW_DATA, $iv); }



/**
 * Ehex Token Generator
 * @return string
 */
function token(){
    if(!empty($_SESSION['_token'])) return $_SESSION['_token'];
    else{
        $_SESSION['_token'] = bin2hex(openssl_random_pseudo_bytes(32));//.'____'.String1::encodeStringToNumber(Url1::backUrl()); //$_SESSION['token'] =  bin2hex(random_bytes(32)); //md5(Form1::encode_data(Math1::getUniqueId()));
        $_SESSION['_token_time'] = time();
        return $_SESSION['_token'];
    }
}



/**
 * validate token
 * @param null $token
 * @param bool $moreValidation
 * @return bool
 */
function is_token_valid($token = null, $moreValidation = true){
    $token = $token? $token: String1::isset_or($_POST['_token'], '');
    $is_match = hash_equals(token(), $token);
    if($is_match){
        if(is_ajax_request() || !$moreValidation) return true;
        else{
            //if( $moreValidation && ((time()-$_SESSION['_token_time']) > 1500) ) die( Console1::println("Error, Token Validation Timeout!. Please resend your request") );

            if((time()-$_SESSION['_token_time']) > 5000)
                unset($_SESSION['_token'], $_SESSION['_token_time']);
            return true;
        }
    }
    unset($_SESSION['_token'], $_SESSION['_token_time']);
    return false;
}



/**
 * Get Session Token
 * @return string
 */
function csrf_token(){ return token(); }

/**
 * Get Session Token Form, Hidden form with token field
 * @return null|string
 */
function form_token(){ return HtmlForm1::addHidden('_token', token()); }

/**
 * Generate Url to Form Controller
 * @param string $classStaticFunction
 * @return string
 */
function form_call_controller($classStaticFunction = 'className::function(param1, param2)'){ return Form1::callController($classStaticFunction); }

/**
 * Generate Url to API
 * @param string $classStaticFunction
 * @return string
 */
function form_call_api($classStaticFunction = 'className::function(param1, param2)'){ return Form1::callApi($classStaticFunction); }


/**
 * Check is request is Ajax... support Jquery, Prototype and other except for angular and express.js
 *  Request header must contain 'X-Requested-With': 'XMLHttpRequest'.
 * @return bool
 */
function is_ajax_request(){ return Url1::isAjaxRequest(); }

/************************************************
 *  Helper Function
 ***********************************************
 * @param array $except
 * @param bool $listAsMenu
 * @param array @see Array1::replaceKeyNames(),  $renameLinkName_oldName_equals_newName  E.g ['dashboard'=>'My Dashboard']
 * @return ArrayObject|mixed
 * @internal param array $rename
 */
//[XAMTAX EDIT]
/**
 * Navigate to any menu and Return all Menu, can be accessed through routes()->login
 * =======[ get all route link and value array as ArrayObject and call by name, e.g routes()->home,  routes()->current,   ]=================
 * @param array $except
 * @param bool $listAsMenu
 * @param array $renameLinkName_oldName_equals_newName
 * @return array|mixed
 */
function routes($except = [], $listAsMenu = false, $renameLinkName_oldName_equals_newName = []) {
    $routeKeyValueList = Array1::removeKeys(array_merge(  Array1::wrap( array_merge(['index'=> '/',  'home'=>'/'], app('route')->getAllRoutes()), path_main_url('/')), ['current'=>path_current_url()]), $except);
    $routeKeyValueList = Array1::replaceKeyNames($routeKeyValueList, $renameLinkName_oldName_equals_newName);
    if($listAsMenu) { $menuLink = []; foreach ($routeKeyValueList as $item => $value) $menuLink[ucwords(String1::convertToCamelCase(String1::replace($item, '.', ' '), ' '))] = $value; return $menuLink; }
    else return Object1::toArrayObject(true, $routeKeyValueList);
}






/**
 * redirect with route | Navigate to any menu
 * @param null $name
 * @param array $args
 * @return Route|RouteSystem|string
 */
function route($name = null, array $args = []) {
    if($name) return url(app('route')->getRoute($name, $args));
    global $route; return $route;
}

/**
 * redirect with route url
 * @param null $path
 * @return string
 */
function url($path = null) { return path_main_url().'/'.ltrim($path, '/'); }

/**
 * use mostly in controller
 * @param $viewPageName
 * @param array $param
 * @param bool $actionResult
 * @param array $trueMessage
 * @param array $falseMessage
 * @return string
 */
function redirect_to_view($viewPageName, array $param = [], $actionResult = false, $trueMessage = [], $falseMessage = []){
    // disable form/action/controller auto redirect
    global $FORM_ACTION_SHOULD_REDIRECT;
    $FORM_ACTION_SHOULD_REDIRECT = false;
    // set status
    if(!empty($trueMessage) || !empty($trueMessage)) Session1::setStatusFrom(($actionResult)? $trueMessage: $falseMessage );
    // set page rendering
    return view($viewPageName, $param);
}


/**
 * Goto a particular address
 * use mostly in controller
 * @param string $routeUrl
 * @param array $status
 * @param array $param
 * @return string
 */
function redirect($routeUrl = '/', $status = [], $param = []){
    if(String1::startsWith($routeUrl, '/') || !String1::startsWith(strtolower($routeUrl), 'http')) return Url1::redirect(url($routeUrl), $status, $param);
    else return Url1::redirect($routeUrl, $status, $param);
}

/**
 * redirect to previous page or to error404 Page if previous failed
 * @param array $status
 * @return string
 */
function redirect_failed($status = ['Request Failed', 'Could not retrieve necessary data', 'error']){
    Session1::setStatusFrom($status? $status: ['Request Failed']);
    $backUrl = Url1::backUrl();
    $returnUrl = url('/error404');
    if($backUrl !== Url1::getPageFullUrl()) $returnUrl = $backUrl;
    Url1::redirect($returnUrl);
    return Console1::println($status, true);
}

/**
 * Goto a previous address
 * @param array $status
 * @param array $param
 * @return string
 */
function redirect_back($status = [], $param = []){
    Url1::redirect(Url1::backUrl(), $status, array_merge(["_REQUEST"=>$_REQUEST], $param));
    return '';
}


/**
 * Get Layout Assets directory ( Layout serve as Theme )
 * @see current_layout_asset(); // to get current layout assets
 * @see register_path_for_layout_asset(); // to register theme assets
 * @param string $file_path_name
 * @param string $assets_folder_name
 * @param null $layout_name
 * @param bool $isInSharedLayout
 * @return string
 *
 */
function layout_asset($file_path_name = '', $assets_folder_name = 'assets', $layout_name= null, $isInSharedLayout = false){
    // path gotten from register_path_for_layout_asset() or auth from Blade compiler
    //$layout_name_or_path = String1::contains( DS, $layout_name_or_path)? $optional_layoutViewPath_or_layoutFullPath: viewpath_to_path($optional_layoutViewPath_or_layoutFullPath) )
    $path = exBlade1::$CURRENT_LAYOUT_PATH ? exBlade1::$CURRENT_LAYOUT_PATH: (resources_path_view_layout($isInSharedLayout).DS.$layout_name);
    $path = $path.DS.$assets_folder_name.(!empty($file_path_name)? DS.$file_path_name: '');
    // if shared_assets, create symlink to assets and put under website. (otherwise move __include folder to your website) because assets file must be a subdirectory under website domain and not outside website folder wic we don't knw url location for.
    $path = normalizeSharedPath($path, '/shared/resources/views/', 'layout_list');
    return Url1::pathToUrl($path);
}

/**
 * Get Plugin Assets directory
 * @param string $file_path_name
 * @param string $assets_folder_name
 * @param null $plugin_name
 * @param bool $isInSharedLayout
 * @return string
 *
 */
function plugin_asset($file_path_name = '', $assets_folder_name = 'assets', $plugin_name = null, $isInSharedLayout = false){
    // path gotten from register_path_for_layout_asset() or auth from Blade compiler
    $path =  resources_path_plugin($isInSharedLayout).DS.$plugin_name;
    $path = $path.DS.$assets_folder_name.(!empty($file_path_name)? DS.$file_path_name: '');
    // if shared_assets, create symlink to assets and put under website. (otherwise move __include folder to your website) because assets file must be a subdirectory under website domain and not outside website folder wic we don't knw url location for.
    $path = normalizeSharedPath($path, '/shared/resources/plugins/', 'plugin_list');
    return Url1::pathToUrl($path);
}


/**
 * if shared_assets, create symlink to assets and put under website. (otherwise move __include folder to your website) because assets file must be a subdirectory under website domain and not outside website folder wic we don't knw url location for.
 * normalizeSharedPath('', '/shared/resources/plugins/', 'plugin_asset');
 * @param string $file_system_path
 * @param string $shared_path_delimiter
 * @param string $destination_asset_folder_name
 * @return string
 */
function normalizeSharedPath($file_system_path = '', $shared_path_delimiter = '/shared/resources/', $destination_asset_folder_name = 'shared_asset_list'){
    if(String1::contains($shared_path_delimiter, $file_system_path) && String1::startsWith(Config1::INCLUDES_PATH, '../') ){
        $name = String1::replace(explode($shared_path_delimiter, $file_system_path)[1], DS, '_');
        $layout_asset = path_asset()."/shared/$destination_asset_folder_name/$name";
        if(!is_link($layout_asset)){
            @unlink($layout_asset);
            @mkdir(path_asset()."/shared/$destination_asset_folder_name", 0777, true);
            Session1::setStatus('Shared Resources Linked', ["Resources ('".String1::convertToCamelCase($name, ' ')."') Linked to app!",   Url1::createSymLinks($file_system_path, $layout_asset)]);
        }
        $file_system_path = $layout_asset;
    }
    return $file_system_path;
}


/**
 * Use in your plugin/layout to get current location of  assets
 * @see layout_asset();
 * @see register_path_for_layout_asset();
 * @param string $file_path_name
 * @param string $assets_folder_name
 * @param string $app_path_delimiter
 * @param string $shared_path_delimiter
 * @param string $destination_asset_folder_name
 * @return mixed
 */
function current_resources_asset_path($file_path_name = '', $assets_folder_name = 'assets', $app_path_delimiter = '/resources/views/layouts/',  $shared_path_delimiter = '/shared/resources/', $destination_asset_folder_name = 'shared_asset_list', $debug_backtrace = 0){
    $current_file_full_path = debug_backtrace(null, 2)[$debug_backtrace]['file'];
    // split and confirm if is layout path
    if(!String1::contains($app_path_delimiter, $current_file_full_path)) die(Console1::println('Current Layout Assets function Can only be run in the layout folder to retrieve assets of the layout. e.g Can be use to retrieve assets/css for plugin instead of using layout_asset("layout-name")'));
    // extract layout name
    $slitter = explode($app_path_delimiter, $current_file_full_path);
    $full_layout =  $slitter[0].$app_path_delimiter.explode(DS, $slitter[1])[0];
    // merge up
    $path = $full_layout.DS.$assets_folder_name.(!empty($file_path_name)? DS.$file_path_name: '');
    // if shared_assets
    $path = normalizeSharedPath($path, $shared_path_delimiter, $destination_asset_folder_name);
    // return path
    return Url1::pathToUrl($path);
}

/**
 * Use in your plugin to get current location of plugin assets
 * Get Current Plugin Assets ( Function can only be used inside resources/plugins/plugin_name )
 * @param string $file_path_name
 * @param string $assets_folder_name
 * @return mixed
 *
 */
function current_plugin_asset($file_path_name = '', $assets_folder_name = 'assets'){
    return current_resources_asset_path($file_path_name, $assets_folder_name, '/resources/plugins/', '/shared/resources/plugins/', 'plugin_list', 1);
}


/**
 * Use in your layout to get current location of layout assets
 * Get Current Layout Assets ( Function can only be used inside resources/layouts/layouts_name )
 * @param string $file_path_name
 * @param string $assets_folder_name
 * @return mixed
 */
function current_layout_asset($file_path_name = '', $assets_folder_name = 'assets'){
    return current_resources_asset_path($file_path_name, $assets_folder_name, '/resources/views/layouts/',  '/shared/resources/views/',  'layout_list', 1);
}


/**
 * Call on all layout template. It will use the template path to locate assets folder and use it for the website
 * @param null $optional_layoutViewPath_or_layoutFullPath (can be layouts.bootstrap.template or resources_path_view_layout().'/bootstrap/template.blade.php')
 * @param int $backtrace_index
 * @return string
 * @see current_layout_asset(); // to get current layout assets
 * @see layout_asset(); // to get current layout assets
 */
function register_path_for_layout_asset($optional_layoutViewPath_or_layoutFullPath = null, $backtrace_index = 0){
    if($optional_layoutViewPath_or_layoutFullPath) return exBlade1::$CURRENT_LAYOUT_PATH = dirname(String1::contains( DS, $optional_layoutViewPath_or_layoutFullPath)? $optional_layoutViewPath_or_layoutFullPath: viewpath_to_path($optional_layoutViewPath_or_layoutFullPath) );
    $allData = array_flip(exBlade1::$LOADED_VIEW_AND_CACHE_LIST);
    $cachePath = FileManager1::normalizeFilePathSeparator(@debug_backtrace(null, 2)[$backtrace_index]['file']);
    if(isset($allData[$cachePath])) return exBlade1::$CURRENT_LAYOUT_PATH = dirname($allData[$cachePath]);
    else return die(Console1::println('Error Occurred : Assets Path Not Found, register_path_for_layout_asset() template layout is not properly set, Please remove register_path_for_layout_asset() in template or visit ehex documentation for proper usage'));
}





/**
 * @param string $path
 * @return string
 *  Site Url [ http://localhost/Project-Ehex/ ]
 */
function path_main_url($path = ''){
    if(!String1::is_empty($path)) $path = '/'.ltrim($path, '/');
    return rtrim(Url1::getSiteMainAddress().str_replace('index.php', '', $_SERVER['PHP_SELF']), '/').$path;
}




/**
 * @param string $path
 * @return string
 *      Real Path [ /Applications/MAMP/htdocs/Project-Ehex/ ]
 */
function path_main($path = ''){ return rtrim(BASE_PATH.'/'.ltrim($path, '/'), '/'); }

/**
 * Get Current Path Url
 * @param bool $withParameter
 * @return string
 */
function path_current_url($withParameter = false){ return Url1::getCurrentUrl($withParameter); }


/**
 * Get Current Path
 * @return string
 */
function path_current(){
    $path =  String1::isset_or(debug_backtrace(null, 2)[0]['file'], Url1::urlToPath(path_current_url()));
    return String1::isset_or(array_flip(exBlade1::$LOADED_VIEW_AND_CACHE_LIST)[$path], $path);
}








/**
 * Get Assets files
 * @param string $path
 * @param bool $findInSharedAssets
 * @return string Assets Path [ http://localhost/Project-Ehex/resources/assets ]
 * Assets Path [ http://localhost/Project-Ehex/resources/assets ]
 */
function asset($path = '', $findInSharedAssets = false){ return path_asset_url($path, $findInSharedAssets); }
function path_asset_url($path = '', $findInSharedAssets = false){
    if($findInSharedAssets) return path_shared_asset_url($path);
    return  path_main_url().'/resources/assets'.((!empty($path))?  '/'.trim($path, '/'): '');
}
function path_asset($path = '') { return rtrim(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']), '/').'/resources/assets'.((!empty($path))?  '/'.trim($path, '/'): ''); }






/**
 * @param string $path
 * @return string app_main_path/app/
 */
function path_app($path = ''){ return rtrim(PATH_APP.ltrim($path, '/'), '/'); }





/**
 * Shared Path Information
 *
 * @param string $path
 * @param string $directory
 * @return string
 */
function path_shared($path = '', $directory = ''){ return (!empty($path))? PATH_SHARED.$directory.'/'.ltrim($path, '/'): PATH_SHARED.$directory; }

/**
 * @param string $path
 * @return string
 */
function path_shared_resources($path = ''){ return path_shared($path, 'resources'); }

/**
 * @param string $path
 * @return string
 */
function path_shared_app($path = ''){ return path_shared($path, 'app'); }

/**
 * @param string $path
 * @return string
 */
function path_shared_asset($path = ''){ return path_shared($path, 'resources/assets'); }

/**
 * @param string $path
 * @return string
 *
 */
function path_shared_asset_url($path = ''){
    if(String1::startsWith(Config1::INCLUDES_PATH, '../')){
        $shared_link_path = path_asset()."/shared/assets";
        if(!is_link($shared_link_path)){ Session1::setStatus('Shared Assets Linked', ['Link Successfully Created', Url1::createSymLinks(path_shared_asset(), $shared_link_path)]); } ////symlink(shared_asset(), path_asset().DS.'shared_assets');
    }else{
        $shared_link_path = PATH_SHARED_RESOURCE.'/assets';
    }



    return Url1::pathToUrl($shared_link_path).(    (empty($path)? '': '/'.trim($path, '/')));
}

/**
 * @param string $path
 * @return string
 *
 */
function shared_asset($path = ''){ return (path_shared_asset_url($path)); }

/**
 * Verify if url exists or use default
 * @param string $url
 * @param string $default
 * @return string
 */
function path_url_exists_or($url = '', $default = '...'){
    $default = ($default === '...') ? HtmlAsset1::getImageThumb(): $default;
    return FileManager1::urlPathExistsOr($url, $default);
}


/**
 * Delete All Ehex Creatd Cache
 * @param bool $clear_session
 */
function path_clear_cache($clear_session = false){

    // includes path shared assets
    $all_link_path = [ path_asset().DIRECTORY_SEPARATOR.'shared', resources_path_view_cache()]; //resources_path_cache().'/file_session'

    // Ehex
    if($clear_session) @session_destroy();
    
    // delete link directory
    foreach(array_merge($all_link_path) as $path) FileManager1::deleteDirectory(FileManager1::normalizeFilePathSeparator($path));

    // recreate
    @mkdir(resources_path_view_cache());
    Session1::setStatus('Session and All Path Cleared', 'Cleared cache Affected Path<hr/>'.implode('<hr/>', array_merge($all_link_path)).']');
}

