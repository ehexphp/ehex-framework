<?php

/**
 * @backupGlobals disabled
 */
class BlogCategory extends Model1 {
    public static $FIX_COLUMN = ['id'];

    public $id = 0;
    public $name = '';
    public $description = '';


    static function getAllName(){
        return  array_merge(['All'], static::selectManyAsList(' GROUP BY NAME','name'));
    }


    /**
     * @return mixed|Xcrud
     */
    static function manage(){
         return self::xcrud()
            ->columns('name, description')
            ->fields('created_at, updated_at', true)
            ->column_cut('50', 'name')
            ->unset_title();
    }




    /**
     * @return ResultObject1
     *
     * Api Call to Add new Category for Blog on the fly
     */
    static function addNew(){
        $result = self::insert(request());
        //return $result;
        return ResultObject1::make($result, $result->getMessage(), $result? $result->toArray(): null);
    }




    /**
     *
     * Add De4fault
     */
    static function initDefaultData(){
        //   $default = [
        //       ['title'=>'Nature', 'feature_image_url'=>'/images/work_1.jpg'],
        //   ];
        //
        //   foreach ($default as $row) {
        //       Session1::setStatus('Category Initialized', '<h5>'.$row['title'].'</h5>'.self::insert(array_merge($row, ['user_id'=>Auth1::id()]), ['title'])->getMessage());
        //   }
    }
}