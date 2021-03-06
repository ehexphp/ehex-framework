<?php

/**
 * Ehex
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2015 - 20.., Xamtax Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	Ehex (EX)
 * @author	Samson Iyanu (Xamtax Technnology)
 * @copyright	Copyright (c) 2015 - 2019, Xamtax, Inc. (https://xamtax.com/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://ehex.xamtax.com
 * @since	Version 2.0
 * @filesource
 */



function framework_info(){
    return Object1::toArrayObject(true, [
        'name'=>'laravel',
        'alias'=>'lv',
        'description'=>'',
        'version'=>'5.0',
        'website'=>'https://laravel.com',
        'author'=>[
            'name'=>'Taylor Otwell',
            'alias'=>'Otwell',
            'email'=>'support@laravel.com',
            'website'=>'https://laravel.com',
        ],
    ]);
}



class Form2{
    public static function encrypt($string){
        return \Illuminate\Support\Facades\Crypt::encrypt($string);
    }
    public static function decrypt($encrypted_string){
        return \Illuminate\Support\Facades\Crypt::decrypt($encrypted_string);
    }
}







class Session2{

    static function setAccountData($name, $value){
        $_SESSION['__site'][$name] = \Form2::encrypt($value);
    }
    static function getAccountData($name){
        if(isset($_SESSION['__site'][$name])) return \Form2::decrypt($_SESSION['__site'][$name]);
        return null;
    }
    static function deleteAccountData($name = null){
        if($name === null) unset($_SESSION['__site']);
        else unset($_SESSION['__site'][$name]);
    }


    /**
     * @param $name
     * @param $password
     * @param $shouldLogin
     * @return \Illuminate\Contracts\Auth\Authenticatable|null


    // login not saving, therefore re-login again
    if(!Auth::check()) Auth::attempt(Array1::replaceKeyName(Session2::getLogin(), 'name', 'email'), true);
    if(Auth::id() === null) return 'Authentication Failed!';

    OR || ($password_old !== Session2::getLogin()['password'])

     *
     */


    public static function saveLogin($name, $password, $shouldLogin = false){
        $_SESSION['__site']['u10'] = \Form2::encrypt($name);
        $_SESSION['__site']['p10'] = \Form2::encrypt($password);
        if($shouldLogin) return self::getUserInfo();
    }

    public static function saveUserInfo($user){
        $_SESSION['__site']['u10'] = $user['email'];
        $_SESSION['__site']['p10'] = \Form2::encrypt($user['password']);
        $_SESSION['__site']['usi'] = \Form2::encrypt($user);
    }

    public static function getLogin(){
        if(isset($_SESSION['__site']['u10']) && isset($_SESSION['__site']['p10'])){
            return ['email'=>\Form2::decrypt($_SESSION['__site']['u10']), 'password'=>\Form2::decrypt($_SESSION['__site']['p10'])];
        }
        return null;
    }

    /**
     * @Depreciated (use deleteUserInfo() )
     */
    public static function deleteLogin(){
        static::deleteUserInfo();
    }
    public static function deleteUserInfo(){
        unset($_SESSION['__site']);
        self::deleteAccountData();
    }


    public static function getUserInfo($clearAuthSessionOnFailedAndRedirect = false, $redirectTo = '/login', $redirectMessage = 'Please Login!'){
        // login not saving, therefore re-login again
        $userInfo = null;




        // generate userInfo
        try{
            if(!Auth::check() && (Session2::getLogin() != null)) {
                Auth::attempt(Session2::getLogin(),  true);
            }
            $userInfo = Auth::user();
        }catch (Exception $e){}




        // fetch userInfo from USI
        if((!$userInfo) && isset($_SESSION['__site']['usi'])) {
            Auth::login(\Form2::decrypt($_SESSION['__site']['usi']), true);
            $userInfo = Auth::user();
        }



        // $userInfo
        if(!$userInfo){
            if($clearAuthSessionOnFailedAndRedirect){
                self::deleteUserInfo();
                Auth::logout();

                // redirect
                if(trim($redirectTo) !== '') {
                    Url2::redirectIf($redirectTo, $redirectMessage, [ true ]);
                    return null;
                }
            }
            return null;
        }
        return $userInfo;
    }
}


