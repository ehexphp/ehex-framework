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




/**
 * Check app debug state
 * @return bool
 */
function is_debug_mode(){
    if(Config1::DEBUG_MODE) return true;
    else foreach (Config1::DEBUG_IP as $key) if(preg_match("/$key/", $_SERVER['REMOTE_ADDR'])) return true;
    return false;
}


// error activator
    if(is_debug_mode()){
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }



/************************************************
 *  Util
 ************************************************/
    require PATH_LIBRARY . 'utilphp/util.php';


/************************************************
 *  Ehex Import
 ************************************************/
    // Ehex MadeWork
    require PATH_EASYCORE . 'Ehex.php';
    require PATH_EASYCORE . 'EasyDb.php';
    require PATH_EASYCORE . 'EasyDataSet.php';
    require PATH_EASYCORE . 'EasyForm.php';







/************************************************
 *  Others, like function list and Simple Html Dom
 ************************************************/
    // require PATH_LIBRARY . 'html-dom/simple_html_dom.php';
    require PATH_INCLUDE . "config/function.php";
    include PATH_INCLUDE . 'config/session.php';

    // Load Autoload Classes
    FileManager1::autoClassRecursiveLoad(
        array_merge(
            app_class_paths(),
            [PATH_LIBRARY.'__autoload_class/']
        )
    );

    // load Helper Library
    include PATH_INCLUDE . 'config/error.php';                // Error Handler
    include PATH_INCLUDE . 'config/ex1.php';                  // Extending Class1 list/ Url1x::route(), Mail1x::...
    include PATH_INCLUDE . 'config/data_query.php';           // Query Builder Config
    include PATH_INCLUDE . 'config/view.php';                 // View Config
    include PATH_INCLUDE . 'config/translator.php';           // Language Translator
    include PATH_INCLUDE . 'config/mail.php';                 // Mailer
    include PATH_INCLUDE . 'config/file.php';                 // File Session and File Database
    include PATH_INCLUDE . 'config/vendor.php';               // File Session and File Database