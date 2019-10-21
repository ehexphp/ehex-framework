<?php


class AuthApi extends Api1 {

    public static $api_id = '123';
    public static $api_key = '123';


//    public static function onApiStart($request){
//        //dd($request);
//        return true;
//    }
//
//    public static function isUserAllowed(){
//        return true;
//    }


    /**
     * Generate a new token
     * @param $user_name
     * @param $password
     * @return ResultObject1
     */
    public static function login($user_name = null, $password = null){

        //return self::request();

        // validate
        $validateResult = Validation1::validate( ['user_name'=>self::request()->user_name, 'password'=>self::request()->password], ['user_name'=>'required',  'password'=>'required|min:6']);
        if(!$validateResult->getStatus()) return $validateResult;
        // log user in
        $userInfo = User::login(self::request()->user_name, self::request()->password, ['user_name', 'id', 'email'], ['password'], true);
        // generate token
        return ResultObject1::make(!!$userInfo, $userInfo->getMessage(), $userInfo? Url1::generateJWToken(['user_id'=>$userInfo->id, 'user_name'=>$userInfo->user_name]): null);
    }


    /**
     * Renew Token
     * @param $old_token
     * @return ResultObject1
     */
    public static function renewToken($old_token = null){
        $isValid = Url1::validateJWToken(self::request()->old_token, false);
        $userInfo =  $isValid? User::find($isValid['user_id']): null;
        return $userInfo? ResultObject1::make(!!$userInfo, $userInfo->getMessage(),  Url1::generateJWToken(['user_id'=>$isValid['user_id'], 'user_name'=>$isValid['user_id']])) : ResultObject1::falseMessage("Token not valid");
    }



}