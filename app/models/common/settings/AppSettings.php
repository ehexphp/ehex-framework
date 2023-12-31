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
     * Todo: optimise
     * List All Assets Information
     * @return array
     */
    static function getLayoutAndPlugin(){
        $all = [
            'Plugin [App]'=>self::getFolderDataList(PATH_PLUGINS),
            'Layout [App]'=>self::getFolderDataList(PATH_LAYOUTS),
        ];
        // If Shared is not in app, it means all shared resource assets are saved in app assets
        $all = array_merge($all, [
            'Plugin [Shared]'=>self::getFolderDataList(PATH_SHARED_RESOURCE.'plugins/'),
            'Layout [Shared In Assets]'=>FileManager1::getDirectoriesFolders(PATH_SHARED_RESOURCE.'views/layouts/'),
        ]);

        return array_merge($all, [
            'Assets [App]'=>self::getFolderDataList(path_asset()),
            'Assets [Shared]'=>FileManager1::getDirectoriesFolders(path_shared_asset()),
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
        if(String1::contains('/shared/resources/', $path)) return Session1::setStatus('Cannot Delete MultiSite Shared Assets', "Deleting $name is a Bad Idea!, We Found a MultiSite Configuration on this Site and therefore, You cannot delete Shared Resources because other website might depends on it. You can put a copy of Include/Shared folder in your Website to allow this operation", 'error');
        try{
            if(FileManager1::delete($path)) return Session1::setStatus('Deleted Successfully', "You have deleted $name Successfully ",'success');
            else throw new Exception("Failed to delete $name, Due to Some evil eye");
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