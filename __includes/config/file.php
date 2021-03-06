<?php
/**
 * Created by PhpStorm.
 * User: samtax
 * Date: 08/07/2018
 * Time: 7:47 AM
 */




/************************************************
 *  File Session
 ************************************************/
    require_once(PATH_LIBRARY . 'filesession/FileSession1.php');
    $__FILE_SESSION =   new FileSession1('default', resources_path_cache().'/file_session/', is_debug_mode());
    /**
     * Custom Define
     * @return FileSession1
     * @param null $fileName
     * @see https://github.com/bendahrooge/PHP-Simple-Database
     *

    A simple flat-file key/value storage class for PHP. Great for small databases or servers where SQL can't be used. Only 150 lines of code :)
    This is not a replacement for SQL or other databases, and it should only be used in smaller applications where a conventional database isn't possbile. It is very inefficient and slow for PHP to keep pulling and overwriting an entire JSON file.

    * //Writes Data into file
    *
    * $fruit->set('fruits', array('apples', 'bananas', 'clementines'));
    * //returns TRUE or Error
    *
    * //Tells if a key is stored in the file
    * $fruit->search('fruits');
    * //returns TRUE
    *
    * $fruit->search('prices');
    * //returns FALSE
    *
    * //Returns the value of a key
    * $fruit->get('fruits');
    * //returns that.object
    *
    * //Deletes a value in file
    * $fruit->delete('fruits');
    * //returns TRUE
    *
     *
     */
    function file_session($fileName = null){
        if($fileName) return new FileSession1($fileName, resources_path_cache().'/file_session/', is_debug_mode());
        global $__FILE_SESSION;
        return $__FILE_SESSION;
    }

    // OR

    /**
     * just call file_session_save(name, content)
     * @param $name
     * @param $value
     * @param bool $forceReplace
     * @return bool
     */
    function file_session_save($name, $value, $forceReplace = false){
        if($forceReplace && file_session()->has($name)) file_session($name)->del($name);
        return file_session()->set($name, $value);
    }



    /**
     * @param $name
     * @param null $defaultValue
     * @return mixed
     */
    function file_session_get($name, $defaultValue = null){ return file_session()->get($name, $defaultValue); }

    /**
     * @param $name
     * @return mixed
     */
    function file_session_remove($name){ return file_session()->del($name); }

































