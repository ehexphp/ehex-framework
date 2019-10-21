<?php


class Portfolio extends Model1 implements Model1ActionInterface {

    public $id = 0;
    public $title = "";
    public $category = "";
    public $description = null;
    public $project_link = null;
    public $is_active = true;
    public $feature_picture_url = "";


















    /**
     * Dashboard Menu.
     * for quick implementation visit
     * @see https://ehexphp.github.io/ehex-docs/#/BasicUsage?id=model-dashboard
     * @return array
     */
    static function getDashboard(){
        return [
            ['name'=>'All Project',    'icon'=>'fa fa-user', 'value'=>self::count(), 'linkName'=>'Visit', 'linkUrl'=>'/user/manage'],
        ];
    }





    /**
        // Loop Picture Out in your view  with 
        
        @foreach($portfolioInfo->getFileUrlList(false, FileManager1::getImageExtension()) as $image)
            <div class="col-md-6 mt-3">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ $image }}"><img src="{{ $image }}" alt="Image placeholder" class="img-fluid" style="width: 100%;max-height:100%;"></a>
                    </div>
                </div>
            </div>
        @endforeach




     * Manage Blog with HtmlForm1 or xcrud.
     * for quick implementation visit
     * @see https://ehexphp.github.io/ehex-docs/#/BasicUsage?id=model-manage
     * @return mixed|Xcrud|HtmlForm1
     */
    static function manage(){
        return new Html1(function(){
            /** @var INT $id */
            $dataInfo = isset($_REQUEST["portfolio_id"])? self::findOrFail($_REQUEST["portfolio_id"]): self::findOrInit($_REQUEST);

            // Create/Update form
            echo "<div class='row'>
                    <div class='col-md-5'>
                        <div class='jumbotron'>
                            <h4>".($dataInfo->id>0?"Update": "Create")." Project <a href='".Dashboard::getManageUrl(self::class)."' class='btn btn-primary float-right'> <i class='fa fa-plus' aria-hidden='true'></i> Create New </a></h4>".
                                HtmlForm1::open(self::class).
                                form_token().
                                HtmlForm1::addHidden('id', $dataInfo->id).
                                "<div class='text-center'>".""."</div>".

                                "<div class='card mb-3'><div class='card-body'>".
                                    "<h5>Add Default Image</h5>".
                                    HtmlWidget1::imageUploadBox("feature_picture", $dataInfo->feature_picture_url, 'width:100% !important;height:150px !important').
                                    "<h5>Add More Images</h5>".
                                    HtmlWidget1::imagesUploadBox('images[]', $dataInfo->id > 0? $dataInfo->getFilePath(): null, 'width:100% !important;height:150px !important', 'Upload Images', $dataInfo->id>0? [$dataInfo->feature_picture_url]: null ).
                                "</div></div>".

                                HtmlForm1::addInput("Project Title", ['name'=>'title', 'value'=>$dataInfo]).
                                HtmlForm1::addInput("Project Category <i>(optional)</i>", ['name'=>'category', 'value'=>$dataInfo]).
                                HtmlForm1::addInput("Project Link <i>(optional)</i>", ['name'=>'project_link', 'value'=>$dataInfo]).
                                HtmlForm1::addTextArea("Project Description", ['name'=>'description', 'value'=>$dataInfo]).
                                HtmlForm1::addInput("Is Active", ['name'=>'is_active', 'type'=>'checkbox', 'value'=>$dataInfo, $dataInfo->is_active > 0? 'checked': '']).
                                HtmlForm1::close("Save Project").
                        "</div>
                    </div>
                        <div class='col-md-7'>
                            <div class='jumbotron'>
                                <h4> Manage Portfolio Project </h4>".
                                    self::xcrud()
                                        ->unset_add()
                                        ->unset_print()
                                        ->unset_csv()
                                        ->unset_limitlist()
                                        ->limit(1000)
                                        ->columns('updated_at, created_at, id, description, feature_picture_url, project_link', true)
                                        ->fields('created_at, updated_at', true)
                                        ->order_by('is_active', 'desc')
                                        //->column_name('is_active', 'As Called')
                                        ->highlight('is_active', '=', '0', '#ff845b')
                                        ->highlight('is_active', '=', '1', '#8eff60')
                                        ->button(Dashboard::getManageUrl(self::class)."&portfolio_id={id}", 'Edit', 'icon-pen')
                                        ->unset_title().
                            "</div>
                        </div>
                    </div>";
        });
    }






    /**
     * Model Sidebar menu list.
     * for quick implementation visit
     * @see https://ehexphp.github.io/ehex-docs/#/BasicUsage?id=model-route-and-menu
     * @return mixed|array
     */
    static function getMenuList() {
        return Auth1::isAdmin()? [
            'Portfolio'=>[
                Dashboard::getManageUrl(self::class)=>'<i class="fa fa-briefcase"></i><span> Manage Portfolio </span>',
            ],
        ]: [];
    }




    /**
     * Model Route List
     * for quick implementation visit
     * @see https://ehexphp.github.io/ehex-docs/#/BasicUsage?id=model-route-and-menu
     * @param exRoute1 $route
     */
    static function onRoute($route){

    }

    /**
     * Save  Model Information
     * for quick implementation visit
     * @see https://ehexphp.github.io/ehex-docs/#/BasicUsage?id=model-process-save
     * @param $id
     */
    static function processSave($id = null){

        $result = self::insertOrUpdate(request([], ['is_active']));
        if($result && isset($_FILES['feature_picture']['tmp_name']) && !empty($_FILES['feature_picture']['tmp_name'])){
            $url = $result->uploadFile($_FILES['feature_picture'], 'project_image');
            $result->update(['feature_picture_url'=>$url]);
        }

        if($result && isset($_FILES['images'])){
            foreach (Array1::normalizeLinearRequestList($_FILES['images']) as $image)
                if(!empty($image['tmp_name'])) $result->uploadFile($image);
        }

        Session1::setStatus($result? 'Saved': 'Failed', $result->getMessage(), $result? 'success': 'error');
    }
}