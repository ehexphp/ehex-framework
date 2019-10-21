<?php


class DbAdapter1{

    /**
     * @return string
     */
    static function getType(){ return "mysql"; }

    /**
     * @param $isDatabaseAvailable
     * @return mysqli
     */
    static function open($isDatabaseAvailable){
       $da = @new mysqli(Config1::DB_HOST, Config1::DB_USER, Config1::DB_PASSWORD, ($isDatabaseAvailable)? Config1::DB_NAME:null);
       if(!empty($da->connect_error)) die(Db1::errorHandlerAndSolution($da->connect_error));
       return $da;
    }


    /**
     * @param $query
     * @param SQLite3 $dbHandler
     * @param $asMultipleQuery
     * @return mixed SQLite3Result object or bool
     */
    static function exec($query, $asMultipleQuery, $dbHandler){
        return Db1::isQueryReturningValue($query) ?
            $dbHandler->{ $asMultipleQuery? 'multi_query': 'query' }($query) :
            $dbHandler->{ $asMultipleQuery? 'multi_query': 'exec' }($query);
    }



    /**
     * @param mysqli $dbHandler
     * @return string
     */
    static function getLastErrorMessage($dbHandler){
        return $dbHandler->error;
    }


    /**
     * @param $query
     * @return mixed
     */
    static function filterUnsupportedString($query){
        return $query;
    }


    /**
     * @param $value
     * @param mysqli $dbHandler
     * @return string
     */
    static function escapeString($value, $dbHandler){
        return MySql1::mysqli_real_escape($value, $dbHandler);
    }


    /**
     * @param $value
     * @param mysqli $dbHandler
     * @return mixed
     */
    static function unEscapeString($value, $dbHandler){
        return MySql1::mysql_unreal_escape($value);
    }


    /**
     * @param mysqli $dbHandler
     * @return mixed
     */
    static function lastInsertRowID($dbHandler){
        return $dbHandler->insert_id;
    }

    /**
     * @param int $AUTOINCREMENT_FROM
     * @return mixed
     */
    static function getPrimaryKeyAttribute($AUTOINCREMENT_FROM = 0){
        return "BIGINT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT".($AUTOINCREMENT_FROM > 0? "=$AUTOINCREMENT_FROM":"");
    }


    /**
     * @param SQLite3Result $cursor
     * @param string $modelClass
     * @param $makeArray_ArrayObject
     * @return array
     */
    static function cursorToArray($cursor, $modelClass, $makeArray_ArrayObject = false){
        $buf = [];
        $alternativeWrap  = (!is_ajax_request() && !$makeArray_ArrayObject);
        while ($row = @mysqli_fetch_assoc($cursor)) {
            if(!empty($modelClass::$COLUMN_UN_FILTER_LIST)) $row = MySql1::unFilterValueIfKeyExist($row, $modelClass::$COLUMN_UN_FILTER_LIST);
            $buf[] = ($makeArray_ArrayObject)? ($modelClass::findOrInit($row)): ($alternativeWrap? Object1::toArrayObject(true, $row) : $row);
        }
        return $buf;
    }


    /**
     * @param string $tableName
     * @return array
     */
    static function getTableDbField($tableName = 'users'){
        $fieldAndTypeList = [];
        foreach (Model1::exec("SHOW FIELDS FROM $tableName")  as $field){
            $fieldAndTypeList[$field['Field']] = $field['Type'];
        }
        return $fieldAndTypeList;
    }



}