<?php
/**
 * Created by PhpStorm.
 * User: samtax
 * Date: 08/07/2018
 * Time: 7:47 AM
 */



    if(!empty(Config1::DB_NAME)){

        /**
         * For further documentation on using the various database facilities this library provides, consult the
         * https://github.com/illuminate/database
         * https://laravel.com/docs
         *
         */
        try{

            require PATH_LIBRARY . 'illuminate/vendor/autoload.php';
            $capsule = new \Illuminate\Database\Capsule\Manager();
            $capsule->addConnection([
                'driver'    => Config1::DB_DRIVER, // Db driver
                'host'      => Config1::DB_HOST,
                'database'  => Config1::DB_NAME,
                'username'  => Config1::DB_USER,
                'password'  => Config1::DB_PASSWORD,
                'charset'   => 'utf8', // Optional
                'collation' => 'utf8_unicode_ci', // Optional
                'prefix'    => '',
            ]);

            // Set the event dispatcher used by Eloquent models... (optional)
            //use Illuminate\Events\Dispatcher;
            //use Illuminate\Container\Container;
            //$capsule->setEventDispatcher(new Dispatcher(new Container));

            // Make this Capsule instance available globally via static methods... (optional)
            $capsule->setAsGlobal();
            // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
            $capsule->bootEloquent();

        } catch (Exception $ex){

            $errorMessage = $ex->getMessage();
            if(String1::contains('many connections', strtolower($errorMessage))){
                Session1::setStatus('Reload Page', 'Multiple connection to Db, Reload to re-connect');
            }else{
                Console1::println(['<hr/>Database Connection Error..., <hr/>Solution <hr/>[1> Verity Model Query. <hr/>[2> Run Db1::databaseCreate() in "config onDebug(){...}" and Refresh!]<hr/>'. $errorMessage]);
            }
        };

    }

    /************************************************
     *  XCRUD
     *  call model1->xcrud()->render()
     *
     * @see http://xcrud.com/
     * @see http://xcrud.com/documentation/{{ url('/') }}
     *
     ************************************************/
    function Xcrud_load(){
        include_once PATH_LIBRARY . 'xcrud/xcrud.php';
        Xcrud_config::$upload_folder_def = path_asset().'/uploads/xcrud';  //include Page1::getEhexCoreAssetsPath(). '/library/xcrud/xcrud.php';
    }










    /************************************************
     *  Paginator
     *  example paginate( model1->query()  )
     *  example paginate( [1,2,3...10]  )
     *
     * where Records Could be Any of this

     *  $records = [1,2,3,4...100];                             // Php Array
     *  $records = $qb->select('*')->from('sample', 'sample');  // Doctrine
     *  $records = User::select('*')->from('sample');           // Laravel
     *
        $strana = new \Strana\Paginator();
        $paginator = $strana->perPage(10)->make($records);
        foreach ($paginator as $item) echo $item['field'] . '<br>';
        echo $paginator;
     *
     * @see https://github.com/usmanhalalit/strana
     */
    function paginate($records, $perPage = 10, $asInfiniteLoad = false, $infiniteLoadConfig = [], $adapterType = null, $config = [],  $paginationTemplateClass = DefaultPaginationTemplate::class, $pageKeyName = 'page') {
        if(!class_exists('paginator/strana/vendor/autoload.php'))
            include PATH_LIBRARY . 'paginator/strana/vendor/autoload.php';
        //$infiniteLoadConfig = ['loaderDelay' => 600,  'loader' => '<img src="images/loader.gif"/>']
        $strana = new \Strana\Paginator();
        if($asInfiniteLoad) $strana->infiniteScroll($infiniteLoadConfig);
        return  $strana->perPage($perPage)->make($records, $paginationTemplateClass, $adapterType, $config, $pageKeyName);
    }
