<?php


class GameApi extends Api1 {

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





    // // fetch all
    // public static function games(){
    //     return ResultObject1::trueData(Game::paginateApi(""));
    // }


    // // single
    // public static function getGame(){
    //     return ResultObject1::trueData(
    //         Game::findOrFail(self::request()->id, 'id', function(){
    //             return ResultObject1::falseMessage("Item id is not set!");
    //         })
    //     );
    // }



    // // add
    // public static function addGame(){
    //     $validateResult = Validation1::validate(['name', 'description']);
    //     if(!$validateResult->status) return $validateResult;
    //     return ResultObject1::trueData( Game::insertOrUpdate(self::request(), ['name']) );
    // }







    // fetch all
    public static function all(){
        return ResultObject1::trueData(Game::paginateApi(""));
    }


    // single
    public static function get($id = ''){
        return ResultObject1::trueData(
            Game::findOrFail(self::request()->id, 'id', function(){
                return ResultObject1::falseMessage("Item id is not set!");
            })->toArray()
        );
    }



    // add
    public static function add(){
        $validateResult = Validation1::validate(['title', 'body']);
        if(!$validateResult->status) return $validateResult;
        return ResultObject1::trueData( Game::insertOrUpdate(self::request(), ['name']) );
    }



    // delete
    public static function delete(){
        return ResultObject1::trueData(
            Game::deleteBy(self::request()->id, 'id', function(){
                return ResultObject1::falseMessage("Item id is not set!");
            })
        );
    }





}