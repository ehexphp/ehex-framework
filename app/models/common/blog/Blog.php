<?php


use vendor\ehex\easycore\assets\library\__autoload_class\image\ImgurFileManager;




class Blog extends Model1 implements Model1ActionInterface {

    public static $COLUMN_UN_FILTER_LIST = ['body'];

    public $id = 0;
    public $user_id = 0;
    public $slug = "";
    public $category_list = ''; //separate like -category1--category2--category3-, could be exploded with --

    public $name = '';
    public $body = null;
    public $password = '';
    public $tag_list = '';
    public $is_active = true;

    public $allow_comment = true;
    public $auto_approve_comment = true;

    public $feature_picture_url = ''; //
    public $download_url = ''; //

    public $total_visited_count = 1;
    public $last_visited_at = null;
    public $published_at = null;




    /**
     * @return array
     */
    //function getAllImages(){ return $this->getFilePathList(FileManager1::getImageExtension(true)); }


    /**
     * Get Pure Text
     */
    static function getFilteredSummary($description, $total = 120){
        return String1::getSomeText(Html1::removeTag(String1::getSomeText($description, 700, ''), ['a']), $total, '[...]');
    }

    /**
     * CONVERT Saved category to ARRAY
     */
    static function getCategoryList($category_string){
        return array_map(function($key){ return trim($key, "-");}, Array1::splitAndFilterArrayItem('--', $category_string));
    }

    /**
     * Delete Single Data Completely
     * @param int
     * @return bool
     */
    static function deleteOne($id){
        return ($id>0 && static::deleteBy($id, 'id', true));
    }

    static function blogTitleAndCommentTotal($text, $fieldName, $primaryId, $instance){
        return '<strong>'.$text.'</strong><br>'.'<small>(unknown) comment</small>';
    }

    /**
     * @return mixed|Xcrud
     *  Manage Blog
     */
    static function manage(){
        return self::xcrud()
            ->columns('name, category_list, body, is_active, created_at')
            //->column_callback('name', [self::class, 'blogTitleAndCommentTotal'])
            ->column_cut('50', 'name, body')
            ->unset_title()
            ->unset_add()
            ->unset_remove()
            ->column_name('category_list', 'Category')
            ->column_name('is_active', 'Has Published')
            ->change_type('category_id', 'select', null, BlogCategory::selectManyAsKeyValue("", 'id', 'name'))
            ->button(url('/blog/{id}/edit'), 'Edit', 'icon-pencil')
            ->button(url('/blog/{slug}'), 'View', 'icon-eye')
            ->unset_edit();
    }



    /**
     * @return array
     * Dashboard Menu
     */
    static function getDashboard(){
        return [
            ['name'=>'All Post',            'icon'=>'fa fa-th', 'value'=>Blog::count(), 'linkName'=>'View All', 'linkUrl'=>'/blog/manage'],
            ['name'=>'Published Post',      'icon'=>'fa fa-th', 'value'=>Blog::count('where is_active = true'), 'linkName'=>'View All', 'linkUrl'=>'/blog/manage'],
            ['name'=>'Un Published Post',   'icon'=>'fa fa-th', 'value'=>Blog::count('where is_active = false'), 'linkName'=>'View All', 'linkUrl'=>'/blog/manage'],
            ['name'=>'All Post Category',   'icon'=>'fa fa-th', 'value'=>BlogCategory::count(), 'linkName'=>'View All', 'linkUrl'=>'/blog/manage'],
        ];
    }


    /**
     *
     * Save Blog
     */
    static function processSave($id = null){
        // Category Filter
        $category_list = Array1::wrap( Array1::stringArrayToArray(request()->category_list), "-", "-");
        $_REQUEST['tag_list'] = implode(',', Array1::stringArrayToArray(request()->tag_list));
        $_REQUEST['slug'] = String1::if_empty($_REQUEST['slug'], Math1::getUniqueId(), $_REQUEST['slug']);

        // insert to database
        $result = self::insertOrUpdate(request(['category_list'=>implode('', $category_list)], ['allow_comment', 'auto_approve_comment' , 'is_active']), ['slug']);
        if($result && $result->id > 0){
            // save category
            foreach ($category_list as $category)
                if(!empty(trim($category))) BlogCategory::insert(['name'=>trim($category, '-')], ['name']);

            // Upload Feature Image
            if(isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])){
                $link = null;
                // save to cloud
                try{$link = ImgurFileManager::instance()->upload($_FILES['image']['tmp_name'])->link(); }catch (Exception $ex){  }
                // or save to file system
                if(!$link) $link = $result->uploadFile($_FILES['image'], 'feature_picture');
                if($link) $result->update(['feature_picture_url'=>$link]);
                else Session1::setStatus('Image Uploading Failed', 'Failed to Upload Feature Image to Server, Please try again');
            }
            redirect('blog/'.$result->id.'/edit', ['Saved', $result->getMessage(), 'success']);
        }else{ Session1::setStatusFrom($result); }
    }



    /**
     * Get Blog List
     */
    static function fetchData($category = null) {
        try{
            // init
            $category = $category?? String1::isset_or($_GET['category'], "All");
            // Search With Category
            $paginateDataQuery = Blog::query()->select(['name', 'updated_at', 'body', 'id', 'slug', 'category_list', 'user_id', 'feature_picture_url'])->orderBy('updated_at', 'DESC')->where('is_active', '=', 1);
            // category filter
            if($category && $category !== 'All')
                $paginateDataQuery = $paginateDataQuery->where('category_list', 'like', "%-$category-%");
            // query filter
            if(String1::isset_or($_GET['q'], null))
                $paginateDataQuery = $paginateDataQuery->where('name', 'like', '%'.$_GET['q'].'%')->orWhere('body', 'like', '%'.$_GET['q'].'%')->orWhere("tag_list", 'like', '%'.$_GET['q'].'%');
            return $paginateDataQuery = $paginateDataQuery->paginate(20, false, [], BootstrapPaginationTemplate::class);
        }catch (Exception $ex){
            return redirect_back(['Error Occured', $ex->getMessage(), 'error']);
        }
    }


    /**
     * @return mixed|array
     */
    static function getMenuList(){
        return Auth1::isAdmin()?  [
            'Blog Post'=>[
                url('/blog/manage')=>'<i class="fa fa-photo"></i><span> Manage Blog</span>',
                url('/blog/create')=>'<i class="fa fa-plus"></i><span> Add Blog</span>',
            ],
        ]: [];
    }


    /**
     * @param exRoute1 $route
     */
    static function onRoute($route){
        if(!Auth1::isGuest()){
            $route->view('blog/manage', 'pages.common.blog.admin.manage');
            $route->view('blog/create', 'pages.common.blog.admin.edit');
            $route->get('blog/{id}/edit', function($id){
                view('pages.common.blog.admin.edit', ['id'=>$id]);
            });
        }
        $route->view('/blog', 'pages.common.blog.index');
        $route->get('blog/{slug}', function($slug){
            view('pages.common.blog.show', ['slug'=>$slug]);
        });
    }

}


