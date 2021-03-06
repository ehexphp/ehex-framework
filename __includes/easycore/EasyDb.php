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
 * @copyright	Copyright (c) Xamtax, Inc. (https://xamtax.com/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://ehex.xamtax.com
 * @since	Version 2.0
 * @filesource
 */

/**
 * @see https://ehex.xamtax.com for Documentation
 * Created by Samson Iyanu
 * Website : https://xamtax.com
 * Required
    class Config1{
        const DB_NAME= 'my_db_name';
        const DB_USER_name = 'root';
        const DB_USER_password = 'root';
        const DEBUG_MODE = true;
        const MAINTENANCE_MODE = false;
    }
 *
 *
 * This Class Consist of
 *      Db1 : re-declares mysql connection
 *      Model1 : MySqlQueryGenerator and Handler
 *      AuthModel1 : Extend Model1 and Include Auth Function
 *      DbPref1 : Extend Model1 and It Easy to Store KeyValue Data
 */
// verify if config1 exists
if(!class_exists(Config1::class)) die('<h1>APP CONFIG NOT FOUND!<br/><small>".config.php" Missing.</small></h1>');

// activate Selected Db
if(defined("Config1::DB_DRIVER")) if (!( include(PATH_INCLUDE . 'config/database/'.Config1::DB_DRIVER.'.php') )) die('<h1>Oops!. Database not supported<br/><small>please switch to mysql or sqlite.</small></h1>');











/**
 * Database Class
 * Class Db1
 */
 class Db1 {

    /**
     * @var mysqli|SQLite3 null
     */
    static $DB_HANDLER = null;

    /**
     * Open Database Connection
     * @param bool $isDatabaseAvailable
     * @return mysqli|string
     */
    static function open($isDatabaseAvailable = true) {
        try{
            return static::$DB_HANDLER = DbAdapter1::open($isDatabaseAvailable);
        } catch (Exception $ex){
            Console1::println("<h3>Welcome to Ehex (ex).</h3> <p>App encounter error in Database</p><em>".$ex->getMessage()."</em>");
            Console1::println("<strong>NOTE</strong><br/><small>You can also change your app_key to <em style='font-weight: 800;color:gray'>APP_KEY = 'base64:".password_hash(Math1::getUniqueId(), 1)."'</em> if you have not, in .config file</small>");
            If(String1::contains('Unknown database', $ex->getMessage())) return null.die(Console1::println('<h2>Database ['.Config1::DB_NAME.'] is not created yet.</h2><p>Open <em>.config.php</em> file and run <code>Db1::databaseCreate()</code> In Config1::onDebug() method. <br/><small>You can also run <em><a href="?db_help">Db1::help()</a></em> to manage model graphically.</small></p>'.exForm1::makeRunnableForm(Db1::class, 'databaseCreate()').Session1::setStatus('Manage Model Graphically', 'to manage model, run Db1::help() in Config')));
        }
        return null;
    }

    /**
     * Close Database connection
     * @return mixed
     */
    static function close() { return static::$DB_HANDLER->close(); }


     /**
      * is query suppose to return value
      * @param $sql
      * @return bool
      */
    static function isQueryReturningValue($sql){
        return !(bool) preg_match('/^\s*"?(SET|INSERT|UPDATE|DELETE|REPLACE|CREATE|DROP|TRUNCATE|LOAD|COPY|ALTER|RENAME|GRANT|REVOKE|LOCK|UNLOCK|REINDEX)\s/i', $sql);
    }

    static function isDatabaseExists(){
        try{ new mysqli(Config1::DB_HOST, Config1::DB_USER, Config1::DB_PASSWORD, Config1::DB_NAME); return true;
        }catch (Exception $ex){  return null; }
    }

    /*
     * Run Direct Query on Database
     */
    static function exec($query, $closeDbOnFinished = true, $isDatabaseAvailable = true, $throwError = true, $asMultipleQuery = false){
        //open connection
        static::$DB_HANDLER = Db1::open($isDatabaseAvailable);
        if(!static::$DB_HANDLER) die(strtoupper(Config1::DB_DRIVER).' DB_HANDLER not initialized'."<br/><hr/><br/>Error in db:[" . DbAdapter1::getType() === 'mysql'? String1::toArrayTree(static::$DB_HANDLER->error_list): ' error_list N/A ' . "] dbString:[" .DbAdapter1::getLastErrorMessage(static::$DB_HANDLER). "]");
        //query
        $data =  DbAdapter1::exec($query, /* $asMultipleQuery */ (self::isQueryReturningValue($query)?false:true), static::$DB_HANDLER) or ($throwError? die("InValid Query [ ".static::errorHandlerAndSolution()." ] "): $data = null);
        //close connection
        if($closeDbOnFinished && is_bool($data)) Db1::close();
        return $data;
    }


    /**
     * Error handler
     * @return mixed
     */
    public static function errorHandlerAndSolution($errorText = null){
        $errorText =  $errorText? $errorText:  DbAdapter1::getLastErrorMessage(static::$DB_HANDLER);
        if(!is_debug_mode()) die(Console1::println("EXDB001 Error Occured, please enable debug mode to view more"));
        $suggestion = '';

        $runLink = function($modelClassName, $functionName){
            return "<li>
                        <hr/>".exForm1::makeRunnableForm($modelClassName, $functionName)
                        ."<a href='".Form1::callController($modelClassName, $functionName).'?_token='.token()."'> Run </a>
                    </li>";
        };

        // Merge debug_backtrace() with method Suggestion Links
        $runFunction = function($className, $functionName) use (&$suggestion, $runLink){
            Object1::getExecutedClass($className, true, function($class) use ($functionName, &$suggestion, $runLink){
                if($class!==Model1::class) $suggestion .= $runLink($class, $functionName);
            });
        };

        // Database Access Denied
        if(String1::contains('Access denied', $errorText)) {
            $suggestion .= '<li><h4>Database Access denied <small>(invalid user/password)</small></h4></li><li>Your Database Config DB_USER = "***", or DB_PASSWORD = "***" is wrong. Please open .config.php file and update it</li>';
        }

        // Column Not Exists Yet
        if(String1::contains('Unknown column', $errorText)) {
            $suggestion .= '<li>Please update Model Fields and run tableReset() method on Model. e.g User::tableReset() </li>';
            $runFunction(Model1::class, "tableReset()");
        }

        // Column Not Exists Yet
        else if(String1::containsMany(['Table', 'doesn\'t exist'], $errorText, 'and')){
            $dbAndModel = explode('.', trim(String1::replaceEnd(String1::replaceStart($errorText, 'Table', ''), 'doesn\'t exist', ''), "\"' "));
            $modelName = isset($dbAndModel[1])? @array_flip(app_model_list(true, true))[$dbAndModel[1]] : null;
            $suggestion .= "<li>Please run Model $modelName::tableCreate() method in config onDebug(){...}. e.g User::tableCreate() </li>";
            if($modelName) $suggestion .= $runLink($modelName, 'tableCreate()');
            else  $suggestion .= $runFunction(Model1,"tableCreate()");
        }

        $errorText = (empty($errorText) && empty($suggestion))? '<hr>Is Database Exists? If not, Please Run either<ul><li>Db1::databaseCreate();</li> <li>Db1::tableCreateAll();</li> </ul> In Your Debug Method': $errorText;
        echo "<div class='middle' style='position: absolute !important; top:0;left:0;margin:50px;z-index: 103904208284804'>".Console1::println(
            '<h3>Ehex Database Error</h3>'.$errorText.
            (!empty($suggestion)? "<br/><br/><h3>Suggestion</h3><ul>$suggestion</ul><strong>Note:</strong> <small>You can also run <em><code><a href='?db_help'>Db1::help()</a></code></em> to manage your models graphically.</small>": ''))."</div>";
        return $errorText;
    }


    /**
     * Easy Best FUnction So Far
     * guild to create and manage db model.
     * @param bool $endPage
     */
    static function help($endPage = true){
        Page1::start(); 
        Db1::databaseCreate();
        $style = "<style>
                    code{color:gray; font-weight: 800} 
                    code.ex_note{color:#f06956; font-weight: 800} 
                    hr{ border:1px solid #27aad6}
                    td{ border-bottom:1px solid #27aad6; padding-top:5px;}
                    .ex_right{float:right;}
                </style>";
        $script = "<script src='".shared_asset('jquery/js/jquery3.3.1.min.js')."'></script><script>  $(function(){  $('#model_search').on('keyup', function(){ Html1.enableSearchFilter('model_search', 'model_table', 'tr'); })  }) </script>";
        Console1::println($style.$script.'<strong>Welcome to Ehex (ex). DB Smart Help</strong> <a href="'.Url1::getCurrentUrl(false).'" style="float:right;text-decoration: none">&hookleftarrow; Home</a><hr/><small>You can either open this interface by adding <code>?db_help</code> to your url or <code>Db1::help();</code> to your Config::onDebug() method, located in .config.php file while your DEBUG_MODE is set to true. This interface enables you to manage your database models with ease. 
        <br/><small>Please be sure to change your APP_KEY to the below in your .config file for maximum security. <em style=\'font-weight: 800;color:gray\'><br/><strong>APP_KEY = base64:'.password_hash(Math1::getUniqueId(), 1).'</strong></small>
        <br/><code class="ex_note">Please Note that Action Here Cannot Be Undo.</code></small>');

        // Data buffer
        $existsModel = @Db1::getExistingModels();
        $modelMethodList = ['tableCreate()', 'tableReset()', 'tableTruncate()', 'tableDestroy()', 'tableSaveBackup()', 'tableLoadBackup()', 'generateDemoData(1)'];
        $modelBuff = "<div><strong>Created Model Table : ".count($existsModel).'/'.count(app_model_list() )."</strong><span style='float:right'>".HtmlForm1::addInput(null, ['placeholder'=>'search model', 'id'=>'model_search', 'style'=>'padding:10px;'])."</span> <br><small style='color:gray;padding:3px;font-size:12px;'>If Model is red, click on <small>tableCreate()</small> Button to Create table for it</small> <div style='clear:both'></div></div><hr/>";

        // Database Method
        $modelBuff .= "<table style='width:100%' id='model_table'>";
        foreach (app_model_list() as $model){
            $modelBuff .= "<tr><td><strong>".(in_array($model, $existsModel)? $model: "<code class='ex_note'>$model</code>")."</strong></td>";
            foreach ($modelMethodList as $method)$modelBuff .= "<td>".exForm1::makeRunnableForm($model, $method, $method)."</td>";
            $modelBuff .= "</tr>";
        }
        $modelBuff .= "</table>";

        // Database Method
        $dbMethodList = ['tableCreateAll()', 'tableResetAll()', 'tableTruncateAll()', 'tableDestroyAll()', 'tableClearBackupAll()', 'tableSaveBackupAll()', 'tableLoadBackupAll()'];
        $modelBuff .= "<br/><br/><code class=\"ex_note\">The Function Below Is Disabled by Default for security reason, to Enable it, Make Db1::class extends Controller1.</code>";
        $modelBuff .= "<table  style='width:100%'><tr><td><strong>Database</strong></td>";
        foreach ($dbMethodList as $method)$modelBuff .= "<td disabled=''>".exForm1::makeRunnableForm('Db1', $method, $method)."</td>";
        $modelBuff .= "</tr></table>";

        Console1::println($modelBuff);
        Console1::println("<h4 align='center'>Check Out <a href='http://ehex.xamtax.com'>Ex Documentation</a> Now<hr/><small>Made with Love by <a href='https://github.com/samtax01'>Samson Iyanu</a> @ <a href='http://xamtax.com'>Xamtax</a></small></h4>");
        echo "<br/><br/>";

        Page1::end();
        if($endPage) exit;
    }



    /*
     * Create Database
     */
    static function databaseCreate() {   if (!static::exec( "CREATE DATABASE IF NOT EXISTS `" . Config1::DB_NAME."`  DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci", true, false)){ die( "Cannot create Database 'Database'. WHY? [" . (DbAdapter1::getLastErrorMessage(static::$DB_HANDLER)) . "]"); } }

    /*
     * Delete Database
     */
    static function destroyDatabase() {  static::exec( "DROP DATABASE " . Config1::DB_NAME, true);}

    /**
     * Create Multiple Table at once
     * @param Model1 ...$modelList
     * 
     */
    static function tableCreate(...$modelList){
        static::databaseCreate();
        $tableRunBuffer = '';
        $logBuffer = '';
        $logFormat = "<br/><br/><hr/><h5> Creating Table for [%s]</h5><hr/> %s";

        foreach ($modelList as $modelClass) {
            if(empty($modelClass)) continue;
            $modelInstant = (new $modelClass());
            $createQuery = '';
            if( method_exists($modelInstant, 'toTableCreateQuery') )  $createQuery = $modelInstant->toTableCreateQuery();
            else $modelClass::tableCreate();
            $tableRunBuffer .= $createQuery;
            $logBuffer .=  sprintf($logFormat, $modelClass, $createQuery);
        }
        if(empty($tableRunBuffer)) return;
        Session1::setStatus('Creating DB Table(s)', $logBuffer);
        Db1::exec($tableRunBuffer, true, true, true, true);
    }

     /**
      * Create table for all Available Model
      */
     static function tableCreateAll(){  static::tableCreate( ...app_model_list() );  }

    /*
     * Reset all Database Table [ delete and re-create with data ]
     */
    static function tableReset(...$modelList){ static::databaseCreate(); foreach ($modelList as $model) $model::tableReset(); }
    static function tableResetAll(){ static::tableReset(...Db1::getExistingModels());  }

    /*
     * Delete all Database Table
     */
    static function tableDestroy(...$modelList){ foreach ($modelList as $model) $model::tableDestroy(); }
    static function tableDestroyAll(){  static::tableDestroy(...Db1::getExistingModels());  }



    /*
     * Delete all Database Table
     */
    static function tableSaveBackupAll($optionalBackupFolderName = 'all'){
        $path = path_asset("backups".DIRECTORY_SEPARATOR."$optionalBackupFolderName");
        $result = []; foreach (Db1::getExistingTables(true) as $tableName=>$dbTableName) $result = $tableName::tableSaveBackup(rtrim($path, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$tableName.'.model.json');
        Session1::setStatus("Backup Completed", "Backed Up (".count($result).") Models", 'success');
        return $result;
    }


    /**
     * Restore all backup. Model Backup must end with '.model.json'
     * @param string $optionalBackupFolderName
     * @param bool $clearExistingData
     * @return array
     */
    static function tableLoadBackupAll($optionalBackupFolderName = 'all',  $clearExistingData = true){
        $result = FileManager1::getDirectoryFiles(path_asset("backups".DIRECTORY_SEPARATOR."$optionalBackupFolderName"), true, function($path) use ($clearExistingData){
            if(String1::endsWith($path, '.model.json')){
                $modelNameFromFileName = Array1::getFirstItem(explode('.', FileManager1::getFileName($path)));
                return $modelNameFromFileName::tableLoadBackup($path, $clearExistingData);
            }
        });
        return $result;
    }

    /**
     * Clear all backup, for safety
     * @param string $optionalBackupFolderName
     * @return bool
     */
    static function tableClearBackupAll($optionalBackupFolderName = 'all'){ return FileManager1::deleteAll(path_asset("backups".DIRECTORY_SEPARATOR."$optionalBackupFolderName"),true); }










    /**
     * create table with  - e.g createClassTable(UserInfo::getCreateQuery());
     * @param $tableQuery
     * @return bool
     * 
     */
    static function createClassTable($tableQuery) {
        $result = static::exec($tableQuery);
        if($result) return true;
        die("Cannot create tableInfo [ ".substr($tableQuery, 0, 37)." ]");
    }


     /**
      * Get Existing Table Column Information.
      * @param string $tableName
      * @return array
      */
    static function getTableDbField($tableName = 'users'){
        return DbAdapter1::getTableDbField($tableName);
    }


    /**
     * Get Existing Table
     *  using USE db_name; SHOW TABLES;
     * @param bool $withModelName
     * @return array
     */
    static function getExistingTables($withModelName = true){
        try{
            if(isset(Page1::$_VARIABLE['__getExistingTables'][$withModelName])) return Page1::$_VARIABLE['__getExistingTables'][$withModelName];


            $allTableName= [];
            $queryResult = static::exec("SHOW TABLES;", true, true, false);
            if(!$queryResult) return [];
            foreach ($queryResult  as $db=>$table) $allTableName[] = $table['Tables_in_'.Config1::DB_NAME];
            if(!$withModelName) return Page1::$_VARIABLE['__getExistingTables'][$withModelName] = $allTableName;

            // merge model with declared table name
            $modelNameAndTableName = [];
            array_map(function($modelName) use ($allTableName, &$modelNameAndTableName){
                if(in_array($modelName::getTableName(), $allTableName)) $modelNameAndTableName[$modelName] = $modelName::getTableName();
            }, app_model_list());



            return Page1::$_VARIABLE['__getExistingTables'][$withModelName] = $modelNameAndTableName;
        }catch(ErrorException $ex){ return []; }
    }

    /**
     * Get Existing Table
     *  using USE db_name; SHOW TABLES;
     * @return array
     */
    static function getExistingModels(){
        if(isset(Page1::$_VARIABLE['__getExistingModels'])) return Page1::$_VARIABLE['__getExistingModels'];
        return Page1::$_VARIABLE['__getExistingModels'] = array_keys(static::getExistingTables(true));
    }

}





/**
 * Interface Controller1RouteInterface
 * Use for (new RouteSystem)->resource('', '', [])
 */
interface Controller1RouteInterface{
    /**
     * Return First Page interface. Like Home
     * Access with url('/{model}/')
     * @return mixed
     */
    static function  index();

    /**
     * View Search Model
     * Access with url('/{model}/search')
     * @param $text
     * @return mixed
     */
    //static function  search($text = '');

    /**
     * Return Show View interface
     * Access with url('/{model}/model_id_or_slug')
     * @param $id
     * @return mixed
     */
    static function  show($id);

    /**
     * Return Manage View interface
     * Access with url('/{model}/manage')
     * @return mixed
     */
    static function  manage();

    /**
     * Return Edit View interface
     * Access with url('/{model}/{model_id_or_slug}/edit')
     * @param $id
     * @return mixed
     */
    static function  edit($id);

    /**
     * Return Create View interface
     * Access with url('/{model}/create')
     * @return mixed
     */
    static function  create();


    /**
     * Update Model Information
     * Access with <form action="Form1::callController(Model1::class, 'processSave()')" > <?= form_token() ?>  ... </form>
     * @param $id
     */
    static function processSave($id = null);

    /**
     * Delete Model
     * Access with <form action="Form1::callController(Model1::class, 'processDestroy()')" > <?= form_token() ?> ... </form>
     * @param $id
     */
    static function processDestroy($id);
}









/**
 * Display in Admin Dashboard
 * Interface ModelAdmin
 */
interface Model1ActionInterface{
    /**
     * Dashboard Menu.
     * for quick implementation visit
     * @see https://ehex.github.io/ehex-docs/#/BasicUsage?id=model-dashboard
     * @return array
     */
    static function getDashboard();

    /**
     * Manage model with HtmlForm1 or xcrud.
     * for quick implementation visit
     * @see https://ehex.github.io/ehex-docs/#/BasicUsage?id=model-manage
     * @return mixed|Xcrud|HtmlForm1
     */
    static function manage();


    /**
     * Model Sidebar menu list.
     * for quick implementation visit
     * @see https://ehex.github.io/ehex-docs/#/BasicUsage?id=model-route-and-menu
     * @return mixed|array
     */
    static function getMenuList();

    /**
     * Model Route List
     * for quick implementation visit
     * @see https://ehex.github.io/ehex-docs/#/BasicUsage?id=model-route-and-menu
     * @param exRoute1 $route
     */
    static function onRoute($route);


    /**
     * Save  Model Information
     * for quick implementation visit
     * @see https://ehex.github.io/ehex-docs/#/BasicUsage?id=model-process-save
     * @param $id
     */
    static function processSave($id = null);
}





/**
 * Display in Admin Dashboard
 * Interface ModelAdmin
 */
interface Model1PageInterface{
    /**
     * Save  Model Page Information
     * Simply Call PageModel1Class::saveDefault($_POST)
     *  e.g Session1::setStatusFrom(static::saveDefault($_POST)? ['Updated', 'Page Updated!', 'success']: ['Failed', 'Failed to Updated Page', 'error']);
     */
    static function processUpdatePage();


    /**
     * Manage PageModel1Class with HtmlForm1 or xcrud
     * simply  call.
     *  e.g  return static::getDefault()->form([])->setFieldAttribute([ 'address'=>['type'=>'textarea'], ]);
     * @return mixed|Xcrud|HtmlForm1
     */
    static function manage();
}






/*********************************************************************************************************************************************************************************
 *
 * [  MODEL ]
 *
 * Author : Samson Iyanu
 * Version : 1.0
 * Description : Database Model Class..., User Model should extend This  So you can have access to SQL function and Database Query and sample
 * Class : model1
 *
 *
 *
 * How to Use Model1 Class
 * Create a PHP class and extend Model1, Add some public variables in the following ways
 *  E.G
 *  $id = -1 or any number // INTEGER will be use in toCreateQuery() and will be made primary key and auto_increment (Primary key can be override in Model e.g $PRIMARY_KEY_NAME = 'pid')
 *  $user_name = '' // VARCHAR(250) will be use in toCreateQuery(), so as any string
 *  $full_name = '' // VARCHAR(250) will be use in toCreateQuery()
 *  $address = null // TEXT will be use in toCreateQuery() (So as for any Null Value Variables)
 *  $created_at = '' // TIMESTAMP will be use in toCreateQuery() (So as for any variable name ends with _at)
 *  $created_date = '' // DATE will be use in toCreateQuery() (So as for any variable name ends with _date)
 *  $created_time = '' // TIME will be use in toCreateQuery() (So as for any variable name ends with _time)
 *  $sex = [] // ENUM will be use in toCreateQuery() (So as for any variable name ends with _time)
 *      NOTE = $create_at and $updated_at will be created automatically as fix column  (FIX COLUMN can be override in Model e.g $FIX_COLUMN = ['id', 'created_at', 'updated_at'])
 *
 *      We Use this variables dataType to create equivalent MySQL Table,
 *      You can get all query with to...Query(), e.g toCreateQuery(), toInsertQuery($array_key_value_toInsert = []), toUpdateQuery($array_key_value_toUpdate = [])
 *
 *********************************************************************************************************************************************************************************/
abstract class Model1 extends Controller1 {




    /**
     * @var bool
     * Do not Execute Query, Just Display it
     */
    public static $FLAG_SHOW_EXEC_QUERY = false;

    /**
     * No Column Must be filtered
     * @var bool
     */
    public static $FLAG_COLUMN_NO_FILTER = false;

    /**
     * Do Not filter list
     * @var array
     */
    public static $COLUMN_NO_FILTER_LIST = [];

    /**
     * filter but restore variable state
     * @var array
     */
    public static $COLUMN_UN_FILTER_LIST = [];
    
    
    /**
     * allowed callable method
     * @var array
     */
    public static $CLF_CALLABLE_LIST = Config1::MODELS_CLF_CALLABLE_LIST;
    
    

    /**
     * Set SQL property
     *  either in Model with
     *      $COLUMN_SQL_PROPERTY_LIST = [  'id'=>'INTEGER  NULL DEFAULT 110',  'fullName'=>'TEXT  NULL', ... ]
     *  OR in Debug Mode with
     *      Model1::createTable( ['id'=>'INTEGER  NULL DEFAULT 110 '], .... )
     * @see https://ehex.github.io/ehex-docs/#/Model%20and%20Database?id=manual-sql-property-set for more information
     */
    public static $COLUMN_SQL_CREATE_PROPERTY = [];



    /**
     * @var string
     * Last Executed Message
     */
    public static    $EXECUTED_MESSAGE = '';


    /**
     * @var int
     *  Maximum String Length for default varchar datatype
     */
    public static    $SQL_VARCHAR_STRING_LENGTH = 350;


    /**
     * @var string
     * SQL timeStamp format
     */
    public static    $SQL_TIMESTAMP_FORMAT = 'Y-m-d G:i:s'; //Y-m-d H:1:s

    /**
     * @var array
     * Default Column that will be created for all column
     */
    public static    $FIX_COLUMN = ['id', 'created_at', 'updated_at'];

    /**
     * @var array
     * Default Column that will be created for all column
     */
    public static    $UNIQUE_COLUMN = [];


    /**
     * @var string
     * default primary key for all model, will be create automatically
     */
    public static    $PRIMARY_KEY_NAME = 'id';

    /**
     * @var string
     * ID AUTOINCREMENT START FROM
     */
    public static    $AUTOINCREMENT_FROM = 0;


    /**
     * @var null
     * foreign link for linking and binding field to another model
     * e.g on Blog model, you can put $FOREIGN_LINK_FIELD = ['user_id'=>User::class];
     * where user_id is the field for User Id and User Class is d class. The Call $PRIMARY_KEY_NAME is used by default
     */
    public static    $FOREIGN_LINK_FIELD = ['user_id'=>User::class];


    /**
     * @var null
     * current table name
     */
    public static    $TABLE_NAME = null;



    /**
     * EasyModel constructor.
     * @return $this
     * @param array $column_and_value
     *  init Model Field
     */
    public function __construct($column_and_value = []){
        $filterArray = ($column_and_value);
        if(empty($filterArray)) return null;
        foreach ($filterArray as $key=>$value){
            $this->{$key} = $value;
        }
        return $this;
    }


    /**
     * @return null|string|string[]
     * get generated table name. always in plural of model form.
     * e.g User Mode turns to users
     * Child = children
     */
    static function getTableName(){
        if(isset(static::$TABLE_NAME) && !empty(static::$TABLE_NAME)) return static::$TABLE_NAME;
        $convertToSnakeCase = function($value){ return $word = preg_replace_callback("/(^|[a-z])([A-Z])/", function($m) { return strtolower(strlen($m[1]) ? "$m[1]_$m[2]" : "$m[2]"); }, $value); };
        $pluralize = function($singular) { return String1::pluralize($singular); };
        return /*static::$TABLE_NAME =*/ strtolower($convertToSnakeCase( $pluralize(((string)static::getModelClassName())) ));
    }


    /**
     * @param bool $addMethod
     * @return $this
     * get Model Instance with / without method
     */
    function getModel($addMethod = true){ return Object1::cast($this, static::getModelClassName(), $addMethod); }

    /**
     * Get Previous Model
     * @param null $sortColumnName
     * @return static|ResultStatus1
     */
    function getPreviousModel($sortColumnName = null) {
        $sortColumnName = $sortColumnName? $sortColumnName:static::$PRIMARY_KEY_NAME; // $data = static::exec("SELECT * FROM ".static::getTableName()." WHERE ".$sortColumn." = (select max(".$sortColumn.") FROM ".static::getTableName()." WHERE ".$sortColumn." < ".$this->{$sortColumn}." )", true, true );
        $data = static::exec("SELECT * FROM ".static::getTableName()." WHERE ".$sortColumnName."  < ".$this->{$sortColumnName}." ORDER BY ".$sortColumnName." DESC LIMIT 1 ", true, true );
        return $data? $data[0] : ResultStatus1::falseMessage('Previous Record Not Found');
    }

    /**
     * Get Next Model
     * @param null $sortColumnName
     * @return static|ResultStatus1
     */
    function getNextModel($sortColumnName = null){
        $sortColumnName = $sortColumnName?$sortColumnName:static::$PRIMARY_KEY_NAME; //$data = static::exec("SELECT * FROM ".static::getTableName()." WHERE ".$sortColumnName." = (select min(".$sortColumnName.") FROM ".static::getTableName()." WHERE ".$sortColumnName." > ".$this->{$sortColumnName}." )", true, true );
        $data = static::exec("SELECT * FROM ".static::getTableName()." WHERE ".$sortColumnName."  > ".$this->{$sortColumnName}." ORDER BY ".$sortColumnName." ASC LIMIT 1 ", true, true );
        return $data? $data[0] : ResultStatus1::falseMessage('Next Record Not Found');
    }

    /**
     * @param bool $asFriendly
     * @return string
     */
     static function getModelClassName($asFriendly = false){ return  $asFriendly? ucwords(String1::convertToSnakeCase(static::class, ' ')): static::class;  }

    /**
     * Magic Method
     *      with...()
     *          use $model->withVariable to set variable in your model
     *          e.g $model->withEmail to set email of model
     *
     * @param $func
     * @param $params
     * @return $this
     */
    function __call($func, $params){
        // if start with "with". Example User::withId =
        if(isset($this->$func)) {
            if (String1::startsWith($func, 'with')) $this->{lcfirst(String1::replaceStart($func, 'with', ''))} = $params[0]; //call_user_func_array($func, $params[0]);
            return $this;
        }
    }



    /**
     * @param $id
     * @param string $idField : id
     * @param array $othersField = ['full_name'=>'samson iyanu']
     * @return static
     */
    static function withId($id, $idField = 'id', array $othersField = []){ return static::findOrInit( Array1::merge([$idField=>$id], $othersField)); }


    /**
     * @return array
     */
    static function getDbTableField(){ return Db1::getTableDbField(static::getTableName()); }

    /**
     * @return array
     */
    static function getModelTableField(){
        $keyValue = [];
        foreach (static::toModelColumnValueArray() as $key=>$value){
            $keyValue[$key] = self::convertToMySqlDataType($key, $value, true);
        }
        return $keyValue;
    }

    static function getFixColumn(){ return @array_flip(static::$FIX_COLUMN); }

    //    /**
    //     * @return array
    //     * get model property, any property starting with __
    //     */
    //    private static function getModelPropertyColumn(){  return Array1::startsWith( Object1::getClassVariables(new Static), ['__']); }

    /**
     * @param null $objectInstance
     * @return array
     * get all needed column for table
     */
    static function toModelColumnValueArray($objectInstance = null){
        // remove field variable
        $pureVariable = [];
        $classFields = $objectInstance? $objectInstance: new static;
        $objectClass = $objectInstance? Array1::toArray((new $objectInstance)): null;   // ErrorFixed: instance model returns model data with model functions too which is buggy wrong. therefore we need just model data here.
        foreach (get_object_vars($classFields) as $key=> $value) {
            if(!String1::startsWith($key, '__') && ($objectClass? array_key_exists($key, $objectClass): true)   ) $pureVariable[$key] = $value;
        }
        return Array1::merge(static::getFixColumn(), $pureVariable);
    }

    /**
     * @return array
     * get Array List of Column and Database or Default Value
     */
    function toArray(){ return static::toModelColumnValueArray($this); } //return  Object1::getClassObjectVariables($this);



    /**
     * @param $query
     * @param bool $normalizeAndListAsArray
     * @param bool $makeArray_ArrayObject
     * @return array|ArrayObject|bool|mysqli_result|null
     *  Run Query and return Smart ArrayObject when result is array. So You can access Each Property either ways
     *      E.g
     *          User::find(1)->full_name
     *          User::find(1)['full_name']
     *          User::find(1)->update(['full_name', 'samson iyanu'])
     *
     *      Enable ( static::$FLAG_EXEC_AS_QUERY = true ) to see code to run
     *      E.g
     *          User::$FLAG_EXEC_AS_QUERY = true;
    * Console1::println(  User::findAll(['id'=>'1', 'user_name'=>'samson iyanu']) );
     *          Output: SELECT *  FROM `users` WHERE `id` = '1' OR `user_name` = 'samson iyanu'
     *          Instead of Running it
     */
    static function exec($query, $normalizeAndListAsArray = false, $makeArray_ArrayObject = false){
        if(static::$FLAG_SHOW_EXEC_QUERY) return $query;
        $normalizeAndListAsArray = $makeArray_ArrayObject? true: $normalizeAndListAsArray;
        if( !$query || trim($query) == '') return null;
        try{
            //$result = ($asArray)? mysqli_fetch_all(Db1::exec($query), MYSQLI_ASSOC): (Db1::exec($query));
            $result = ($normalizeAndListAsArray)? @static::cursorToArray(@Db1::exec($query), $makeArray_ArrayObject): (Db1::exec($query));
            static::$EXECUTED_MESSAGE = 'Action Successful';
            if($makeArray_ArrayObject && $result && is_array($result) ) return Object1::toArrayObject(true, $result);
            else return $result;
        }catch (Exception $ex){ static::$EXECUTED_MESSAGE = $ex->getMessage(); return null; }
    }

    /**
     * Get Last Executed message
     * @return string
     */
    static function getMessage(){ return static::$EXECUTED_MESSAGE; }

    /**
     * database query result list normalizer...
     * @param $queryOutput
     * @param bool $makeArray_ArrayObject
     * @return array
     */
    static function cursorToArray($queryOutput, $makeArray_ArrayObject = false ){
        return DbAdapter1::cursorToArray($queryOutput, static::class, $makeArray_ArrayObject);
    }


    /**
     * filter String
     * @param $str
     * @return string
     */
    static function mysqlFilterValue($str){
        Db1::open();
        return DbAdapter1::escapeString($str, Db1::$DB_HANDLER);
    }

    /**
     * Restored filter String
     * @param $str
     * @return mixed
     */
    static function mysqlUnFilterValue($str){
        return DbAdapter1::unEscapeString($str, Db1::$DB_HANDLER);
    }



    /**
     * @return \Illuminate\Database\Query\Builder
     * Visit https://github.com/illuminate/database
     */
    static function query(){
        return \Illuminate\Database\Capsule\Manager::table(static::getTableName()); //include_once ('assets/library/sparrow/sparrow.php'); //return (new Sparrow())->from(static::getTableName());
    }





//    static $paginationData = [];
//    /**
//     * Put your query in paginationLimit($query='...')
//     *  E.g
//        $pagination = Product::selectMany( true, Product::paginationLimit('WHERE category = "Games"', 2) );
//        foreach ($pagination as $row){
//            echo $row->id;
//        }
//        // Render Pagination Template with
//        echo Product::paginationRender();
//     *
//     * @param string $prefixQuery
//     * @param int $limit
//     * @param string $templateClass
//     * @param string $requestPageKeyName
//     * @return mixed
//     */
//    static function paginationLimit($prefixQuery = '', $limit = 10, $templateClass = BootstrapPaginationTemplate::class, $requestPageKeyName = 'page'){
//        $total = static::count($prefixQuery, 'count('.static::$PRIMARY_KEY_NAME.') as data');
//        $ql = MySql1::makeLimitQueryAndPagination($prefixQuery, $total, $limit, $templateClass, $requestPageKeyName);
//        static::$paginationData[static::getModelClassName()] = $ql->paginate;
//        return $ql->query;
//    }
//
//    /**
//     * @return string
//     */
//    static function paginationRender(){ return String1::isset_or(static::$paginationData[static::getModelClassName()], '');  }
//
//
//    /**
//     * @return \Pixie\QueryBuilder
//     * Raw Eloquent Builder
//     */
//    static function raw(){ return QB::class; }


    /**
     * Pagination for Model
     * @param string $query
     * @param int $per_page
     * @param string $templateClass
     * @param string $requestPageKeyName
     * @param array $selectColumn
     * @return array|Object1::toArrayObject
     * @see paginationApi() or api
     */
    static function paginate($query = "", $selectColumn = [], $per_page = 10, $templateClass = BootstrapPaginationTemplate::class, $requestPageKeyName = 'page'){
        $total = static::count($query, 'count('.static::$PRIMARY_KEY_NAME.') as data');
        $ql = MySql1::makeLimitQueryAndPagination($query, $total, $per_page, $templateClass, $requestPageKeyName);
        $allData = static::selectMany(true, $ql->query, $selectColumn);
        return Object1::toArrayObject(true, [
            "data"=>$allData,
            "render"=>$ql->paginate,
            "total"=>$total,
            "count"=>count($allData)
        ]);
    }

    /**
     * Pagination for Api
     * @param string $query
     * @param int $per_page
     * @param array $selectColumn
     * @param array $config
     * @return array|string
     * @see pagination() or Model
     */
    static function paginateApi($query = "", $per_page = 10, $selectColumn = [], $config = ['max_page_count'=>6]){
        $config = array_merge(['max_page_count'=>6], $config);
        $per_page = isset_or($_REQUEST['per_page'], $per_page);
        $current_page = +isset_or($_REQUEST['page'], 1);
        // limit
        $total = static::count($query, 'count('.static::getTableName().'.'.static::$PRIMARY_KEY_NAME.') as data');
        $query = $query.' '.MySql1::makeLimitQuery($current_page, $per_page);
        $total_pages = ceil($total / $per_page);
        // page
        $link = ['first'=>($current_page != 1? Url1::replaceParameterAndGetUrl(['page'=>1]): null), 'prev'=>null, 'next'=>null, 'last'=>$total_pages > 1 && $current_page != $total_pages? Url1::replaceParameterAndGetUrl(['page'=>$total_pages]): null];
        $meta = ['prev'=>0, 'next'=>0, 'more'=>Math1::getSurroundingValues($total_pages, $current_page, $config['max_page_count']), 'per_page'=>$per_page, 'current_page'=>$current_page, 'total_page'=>$total_pages, 'total_count'=>$total, 'path'=>Url1::getPageFullUrl(['page'=>''])];
        if( ($current_page-1) > 0){
            $meta['prev'] = $current_page - 1;
            $link['prev'] = Url1::replaceParameterAndGetUrl(['page'=>$meta['prev']]);
        }
        if( ($current_page+1) <= $total_pages) {
            $meta['next'] = $current_page + 1;
            $link['next'] = Url1::replaceParameterAndGetUrl(['page'=>$meta['next']]);
        }
        return [
            "data"=>static::selectMany( false, $query, $selectColumn),
            "links"=>$link,
            "meta"=>$meta,
        ];
    }


    /**
     * @param array $visibleField
     * @param array $invisibleField
     * @param array $hiddenField    @default is ['id', 'created_at', 'updated_at', 'last_login_at']
     *  Form Builder
     * @return HtmlForm1
     */
    function form($visibleField = [], $invisibleField = [], $hiddenField = null){ return new HtmlForm1($this, $visibleField, $invisibleField, $hiddenField? $hiddenField: static::$FIX_COLUMN); }


    /**
     * @param int $findModelById
     * @param array $visibleField
     * @param array $invisibleField
     * @param null $hiddenField
     * @return HtmlForm1
     *      Similar to $model->form(),  Auto Form Generator with EasyForm HtmlForm1 Class
     */
    static function formMake($findModelById = -1, $visibleField = [], $invisibleField = [], $hiddenField = null){
        $newModel = ($findModelById && $findModelById>0)?  static::find($findModelById): null;
        return new HtmlForm1($newModel? $newModel->getModel(false): (new static()), $visibleField, $invisibleField, $hiddenField? $hiddenField: static::$FIX_COLUMN);
    }


    /**
     *
     * @param null $table_name
     * @param string $order_by
     * @param null $query
     * @return mixed | Xcrud
     * @internal param null $invisibleColumn @default is ['id', 'created_at', 'updated_at', 'last_login_at']
     *  Get xcrud Instance
     *
     *
     * ->fields('id, created_at, updated_at, user_id, file_name', true)
     * ->columns('english_name, yoruba_name, botanical_name')
     *
     * ->limit(50)
     *
     * ->unset_add()
     * ->unset_edit()
     * ->unset_csv()
     * ->unset_title()
     * ->unset_print()
     *
     * ->button(url('/herb/{id}/edit'),  "Edit Item","icon-pen","")
     *
     *
     * ->validation_required('unique_identification, title, issue_date')
     *
     * ->change_type('role', 'select', null, Array1::reUseValueAsKey(static::getRoles()))
     * ->change_type('sex', 'select', null, Array1::reUseValueAsKey(['male', 'female']))
     *
     * ->column_callback('title', [self::class, 'blogTitleAndCommentTotal']);
     */
    static function xcrud($table_name = null, $order_by = 'id', $query = null) { //, $pass_default = ['id'=>'']
        Xcrud_load();
        $xcrud = Xcrud_instance();
        $xcrud->table(static::getTableName());
        if($order_by)  $xcrud->order_by($order_by, 'desc');
        if($table_name)  $xcrud->table_name($table_name);
        if(!String1::is_empty($query)) $xcrud->query($query);
        //$xcrud->pass_default($this->toArray());
        //if(!$invisibleColumn){ $xcrud->columns(static::$FIX_COLUMN, true); $xcrud->fields(static::$FIX_COLUMN, true);}
        //$xcrud->no_quotes('updated_at');
        //$xcrud->pass_var('updated_at','now()');
        return $xcrud;
    }






    /**
     *  Search list of values in list of columns
     *
     * @param array $values
     * @param array $inColumn
     * @param array $selectColumn
     * @param string $logic
     * @param string $operator
     * @param string $otherQuery
     * @return array|ArrayObject|bool|mysqli_result|null]
     *
     */
    static function findIn($values = [], $inColumn = [], $selectColumn = [], $logic = 'OR', $operator = ' = ', $otherQuery = ''){
        $columnList = static::tableColumnMerge($selectColumn);
        $selectWhere = MySql1::toWhereValuesInColumnsQuery($inColumn, $values, $logic, $operator);
        $selectWhere =  ("SELECT $columnList  FROM ".static::getTableName()).((trim($selectWhere)!='')? ' WHERE '.$selectWhere:'').' '.$otherQuery;
        $result = static::exec($selectWhere, true, false);
        return $result? $result : ResultStatus1::falseMessage('Record Not Found!');
    }


    /**
     * @param array|ArrayObject1|ArrayAccess $key_value_array
     * @param string $findValue
     * @param string $findColumn
     * @return static|ResultStatus1 :  of init model
     */
    static function findOrInit($key_value_array  = [], $findValue = null, $findColumn = 'id'){
        $foundModel = (!empty($findValue))? static::find($findValue, $findColumn, '', [], false): [];
        $mergeData = Array1::merge(Object1::toArray($key_value_array), $foundModel? $foundModel:[]);
        $data = (count(Array1::toArray($mergeData)) < 1) ? static::toModelColumnValueArray(): $mergeData;
        return empty($data) ? ResultStatus1::make(false, 'Empty Model', null):  Object1::toArrayObject(true,   Object1::convertArrayToObject($data, static::getModelClassName()) );
    }

    /**
     * @param $id_or_value
     * @param string $inColumnName
     * @param callable|null $errorCallback
     * @return static|string
     */
    static function findOrFail($id_or_value, $inColumnName = 'id', callable $errorCallback = null){
        $model = static::find($id_or_value, $inColumnName);
        if($model) return $model;
        if($errorCallback) return $errorCallback();

        // redirect to previous page or to error404 Page if previous failed

        $status = ucfirst(static::getModelClassName(true))." ($id_or_value) Not Found";
        return redirect_failed( [ucfirst(static::getModelClassName()).' Failed', $status, 'error'] );
    }


    /**
     * @param $id_or_value
     * @param string $inColumnName default is Primary Id
     * @param string $andOtherQuery
     * @param array $selectColumn
     * @param bool $convertToModel1
     * @return string|static
     */
    static function find($id_or_value, $inColumnName = 'id', $andOtherQuery = '', $selectColumn = [], $convertToModel1 = true){
        if(empty($id_or_value)) return ResultStatus1::falseMessage('Invalid Id Set!');
        $id_or_value = (is_array($id_or_value) && isset($id_or_value['id']) )? $id_or_value['id']: $id_or_value;
        $tableName = static::getTableName();
        $columnList = static::tableColumnMerge($selectColumn);
        $result = static::exec("SELECT $columnList FROM `$tableName` WHERE `".(($inColumnName === 'id')? static::$PRIMARY_KEY_NAME: $inColumnName)."` = '$id_or_value' $andOtherQuery  limit 1", true, false);
        if(static::$FLAG_SHOW_EXEC_QUERY) return $result;

        // convert
        if(!$convertToModel1) return (!empty($result))? $result[0]: null;
        $newObject = ($result)? Object1::toArrayObject(true,   Object1::convertArrayToObject($result[0], static::getModelClassName()) ): null;
        return ($result && (count($result)>0)) ? $newObject : ResultStatus1::falseMessage('Record Not Found!');
    }


    /**
     * @param array $column_and_value
     * @param string $logic
     * @param string $operator
     * @param string $sortOrLimitQuery
     * @param array $selectColumn
     * @return array|ArrayObject|bool|mysqli_result|null
     *  Get Equal Or Likely Value
     */
    static function findMany($column_and_value = [], $logic = ' AND ', $operator = ' = ', $sortOrLimitQuery = "", $selectColumn = []){
        $selectWhere = static::toSelectWhereQuery($column_and_value, $selectColumn, $logic, $operator, $sortOrLimitQuery);
        return static::exec($selectWhere, true, false);
    }




    /**
     * @param string $valueA
     * @param string $valueB
     * @param array $search_in_columnA_list
     * @param array $search_in_columnB_list
     * @param string $againstLogic
     * @param string $logic
     * @param string $operator
     * @param array $selectColumn
     * @return array|ArrayObject|bool|mysqli_result|null Assign $valueA to all paramsArray or $columnA ( e.g ['user_name', 'email'] )
     *
     * Assign $valueA to all paramsArray or $columnA ( e.g ['user_name', 'email'] )
     *
     * Assign $valueB to all paramsArray or $columnB ( e.g ['password', 'api_secret'] )
     *
     * Now, select datas Where $columnA[..$valueA...]  $againstLogic ( AND ) $columnB[..$valueB...]
     */
    static function findAgainst($valueA = 'samtax01', $valueB = '123456', $search_in_columnA_list = ['user_name', 'email'], $search_in_columnB_list =  ['password'], $againstLogic = ' AND ', $logic = ' OR ', $operator = ' = ', $selectColumn = []){
        $columnList = static::tableColumnMerge($selectColumn);

        $columnA_plus_valueA = [];
        foreach (@array_flip($search_in_columnA_list) as $key=> $value)
            $columnA_plus_valueA[$key] = $valueA;

        $columnB_plus_valueB = [];
        foreach (@array_flip($search_in_columnB_list) as $key=> $value)
            $columnB_plus_valueB[$key] = $valueB;


        $query =  "SELECT $columnList  FROM `".static::getTableName()."` WHERE ".
            " (".Array1::mergeKeyValue($columnA_plus_valueA, $operator, $logic, "`%s`", "'%s'")." )"
            .(empty($columnB_plus_valueB)? '': $againstLogic.
            " (".Array1::mergeKeyValue($columnB_plus_valueB, $operator, $logic, "`%s`", "'%s'")." )");

        return static::exec($query, true, false);
    }




    /**
     * @param array $column_and_value
     * @return Model1|null
     */
    function update($column_and_value = []){ return static::exec($this->toUpdateQuery($column_and_value))? static::findOrInit(Array1::merge(Object1::toArray($this), $column_and_value)) : null; }



    /**
     * @param bool $deleteFromModel1FileLocator
     * @return array|ArrayObject|bool|mysqli_result|null
     */
    function delete($deleteFromModel1FileLocator = false){
        if($deleteFromModel1FileLocator) Model1FileLocator::deleteAll($this);
        $this->deleteAssetDirectory();
        return static::exec($this->toDeleteQuery());
    }

    /**
     * @param $id_or_value
     * @param string $inColumnName
     * @param bool $deleteFromModel1FileLocator
     * @return array|ArrayObject|bool|mysqli_result|null|ResultStatus1
     */
    static function deleteBy($id_or_value, $inColumnName = 'id', $deleteFromModel1FileLocator = false){ $model = static::find($id_or_value, $inColumnName); if($model) return $model->delete($deleteFromModel1FileLocator); else return ResultStatus1::falseMessage('Model Not Exist!'); }

    /**
     * @param bool $asAdd_orElseModify
     * @param string $keyAndParameter
     * @return array|ArrayObject|bool|mysqli_result|null
     */
    function alter($asAdd_orElseModify = true, $keyAndParameter = ' `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7 '){ return static::exec($this->toAlterQuery($asAdd_orElseModify, $keyAndParameter)); }


    static function deleteMany($whereColumn_and_value = [], $logic = ' AND ', $operator = ' = '){ return static::exec(static::toDeleteWhereQuery($whereColumn_and_value, $logic, $operator));}

    /**
     * @param array $update_column_and_value
     * @param array $whereColumn_and_value
     * @param string $logic
     * @param string $operator
     * @return array|ArrayObject|bool|mysqli_result|null
     *      Update Any Table Column with ( $update_column_and_value = [] ) where ( $whereColumn_and_value = [] )
     */
    static function updateMany($update_column_and_value = [], $whereColumn_and_value = [], $logic = ' AND ', $operator = ' = '){
        return static::exec(static::toUpdateWhereQuery($update_column_and_value, $whereColumn_and_value, $logic, $operator));
    }


    /**
     * Update column value
     * @param $id
     * @param $fieldName
     * @param $fieldValue
     * @param string $optionalIdColumnName
     * @return array|ArrayObject|bool|mysqli_result|null
     */
    static function setField($id, $fieldName, $fieldValue, $optionalIdColumnName = null){ return static::updateMany([$fieldName=>$fieldValue], [($optionalIdColumnName?? static::$PRIMARY_KEY_NAME)=>$id]); }


    /**
     * Get a column value
     * @param $id
     * @param $fieldName
     * @param null $defaultValue
     * @param string $optionalIdColumnName
     * @return array|ArrayObject|bool|mysqli_result|null
     */
    static function getField($id, $fieldName, $defaultValue = null, $optionalIdColumnName = null){
        $result = static::exec("SELECT $fieldName FROM `".static::getTableName()."` WHERE `".( ($optionalIdColumnName?? static::$PRIMARY_KEY_NAME).'` = "'.$id.'" ')." limit 1", true, false);
        if(static::$FLAG_SHOW_EXEC_QUERY) return $result;
        return ($result && isset($result[0][$fieldName])) ? $result[0][$fieldName]: $defaultValue;
    }



    /**
     * @param array $column_and_value
     * @param array $selectColumn
     * @param string $logic
     * @param string $operator
     * @return array|ArrayObject|bool|mysqli_result|null
     */
    static function all($column_and_value = [], $selectColumn = [], $logic = ' OR ', $operator = ' = '){ return static::exec( static::toSelectWhereQuery($column_and_value, $selectColumn, $logic, $operator), true ); }

    /**
     * @param array $initTable
     * @param bool $silent
     * @return array|ArrayObject|bool|mysqli_result|null
     * @see @destroy
     *  Crete Table
     */
    static function tableCreate($initTable = [], $silent = true){
        //if(in_array(static::getTableName(), Db1::getExistingTables(false))) return  Session1::setStatusIf($silent,'Table Exists', "Cannot re-create table (".static::getTableName()."), Table Exists!" );
        $status = static::exec((new static())->toTableCreateQuery());
        if(!empty($initTable) && (static::count() < 1)) static::insertMany(...$initTable);
        Session1::setStatusIf(!$silent,'Table Create', 'Table '.static::getTableName().' Create Query...<hr/>'.(new static())->toTableCreateQuery());
        return $status;
    }

    static function isTableExists(){ return in_array(static::getModelClassName(), Db1::getExistingModels()); }


    /**
     * @param bool $insertIntoModel
     * @param int $count
     * @param array $ignoreColumn
     * @param array $fieldAndPossibleValueArrayList
     * @param array $initField
     * @param bool $convertToModel
     * @return array|static
     *  Generate Demo Text
     *
     *
     * $userInfo = ['user_name'=>'samtax', 'password'=>'1234', 'email'=>'samtax01@gmail.com', 'role'=>(new User())->role ];
     * $userAdmin = ['user_name'=>'samtax_admin', 'password'=>'1234', 'email'=>'samsoniyanu@hotmail.com', 'role'=>'admin'];
     * User::insert(User::generateDemoData(1,null, null, $userInfo)[0], ['user_name', 'email']);
     * User::insert(User::generateDemoData(1,null, null, $userAdmin), ['user_name', 'email']);
     */
    static function generateDemoData($insertIntoModel = false, $count = 10, $ignoreColumn = ['id'], $fieldAndPossibleValueArrayList = ['id'=>['2', '4', '5']], $initField = [], $convertToModel = true){

        // init $fieldColumn with either TableColumn or DbColumn
        $fieldColumn = (static::isTableExists() ||  (!static::isTableExists() && $insertIntoModel && static::tableCreate()))?  static::getDbTableField(): static::getModelTableField();

        // generate data
        $resultData = DemoGenerator::fillModelArray($fieldColumn, $ignoreColumn, $fieldAndPossibleValueArrayList, $count);
        $buff = [];
        foreach ($resultData   as $fieldRow)   $buff[] = $convertToModel? static::findOrInit(Array1::merge($fieldRow, $initField)): Array1::merge($fieldRow, $initField);
        if($insertIntoModel) static::insertMany(...$buff);
        return $buff;
    }


    /**
     * @return array|ArrayObject|bool|mysqli_result|null
     * @see @create
     * Delete Table
     */
    static function tableDestroy(){ return static::exec( static::toDropTableQuery() ); }

    /**
     * @return bool
     * Reset Table
     */
    static function tableTruncate(){ return static::exec("TRUNCATE `".static::getTableName()."`"); }


    /**
     * rename table to something else
     * Please consider setting (static::$TABLE_NAME = "new_table") in your model, if you want to change model name
     * @param $newName
     * @return bool
     * Reset Table
     */
    static function tableRename($newName){ return static::exec("ALTER TABLE `".static::getTableName()."` RENAME TO $newName"); }


    /**
     * Remove duplicateRow
     * @param array $unique_key
     * @param bool $keepLastId. IF true, Last Id will Remain otherwise first Id will remain
     * @param string $delimeter
     * @return bool
     * Reset Table
     */
    static function tableDeleteDuplicateRows(array $unique_key = ['user_name', 'email'], $delimeter = "AND", $keepLastId = true){
        $where = Array1::mergeKeyValue(Array1::reUseValueAsKey($unique_key), "=", " $delimeter ", "t1.%s",  "t2.%s" );
        return static::exec("DELETE t1 FROM  `".static::getTableName()."` t1,  `".static::getTableName()."` t2 WHERE t1.id ".($keepLastId? "<" : ">")." t2.id AND $where");
    }



    /**
     * This will enable you to copy data to another model quickly
     * e.g
     * dd( User::tableCopyDataToAnotherModel(UserProfile::class, [
            'user_name'=>'first_name',
            'full_name'=>'last_name',
            'email'=>'email',
        ]));
     * @param $destinationModelName
     * @param array $tableKeyMergeWithOtherTableKey
     * @return bool
     * Reset Table
     */
    static function tableCopyDataToAnotherModel($destinationModelName, array $tableKeyMergeWithOtherTableKey = []){
        $newTableKeys = implode(", ", @array_values($tableKeyMergeWithOtherTableKey));
        $currentTableKeys = implode(", ", @array_keys($tableKeyMergeWithOtherTableKey));
        // create table if not exists
        if(!$destinationModelName::isTableExists()) $destinationModelName::tableCreate();
        // copy data
         return Db1::exec("INSERT INTO `".$destinationModelName::getTableName()."` ($newTableKeys)  
            SELECT $currentTableKeys FROM `".static::getTableName()."` ORDER BY id ASC");
    }




    /**
     * @param array $renameColumnKeyValue
     * @param bool $forceReset
     * @param bool $addBackupToSession
     * @param bool $backupAndRestore
     * @param string $optionalBackupFilePath Where to save backup json data
     * @return array|null
     * Synchronize table with it's model.
     *      Soft-reset will Re-Adjust model fields to match with db table,
     *      While forceReset/Hard-Reset will delete and re-creating the table with the model info and finally restore its data back
     * @see tableRefresh()
     */
    static function tableReset(array $renameColumnKeyValue = [], $forceReset = false, $addBackupToSession = true, $backupAndRestore = true, $optionalBackupFilePath = null) {
        // backup data to session
        $allTableData = [];
        if($backupAndRestore) $allTableData = static::tableSaveBackup($optionalBackupFilePath === null? false: $optionalBackupFilePath, $addBackupToSession);

        // try soft-reset first
        if(!$forceReset){
            try{
                if(!empty($renameColumnKeyValue)) self::tableColumnRename($renameColumnKeyValue);
                $currentModelFieldList = self::getModelTableField();
                $currentDbFieldList = self::getDbTableField();
                unset($currentModelFieldList[self::$PRIMARY_KEY_NAME], $currentDbFieldList[self::$PRIMARY_KEY_NAME]);

                // Add or Modify Column
                $query = "ALTER TABLE `".static::getTableName()."` ";
                $lastColumn = null; //self::$PRIMARY_KEY_NAME;
                foreach ($currentModelFieldList as $key=>$value) {
                    $query .= isset($currentDbFieldList[$key])? " MODIFY $key $value, ": (" ADD $key $value ".(!empty($lastColumn)? " AFTER $lastColumn," : ","));
                    $lastColumn = $key;
                }
                // Remove Column
                foreach ($currentDbFieldList as $key=>$value) {
                    if(isset($currentModelFieldList[$key]) || ($key === self::$PRIMARY_KEY_NAME)) continue;
                    $query .= " DROP $key, ";
                }
                $query = DbAdapter1::filterUnsupportedString(rtrim($query, ", "));
                if(!Db1::exec($query, true, true, true, true))
                    $forceReset = true;
                else
                    Session1::setStatus("Model Reset Type", "Soft-Reset was performed on ".static::getTableName());
            }catch (Exception $ex){
                $forceReset = true;
                Session1::setStatus("Soft-Reset Error", "Could not perform Soft-Reset on ".static::getTableName().", error is ".$ex->getMessage().". Switching to Hard-Reset") ;
            }
        }


        // run if soft-reset failed or $forceReset is enabled by default
        if($forceReset){
            $tableTruncateAction = (static::tableDestroy() && static::tableCreate());
            // restore data
            if($backupAndRestore && $allTableData) static::insertMany(...$allTableData); //foreach ($allTableData as $table) static::insertMany($table);
            Session1::setStatus("Model Reset Type", "Hard-Reset was performed on ".static::getTableName());
        }

        // return backup
        return $allTableData;
    }



    /**
     * Rename Table Column Name
     *  e.g tableColumnRename([ "alias_name"=>"user_name", "email_address"=>"email"])
     *  or with param tableColumnRename([ "alias_name"=>"user_name varchar(50)" ])
     * @param array $columnNameKeyValue
     * @return array
     */
    static function tableColumnRename(array $columnNameKeyValue = []){
        $query = "ALTER TABLE `".static::getTableName()."` ";
        foreach ($columnNameKeyValue as $oldName=>$newName) {
            $query .= " CHANGE $oldName $newName, ";
        }
        $query = DbAdapter1::filterUnsupportedString(rtrim($query, ", "));
        return static::exec($query);
    }


    /**
     * @param string $backupDataOrFilePath Load JSON Data from FilePath
     * @param bool $clearExistingData
     * @return array|bool|Model1|ResultStatus1
     */
    static function tableLoadBackup($backupDataOrFilePath = null, $clearExistingData = true){
        static::tableCreate([],  true);
        if($clearExistingData) static::tableTruncate();
        $allTableData = is_string($backupDataOrFilePath)? Array1::readFromJSON($backupDataOrFilePath): $backupDataOrFilePath;
        $allTableData = $allTableData? $allTableData: Session1::get('backup_'.static::getTableName());
        return ($allTableData)? static::insertMany(...$allTableData): false;
    }

    /**
     * Default save to assets/backup
     * @param string $saveToFilePath Save JSON Data to FilePath
     * @return array|ArrayObject|bool|Model1[]|mysqli_result|null
     */
    static function tableSaveBackup($saveToFilePath = null, $addBackupToSession = true){
        $backupName = static::getTableName().'_'.String1::convertWordToSlug(now());
        if($saveToFilePath !== false){ $saveToFilePath = $saveToFilePath? $saveToFilePath: path_asset('backups').DIRECTORY_SEPARATOR.$backupName.'.model.json'; }

        // all data
        $allTableData = static::selectMany(false, '');

        // save to session
        if($addBackupToSession) {
            Session1::set('backup_'.static::getTableName(), $allTableData);
            Session1::set('backup_'.$backupName, $allTableData);
            Session1::setStatus('Table Backup Information', "Ehex Has Just Backed Up DB Table (".static::getTableName().") Information to  Model (".static::getModelClassName().") information. <br/>Therefore, We added additional Backup to your Session should anything goes wrong. <br/><br/><h5>Back Up Name : $backupName<hr><small><code><em>view it with : </em> Session1::get('backup_$backupName')</code> </small></h5>");
        }

        // Save to File System
        if($saveToFilePath) {
            if(Array1::saveAsJSON($allTableData, $saveToFilePath)) Session1::setStatus(static::getTableName().' Backed Up', static::getTableName().' backup saved to '.$saveToFilePath, 'success');
            else die(Console1::println("<h4>Failed to Save Backup</h4>").'Backup Failed');
        }

        return  $allTableData;
    }



    /**
     *
     * @param null $cloneToRowIndex
     * @return array|null Clone or Duplicate table data
     * Clone or Duplicate table data
     */
    static function tableDataClone($cloneToRowIndex = null) {
        $allTableData = [];
        $index = 0;
        foreach (static::selectMany(true, '') as $table) {
            $allTableData = static::insertMany($table);
            $index ++; if ($cloneToRowIndex && ($index === $cloneToRowIndex)) break;
        }
        Session1::setStatus('Table ('.static::getTableName().') Cloned');
        return $allTableData;
    }


    /**
     * @param array $column_and_value
     * @param array $uniqueColumnKey
     * @param string $uniqueColumnLogic
     * @param bool $replaceOldEqualRow [Delete any row with equal inserting data. Note... Use to Care, to avoid lost of valued data]
     * @return bool|Model1|ResultStatus1|static
     * 
     */
    static function insert($column_and_value = [], $uniqueColumnKey = [], $uniqueColumnLogic = 'OR', $replaceOldEqualRow = false) {
        // normal value if is [0=>[data]]
        if(@is_int(@array_keys($column_and_value)[0])) return static::insertMany(...$column_and_value); // $column_and_value = [0];

        if($replaceOldEqualRow) static::deleteMany($column_and_value, ' AND ', '=');
        $uniqueColumnKey = static::tableColumnExpand($uniqueColumnKey);
        $allQuery = ''; $query1 = false; $query2 = false;
        $extractUniqueValue = Array1::getCommonField(null, $column_and_value, @array_flip($uniqueColumnKey));
        if(!empty($extractUniqueValue)) $allQuery .= String1::toString($query1 = static::findMany($extractUniqueValue, " $uniqueColumnLogic ", ' = ', "", Array1::merge([static::$PRIMARY_KEY_NAME], $uniqueColumnKey)));
        $allQuery .='<br/>'. String1::toString( $query2 = (new static())->toInsertQuery($column_and_value));
        if(static::$FLAG_SHOW_EXEC_QUERY) return $allQuery;
        if($query1 && count($query1) > 0 ){
            // check exists data key
            $existKey = [];
            foreach ($query1 as $fetchedData){
                foreach ($uniqueColumnKey as $uniqueDataKey) {
                    if(trim(strtolower($fetchedData[$uniqueDataKey])) === trim(strtolower($column_and_value[$uniqueDataKey]))) $existKey[] = String1::convertToCamelCase($uniqueDataKey, ' ');
                }
            }
            return ResultStatus1::falseMessage(implode(" And ", $existKey).' Exists');
        }
        else return (Db1::exec($query2, false))? static::find(DbAdapter1::lastInsertRowID(Db1::$DB_HANDLER)): ResultStatus1::falseMessage('Unable to Execute Query');
    }



    static function insertMany(...$column_and_value){ $buff = []; foreach ($column_and_value as $cl) $buff[] = static::insert($cl); return $buff; }


    /**
     * @param array $column_and_value
     * @param array $insertUniqueColumnKey
     * @param string $insertUniqueColumnLogic
     * @param null $primary_key_name_to_find_exists_model
     * @return array|ArrayObject|bool|Model1|mysqli_result|null
     * 
     * @internal param array $updateWhereColumnValue
     * @internal param string $operator
     */
    static function insertOrUpdate($column_and_value = [], $insertUniqueColumnKey = [], $insertUniqueColumnLogic = ' AND ', $primary_key_name_to_find_exists_model = null) {
        $primary_key_name_to_find_exists_model = $primary_key_name_to_find_exists_model? $primary_key_name_to_find_exists_model: static::$PRIMARY_KEY_NAME;
        if(isset($column_and_value[$primary_key_name_to_find_exists_model]) && !empty($column_and_value[$primary_key_name_to_find_exists_model]) && $column_and_value[$primary_key_name_to_find_exists_model]) {
            $result = static::find($column_and_value[$primary_key_name_to_find_exists_model], $primary_key_name_to_find_exists_model, "", [$primary_key_name_to_find_exists_model]); //'', [static::$PRIMARY_KEY_NAME, $primary_key_name]
            if($result) return $result->update($column_and_value);
        }else if(!empty($insertUniqueColumnKey)){
            $withValue = Array1::getCommonField(null, $column_and_value, $insertUniqueColumnKey);
            if(count($withValue) === count($insertUniqueColumnKey)){
                $result = static::findMany($withValue, $insertUniqueColumnLogic, " = ", " limit 1 ", [$primary_key_name_to_find_exists_model]);
                if(isset($result[0])) return static::withId($result[0][$primary_key_name_to_find_exists_model])->update($column_and_value);
            }
        }
        return static::insert($column_and_value, $insertUniqueColumnKey, $insertUniqueColumnLogic);
    }


    /**
     * @param bool|string $includeClassFunctionOrQuery or simply put your $whereRawQuery
     * @param string $whereRawQuery ( e.g 'where id = 1')
     * @param array $selectColumn
     * @param bool $idAsIndex
     * @return array|self|static
     */
    static function selectMany($includeClassFunctionOrQuery = false, $whereRawQuery = '', $selectColumn = [], $idAsIndex = false){
        if(is_string($includeClassFunctionOrQuery)){ $whereRawQuery = $includeClassFunctionOrQuery; $includeClassFunctionOrQuery = false; }
        $tableName =  static::getTableName();
        $columnList = static::tableColumnMerge($selectColumn);
        $data = static::exec("SELECT $columnList FROM `$tableName` $whereRawQuery ", true, $includeClassFunctionOrQuery);
        return $idAsIndex? Array1::columnAsIndex($data, 'id'): $data;
    }


    /**
     * @param bool|string $includeClassFunctionOrQuery
     * @param string $whereRawClause ( e.g 'where id = 1')
     * @param int $minOrFix
     * @param null $max
     * @return array|ArrayObject|bool|mysqli_result|null|static[]
     */
    static function selectRandom($includeClassFunctionOrQuery = false, $whereRawClause = '', $minOrFix = 10, $max = null){
       return self::selectMany($includeClassFunctionOrQuery, $whereRawClause, $max? "FLOOR(RAND()*($max-$minOrFix+1)+$minOrFix)": "RAND($minOrFix)");
    }



    /**
     * @param string $where
     * @param string|array $selectColumnName
     * @return array|ArrayObject|bool|mysqli_result|null
     * @internal param bool $asArray
     * @internal param string $whereRawClause
     * @internal param null $tableName
     */
    static function selectManyAsList($where = '', $selectColumnName = 'id'){
        $selectColumnName = Array1::makeArray($selectColumnName);
        $result =  static::selectMany(false, $where, $selectColumnName);
        return ($selectColumnName && (count($selectColumnName) === 1))? static::singleColumnList($result, static::tableColumnExpand($selectColumnName[0]) [0]): $result;
    }


    /**
     * @param string $where
     * @param string $keyColumnName  ( Option of Combo Box)
     * @param string $valueColumnName   ( $keyForValue)
     * @return array
     *      Suitable for Select Option Value and Text
     */
    static function selectManyAsKeyValue($where = '', $keyColumnName = 'id', $valueColumnName = 'name'){
        return static::arrayValueToKeyValue( static::selectMany(true, $where, Array1::filterArrayItem([$keyColumnName,$valueColumnName])), $keyColumnName,  $valueColumnName);
    }

    private static function arrayValueToKeyValue($queryArrayResult = [], $keyForOption = 'id', $keyForValue = 'name'){
        $dataBuf = [];
        foreach ($queryArrayResult as $key=> $value) $dataBuf[$value[$keyForOption]] = $value[$keyForValue];
        return $dataBuf;
    }


    /**
     * @param string $where
     * @param array $columnQuery E.G ['count(*)as data'], ['sum(amount)as data'],
     * @param bool $returnAsSingleColumn
     * @return mixed
     */
    static function count($where = '', $columnQuery = ['count(id) as data'], $returnAsSingleColumn = true){
        $result =  static::selectMany(true, $where, $columnQuery);
        return  ($returnAsSingleColumn)? (int)@static::singleColumnList($result, 'data')[0]: $result;  //Db1::exec('Select count(*) from '.User::getTableName())
    }


    /**
     * @param array|string $selectColumn
     * @param string $default
     * @return string
     *  Merge Column List Into String, or Leave if String
     */
    private static function tableColumnMerge($selectColumn = [], $default = '*'){ return is_array($selectColumn)?  (($selectColumn && !empty($selectColumn))? implode(',', array_keys(@array_flip($selectColumn))): '*'):  String1::isset_or($selectColumn, $default); }


    /**
     * @param string $selectColumn
     * @return array
     *  Explode Column List if String or leave if Array
     */
    private static function tableColumnExpand($selectColumn = ''){ return is_array($selectColumn)? $selectColumn:  (($selectColumn && !empty($selectColumn))? explode(',', $selectColumn): []); }


    /**
     * @param array $arr
     * @param null $columnKeyName
     * @return array
     *  Use When Expecting Single Column List for Example, List Of Ids
     *      @see selectManyAsList();
     */
    static function singleColumnList($arr = [], $columnKeyName = null){
        $buf = [];
        foreach ($arr as $key => $value) $buf[] = ($columnKeyName)? $value[$columnKeyName]: $value;
        return $buf;
    }


    /**
     * If Table Row Exists
     * @param array $idOr_column_and_value
     * @param string $logic
     * @param array $onExistsReturnColumn
     * @param bool $makeArrayObject
     * @return array|ArrayObject|bool|mysqli_result|null
     */
    static function exists($idOr_column_and_value = [], $logic = ' OR ', $onExistsReturnColumn = [], $makeArrayObject = false){
        if(is_string($idOr_column_and_value)) $idOr_column_and_value = ['id'=>$idOr_column_and_value];
        $selectWhere = static::toSelectWhereQuery($idOr_column_and_value, Array1::merge(["`".static::$PRIMARY_KEY_NAME."`"], Array1::makeArray($onExistsReturnColumn, ',')), $logic);
        return static::exec($selectWhere, true, $makeArrayObject);
    }


    /*
     * get all generated data
     */
    static function getAllQueryHelp() {
        $break = '<br><hr><br>';
        $buf = '<div style="margin:20px;"><h2><a href="https://ehex.xamtax.com">Ehex Model</a></h2><hr> Table name is (' .static::getTableName().')<br/> <small>Model Includes MYSQL CRUD Generator and Model function is Callable from Form Action</small>
            '.$break.
            "<h4>Create table</h4>".  static::toTableCreateQuery().$break.
            "<h4>Drop table</h4>". static::toDropTableQuery().$break.
            "<h4>Add Foreign Option table</h4>". static::toForeignLinkAdd().$break.
            "<h4>Insert Query</h4>". static::toInsertQuery(static::toModelColumnValueArray()).$break.
            "<h4>Update Query</h4>". (new static())->toUpdateQuery(static::toModelColumnValueArray()).$break.
            "<h4>Delete Query</h4>". (new static())->toDeleteQuery().$break.
            "<h4>Select Query</h4>". static::toSelectAllQuery().$break.
            "<h4>Alter Query</h4>". static::toAlterQuery().$break.
            "<h4>Find Against Query</h4>".$break;
        $buf .= $break.$break.'<h2>MODEL TABLE COLUMN</h2><div style="padding:10px;">';
        foreach (static::toModelColumnValueArray() as $key=>$value){ $buf .= ($break.$key.' = '.$value.' &nbsp; <strong>[ '.static::convertToMySqlDataType($key, $value).' ]</strong>'); }
        $buf .= '</div>';

        $buf .= $break.$break.'<h2>ALL CALLABLE FUNCTION</h2><div style="padding:10px;">';
        $param = String1::contains('?', Url1::getPageFullUrl())? explode('?', Url1::getPageFullUrl())[1]: null;
        foreach (get_class_methods(static::getModelClassName()) as $method) {
            $full_link = Form1::callApi(static::getModelClassName().'@'.$method.'(...)'. ($param? '?'.$param: '')  );
            $buf .= ("<h3>function $method(...) <br/><a href='$full_link' target='_blank'>$full_link</a></h3><hr/>" );
        }
        return $buf;
    }

    /**
     *
     * @return false|string
     */
    static function help(){
         ob_start();
            echo Console1::dd( static::getAllQueryHelp() );
        return ob_get_clean();
    }



    static function toAlterQuery($asAdd_orElseModify = true, $keyAndParameter = ' `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7 '){
        $sqlQuery =  'ALTER TABLE `'.static::getTableName().'` ';
        $sqlQuery .= (($asAdd_orElseModify)?'ADD ':'MODIFY ')." $keyAndParameter;";
        return $sqlQuery;
    }

    function toDeleteQuery(){ return "DELETE FROM `".static::getTableName()."` WHERE `".static::$PRIMARY_KEY_NAME."` = '".$this->id."'"; }

    static function toSelectAllQuery($value = '', $key = 'user_id', $selectColumn = []){
        $columnList = static::tableColumnMerge($selectColumn);
        return "SELECT $columnList FROM `".static::getTableName()."` WHERE `$key` = '$value'";
    }

    static function toDropTableQuery(){
        return "DROP TABLE `".static::getTableName()."` ";
    }


    /**
     * @param string $myForeignReferenceKeyName     <p>id i declared for table i wanted to reference</p>
     * @param string $foreignTableName              <p> Example 'users' </p>
     * @param string $foreignTablePrimaryId         <p>  'users' primary key ( usually id ) </p>
     * @param $deleteCascade                        <p>  should associated data be deleted on 'users' account deleted </p>
     * @return string
     */
    static function toForeignLinkAdd($myForeignReferenceKeyName = 'user_id', $foreignTableName = 'users', $foreignTablePrimaryId = 'id', $deleteCascade = true){
        $foreignKey = '`'.static::getTableName().'_'.$myForeignReferenceKeyName.'_foreign`';

        $sqlQuery =  'ALTER TABLE `'.static::getTableName().'` ';
        $sqlQuery .= " ADD KEY $foreignKey (`$myForeignReferenceKeyName`); ";   // declare $foreignKey as $myForeignKeyName

        if($deleteCascade){
            $sqlQuery .=  'ALTER TABLE `'.static::getTableName().'` ';
            $sqlQuery .= " ADD CONSTRAINT $foreignKey  FOREIGN KEY  (`$myForeignReferenceKeyName`)  REFERENCES `$foreignTableName` (`$foreignTablePrimaryId`) ON DELETE CASCADE ";   // delete data on foreign reference deleted
        }

        return $sqlQuery;
    }


    /**
     * @param array $column_and_value
     * @return array
     *
     *  This Verify the input "$column_and_value" with models column dat exists,
     *  and  $column_and_value that does not exists in Model
     */
    static function getSafeParamOnly($column_and_value = []){

        // note down ignore
       $noFilteredColumn = []; foreach (static::$COLUMN_NO_FILTER_LIST as $ignoreColumn) if(isset($column_and_value[$ignoreColumn])) $noFilteredColumn[$ignoreColumn] = $column_and_value[$ignoreColumn];

        // filter out bad and needed row
        $filterArray = Array1::getCommonField(function ($data){
            return (static::$FLAG_COLUMN_NO_FILTER)? $data: static::mysqlFilterValue($data);
        }, $column_and_value, Array1::initEmptyValueTo(static::toModelColumnValueArray(), ''));
        $filterArray = Array1::merge($filterArray, $noFilteredColumn);

        //dd($filterArray, $filterArray);

        // remove id
        if(isset($filterArray[static::$PRIMARY_KEY_NAME])) unset($filterArray[static::$PRIMARY_KEY_NAME]);

        // update update_at
        if(isset(static::getFixColumn()['updated_at'] )) $filterArray['updated_at'] = date(static::$SQL_TIMESTAMP_FORMAT);
        if(isset($filterArray['created_at'] )) unset($filterArray['created_at']);
        return $filterArray;
    }


    /**
     * @param array $column_and_value
     * @return string
     *  Return Update Query
     */
    function toUpdateQuery($column_and_value = []){ return static::toUpdateWhereQuery($column_and_value, [static::$PRIMARY_KEY_NAME=>$this->id]); }


    /**
     * @param bool $removeEmptyData
     * @param array $uniqueColumnKey
     * @param string $logic
     * @return string Return Update Query
     * Return Update Query
     * 
     * @internal param array $column_and_value
     */
    function save($removeEmptyData = true, $uniqueColumnKey = [], $logic = 'OR'){
        $filterColumn = ($removeEmptyData)? Array1::filterArrayItem($this->toArray()): $this->toArray();
        return static::insertOrUpdate($filterColumn, $uniqueColumnKey, $logic);
    }


    /**
     * @param array $variableEqualValueArrayList
     * @param string $optionalName
     * @return bool
     *  Set Model Default Property
     */
    static function saveDefault($variableEqualValueArrayList = [], $optionalName = ''){
        $exists = Object1::convertObjectToArray( file_session_get(static::getTableName().$optionalName, []) );
        return file_session_save(static::getTableName().$optionalName, Array1::merge($exists, Array1::toArray($variableEqualValueArrayList)), true);
    }


    /**
     * @param string $optionalName
     * @param bool $asFullModel
     * @return static
     *
     * Get Model Default Property
     */
    static function getDefault($optionalName = '', $asFullModel = false) {
        // get if exists
        $data = file_session_get(static::getTableName().$optionalName, []);
        // merge data together
        $obj = empty($data)? (new static): new static(static::getSafeParamOnly($data));
        // Add Id Because of PageUpdate form
        $obj->{'id'} = (isset($obj->{'id'}) && isset($obj->{'id'})> 0)? isset($obj->{'id'}):  1;
        // return data
        return $asFullModel? Object1::toArrayObject(true,   Object1::convertArrayToObject($obj, static::getModelClassName()) ): $obj;
    }

    /**
     * @param string $optionalName
     * @return bool
     *  Restore Model Real Default Property
     */
    static function resetDefault($optionalName = '') { return file_session_remove(static::getTableName().$optionalName); }







    /**
     * @param array $update_column_and_value
     * @param array $where_column_and_value
     * @param string $logic
     * @param string $operator
     * @return string Return Update Query
     * Return Update Query
     */
    static function toUpdateWhereQuery($update_column_and_value = [], $where_column_and_value = [],  $logic = ' AND ', $operator = ' = '){
        $filterArray = static::getSafeParamOnly($update_column_and_value);
        if(empty($filterArray)) return null;
        $whereQuery = Array1::mergeKeyValue($where_column_and_value, $operator, " $logic ", "%s", "'%s'");
        $tableData = static::toModelColumnValueArray();
        $toDataTypeFormat = function ($key, $value) use ($tableData){
            return static::saveToDbAs(gettype($tableData[$key]), $value);
        };
        $sqlQuery = 'UPDATE `'.static::getTableName().'` SET ';
        $i = 0;
        $total = count($filterArray);
        foreach ($filterArray as $key=>$value ) {
            // add normal
            $sqlQuery .= " `$key` = '".static::mysqlFilterValue( $toDataTypeFormat($key, $value) )."' ";
            // close
            if($i < $total-1) $sqlQuery .= ', ';
            else $sqlQuery .= ($whereQuery)? " WHERE $whereQuery ": '';
            $i++;
        }
        return $sqlQuery;
    }







    /**
     * @param Pixie\QueryBuilder\NestedCriteria $query
     * @param array $columns
     * @param array $values
     * @param string $logic
     * @param string $operator
     * @return mixed
     *      Run Many Where Query Against Columns(s)
     *          E.G
     *           function search($text){
     *              echo static::whereValuesInColumns($columns = ['`title`', '`body`'], $values = Array1::merge(["%$text%"] explode(' ', $text)), $logic = 'OR', $operator = ' LIKE ')
     *           }
     *
     *          OUTPUT :  title LIKE "%text%" OR title LIKE "text" OR body LIKE "%text%" OR body LIKE "text"
     *              OR
     *          ["query" => " title  LIKE  ?  OR  body  LIKE  ? ",       "value" =>  ["%fff%",  "%fff%"] ]
     *
     */
    static function whereValuesInColumnsAsRaw($columns = [], $values = [], $logic = 'OR', $operator = '=', $query = null){
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
        return $query? $query->whereRaw($whereQuery, $whereArray): ['query'=>$whereQuery, 'value'=>$whereArray];
    }


    /**
     * @param Pixie\QueryBuilder\NestedCriteria $query
     * @param array $columns
     * @param array $values
     * @param string $logic
     * @param string $operator
     * @return Pixie\QueryBuilder\NestedCriteria
     */
    static function whereValuesInColumnsAsBuilder($query, $columns = [], $values = [], $logic = 'OR', $operator = '='){
        // Add fake data so we can include AND in front of our query
        if(strtoupper($logic) == 'OR') $query->where('created_at', '=', 'demo_unknown_date');
        // perform real query
        foreach($columns as $column){
            foreach($values as $value){
                 strtoupper($logic) == 'OR'? $query->orWhere($column, $operator, $value): $query->where($column, $operator, $value);
            }
        }
       return ( $query );
    }

    /**
     * @param array $column_and_its_value
     * @param string $logic
     * @param string $operator
     * @param string $keyWrap
     * @param string $valueWrap
     * @return string
     */
    static function toWhereBuilder($column_and_its_value = [], $logic = ' OR ', $operator = ' = ', $keyWrap =  "`%s`", $valueWrap = "'%s'"){ return " WHERE ".Array1::mergeKeyValue($column_and_its_value, $operator, $logic, $keyWrap, $valueWrap); }


    static function toSelectWhereQuery($column_and_value = [], $selectColumn = [], $logic = ' OR ', $operator = ' = ', $sortOrLimitQuery = ""){
        $columnList = static::tableColumnMerge($selectColumn);
        $where = (!empty($column_and_value)? static::toWhereBuilder($column_and_value, $logic, $operator,"`%s`", "'%s'"): '')." $sortOrLimitQuery ";
        return "SELECT $columnList FROM `".static::getTableName()."` ".$where."; ";
    }

    static function toDeleteWhereQuery($column_and_value = [], $logic = ' OR ', $operator = ' = '){
        $where = !empty($column_and_value)? static::toWhereBuilder($column_and_value, $logic, $operator, "`%s`", "'%s'"): '';
        return "DELETE FROM `".static::getTableName()."` ".$where."; ";
    }


    /**
     * @param array $column_and_value ( to add to Database)
     * @return string Return Insert Query
     * Return Insert Query
     * @internal param array $uniqueColumnKey ( unique column to confirm if exists ['user_name', 'email'] )
     */
    static function toInsertQuery($column_and_value = []){
        $filterArray = static::getSafeParamOnly($column_and_value);
        if(isset( static::getFixColumn()['created_at'] )) $filterArray['created_at'] = date(static::$SQL_TIMESTAMP_FORMAT);
        if(empty($filterArray)) return null;

        $sqlQuery = 'INSERT INTO `'.static::getTableName().'` ';
        $sqlQueryObjectVar = '';
        $sqlQueryClassVar = '';

        $tableData = static::toModelColumnValueArray();
        $toDataTypeFormat = function ($key, $value) use ($tableData){
            return static::saveToDbAs(gettype($tableData[$key]), $value);
        };

        $i = 0;
        $total = count($filterArray);
        foreach ($filterArray as $key=>$value ) {

            // add normal
            $sqlQueryClassVar .= "`$key`";
            $sqlQueryObjectVar .= "'".$toDataTypeFormat($key, $value)."'"; //static::mysqlFilterValue(...)

            // close
            if($i < $total-1) { $sqlQueryObjectVar .= ', '; $sqlQueryClassVar .= ', '; }
            else $sqlQuery .= "( $sqlQueryClassVar ) VALUES (  $sqlQueryObjectVar ); ";

            $i++;
        }

        return $sqlQuery;
    }


    /**
     * @return string
     *
     *  Convert Any Model Table to Sql CRUD Query
     *
     *  TIMESTAMP: any null variable ends with _at or _date
     *  TEXT: any null variable
     *  varchar(250): string (any variable initialized to '' (string) )
     *  INTEGER: number (any variable initialized to 0 (number), float )
     *  BOOLEAN: true, false (any variable initialized to true or false )
     */
    static function toTableCreateQuery(){
        $allColumns = static::toModelColumnValueArray();
        //if(empty($allColumns)) throw new Error(Console1::println(static::getModelClassName().' is Empty. Cannot Create empty Model'));
        $filterArray = Array1::removeKeys($allColumns,  [static::$PRIMARY_KEY_NAME]);

        $sqlQuery = 'CREATE TABLE IF NOT EXISTS `'.static::getTableName().'` ('; //PRIMARY KEY(`'.static::$PRIMARY_KEY_NAME.'`)
        $sqlQuery .= '`'.static::$PRIMARY_KEY_NAME.'` '.DbAdapter1::getPrimaryKeyAttribute(static::$AUTOINCREMENT_FROM).',';

        $i = 0;
        $total = count($filterArray);
        foreach ($filterArray as $key=>$value ) {

            $sqlQuery .= '`'.$key.'`  '.static::convertToMySqlDataType($key, $value, true, static::$COLUMN_SQL_CREATE_PROPERTY);
            if($i < $total-1) $sqlQuery .= ', ';
            else $sqlQuery .= ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';

            $i++;
        }
        if($total == 0) return die(Console1::println(static::class." Model Cannot Be empty, Please Add Field"));


        if(!empty(self::$FOREIGN_LINK_FIELD)){
            foreach (self::$FOREIGN_LINK_FIELD as $key=>$value){
                if(isset($filterArray[$key]) && class_exists($value)){
                    $sqlQuery .= self::toForeignLinkAdd($key, $value::getTableName(), $value::$PRIMARY_KEY_NAME, true);
                }
            }
        }

        return DbAdapter1::filterUnsupportedString($sqlQuery); //static::makeFunction('getCreateQuery()', $sqlQuery, true);
    }



    // get mysql variable from php variable
    static function convertToMySqlDataType($variableName = '', $variableValue = '', $addAttribute = true){
        // is custom sql property  exists
        if(isset( static::$COLUMN_SQL_CREATE_PROPERTY[$variableName] )) return static::$COLUMN_SQL_CREATE_PROPERTY[$variableName];


        // variable data type
        $dataType = gettype($variableValue);

        // auto assistance
        if(String1::endsWith($variableName, '_at')) {$dataType = 'timestamp'; }
        else if($dataType == 'NULL'){
            if(String1::endsWith($variableName, '_date')) $dataType = 'date';
            else if(String1::endsWith($variableName, '_time')) $dataType = 'time';
            else if(String1::endsWith($variableName, '_datetime')) $dataType = 'timestamp';
        }

        // extract and filter default Value
        $defaultValue = function() use ($variableValue, $dataType){ return @String1::toString(@Value1::typecast($dataType, "'$variableValue'", 'NULL', false)); };



        // assign equivalent MySQL DataType
        $dataTypeList = array(
            'boolean'=>'BOOLEAN' . (($addAttribute)?' NULL DEFAULT '.String1::toBoolean($variableValue, '1', '0').' ':''),

            'double'=>'BIGINT' . (($addAttribute)?' NULL DEFAULT  '.$defaultValue().'  ':''),
            'integer'=>'BIGINT' . (($addAttribute)?' NULL DEFAULT '.$defaultValue().'  ':''),

            'object'=>'BLOB' . (($addAttribute)?' NULL DEFAULT NULL ':''),
            'array'=>'BLOB' . (($addAttribute)?' NULL DEFAULT NULL ':''),

            'string'=>'VARCHAR('.static::$SQL_VARCHAR_STRING_LENGTH.')' . (($addAttribute)?" COLLATE utf8mb4_unicode_ci NULL DEFAULT ".$defaultValue()." ":''),
            'unknown type'=>'TEXT' . (($addAttribute)?' NULL DEFAULT NULL ':''),
            'resource'=>'TEXT' . (($addAttribute)?' NULL DEFAULT NULL ':''),

            'timestamp'=>'TIMESTAMP' . (($addAttribute)?' NULL DEFAULT NULL ':''),
            'date'=>'DATE' . (($addAttribute)?' NULL DEFAULT NULL ':''),
            'time'=>'TIME' . (($addAttribute)?' NULL DEFAULT NULL ':''),
            'NULL'=>'TEXT' . (($addAttribute)?" COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL ":'') //'TEXT' . (($attribute)?' COLLATE utf8mb4_unicode_ci  ':''),
        );

        $ifColumnUnique = in_array($variableName, static::$UNIQUE_COLUMN)? " UNIQUE ": "";
        return $ifColumnUnique.(isset($dataTypeList[$dataType])? $dataTypeList[$dataType]: 'TEXT');
    }



    static function saveToDbAs($dataType, $value){
        return ($dataType === 'array')? base64_encode(serialize($value)): String1::toString($value);
    }
    static function getFromDbAs($dataType = 'array', $value){
        return ($dataType === 'array')? unserialize(base64_decode($value)): String1::toString($value);
    }













    /*********************************************************************************************************************************************************************************
     *
     * [ FILE-SYSTEM ]    and     [ MODEL-ASSETS ]
     *
     ***************************************************************************************/


    /**
     * @param string $uploadMainDirectory
     * @return string
     */
    static function getModelAssetPath($uploadMainDirectory = 'uploads') {
       return path_asset($uploadMainDirectory.DIRECTORY_SEPARATOR.static::getTableName());
    }



    /**
     * @param string $uploadMainDirectory
     * @return array: get Model Assets Path and Url in an Array
     */
    function getAssetDirectoryType($uploadMainDirectory = 'uploads') {
        if(!empty($this->id) && $this->id > 0){
            $realPath = path_asset($uploadMainDirectory.DIRECTORY_SEPARATOR.static::getTableName().DIRECTORY_SEPARATOR.$this->id);   if(!is_dir($realPath)) FileManager1::createDirectory($realPath);
            $pathUrl = asset($uploadMainDirectory.DIRECTORY_SEPARATOR.static::getTableName().DIRECTORY_SEPARATOR.$this->id);
        }
        return ['path'=>isset_or($realPath), 'url'=>isset_or($pathUrl)];
    }




    /**
     * @param string $file_name
     * @param $onlyIfExists
     * @param string $uploadMainDirectory
     * @return array|null : Get Model File Path and Url in an Array ['url'=>'http://localhost/users/1.jpg', 'path'=>'/application/mamp/users/1.jpg', ]
     */
    function getFilePathAndUrl($file_name = '',  $uploadMainDirectory = 'uploads', $onlyIfExists = true) {
        $file_name = String1::startsWith(strtolower($file_name), 'http')? FileManager1::getFileName($file_name): $file_name;
        $realPath = $this->getAssetDirectoryType($uploadMainDirectory)['path'].DIRECTORY_SEPARATOR.$file_name;
        $pathUrl = $this->getAssetDirectoryType($uploadMainDirectory)['url'].DIRECTORY_SEPARATOR.$file_name;
        return !$onlyIfExists ? ['path'=>$realPath, 'url'=>$pathUrl]:  ((file_exists($realPath))? ['path'=>$realPath, 'url'=>$pathUrl]: null);
    }




    /**
     * Delete Model Assets Directory
     * @param string $uploadMainDirectory
     * @return bool
     */
    function deleteAssetDirectory($uploadMainDirectory = 'uploads') {
        $path = $this->getAssetDirectoryType($uploadMainDirectory)['path'];
        return (is_dir($path)) ? FileManager1::deleteAll($path, true): false;
    }


    /**
     * @param null $source_file, Just passed in $_FILES['file_url']
     * @param null $file_name, Use can use a custom name
     * @param bool $addUrlToModel1FileLocator
     * @param bool $compress
     * @param string $uploadMainDirectory
     * @param array $compress_config
     * @return bool|null|string (full_path)
     *  Upload File to Resources/assets/uploads/{$model}/{$model_id}/file_name
     */
    function uploadFile($source_file = null, $file_name = null, $addUrlToModel1FileLocator = false, $compress=true, $compress_config = ['width'=>400, 'height'=>400, 'quality'=>80, 'watermark_source'=>false], $uploadMainDirectory = 'uploads'){
        // init
        if(empty($source_file)) return null;
        if(is_array($source_file)) {
            if(empty(@$source_file['tmp_name'])) return false;
            $fileInfo = pathinfo($source_file['name']);
            $file_name = String1::convertWordToSlug(!empty($file_name)? $file_name: time().'_'.$fileInfo['filename']);
            if(!empty($file_name) && !strpos($file_name, '.')) $file_name = $file_name.'.'.$fileInfo['extension'];
            return $this->uploadFile($source_file['tmp_name'], $file_name, $addUrlToModel1FileLocator, $compress, $compress_config, $uploadMainDirectory);
        }else{
            // create all path
            $path = $this->getAssetDirectoryType($uploadMainDirectory)['path'];

            // file name
            $file_name = (($file_name)? $file_name: time());//.'_'.$source_file['name']);
            if(FileManager1::upload($source_file, $path.'/'.$file_name, $compress, $compress_config)){
                $url = $this->getFileUrl($file_name);
                return $addUrlToModel1FileLocator? Model1FileLocator::insertUrl($this, $url, $file_name): $url;
            }else return false;
        }
    }




    /**
     * @param $file_name
     * @param string $orDemoPictureUrl
     * @param string $uploadMainDirectory
     * @return null|string
     *  Verify If File Exists, Then Return File Url Path else, return null or Demo Image if Specified
     */
    function getFileUrl($file_name = '', $orDemoPictureUrl = '...', $uploadMainDirectory = 'uploads') {
        if($orDemoPictureUrl === '...') $orDemoPictureUrl = HtmlAsset1::getImageThumb();
        $path = !empty($file_name)? $this->getFilePathAndUrl($file_name, $uploadMainDirectory): [];
        return ($path) ? $path['url']: (!empty($orDemoPictureUrl)? ($orDemoPictureUrl): null);
    }



    /**
     * @param $file_name
     * @param string $uploadMainDirectory
     * @return null|string
     *  Verify If File Exists, Then Return File Path else, return null or Demo Image if Specified
     */
    function getFilePath($file_name = '', $uploadMainDirectory = 'uploads'){ $path = $this->getFilePathAndUrl($file_name, $uploadMainDirectory); return ($path) ? $path['path']: null; }

    /**
     * @param array $filterExtensionList
     * @param bool $recursive
     * @return array
     */
    function getFilePathList($filterExtensionList = [], $recursive = false){ return FileManager1::getDirectoriesFiles($this->getFilePath(), $filterExtensionList, [], -1, $recursive ); }

    /**
     * @param bool $fromModel1FileLocator
     * @param array $filterExtensionList
     * @param bool $recursive
     * @return array
     */
    function getFileUrlList($fromModel1FileLocator = false, $filterExtensionList = [], $recursive = false){ return $fromModel1FileLocator? Model1FileLocator::selectAll_fromDb($this): array_map(function($key){ return Url1::pathToUrl($key); }, FileManager1::getDirectoriesFiles($this->getFilePath(), $filterExtensionList,[], -1, $recursive)); }

    /**
     * Delete Any Uploaded File
     * @param string $file_name
     * @param string $uploadMainDirectory
     * @return bool
     */
    function deleteFile($file_name = '', $uploadMainDirectory = 'uploads'){
        // $path = $this->getFilePathAndUrl($file_name, $uploadMainDirectory);
        // return ($path) ? unlink($path['path']): false;
        $path = $this->getFilePath($file_name, $uploadMainDirectory);
        return ($path) ? unlink($path): false;
    }
}


















/*********************************************************************************************************************************************************************************
 *
 * [ AUTH MODEL ]
 *
 * Author : Samson Iyanu
 * Version : 1.0
 * Description : Database Auth Class..., User Model should extend This (Instead of EasyModel) So you can have access to login() and sample
 * Class : AuthModel1
 *
 *********************************************************************************************************************************************************************************/
abstract class AuthModel1 extends Model1 {

    /**
     * Default Field to be included in all Auth Model
     * @var array
     */
    public static $FIX_COLUMN = ['id', 'created_at', 'updated_at', 'last_login_at'];

    /**
     * Should Contain Available Role List, in Descending order
     * @return array
     */
    static function getRoles(){ return ['developer', 'admin', 'staff', 'user']; }

    /**
     * get allowed role access list
     * @param string $role
     * @return array|mixed
     */
    static function getRolesFrom($role = 'user'){ return Array1::splitAndGetFirstList(static::getRoles(), $role); }

    /**
     * Confirm if logged in user role exists within First Row and Specified $toWhichRole End Role... e.g from admin to staff
     *  e.g User::isRoleWithin($userInfo->role, 'staff'); // if user is within the role
     *  Or Simply
     *      User::isRoleWithin(['admin', 'manager', 'staff']) // or
     *      User::isRoleWithin( User::getRolesFrom('staff') )
     * @param string $userRoleOrRoleList
     * @param string $toWhichRole
     * @return array
     */
    static function isRoleWithin($userRoleOrRoleList, $toWhichRole = 'staff') {
        if(is_array($userRoleOrRoleList)) return static::isAdmin(false, $userRoleOrRoleList);
        return Array1::contain(Array1::splitAndGetFirstList(static::getRoles(), $toWhichRole), $userRoleOrRoleList);
    }







    /**
     * @param null $requestKeyValue (Default is  $_REQUEST)
     * @param array $uniqueColumn (Columns That Must not Exists Twice)
     * @param bool $encryptPassword
     * @return static|bool|Model1|ResultStatus1
     *
     *        Register User and Return Account Info
     */
    static function register($requestKeyValue = null, $uniqueColumn = ['email', 'user_name'], $encryptPassword = false){
        $requestKeyValue = $requestKeyValue? $requestKeyValue: $_REQUEST;
        $requestKeyValue['password'] = $encryptPassword? encrypt_data($requestKeyValue['password']): $requestKeyValue['password'];
        return static::insert($requestKeyValue, $uniqueColumn);
    }


    /**
     * @param $user_name_or_email
     * @param $password
     * @param array $search_in_likely_column_name
     * @param array $search_in_likely_column_password
     * @param bool $tryPasswordEncryptVerification
     * @param bool $withCookie
     * @return array|ArrayObject|bool|mysqli_result|null|ResultStatus1|string|static
     *
     *    Login, Save Login Information to Session, and Return Login
     *        Use getLoginInfo() on any AuthRequiredPage
     */
    static function login($user_name_or_email, $password, $search_in_likely_column_name = ['email', 'user_name'], $search_in_likely_column_password =  ['password'], $tryPasswordEncryptVerification = false, $withCookie = true){
        if(String1::is_empty($user_name_or_email) || String1::is_empty($password)) return  ResultStatus1::falseMessage('Complete login details required');

        // fetch user info
        $result =  static::findAgainst($user_name_or_email, $tryPasswordEncryptVerification? '': $password, $search_in_likely_column_name, $tryPasswordEncryptVerification? []: $search_in_likely_column_password, ' AND ', ' OR ', ' = '); //["`".static::$PRIMARY_KEY_NAME."`"]
        if(static::$FLAG_SHOW_EXEC_QUERY) return $result;

        // assign user info
        $user = null;
        if($result && !empty($result) && isset($result[0][static::$PRIMARY_KEY_NAME]) && $result[0][static::$PRIMARY_KEY_NAME] > 0){
            if($tryPasswordEncryptVerification) {
                $dbPassword = static::getField($result[0][static::$PRIMARY_KEY_NAME], 'password', '');
                if( ($password !== $dbPassword) && !encrypt_validate($password, $dbPassword))
                    return ResultStatus1::falseMessage('Password not Valid');
            }
            $user = static::findOrInit($result[0]);
        }


        if($user){
            Config1::onLogin($user->getModel()); // Call Config onLogin // Console1::log($user);
            if(!Session1::exists('last_login_at') &&  isset(array_flip(static::$FIX_COLUMN)['last_login_at']) ) {
                Session1::set('last_login_at', $user['last_login_at']);
                $user->update(['last_login_at'=>date(static::$SQL_TIMESTAMP_FORMAT)]);
            }
            
            // save user login info
            Session1::saveUserInfo($user, $withCookie);
            return $user;
        }
        else return ResultStatus1::falseMessage('Credentials Not Found');
    }



    /**
     *  Refresh and Retrieve New Login Information in Cache, Call This After Update to Profile
     */
    static function re_login(){
        $userInfo = static::getLogin(false);
        Session1::deleteUserInfo(true);
        if($userInfo && !empty($userInfo) && isset($userInfo['id'])) static::login(String1::isset_or($userInfo['user_name'], isset($userInfo['email'])? $userInfo['email']: $userInfo['id']), $userInfo['password']);
    }


    /**
     * @param bool $orRedirectToLoginPage
     * @param string $on_failed_redirect_to
     * @param string $redirectMessage
     *
     *    use login() to Login, Save Login Information to Session, and Return Login
     *    Use getLoginInfo() on any AuthRequiredPage, If Failed, It Will Redirect to loginPage
     * @return User|Auth1|mixed|null
     */
    static function getLogin($orRedirectToLoginPage = true, $on_failed_redirect_to = '/login', $redirectMessage = 'Session Expired, Please login again'){
        $user = Session1::getUserInfo($orRedirectToLoginPage, url($on_failed_redirect_to), $redirectMessage, static::getModelClassName());
        if($user) $user['last_login_at'] = Session1::get('last_login_at');
        return $user;
    }


    /**
     * Is Login Available in Cache
     * @return bool
     */
    static function isLoginExist(){ return Session1::isLoginExists(); }
    static function isGuest(){ return !Session1::isLoginExists(); }
    static function isAdmin($redirectToLoginPageIfGuest = false, $column_value = ['admin'], $column_name = 'role'){
        if(!static::isLoginExist()) return $redirectToLoginPageIfGuest? redirect(routes()->login, ['Login Required', 'Please login', 'error']): false;
        static::re_login();
        $column_value = Array1::makeArray($column_value);
        $current_role = static::getLogin()[$column_name];
        foreach ($column_value as $value)if($current_role == $value) return true;
        return false;
    }

    /**
     * check if User Instance role exist in role list
     * @param array $roles
     * @param string $role_column_name
     * @return bool
     */
    function isUserRole($roles = ['admin'], $role_column_name = 'role'){
        return in_array($this->{$role_column_name}, Array1::makeArray($roles));
    }
    function isUserRoleGreaterThanOrEqual($role = 'staff', $role_column_name = 'role'){
        return User::isRoleWithin($this->{$role_column_name}, $role);
    }

    /**
     * Put At the top of the Page and Specify The Required Role
     *  If Role Failed, The Page will be redirected to login page
     * @param array $column_role_list
     * @param string $column_role_name
     * @param string $on_failed_redirect_to
     * @param callable|null $onSuccessCallBack
     * @param callable|null $onErrorCallBack
     * @param string $errorMessage
     * @param string $errorTitle
     * @return Auth1|mixed|null|User
     */
    static function getAllowedRoleLogin($column_role_list = ['admin'], $column_role_name = 'role', $on_failed_redirect_to = '/login',  callable $onSuccessCallBack = null, callable $onErrorCallBack = null,  $errorMessage = 'You do not have permission to visit this page, Please re-login with equal permission', $errorTitle = 'Access Denied'){
        $login = static::getLogin(true, $on_failed_redirect_to, $errorMessage);
        if(static::isLoginExist() && in_array($login[$column_role_name], Array1::toArray($column_role_list))) { if($onSuccessCallBack) return $onSuccessCallBack(); return $login; }
        else {
            if($onErrorCallBack) $onErrorCallBack();
            else {
                Session1::setLastAuthUrl(Url1::getPageFullUrl());
                redirect(url($on_failed_redirect_to), [$errorTitle, $errorMessage, 'error']);
            }
        }
    }


    /**
     *  Clear Cache Data for User, This will also clear entire account reference cache
     * @param string $redirectTo
     * @return null
     */
    static function logout($redirectTo = '/'){
        Config1::onLogout();
        return Session1::deleteUserInfo() &&
            Url1::redirectIf($redirectTo, ['Action Successful', 'Logout Successfully!', 'success'], true)??
            Session1::setStatus('Failed', 'Logout Failed', 'error');
    }


    /**
     *  Upload User Avatar
     * @param null $source_url $file @Expecting $_FILE['avatar']['tmp_name'];
     * @param null|string $name @default "uploads/{$this.id}/avatar.jpg"
     * @return null|string
     * @internal param null
     */
    function uploadAvatar($source_url = null, $name = 'avatar.jpg'){
        $result = $this->uploadFile($source_url,  $name, false, true,  ['width'=>300, 'height'=>300]);
        if($result) if( $this->update(['avatar'=>$result]) ) return $result;
        return false;
    }

    /**
     * Get User Avatar
     * @param null|string $name
     * @param string $orDemoPictureUrl
     * @return null|string Verify If Image Exists, Then Return Image Path else, return null or Demo Image
     *  Verify If Image Exists, Then Return Image Path else, return null or Demo Image if Specified
     */
    function getAvatar($name = 'avatar.jpg', $orDemoPictureUrl = '...'){
        if($orDemoPictureUrl === '...') $orDemoPictureUrl = HtmlAsset1::getImageAvatar();
        return $this->getFileUrl($name, $orDemoPictureUrl);
    }


    /**
     * Upload Any File to Id [Default is First User Account, which is usually Admin]
     * @param null $source_url
     * @param null $unique_file_name
     * @param int $user_id
     * @return bool|null|string
     */
    static function uploadMainFile($source_url = null, $unique_file_name = null, $user_id = 1) { return static::withId($user_id)->uploadFile($source_url, $unique_file_name); }

    /**
     * Get Any Main Uploaded File Url or Default Demo
     * @param null $file_name
     * @param int $user_id
     * @param string $orDemoPictureUrl
     * @return mixed
     */
    static function getMainFileUrl($file_name = null, $user_id = 1, $orDemoPictureUrl = '...') { return static::withId($user_id)->getFileUrl($file_name, $orDemoPictureUrl); }

    static function getMainFilePath($file_name = null, $user_id = 1, $uploadMainDirectory = 'uploads') { return static::withId($user_id)->getFilePath($file_name, $uploadMainDirectory); }

    /**
     * Delete Any Uploaded Main File
     * @param null $file_name
     * @param int $user_id
     * @return mixed
     */
    static function deleteMainFile($file_name = null, $user_id = 1){ return static::withId($user_id)->deleteFile($file_name); }

}


/**
 * Class Model1FileLocator
 * Model File Url Saver, Save and Retrieve File From Model with Model Name and Model Unique Id.
 *
 * M
 */

//class __Model1FileLocator extends Model1 {
//    static function getTableName(){ return String1::convertToSnakeCase(static::class); }
//    static function getModelClassName(){  return (static::class); }
//    // field
//    public $id = 0;
//    public $file_name = null;
//    public $file_url = null;
//    public $other_url = null;
//    public $model_name = '';
//    public $model_id = 0;
//    public $tag = null;
//    public $created_at = null;
//};
class Model1FileLocator{
    /**
     * @var Model1
     */
    private static $model = null;
    private static function initClass() {
//        static function getTableName(){ return String1::convertToSnakeCase(Model1FileLocator::class); }
//        static function getModelClassName(){  return static::class; }
        // init model
        if(static::$model) return static::$model;
        $className = '__'.static::class;
        $code = 'class '.$className.' extends Model1{
            public $id = 0;
            public $file_name = null;
            public $file_url = null;
            public $other_url = null;
            public $model_name = \'\';
            public $model_id = 0;
            public $tag = null;
            public $created_at = null;
        }';
        eval($code);
        static::$model = new $className();
        return static::$model;
    }

    /**
     * @return Model1
     */
    static function toModel(){ static::initClass(); return static::$model; }
//    static function tableCreate() {  static::initClass(); return static::$model::tableCreate(); }
//    static function tableTruncate() {  static::initClass(); return static::$model::tableTruncate(); }
//    static function tableReset() {  static::initClass(); return static::$model::tableReset(); }
//    static function getTableName() {  static::initClass(); return static::$model::getTableName(); }

//    public function __call($method, $parameters = null) {
//        return call_user_func_array(array($this, $method), $parameters);
//    }

    public static function __callStatic($method, $parameters) {
        static::initClass();
        call_user_func_array(array(static::$model, $method), $parameters);
    }

















    /***********************************
     * [ SAVE ]
     **************************/

    /**
     * Upload Model File System Asset to server database
     * @param Model1 $model ( consist of Model class and ID )
     * @param bool $append
     * @return array
     */
    public static function insertAll_fromFile_toDb($model, $append = false){
        static::initClass();
        if(!$append) static::$model::deleteMany(['model_name'=>$model->getModelClassName(),   'model_id'=>$model->id]);
        $allFile = array_map(function($row) use ($model) {
            return ['model_name'=>$model->getModelClassName(),   'model_id'=>$model->id,  'file_name'=>FileManager1::getFileName($row),  'file_url'=>Url1::pathToUrl($row) ];
        }, $model->getFilePathList());

        // save all
        $buff = [];
        foreach ($allFile as $newModelRow) if($newModelRow) $buff[] = static::$model::insert($newModelRow, [], 'OR', $append);
        return $buff; //return static::$model::insertMany(...$allFile);
    }


    /**
     * Just Save File Information to DB
     * @param Model1 $model ( consist of Model class and ID )
     * @param null $file_url
     * @param null $file_name
     * @param null $tag
     * @param null $other_url
     * @return mixed
     * 
     */
    public static function insertUrl($model, $file_url = null, $file_name = null, $tag = null, $other_url = null){
        static::initClass();
        if(!$file_url) return false;
        $file_name = (!$file_name && String1::startsWith($file_url, 'http'))? time().'_'.rand(1,80).'_'.FileManager1::getFileName($file_url): $file_name;
        return static::$model::insert(['model_name'=>$model->getModelClassName(),   'model_id'=>$model->id, 'file_name'=>$file_name, 'file_url'=>$file_url, 'tag'=>$tag, 'other_url'=>$other_url ], [], 'OR',true)? $file_url: false;
    }


    /**
     * Upload File and Save File Information to DB
     * @param Model1 $model
     * @param $fileRequest
     * @param bool $append
     * @return array|bool
     */
    public static function uploadFiles_andInsertUrl($model, $fileRequest, $append = true){
        if(!$model || empty($fileRequest)) return false;
        static::initClass();
        foreach (Array1::normalizeLinearRequestList($fileRequest) as $file)  $model->uploadFile($file);
        return static::insertAll_fromFile_toDb($model, $append);
    }







    /***********************************
     * [ GET ]
     **************************/

    /**
     * Get File from File and DataBase
     * @param null $file_name
     * @param Model1 $model
     * @param string $orDemoPictureUrl
     * @return string
     */
    public static function find($model = null, $file_name = null, $orDemoPictureUrl = null){
       $file  =  static::find_inFile($model, $file_name, $orDemoPictureUrl);
       return $file? $file: static::find_inDb($model, $file_name);
    }

    /**
     * Search DataBase
     * @param string $q
     * @param int $limit
     * @param bool $urlOnly
     * @param Model1 $model (optional)
     * @param bool $asObject
     * @return string
     */
    public static function find_likely($q = '', $limit = -1, $urlOnly = true, $model = null, $asObject = false){
        static::initClass();
        $limit = $limit >-1 ? ' limit '.$limit: '';
        $query = $model? "model_name = '".$model->getModelClassName()."' AND model_id = '$model->id' AND ": "";
        $whereClause = "WHERE $query file_name like '%$q%'  $limit ";
        $result = $urlOnly? static::$model::selectManyAsList($whereClause, 'file_url'): static::$model::selectMany($asObject,  $whereClause);
        return  $result;
    }

    /**
     * @param null $file_name
     * @param Model1 $model
     * @param string $orDemoPictureUrl
     * @return string
     */
    public static function find_inFile($model = null, $file_name = null, $orDemoPictureUrl = '...'){ return ($model && $model->id > 0)? $model->getFileUrl($file_name, $orDemoPictureUrl): null; }

    /**
     * @param null $file_name
     * @param null $model
     * @return mixed
     */
    public static function find_inDb($model = null, $file_name = null, $urlOnly = true){
        if(!$model || $model->id < 1) return null;
        static::initClass();
        $whereClause = "WHERE model_name = '".$model->getModelClassName()."' AND model_id = '$model->id' AND file_name='$file_name' limit 1 ";
        $result = $urlOnly? static::$model::selectManyAsList($whereClause, 'file_url'): static::$model::selectMany(true,  $whereClause);
        return isset($result[0])? $result[0]: null;
    }







    /**
     * Get All from File and DataBase
     * @param null $model
     * @return array
     */
    public static function selectAll($model = null){
        return array_unique(Array1::merge(static::selectAll_fromFile($model), static::selectAll_fromDb($model)));
    }
    /**
     * from db
     * @param Model1 $model
     * @param bool $urlOnly
     * @param bool $asObject
     * @return array
     */
    public static function selectAll_fromDb($model, $urlOnly = true, $asObject = false){
        static::initClass();
        $whereClause = "WHERE model_name = '".$model->getModelClassName()."' AND model_id = '$model->id'  ";
        return $urlOnly? static::$model::selectManyAsList($whereClause, 'file_url'): static::$model::selectMany($asObject,  $whereClause);
    }
    /**
     * Get All Model File From FileSystem
     * @param Model1 $model
     * @param $extension
     * @param $recursive
     * @return array
     */
    public static function selectAll_fromFile($model, $extension = [], $recursive = false){ return $model->getFileUrlList($extension, $recursive); }




    /***********************************
     * [ DELETE ]
     *************************/
    /**
     * @param $model Model1
     * @param $file_name
     * @return array|ArrayObject|bool|mysqli_result|null
     */
    static function deleteAll($model = null){
        static::initClass(); $model->deleteAssetDirectory(); return static::$model::deleteMany(['model_name'=>$model->getModelClassName(),   'model_id'=>$model->id]);
    }
    /**
     * @param $model
     * @param $file_name
     * @return array|ArrayObject|bool|mysqli_result|null
     */
    static function delete($model = null, $file_name = null){ static::delete_fromFile($model, $file_name); return static::delete_fromDb($model, $file_name); }
    /**
     * @param Model1 $model
     * @param null $file_name
     * @return bool
     */
    static function delete_fromFile($model, $file_name = null){ return $model->deleteFile($file_name); }
    /**
     * @param Model1 $model
     * @param null $file_name
     * @return bool
     */
    static function delete_fromDb($model, $file_name = null){ static::initClass(); return static::$model::deleteMany(['model_name'=>$model->getModelClassName(),   'model_id'=>$model->id, 'file_name'=>$file_name]); }

    /**
     * Use mostly for deleting with ID in Database
     * @param int $uniqueField
     * @param string $columnName
     * @return array|ArrayObject|bool|mysqli_result|null|ResultStatus1
     */
    static function delete_fromDb_byFieldName($uniqueField = -1, $columnName = 'id'){ static::initClass(); return static::$model::deleteBy($uniqueField, $columnName); }
}





/**
 * Class Auth1
 * the Aim is to Design Something similar to laravel Auth (but with 1)
 */
abstract class Auth1{
    /**
     * @var User
     */
    public static $USER_CLASS = User::class;
    private static $USER_LOGIN = null;

    /**
     * @param bool $redirectOnFailed
     * @return AuthModel1|User
     */
    static function user($redirectOnFailed = false){
        if(static::$USER_LOGIN) return static::$USER_LOGIN;
        return static::$USER_LOGIN = static::$USER_CLASS::getLogin($redirectOnFailed);
    }


    /**
     * Get a particular field/column of user class, return null if user not available or default value
     * @param null $fieldName | optional, return user->getLogin() information if null is passed in ]
     * @param null $defaultOnNull | return default value if null or if user is not set
     * @return AuthModel1|string|User
     */
    static function get($fieldName = null, $defaultOnNull = null){ return $fieldName? String1::isset_or(static::user()[$fieldName], $defaultOnNull): static::user(); }

    /**
     * User Primary Id
     * @return string
     */
    static function id(){ return String1::isset_or(static::user()['id'], null); }


    /**
     * Get User or Blank User Model if User Not Exists
     * @return AuthModel1|User
     */
    static function userOrInit(){ return static::id()? static::$USER_CLASS::getLogin(false): static::$USER_CLASS::findOrInit(); }

    /**
     * If User has not login
     * @return bool
     */
    static function isGuest(){ return static::$USER_CLASS::isGuest() === true; }
    static function isAdmin($redirectToLoginPageIfGuest = false, $column_value = ['admin'], $column_name = 'role'){ return static::$USER_CLASS::isAdmin($redirectToLoginPageIfGuest, $column_value, $column_name);}


    /**
     * Put At the top of the Page and Specify The Required Role
     *  If Role Failed, The Page will be redirected to login page
     * @param array $column_role_list
     * @param string $column_role_name
     * @param string $on_failed_redirect_to
     * @param callable|null $onSuccessCallBack
     * @param callable|null $onErrorCallBack
     * @param string $errorMessage
     * @param string $errorTitle
     * @return mixed
     */
    static function getAllowedRoleLogin($column_role_list = ['admin'], $column_role_name = 'role',  $on_failed_redirect_to = '/login', callable $onSuccessCallBack = null, callable $onErrorCallBack = null,  $errorMessage = 'You do not have permission to visit this page, Please login again', $errorTitle = 'Access Denied'){
        return static::$USER_CLASS::getAllowedRoleLogin($column_role_list, $column_role_name, $on_failed_redirect_to,  $onSuccessCallBack, $onErrorCallBack, $errorMessage, $errorTitle);
    }
}




/**
 * Class Api1
 *  All Api Class must Extend this
 */
abstract class Api1 extends ServerRequest1 {
    public static $api_id = '';
    public static $api_key = '';

    /**
     * @param $request
     * @return bool
     */
    public static function onApiStart($request){ return true; }

    /**
     * @return bool
     */
    public static function isApiAuthValid(){ return isset($_REQUEST['_token'])? is_token_valid($_REQUEST['_token']): false; }

    /**
     * return !!User::getAllowedRoleLogin([]);
     * @return bool
     */
    public static function isUserAllowed(){ return true; }

}


/**
 * Class Controller1
 *  All Controller Class must Extend this, Model is also extending this which means, Model Can contain Controller function as Well...
 *  The Only Different between This and Api1 class is that, Controller get validate automatically just by putting <input name='_token' value="{{ token() }}" type="hidden" /> or simply call form_token() in the form field
 */
abstract class Controller1 extends Api1 {
    /**
     * ...
     * More Features in future
     */
}

























/**
 * Author : Samson Iyanu
 * Description : Key and Value class...
 * Method : using save(), delete(), update(), get() methods
 */

/**
 * Preference is a key value class, it save and get value just like  session / cookie
 * This is a plan to save string value, Object, Model1, in database
 * Class DbPref1
 */
abstract class DbPref1{
    /**
     * @var Model1;
     */
    static $model = null;
    /**
     * @return Model1
     */
    private static function initClass(){
        // init model
        if(static::$model) return static::$model;
        $className = '__'.static::class;
        $code = 'class '.$className.' extends Model1 {
            //pref var
            public $id = -1;
            public $user_id = "";
            public $key = "";
            public $value = null;
            public $name = "";
        }';
        eval($code);
        static::$model = new $className();
        return static::$model;
    }

    /**
     * @return Model1
     */
    static function toModel(){ static::initClass(); return static::$model; }
    static function tableCreate() {  static::initClass(); return static::$model::tableCreate(); }
    static function tableTruncate() {  static::initClass(); return static::$model::tableTruncate(); }
    static function tableReset() {  static::initClass(); return static::$model::tableReset(); }
    //    static function tableCreate(){  static::initClass(); return Db1::exec(static::$model->toTableCreateQuery());  }
    //    static function tableTruncate(){  static::initClass(); return Db1::exec(static::$model::toDropTableQuery()) == static::tableCreate(); }


    /**
     * Save data with respect to Model Instance
     * @param $model
     * @param string $key
     * @param string $object_or_keyValueArray
     * @param bool $replace
     */
    static function save_modelData($model, $key='', $object_or_keyValueArray='', $replace = true) { return static::save($key,$object_or_keyValueArray, ($model->getModelClassName()).'='.$model->id, $replace); }

    /**
     * Delete Model Data
     * @param $model
     * @param string $key
     */
    static function delete_modelData($model, $key='') { static::delete($key, ($model->getModelClassName()).'='.$model->id); }

    /**
     * Get data with respect to Model Instance
     * @param $model
     * @param string $key
     * @param null $defaultData
     * @return array|Model1|string
     */
    static function get_modelData($model, $key='', $defaultData=null) {
        $value = static::get($key, ($model->getModelClassName()).'='.$model->id);
        if(count($value) == 2) {
            unset($value['__id']);
            return Array1::toStringNormalizeIfSingleArray($value);
        }
        return $value? $value: $defaultData;
    }







    /**
     * Insert New / Append / Override Existing data
     * @param $name
     * @param null $object_or_keyValueArray
     * @param string $user_id
     * @param bool $replace
     * @return bool|mysqli_result|null
     * 
     */
    public static function save($name, $object_or_keyValueArray = null,  $user_id = '', $replace = true){
        static::initClass();
        $data = get_parent_class($object_or_keyValueArray) == Model1::class? $object_or_keyValueArray->toArray():  Array1::toArray($object_or_keyValueArray);
        // delete
        $query = $replace? static::$model::toDeleteWhereQuery([ 'name'=>$name, 'user_id'=>$user_id ], ' AND ', ' = '): '';
        //insert all data(key=value) into table
        foreach (Array1::toArray($data) as $key=>$value) {  $query .= static::$model::toInsertQuery(['key'=>$key, 'value'=>$value, 'name'=>$name, 'user_id'=>$user_id]);  }
        // execute
        return Db1::exec($query, true, true, true, true);
    }


    /**
     * Delete Data
     * @param null $name
     * @param string $user_id
     * @return bool
     * 
     */
    public static function delete($name = null,  $user_id = ''){ return static::deleteRaw(['name'=>$name, 'user_id'=>$user_id], ' AND ', ' = '); }

    /**
     * Delete With Option
     * @param array $where
     * @param string $login
     * @param string $operator
     * @return bool
     */
    public static function deleteRaw($where = ['name'=>'', 'user_id'=>''],  $login = ' AND ', $operator = ' = ' ){ static::initClass(); return (true == Db1::exec(static::$model::toDeleteWhereQuery($where, $login, $operator))); }

    /**
     * Convert List of Data to Object Like
     * @param array $arrayRowList
     * @return array
     */
    public static function normalizeRawRows($arrayRowList = []){
        if(empty($arrayRowList)) return null;

        // turn to a perfect array
        $objBuffer = [];
        $rowId = [];
        foreach ($arrayRowList as $row) {
            $objBuffer[$row['key']] = $row['value'];
            $rowId[$row['key']] = @$row['id'];
        }
        $objBuffer['__id'] = $rowId;
        return $objBuffer;
    }


    /**
     * Get Normalized Data
     * @param $name
     * @param string $user_id
     * @param null $convertToClassName
     * @return array|Model1
     */
    public static function get($name, $user_id = '', $convertToClassName = null){
        $data = static::normalizeRawRows( static::getRawRows(['name'=>$name, 'user_id'=>$user_id]) );
        return $convertToClassName?  Object1::toArrayObject(true,   Object1::convertArrayToObject($data, $convertToClassName) ): $data;
    }

    /**
     * Get Likely  Data Using With
     * @param string $nameLike
     * @param string $user_id
     * @param string $nameFormat : use $nameFormat '%{data}%' for like data, or single % for either left or right
     * @return array|Model1
     */
    public static function getMany($nameLike = '_', $user_id = '', $nameFormat = '%{data}%'){
        static::initClass();
        $buffList = [];
        $query ='SELECT name FROM '.static::$model::getTableName()." where name like '".String1::replace($nameFormat, '{data}', $nameLike)."' AND user_id = '$user_id' group by `name` "; // order by id DESC
        foreach (static::$model::exec($query, true, false) as $data){
            $buffList[] = static::normalizeRawRows( static::getRawRows(['name'=>$data['name'], 'user_id'=>$user_id]) );
        }
        return $buffList;
    }

    /**
     * Get If Name Start With Data
     * @param string $namePrefix
     * @param string $user_id
     * @return array|Model1
     */
    public static function getManyIfStartWith($namePrefix = '_', $user_id = ''){ return static::getMany($namePrefix, $user_id, '{data}%'); }

/*    /**
     * Get If Name Contain
     * @param string $name
     * @param string $user_id
     * @return array|Model1
     */
    public static function getManyIfContain($name = '_', $user_id = ''){ return static::getMany($name, $user_id, '%{data}%'); }

    /**
     * Get If Name End With Data
     * @param string $nameSuffix
     * @param string $user_id
     * @return array|Model1
     */
    public static function getManyIfEndWith($nameSuffix = '_', $user_id = ''){ return static::getMany($nameSuffix, $user_id, '%{data}'); }



    /**
     * Get All Row
     * @param array $where
     * @param string $login
     * @param string $operator
     * @return array|ArrayObject|bool|mysqli_result|null
     */
    public static function getRawRows($where = ['name'=>'', 'user_id'=>''],  $login = ' AND ', $operator = ' = ' ){
        static::initClass();
        $query =' SELECT * FROM '.static::$model::getTableName().' '. static::$model::toWhereBuilder($where, $login, $operator, "`%s`", "'%s'");
        $data = static::$model::exec($query, true, false);
        return empty($data)? null: $data;
    }

    /**
     * Get Associated User Info
     * @param string $user_id
     * @return array
     */
    public static function getByUser($user_id = ''){
        return static::normalizeRawRows( static::getRawRows(['user_id'=>$user_id]) );
    }

    /**
     * Is Model Exists
     * @param $name
     * @param string $user_id
     * @return bool
     */
    public static function exists($name, $user_id = ''){ return !empty(static::getRawRows(['name'=>$name, 'user_id'=>$user_id])); }
}






    
    
    