class Generator2{
    public function getToken() {
        return hash_hmac('sha256', str_random(40), config('app.key'));
    }
}





class Date2{

    public function isDataDue($date_at) {
        // "nesbot/Carbon": "1.*" required
        $now = now();
        if ($date_at->diff($now)->days <= 0) return true;
        else return false;

    }
}



class Popup2{
    public function sessionFlash($msgVariable, $type = 'info'){
        if(Session::has($msgVariable)){
            echo "<div class='alert alert-$type'> ".Session::get($msgVariable)."</div>";
        }
        return '';
    }
}





/**
 * Class ServerRequest Use to call method directly with string like url
 */
class ServerRequest2{
    public static $api_id = '';
    public static $api_key = '';
    protected static $_request = [];

    /**
     * access full parameter, either from $_REQUEST or function paramenter
     * $_REQUEST is always inmportant
     * @param array $defaultKeyValue
     * @return array
     */
    public static function request($defaultKeyValue = [], $addPhpInput = false){
        $targetMethod_debug_backtrace = debug_backtrace(null,2)[1];
        $signature = Array1::hashCode(debug_backtrace(null,2)[1]);
        global $__ENV;
        if(!isset($__ENV['method_request_param'][$signature]))   $__ENV['method_request_param'][$signature] = array_merge( Object1::getCurrentMethodParams( $targetMethod_debug_backtrace  ), static::$_request);
        return  Object1::toArrayObject(true, array_merge($defaultKeyValue, $__ENV['method_request_param'][$signature], ($addPhpInput? Array1::makeArray(@json_decode(file_get_contents('php://input'))): []) ));
    }


    /**
     * @param string $lookupFunction @default Format is 'className::function(param1, param2)'
     * @param string $paramDelimiter
     * @param bool $apiValidation (if true, means cannot call function, only class method can be called and the class method must have a corresponding token, api_id and api_key). (turn off if you want to use token only, or on for either token or api)
     * @return ResultObject1|mixed|string
     */
    static function callFunction($lookupFunction = 'className::function(param1, param2)', $paramDelimiter = ',', $apiValidation = true){
        // replace :: to @ because :: failed me on form/user@process...
        //String1::replace($lookupFunction, '::', '@');

        // validate API keys
        $breakSymbol = self::breakSymbol($lookupFunction);
        //$lookupFunction = static::validateAndNormalizeFunction($lookupFunction, $apiValidation);
        if($lookupFunction instanceof ResultObject1) die($lookupFunction);


        // use regex to check if string contain ( , ' ) comma and single quote
        $lookupFunction = trim($lookupFunction, '/');
        $isDoubleQuote = (!preg_match('#,[ ]*\'#', $lookupFunction)? '"': "'");
        //return str_getcsv($lookupFunction, $paramDelimiter, $isDoubleQuote );


        // is valid request
        if(strpos($lookupFunction, '(') <=0 ) return 'Not a valid CLF Request';

        // split up string
        $openB = strpos($lookupFunction, '(');
        $functionAndClass = substr($lookupFunction, 0, $openB);
        $rawParameters = substr($lookupFunction, $openB);



        // split of Url if it contains '?'
        $urlParameter = [];
        if(!String1::endsWith(')', $rawParameters) && String1::contains('?', $rawParameters)) {
            $urlParameter = explode('?', $rawParameters);
            $rawParameters = $urlParameter[0];
            parse_str($urlParameter[1], $urlParameter);
        }

        // split and filter parameter to array (filter out ", ', (, ), ;, )  // first remove space and later rater remove quote because of string like "      hello", so the space in quote preserved for some reason would not be removed as well
        $parameterList = array_map(function($item){ return trim($item, ' ')  ;}, str_getcsv( trim($rawParameters, '();'), $paramDelimiter, $isDoubleQuote) );
        $parameterList = array_map(function($item){ return trim($item, '"\'')  ;}, $parameterList);

        // run the method and function
        if(strpos($lookupFunction, $breakSymbol) > 0){
            try{
                $class_and_method = explode($breakSymbol, $functionAndClass);
                $callAs = (($breakSymbol == '@' || $breakSymbol == '.')? (new $class_and_method[0]): $class_and_method[0]);
                // add parameter to request for verbose access via static::$request in ServerRequest extended Class
                static::$_request = static::getMergeRequestWithFunctionParameter($parameterList, $class_and_method[1], $callAs);
                // return processed data
                return call_user_func_array([$callAs, $class_and_method[1]],  $parameterList);
            }catch (Exception $exception) {
                die(self::serverErrorAsResultObject1($functionAndClass, $parameterList, 'method_call_error-'.$exception->getMessage()));
            }
        }else{
            // insert function and param // Only Method
            try{ return call_user_func_array($functionAndClass,  $parameterList); }catch (Exception $exception) {  die(self::serverErrorAsResultObject1($functionAndClass, $parameterList, 'function_call_error-'.$exception->getMessage())); }
        }
    }


