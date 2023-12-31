<?php
    $route_name = 'blog';

    $model_name = Blog::Class;
    $model_category = BlogCategory::class;

    // init User
    $userInfo = User::getAllowedRoleLogin(['admin']);
    $model = isset($id)? Blog::findOrFail($id, 'id', function(){ redirect('blog/manage', ['Error', 'Not Available', 'error']); }): Blog::findOrInit(old());
?>
@extends('layouts.shards_dashboard.template', ['page_title'=>"$model_name Page", 'allow_xcrud'=>isset($_REQUEST['manage_comment'])? true:false ])




@section('page_content')
    <link rel="stylesheet" href="{{ asset('/default') }}/autocomplete-tag/helper/normalize.min.css"/>
    <link rel="stylesheet" href="{{ asset('/default') }}/autocomplete-tag/style.css"/>


    <!-- / .main-navbar -->
    <div class="main-content-container container-fluid px-4">

        <!-- Page Menu Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-12 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle"><a href="{{ url("/{$route_name}/manage") }}" class="">{{ $model_name }} Posts</a></span>
                <h3 class="page-name">{{ $model->id? "Update $model_name": "Add New $model_name" }}
                    <span class="pull-right">
                        @if($model->id)
                            <div style="display: inline-block">
                                <button onclick="Popup1.confirmForm('Delete {{ $model_name }} category', 'Are you sure?', '{{ Form1::callController("{$model_name}::deleteOne($model->id)?token=".token()) }}')" class="btn btn-danger btn-lg"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                <button onclick="Popup1.confirmLink('Create new {{ $model_name }}', 'Have you Save any changes made to {{ $model_name }} before creating new?', '{{ url( "/{$route_name}/create") }}')" class="btn btn-warning btn-lg"><i class="fa fa-plus" aria-hidden="true"></i> New</button>
                                &nbsp;&nbsp;| &nbsp;&nbsp;
                                <button onclick="Popup1.confirmLink('Preview {{ $model_name }}', 'Have you Save any changes made to {{ $model_name }} before previewing it?', '{{ url( "/{$route_name}/".$model->slug) }}')" class="btn btn-success btn-lg"><i class="fa fa-eye" aria-hidden="true"></i> View </button>
                                <button onclick="Popup1.confirm('Update', 'Will you like to Update {{ $model_name }} now', function(){ Form1.submitForm(null, 'save_form'); })" class="btn btn-primary btn-lg"><i class="fa fa-save" aria-hidden="true"></i> Save </button>
                            </div>
                        @endif
                    </span>
                </h3>
            </div>
        </div>
        <!-- End Page Header -->






        <form id="save_form" class="add-new-post" action="{{ Form1::callController("$model_name@processSave()") }}" method="post" enctype="multipart/form-data">
            <div class="row">
                <!-- Main Page Content-->
                <div class="col-lg-9 col-md-12">
                    <!-- Main Content-->
                    <div class="card card-small mb-3">
                        <div class="card-body">
                            {!! form_token() !!}
                            {!! HtmlForm1::addHidden('user_id', $userInfo->id) !!}
                            {!! HtmlForm1::addInput('Name', ['name'=>'name', 'onkeyup'=>'addSlug(this)', 'value'=>$model->name, 'class'=>'form-control form-control-lg mb-3', 'placeholder'=>"Your Post name"])!!}
                            {!! HtmlForm1::addTextArea('Description', ['name'=>'body', 'value'=>$model->body, 'class'=>'richeditor form-control form-control-lg mb-3', 'style'=>'width:100% !important; height:600px !important', 'placeholder'=>"Description"]) !!}
                            @if($model->id) {!! HtmlForm1::addHidden('id', $model->id) !!} @endif
                        </div>
                    </div>
                    <!-- Bloglink -->
                    @if($model->id > 0)
                        <div class='card card-small mb-3' style="padding:20px;">{!! HtmlForm1::addInput('<strong><i class="fa fa-globe" aria-hidden="true"></i> Content Link</strong>', ['value'=>url('/blog/'.$model->slug) ]) !!}</div>
                    @endif
                </div>







                <div class="col-lg-3 col-md-12">

                    <!-- Init Option  -->
                    <div class='card card-small mb-3'>
                        <div class="card-header border-bottom">
                            <h6 class="m-0">Options</h6>
                        </div>
                        <div class='card-body p-0'>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item p-3">
                                    <h6>Upload Blog Picture</h6>
                                    <!-- Blog Feature Image -->
                                    @if(class_exists("exFeatureImage"))
                                        {!! exFeatureImage::imageUploadBox($model, 'feature_picture_url', 'Feature Image Upload',  'image',  $model->id > 1? $model->feature_picture_url: null, 'height:150px;width:100%', 'Feature image') !!}
                                    @else
                                        {!! HtmlWidget1::imageUploadBox('image',  $model->id > 0? $model->feature_picture_url: null, 'height:150px;width:100%', 'Feature Image Upload') !!}
                                    @endif
                                    <hr>

                                    <!-- Category List -->
                                    {!! HtmlForm1::addInput('<i class="fa fa-group"></i> <strong>Category Name (Separate with comma)</strong>', ['name'=>'category_list',  'value'=>implode(",", Blog::getCategoryList($model->category_list))]) !!}<hr>

                                    <!-- Download Button-->
                                    {!! HtmlForm1::addInput('<i class="fa fa-download"></i> <strong>Item Download Url (Optional)</strong>', ['name'=>'download_url',  'value'=>"$model->download_url"]) !!}<hr>

                                    <!-- Add tag -->
                                    {!! HtmlForm1::addInput('<i class="fa fa-tags"></i> <strong>Add Tag</strong>', ['name'=>'tag_list', 'style'=>'background:transparent !important',  'value'=>"$model->tag_list",  "data-role"=>"tagsinput"]) !!}
                                </li>

                                <li class="list-group-item d-flex px-3">
                                    <div class="custom-control custom-toggle custom-toggle-sm mb-1">
                                        <input type="checkbox" id="customToggle2" name="is_active" value="1" class="custom-control-input" {{ $model->is_active? 'checked="checked"': '' }}>
                                        <label class="custom-control-label" for="customToggle2">Make Active</label>
                                    </div>
                                    <button class="btn btn-sm btn-accent ml-auto" name="" value="true"><i class="fa fa-save"></i> Save</button>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <!-- / Init Option -->







                    <!-- Advance Option -->
                    <div class='card card-small mb-3'  id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="card-header border-bottom">
                            <div class="card-header" role="tab" id="headingOne">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="text-dark collapsed" aria-expanded="false" aria-controls="collapseOne"><h6 class="m-0">Advance Options<br/><small>Click for more option</small> <i class="pull-right fa fa-dot-circle-o"></i></h6></a>
                            </div>
                        </div>
                        <div class='collapse {{ '' /*'show'*/ }} card-body p-0' id="collapseOne" role="tabpanel" aria-labelledby="headingOne">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-3 pb-2">
                                    {!! HtmlForm1::addInput('<i class="fa fa fa-bookmark"></i> Url Slug',       ['name'=>'slug', 'value'=>"$model->slug", 'type'=>'text', 'onkeyup'=>'autoSlug = "false"']) !!}
                                    {!! HtmlForm1::addInput('<i class="fa fa-calendar"></i> Published Date',    ['name'=>'published_at', 'value'=>String1::isSetOr($model->published_at, now()), 'type'=>'datetime']) !!}
                                    {!! HtmlForm1::addInput('<i class="fa fa-key"></i> Lock with Password',     ['name'=>'password',  'class'=>'form-control form-control-lg mb-3', 'value'=>"$model->password", 'type'=>'password']) !!}
                                </li>

                                <li class="list-group-item d-flex px-3">
                                    <div class="custom-control custom-toggle custom-toggle-sm mb-1" name="enable comment box">
                                        <input type="checkbox" name="allow_comment" id="customToggle33" class="custom-control-input" {!! $model->allow_comment? 'checked="checked"': '' !!}>
                                        <label class="custom-control-label" for="customToggle33">Show Comment Box</label>
                                    </div>
                                </li>

                                <li class="list-group-item d-flex px-3">
                                    <div class="custom-control custom-toggle custom-toggle-sm mb-1" name="required no confirmation when user comment">
                                        <input type="checkbox" name="auto_approve_comment"  id="customToggle44" class="custom-control-input" {!! $model->auto_approve_comment? 'checked="checked"': ''  !!}>
                                        <label class="custom-control-label" for="customToggle44">Accept Comment Automatically</label>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <!-- / Advance Overview -->


                </div>
            </div>
        </form>
    </div>













    <script>



        $(function () {
            /*
            /!**
             *  Add New Category
             *  Select Category Or <a class="ml-auto addNewBlogCategory" href="#">Add Category</a>
             *!/
            $('.addNewBlogCategory').click(function(event){
                event.preventDefault();
                Popup1.input('Input Name', 'input the category name', null, function(input){
                    Ajax1.requestGet("{ !! Form1::callApi("$model_category::addNew()?user_id=$userInfo->id&token=".token() ) !!}&name=" + input, null, function(data){
                        data = Object1.fromJsonString(data);;
                        if(data.status) { // if action is successful
                            $('#category_id').append('<option value="' + data.data.id + '">' + data.data.name + '</option>');
                            swal( 'Category Added', 'You have successfully added category "' + data.data.name + '"' );
                        }else
                            swal( 'Failed to Add', data.message );
                    });

                });
            });*/
        });






        /**
         * Add Slug on name input change
         * @type {string}
         */
        var autoSlug = "{!! $model->id >0?  'false': 'true' !!}";
        function addSlug(object){
            if(autoSlug === 'true') {
                var slug = document.getElementById('slug');
                slug.value = String1.slugify(object.value)+'-'+Math1.getUniqueId();
            }
        }
    </script>
@endsection








@section("page_footer_script")
    @parent


    <!-- Auto-complete Tag-->
    {{--<script src="{{ asset('/default') }}/jquery/js/jquery2.1.3.min.js"></script>--}}
    <script src="{{ asset('/default') }}/autocomplete-tag/helper/modernizr.min.js"></script>
    <script src="{{ asset('/default') }}/autocomplete-tag/script.js"></script>

    <script>
        /**
         * Auto Complete Tag
         * @param elementIdAndName
         * @param jsonData
         */
        function renderAutoCompleteTag(elementIdAndName, jsonData){
            var dataList = [];
            for(var i=0;i<jsonData.length;i++) dataList.push({id:jsonData[i], name:jsonData[i]      });
             $('#' + elementIdAndName).tagSuggest({
                data: dataList,
                sortOrder: 'name',
                maxDropHeight: 200,
                name: elementIdAndName
            });
        }
        renderAutoCompleteTag("category_list", {!! json_encode($model_category::selectManyAsList("",  'name')) !!});
        renderAutoCompleteTag("tag_list", {!! json_encode(explode(',', $model->tag_list)) !!});
    </script>
@endsection