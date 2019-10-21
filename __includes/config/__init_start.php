<?php
/**
 * Created by PhpStorm.
 * User: samtax
 * Date: 08/07/2018
 * Time: 7:47 AM
 */
//      SAMPLE of AUTO LOAD
//      spl_autoload_register(function($class_name) {
//            require_once(PATH_LIBRARY.'filesession/FileSession.php');
//      });







/************************************************
 *  Util
 ************************************************/
    require PATH_LIBRARY . 'utilphp/util.php';


/************************************************
 *  Ehex Import
 ************************************************/
    // Ehex MadeWork
    //require PATH . '../.config.php';
    require PATH_EASYCORE . 'Ehex.php';
    require PATH_EASYCORE . 'EasyDb.php';
    require PATH_EASYCORE . 'EasyDataSet.php';
    require PATH_EASYCORE . 'EasyForm.php';







/************************************************
 *  Others, like function list and Simple Html Dom
 ************************************************/
    //require PATH_LIBRARY . 'html-dom/simple_html_dom.php';
    require PATH_INCLUDE . "config/function.php";
    include PATH_INCLUDE . 'config/session.php';





/************************************************
 *  AutoLoadPaths    Model / Api / Controller
 ************************************************/
//    function autoload_register($path, $addToArrList = []){
//        spl_autoload_register(function($class_name) {
//            foreach(Config1::$auto_load_directory as $dir ) {
//                $path = PATH.$dir.DIRECTORY_SEPARATOR;
//                $class_path = $path.$class_name.'.php';
//                if()
//
//                if (file_exists($class_path)) {
//                    require_once($class_path); return;
//                }
//
//
//            }
//        });
//    }
//
//
//    if(Config1::$auto_load_class_only){
//        spl_autoload_register(function($class_name) {
//            foreach(Config1::$auto_load_directory as $dir ) {
//                $class_path = PATH_APP.$dir.DIRECTORY_SEPARATOR.$class_name.'.php';
//                if (file_exists($class_path)) {
//                    require_once ($class_path); return;
//                }
//            }
//        });
//
//    }else{
//        foreach (FileManager1::getDirectoriesFiles(Array1::wrap(Config1::$auto_load_directory, PATH_APP), ['php'], [], -1, true) as $controllerFile) require_once($controllerFile);
//    }




/**
 * Load Autoload Classes
 */
FileManager1::autoClassRecursiveLoad(
    array_merge(
        app_class_paths(),
        [PATH_LIBRARY.'__autoload_class/']
    ));