    /**
     * Add all parameter by name to request... for verbose access via static::$request in ServerRequest extended Class
     * @param $functionParamerList
     * @param $functionName
     * @param null $className
     * @return array
     * @throws ReflectionException]
     */
    public static function getMergeRequestWithFunctionParameter($functionParamerList, $functionName, $className = null){
        $classInfo = $className? (new ReflectionMethod($className, $functionName)): (new ReflectionMethod($functionName));
        $classParam = [];
        $index = 0;
        foreach( $classInfo->getParameters() as $param) {
            $classParam[$param->name] = Value1::isset_or($functionParamerList[$index], null);
            $index++;
        }
        return array_merge($classParam, $_REQUEST);
    }


    private static function serverErrorAsResultObject1($functionAndClass = 'functionName', $parameterList = [], $exception = ''){
        return json_encode( (new ResultObject1(false,  $exception, String1::escapeQuotes($functionAndClass), 400))->toArray() ); // RegEx1::getSanitizeAlphaNumeric($functionAndClass, '_') . '( '       .implode(',,,', $parameterList).        ' ) call'
    }


    /**
     * @param $functionName
     * @return null|string
     * Extract The Symbol Used as a break
     *  if Symbol is @ or ., call class object method and static method. else if symbol is ::, call static method only
     */
    private static function breakSymbol($functionName){
        if (strpos($functionName, '(') > -1) $functionName = String1::getSubString($functionName, strpos($functionName, '('));
        else if (strpos($functionName, '?') > -1) $functionName = String1::getSubString($functionName, strpos($functionName, '?'));

        if(String1::contains('@', $functionName) ) return '@';
        else if(String1::contains('::', $functionName)) return '::';
        else if(String1::contains('.', $functionName) ) return '.';
        else return null;
    }

    /**
     * @param $functionName
     * @param bool $enableApiAuth. turn off if you want to use token only, or on for either token or api
     * @return ResultObject1|string
     */
    private static function validateAndNormalizeFunction($functionName, $enableApiAuth = true){
        $breakSymbol = self::breakSymbol($functionName);

        // normalize url
        $functionName =  (String1::contains($breakSymbol, $functionName) || static::class === self::class)? $functionName: static::class.$breakSymbol.$functionName;
        if(!String1::contains('(', $functionName)){
            if(String1::contains('?', $functionName)){
                $sp = explode('?', $functionName);
                $functionName = $sp[0].'()'.$sp[0];
            }else
                $functionName .= '()';
        }




        // check if class::method exist in token bypass session or class::$CLF_BYPASS_TOKEN_LIST = [] consist of bypassable method
        if(!self::validateCLFAndBypassedToken($functionName, $breakSymbol)){
            // is auth required
            $className = explode($breakSymbol, $functionName)[0];

            // check if serverRequest class is called and not method
            if($enableApiAuth) {
                if(!String1::contains($breakSymbol, $functionName) || !class_exists($className) || !Array1::contain(class_parents($className), ServerRequest1::class))
                    die(self::serverErrorAsResultObject1($functionName, [], 'invalid_function_called- ServerRequest1 or API1 extended Class required!'));
            }


            // validate if API_KEY is valid with REQUEST[API_KEY] or if token is valid with Saved token data
            if(class_exists($className)) {
                if(method_exists($className, 'onApiStart')) $className::onApiStart($_REQUEST);
                if((!method_exists($className, 'isUserAllowed') || !$className::isUserAllowed()) && $className !== Db1::class ) die(self::serverErrorAsResultObject1($functionName, [], 'permission_denied- permission denied, user cannot access non-api/non-user-permitted class'));
                //dd($breakSymbol, $className, $functionName, $className::isApiAuthValid() );

                // check if api info set
                $apiAsAuth = (!empty($className::$api_id) || !empty($className::$api_key)) && (isset($_REQUEST['api_id']) || isset($_REQUEST['api_key']));
                if( (!$apiAsAuth || !$enableApiAuth) && method_exists($className, 'isApiAuthValid') && !$className::isApiAuthValid()) die(self::serverErrorAsResultObject1($functionName, [], 'permission_denied- request token not valid, please go back'));
                else{
                    // if controller... verify API KEY and API ID
                    if($enableApiAuth)  if(!(array_key_exists(Api1::class, class_parents($className)) && String1::isset_or($_REQUEST['api_id'], '') == $className::$api_id && String1::isset_or($_REQUEST['api_key'], '') == $className::$api_key)) die(self::serverErrorAsResultObject1($functionName, [], 'permission_denied- request api_id or api_key not valid'));
                }
            }
        }




        // return parse name
        return $functionName;
    }


