<?php

/**
 * @backupGlobals disabled
 */
class AppSettings {


    /**
     * Get SIde Data List
     * @return array
     */
    static function getSideBar(){
        return [
            ['id'=>'1', 'header_title'=>"Install Layout / Plugin", 'data'=>(String1::isset_or($_GET['id'], 0)==1)? static::installLayoutAndPlugin(): [] ],
            ['id'=>'2', 'header_title'=>"View Resources", 'data'=>(String1::isset_or($_GET['id'], 0)==2)? static::getLayoutAndPlugin(): [] ],
            ['id'=>'3', 'header_title'=>"Model and  Table", 'data'=>(String1::isset_or($_GET['id'], 0)==3)? static::getModelAndDatabase(): [] ],
        ];
    }

    /**
     * List Editable All Code
     * @return array
     */
    static function getModelAndDatabase(){
        $buff = [];
        foreach (app_model_list(true, true) as $key=>$value)  $buff[ $key.' / '.$value ] ='['. $key.'] : '.$value.'';
        return [env('DB_NAME') => $buff];
    }

    /**
     * List Editable All Code
     * @return array
     */
    static function getCodeList(){
        return [];
    }


    /**
     * List All Assets Information
     * @return array
     */
    static function installLayoutAndPlugin(){
        $all = [
            'Incoming Features'=>[],
        ];
        return $all;
    }




    /**
     * List All Assets Information
     * @return array
     */
    static function getLayoutAndPlugin(){
        $all = [
            'Plugins'=>self::getFolderDataList(PATH_PLUGINS),
            'Layouts'=>self::getFolderDataList(PATH_LAYOUTS),
        ];
        return array_merge($all, [
            'Assets'=>self::getFolderDataList(path_asset()),
        ]);
    }














    /**
     * Turns Filename like
     *  layouts_shards_dashboard_assets   To shards_dashboard
     * @param $filePath
     * @return mixed
     */
    static function cleanFileName($filePath){ return String1::replaceEnd(String1::replaceStart(FileManager1::getName($filePath), 'layouts_', ''), '_assets', ''); }

    /**
     * Util Class for list all folder inside layout, plugin...
     * @param $path
     * @return array|string
     */
    static function getFolderDataList($path){ return @FileManager1::getDirectoriesFolders($path); }

    /**
     * Delete Assets Directory
     * @param $path
     * @return array|string
     */
    static function deleteDirectory($path){
        $name = self::cleanFileName($path);

        try{
            if(FileManager1::delete($path)) {
                return Session1::setStatus('Deleted Successfully', "You have deleted $name Successfully ",'success');
            }
            else {
                throw new Exception("Failed to delete '$name' due to Some evil eye");
            }
        }catch (Exception $exception){
            return Session1::setStatus('Error Deleting Resources', $exception->getMessage(),'error');
        }
    }





    /**
     * Settings Menu
     * @return mixed|array
     */
    static function getMenuList(){
        return Auth1::isAdmin()? [
            'Settings'=>[
                Dashboard::getManageUrl( @Class1::getClassesIf(null, "FrontendPage", "User")[0], ['show_all'=>true] )=>'<i class="fa fa-book"></i><span> Explore/Manage Model</span>',
                url('/site/settings')=>'<i class="fa fa-gear" aria-hidden="true"></i> <span> App Settings </span>',
            ],
        ]: [];
    }

    /**
     * @param exRoute1 $route
     */
    static function onRoute($route){
        // Others Admin
        if(Auth1::isAdmin()) {
            $route->view('/site/settings', 'pages.common.settings.admin.app');
        }
    }

}