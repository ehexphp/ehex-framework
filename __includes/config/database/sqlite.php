<?php


class DbAdapter1{


    /**
     * @return string
     */
    static function getType(){ return "sqlite"; }


    /**
     * @param $isDatabaseAvailable
     * @return SQLite3
     */
    static function open($isDatabaseAvailable){
        try{
            $db_path = resources_path_cache().'/database/';
            FileManager1::createDirectory($db_path);
            $db_path = $db_path.config("DB_NAME",'database').'.db';
            return new SQLite3($db_path, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE, config("DB_USER", "root").config("DB_PASSWORD", "root") );
        }catch (Exception $ex){
            return Db1::errorHandlerAndSolution($ex->getMessage());
        }
    }


    /**
     * @param $query
     * @param SQLite3 $dbHandler
     * @param $asMultipleQuery
     * @return mixed SQLite3Result object or bool
     */
    static function exec($query, $asMultipleQuery, $dbHandler){
        return Db1::isQueryReturningValue($query) ?
            $dbHandler->{ $asMultipleQuery? 'exec': 'query' }($query) :
            $dbHandler->exec($query);
    }



    /**
     * @param SQLite3 $dbHandler
     * @return string
     */
    static function getLastErrorMessage($dbHandler){
        return "{$dbHandler->lastErrorMsg()}, (errorCode:{$dbHandler->lastErrorCode()})";
    }



    /**
     * @param int $AUTOINCREMENT_FROM
     * @return mixed
     */
    static function getPrimaryKeyAttribute($AUTOINCREMENT_FROM = 0){
        return "INTEGER PRIMARY KEY AUTOINCREMENT".($AUTOINCREMENT_FROM > 0? "=$AUTOINCREMENT_FROM":"");
    }

    /**
     * @param $query
     * @return mixed
     */
    static function filterUnsupportedString($query){
        $query = String1::replace($query, "COLLATE utf8mb4_unicode_ci", "");
        $query = String1::replace($query, "ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", '');
        return $query;
    }


    /**
     * @param $value
     * @param SQLite3 $dbHandler
     * @return string
     */
    static function escapeString($value, $dbHandler){
        return SQLite3::escapeString ( $value );
    }


    /**
     * @param $value
     * @param SQLite3 $dbHandler
     * @return mixed
     */
    static function unEscapeString($value, $dbHandler){
        return $value;//SQLite3::escapeString ( $value );
    }



    /**
     * @param SQLite3 $dbHandler
     * @return mixed
     */
    static function lastInsertRowID($dbHandler){
        return $dbHandler->lastInsertRowID();
    }





    /**
     * @param SQLite3Result $cursor
     * @param string $modelClass
     * @param $makeArray_ArrayObject
     * @return array
     */
    static function cursorToArray($cursor, $modelClass, $makeArray_ArrayObject = false){
        $buf = [];
        if(method_exists($cursor, "fetchArray")){
            $alternativeWrap  = (!is_ajax_request() && !$makeArray_ArrayObject);
            while($row = @$cursor->fetchArray(SQLITE3_ASSOC) ) {
                if(!empty($modelClass::$COLUMN_UN_FILTER_LIST)) $row = MySql1::unFilterValueIfKeyExist($row, $modelClass::$COLUMN_UN_FILTER_LIST);
                $buf[] = $makeArray_ArrayObject? $modelClass::findOrInit($row): $row;
                $buf[] = ($makeArray_ArrayObject)? ($modelClass::findOrInit($row)): ($alternativeWrap? Object1::toArrayObject(true, $row) : $row);
            }
        }
        return $buf;
    }


    /**
     * @param string $tableName
     * @return array
     */
    static function getTableDbField($tableName = 'users'){
        $fieldAndTypeList = [];
        $result = Db1::exec("PRAGMA table_info($tableName)");
        if($result){
            while($row = $result->fetchArray(SQLITE3_ASSOC) ) {
                $fieldAndTypeList[$row["name"]] = ($row["type"]);
            }
        }
        return $fieldAndTypeList;
    }


}