    /**
     * Use bypassToken if you want to avoid the use of token, maybe token is too long in your url or other cases.
     *  Note, only use when it is absolutly neccessary... and not on form. Because of CSRF attack
     * @param string $functionName
     * @param $token
     */
    static function bypassToken($functionName = "class@function(...)", $token){
        if(!$token || ($token !== token())) return die(Console1::println("bypassToken Required a valid token"));
        $_SESSION[Session1::$NAME]['__bypassed_request'][$functionName] = $token;
        return $functionName;
    }

    /**
     * This method check if developer has override method Using SessionCookie and Class static $CLF_BYPASS_TOKEN_LIST variable
     * @param null $fullClassFunctionName
     * @param null $delimiterSymbol
     * @return bool
     */
    static function validateCLFAndBypassedToken($fullClassFunctionName = null, $delimiterSymbol = null){
        //check if class::method exist in token bypass session
        if(isset($_SESSION[Session1::$NAME]['__bypassed_request'][$fullClassFunctionName])) return $_SESSION[Session1::$NAME]['__bypassed_request'][$fullClassFunctionName];
        else {
            // verify if class::$CLF_BYPASS_TOKEN_LIST = [] consist of the bypassable method
            if($delimiterSymbol){
                list($className, $method) = explode($delimiterSymbol, $fullClassFunctionName);
                $method = explode("(", $method)[0];

                // is method alloww in CLF_CALLABLE_LIST
                if(isset($className::$CLF_CALLABLE_LIST)){
                    if(!in_array($method, $className::$CLF_CALLABLE_LIST)) return die(self::serverErrorAsResultObject1($functionName, [], 'permission_denied- method not allowed in  CLF_CALLABLE_LIST'));
                }

                // should we bypass method
                if(isset($className::$CLF_BYPASS_TOKEN_LIST)){
                    if(in_array($method, $className::$CLF_BYPASS_TOKEN_LIST)) return true;
                }
            }
        }
        return false;
    }


    /**
     * @param string $exec uses eval to execute any php code given [ note: this is dangerous and not the best way, use @call_url instead]
     * @return mixed
     */
    //static function makeAndCall($exec = 'className::function("param1", "param2")'){
    //    return eval($exec.";");
    //}




    /**
     * Get all available method
     */
    static public function help(){
        echo '<div style="margin:100px"><h3>Ehex '.ucfirst(static::class).' Class Method List</h3><hr/>';
        $param = String1::contains('?', Url1::getPageFullUrl())? explode('?', Url1::getPageFullUrl())[1]: null;
        foreach (get_class_methods(static::class) as $method) {
            $full_link = Form1::callApi(static::class.'@'.$method.'(...)'. ($param? '?'.$param: '')  );
            echo Console1::d("<h3>function $method(...) <br/><a href='$full_link' target='_blank'>$full_link</a></h3><hr/>" );
        }
        echo '</div>';
        return 'Xamtax Ehex. '.ucfirst(static::class).' Api Class ';
    }
}







