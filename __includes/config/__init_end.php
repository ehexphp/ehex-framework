<?php
/**
 * Created by PhpStorm.
 * User: samtax
 * Date: 08/07/2018
 * Time: 7:47 AM
 */


/************************************************
 *  Conditional Function
 ************************************************/
    if(Config1::DEBUG_MODE){
        if(isset($_REQUEST['db_help'])) Db1::help();
        Config1::onDebug();


        // check if path exists and real
        if( String1::startsWith(Config1::INCLUDES_PATH, '../') && !file_exists(path_asset().DIRECTORY_SEPARATOR.'shared'.DIRECTORY_SEPARATOR.'assets'))  {
            path_clear_cache();
            FileManager1::createDirectory(path_asset().DIRECTORY_SEPARATOR.'shared');
        }
    }


    include PATH_INCLUDE . 'config/route.php';                // Route  / and Init Route like Login/ Register