class Mail2{
    public static function send($templatePath, $templateData = [], $toEmail = '', $toUserName = '', $subject, $fromMail = 'samtax01@gmail.com', $fromUserName = 'Xamtax XIIP') {
        try{
            Mail::send(['text'=> $templatePath ], $templateData, function($message) use($toEmail, $toUserName, $subject, $fromMail, $fromUserName) {

                // Set the receiver and subject of the mail.
                $message->to($toEmail, $toUserName)->subject($subject);

                // Set the sender
                $message->from($fromMail, $fromUserName);
            });
        }catch(Exception $ex){ return false; }
        return true;
    }





    public static function plainSend($templatePath, $templateData = [], $toEmail = '', $toUserName = '', $subject, $fromMail = 'samtax01@gmail.com', $fromUserName = 'Xamtax XIIP',
        // Configuration
                                     $mailPassword = '',
                                     $encryption = 'ssl',
                                     $port = 465,
                                     $smtpAddress = 'smtp.gmail.com'
    ) {

        // Prepare transport
        $transport = \Swift_SmtpTransport::newInstance($smtpAddress, $port, $encryption)
            ->setUsername($fromMail)
            ->setPassword($mailPassword);
        $mailer = \Swift_Mailer::newInstance($transport);

        // Prepare content
        $view = \Illuminate\Support\Facades\View::make($templatePath, $templateData);

        $html = $view->render();

        // Send email
        $message = \Swift_Message::newInstance($subject)
            ->setFrom([$fromMail => $fromUserName])
            ->setTo([$toEmail => $toUserName])

            // If you want plain text instead, remove the second paramter of setBody
            ->setBody($html, 'text/html');
        if($mailer->send($message)){ return true; }
        return false;//"Something went wrong :(";
    }





}


class Class2{

    static function getViewVariables(){
        return get_defined_vars()['__data'];
    }


}
class Object2 extends Class2 { }



class Route2{




    /**
     * @param string $prefix
     * @param array $domainList
     * @param $callback
     * @param bool $isPrefixExistsInUrl\
     * @param bool $usePrefixAsRouteName\
     *
     *
    Route2::domainGroup(['rexico.xamtax.dev', 'rexico.dev'], function() {
    Route::get('/{page}', 'RexIcoController@show');
    Route::resource('/', 'RexIcoController');
    });
     */
    static function domain($prefix,  $domainList = [], $callback, $isPrefixExistsInUrl = true, $usePrefixAsRouteName = true){

        // assign prefix
        $groupParam = ['prefix' => $prefix];
        if($usePrefixAsRouteName) $groupParam = array_merge($groupParam, ['as'=>"{$prefix}."]);
        if($prefix !== '') Route::group($groupParam, $callback);


        // validate
        if(($isPrefixExistsInUrl) && (!String1::startsWith(Request::getHost(), $prefix))) return;


        // create all domain route
        foreach ($domainList as $domain){
            Route::group(['domain' => $domain], $callback);
        }
    }




    static function domainPattern($prefix = '', $domainList = [], $callback){
        //Console1::popup(implode('|', $domainList));

//        if($prefix != '') {
//            Route::group(['prefix' => $prefix], $callback);
//         }


        //Console1::popup(implode('|', $domainList));
        Route::pattern('www', '(www|)');
        Route::pattern('domain_isValid', '('.implode('|', $domainList).')');
        Route::domain('{www?}.{domain_isValid}')->group($callback);
    }









}



class MySql2{


    /**
     * @param string $columnName
     * @param array $dataArray
     * @param string $logic
     * @param string $operator
     * @return array
     * Use to validate set of array with column
     *      Example validate search 'query column with likely values ['bag', 'shoe', e.t.c]
     */
    static function whereRawColumnEqual($columnName = 'name', $dataArray = [], $logic = 'OR', $operator = '='){
        $whereQuery = '';
        $whereArray = [];
        for($i=0; $i< count($dataArray); $i++){
            $category = $dataArray[$i];
            if($i != 0) $whereQuery .= ' '.$logic.' ';
            $whereQuery .= ' '.$columnName.' '.$operator.' ? ';
            $whereArray[] = $category;
        }
        return ['query'=>$whereQuery, 'array'=>$whereArray];
    }


    /**
     * @param null $query
     * @param array $columns
     * @param array $values
     * @param string $logic
     * @param string $operator
     * @return mixed
     *      Run Many Where Query Against Columns(s)
     *          E.G
     *              function search($text){
     *                 echo self::whereValuesInColumns($columns = ['`title`', '`body`'], $values = ["%$text%", "$text"], $logic = 'OR', $operator = ' LIKE ')
     *              }
     *      OUTPUT : where title LIKE "%text%" OR title LIKE "text" OR body LIKE "%text%" OR body LIKE "text"
     */
    static function whereValuesInColumns($query = null, $columns = [], $values = [], $logic = 'OR', $operator = '='){
        $columns = Array1::filterArrayItem($columns);
        $values = Array1::filterArrayItem($values);

        $whereQuery = '';
        $whereArray = [];


        for($m=0; $m< count($columns); $m++){
            if($m != 0) $whereQuery .= ' '.$logic.' ';

            for($i=0; $i< count($values); $i++){
                $category = $values[$i];
                if($i != 0) $whereQuery .= ' '.$logic.' ';
                $whereQuery .= ' '.$columns[$m].' '.$operator.' ? ';
                $whereArray[] = $category;
            }

        }

        return $query->whereRaw($whereQuery, $whereArray);
    }


    static function createOrUpdate($query, $isExistData = [], $replaceOrUpdateData = []){
        $record = @$query->where($isExistData)->first();
        if( is_null($record)) return $query->create($replaceOrUpdateData);
        else return $record->update($replaceOrUpdateData);
    }

    static function resultToArray($data){
        return json_decode(json_encode($data, true), true);
    }
}


class Model2{
    static function getTableColumns($schemaTableName = 'users'){
        return array_flip(\Illuminate\Support\Facades\Schema::getColumnListing($schemaTableName));
    }
}



class Request2{
    /**
     * SIMILAR to Ehex ( Array1::getCommonField() )
     * @param $schemaTableName
     * @param null $requestInstance
     * @return array return all table field present in $_REQUEST (for better form validation)
     */
    static public function getCommonFields($schemaTableName = 'users', $requestInstance = null){
        $tableFields = array_flip(\Illuminate\Support\Facades\Schema::getColumnListing($schemaTableName));
        if(!$tableFields) return null;

        $requestInstance = ($requestInstance)?$requestInstance:$_REQUEST;

        $isSearchWithRequest = (count($tableFields) > count($requestInstance));
        $fastSearchList = $isSearchWithRequest? $requestInstance: $tableFields;


        $requestKeyValue = [];


        foreach ($fastSearchList as $key=>$value) {

            if ($isSearchWithRequest)  {
                if(isset($tableFields[$key])) $requestKeyValue[$key] = $value;

            } else  {
                if(isset($requestInstance[$key])) $requestKeyValue[$key] = $requestInstance[$key];

            }
        }

        return (count($requestKeyValue)>0)?$requestKeyValue:null;
    }
}


class Url2{
    static public $ext = null;
    static function setExt($domainExtension = 'dev') {self::$ext = $domainExtension;}
    static function getExt() {
        if(self::$ext === null) return self::getHostExtension();
        return self::$ext;
    }


    static function getHostExtension() {
        $last = explode('.',  \Illuminate\Support\Facades\Request::getHost());
        return end($last);
    }

    static function getHostBaseUrl() {
        return Request::getHost();
    }


    static function getHostBaseName() {
        $last = explode('.',  \Illuminate\Support\Facades\Request::getHost());
        return $last[count($last)-2];
    }

    static function isIndexPage($url = null) {
        if($url) return ( ends_with(trim($url, '/ '), self::getExt()) || ends_with(trim($url), self::getExt().'/') ||   ends_with(trim($url), 'index.php') ) ? true : false;
        else return ((trim(\Illuminate\Support\Facades\Request::getPathInfo()) === '/') || (trim(\Illuminate\Support\Facades\Request::getPathInfo()) === '')) ? true : false;
    }


    /**
     * @param string $redirectUrl
     * @param array|string $message
     * @param array $trueConditionList
     * @param array $additionalData
     * @param string $elseCallback
     * @return $this|\Symfony\Component\HttpFoundation\Response Use for User Account is Id=User->id and the likes
     * Use for User Account is Id=User->id and the likes
     *
     * Example
     * \Url2::redirectIf(\Session1::get('last_page'), 'Welcome Back', [\Session1::exists('last_page')]);
     */
    static function redirectIf($redirectUrl = null, $message = [], $trueConditionList = [], $additionalData = [], $elseCallback = '') {
        if($redirectUrl === '' || $redirectUrl === null) $redirectUrl = back()->getTargetUrl();

        foreach(((array)$trueConditionList) as $value) {
            if($value == true) {

                // set status
                $status = [];
                if($message !== null && $message !== ''){
                    Session1::setStatusFrom($message);
                    $status += ['status'=>is_array($message)? implode(', ', $message): $message];
                }

                // return redirected page and stop exec
                \Illuminate\Support\Facades\Redirect::to($redirectUrl)->with(array_merge($status, $additionalData))->withInput()->send();
                Url1::redirect(url($redirectUrl));
                return null;
            }
        }

        if(is_callable($elseCallback)) return $elseCallback();
        return null;
    }

    static function redirectWithMessage($actionResult = true, $redirectUrl = null, $trueMessage = 'Action Successful', $falseMessage = 'Action Failed'){
        return self::redirectIf($redirectUrl, ($actionResult)? $trueMessage: $falseMessage, true);
    }



    static function normalizeUrl($request = null, $removeWWW = true, $secureHTTPS = true){
        // init
        $newRequest = ($request)? $request: \Illuminate\Http\Request::capture();
        $fullUrl = '';
        $shouldRedirect = false;


        // Remove the 'www.' from all domains
        if ($removeWWW && starts_with($newRequest->header('host'), 'www.')) {
            $host = str_replace('www.', '', $newRequest->header('host'));
            $newRequest->headers->set('host', $host);
            $shouldRedirect = true;
        }

        // assign new Url
        $fullUrl = $newRequest->fullUrl();


        // make url https
        if($secureHTTPS && starts_with($fullUrl, 'http://')){
            $fullUrl =  str_replace('http://', 'https://', $fullUrl);
            $shouldRedirect = true;
        }

        // redirect page
        if($shouldRedirect) return self::redirectIf($fullUrl, '', [true]);
    }


    static function serverRequestCall(){
        // extract Full Request Url (this is because of laravel disapproved for slash " /../ ")
        //$fullRequest = String1::replaceStart(urldecode(\Illuminate\Support\Facades\Request::path()), 'api/', '');
        //return response()->json(\ServerRequest1::call($fullRequest));
    }

    static function getLink($hostName = 'xamtax', $param = '/'){ return 'http://'.$hostName.'.'.self::$ext.(String1::startsWith($param,'/')? $param: '/'.$param); }
}



class FileManager2{
    static function getRootPath(){
        return dirname(base_path());
    }






    public function getDropBoxFile($file_name)
    {
//        $client = new Client('dropbox.token','dropbox.appName');
//        $this->filesystem = new Filesystem(new Dropbox($client, '/path'));
//
//        try{
//            $file = $this->filesystem->read($file_name);
//        }catch (\Dropbox\Exception $e){
//            return Response::json("{'message' => 'File not found'}", 404);
//        }
//
//        $response = Response::make($file, 200);
//
//        return $response;

    }


    public function createTemporaryDirectLink($file_name)
    {
        $filename = '/text1.txt';
        $adapter = \Storage::disk('dropbox')->getAdapter();
        $client = $adapter->getClient();
        $link = $client->createTemporaryDirectLink($filename);
        return <<<EOT
    <a href="{$link[0]}">Link</a>
EOT;
    }







//    Not Useful because it only load after filesystem initialization
//    static function gePublicLocalDiskConfig($dirName){
//        return [
//            'driver' => 'local',
//            'root' => storage_path("app/public/$dirName"),
//            'url' => env('APP_URL')."/storage/$dirName",
//            'visibility' => 'public',
//        ];
//    }

}



class Db2{

    static function getTableDbField($tableName = 'users', $fullType = false){
        $fieldAndTypeList = [];
        foreach (DB::select( "describe $tableName")  as $field){
            $type = ($fullType || !str_contains($field->Type, '('))? $field->Type: substr($field->Type, 0, strpos($field->Type, '('));
            $fieldAndTypeList[$field->Field] = $type;
        }
        return $fieldAndTypeList;
    }

    static function getTableColumnType($tableName = 'users', $columnName = false){
        //return DB::getSchemaBuilder()->getColumnType($tableName, $columnName);
        //    OR    return DB::connection()->getDoctrineColumn($tableName, $columnName)->getType()->getName();
    }





}


