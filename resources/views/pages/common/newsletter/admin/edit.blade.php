<?php
    $route_name = 'newsletter';
    $model_name = NewsLetter::class;

    // init User
    $userInfo = User::getLogin(true);
    $model = isset($id)? $model_name::find($id): $model_name::findOrInit(old());
?>
@extends('layouts.shards_dashboard.template', ['page_title'=>"$model_name Page", 'allow_xcrud'=>isset($_REQUEST['manage'])? 'true': 'false'])




@section('page_content')

    <!-- / .main-navbar -->
    <div class="main-content-container container-fluid px-4">

        <!-- Page Menu Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-12 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle"><a href="#" class="">{{ $model_name }} Posts</a></span>
                <h3 class="page-title">{{ $model->id? "Update $model_name": "Add New $model_name" }}
                    <span class="pull-right">
                        @if($model->id)
                            <div style="display: inline-block">
                                <button onclick="Popup1.confirmForm('Delete {{ $model_name }}', 'Are you sure?', '{{ Form1::callController("{$model_name}::deleteBy($model->id)?token=".token()) }}')" class="btn btn-danger btn-lg"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
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
                    <div class="card card-small mb-3">
                        <div class="card-body">
                            {!! form_token() !!}
                            @if($model->id) {!! HtmlForm1::addHidden('id', $model->id) !!} @endif
                            {!! HtmlForm1::addHidden('user_id', $userInfo->id) !!}
                            {!! HtmlForm1::addInput('Title', ['name'=>'title', 'value'=>$model->title, 'class'=>'form-control form-control-lg mb-3', 'placeholder'=>"Mail Title"])!!}
                            {!! HtmlForm1::addInput('Subject', ['name'=>'subject', 'value'=>$model->subject, 'class'=>'form-control form-control-lg mb-3', 'placeholder'=>"Mail Subject"])!!}
                            {!! HtmlForm1::addTextArea('Body', ['name'=>'body', 'value'=>$model->body, 'class'=>'richeditor form-control form-control-lg mb-3', 'style'=>'width:100% !important; height:300px !important', 'placeholder'=>"Mail Body"]) !!}
                        </div>
                    </div>

                    <!-- New Letter -->
                    <div class="card card-small mb-3">
                        <div class="card-body">
                            <h3>{{ $model_name }} List  <a href="{{ url("/{$route_name}/create") }}" class="pull-right btn btn-outline-primary"><i class="fa fa-plus" aria-hidden="true"></i> Create New</a></h3>
                            <a name="manage"></a>
                            {!! isset($_REQUEST['manage'])? $model_name::manage()->render(): '<a href="?manage#manage">Manage '.$model_name.'</a>' !!}
                        </div>
                    </div>

                    <!-- New Letter Subscriber-->
                    <div class="card card-small mb-3">
                        <div class="card-body">
                            <h3> News Letter Subscribers</h3>
                            <a name="manage"></a>
                            {!! isset($_REQUEST['manage_subscriber'])? NewsLetterSubscriber::manage()->render(): '<a href="?manage_subscriber#manage_subscriber">Manage Subscriber</a>' !!}
                        </div>
                    </div>
                </div>







                <div class="col-lg-3 col-md-12">

                    <!-- Init Option  -->
                    <div class='card card-small mb-3'>
                        <div class="card-header border-bottom">
                            <h6 class="m-0">Options</h6>
                        </div>
                        <div class='card-body p-0'>
                            <ul class="list-group list-group-flush">
                                {{--<li class="list-group-item p-3">
                                    <label>Image Upload</label>
                                    <div style="border:1px solid #e7e7e7;text-align:center">{!! HtmlWidget1::imageUploadBox('image',  $model? String1::isSetOr($model->feature_image_url, $model->getFileUrl($model->id)): null, 'height:150px;width:100%', 'User image') !!}</div>
                                </li>
                                --}}
                                <li class="list-group-item d-flex px-3">
                                    <div class="custom-control custom-toggle custom-toggle-sm mb-1">
                                        <input type="checkbox" id="customToggle2" name="is_active" value="1" class="custom-control-input"  {{ $model->is_active ? 'checked="checked"': '' }}>
                                        <label class="custom-control-label" for="customToggle2">Send Mail</label>
                                    </div>
                                    <button class="btn btn-sm btn-accent ml-auto" name="" value="true"><i class="fa fa-save"></i> Save Mail</button>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <!-- / Init Option -->


                </div>
            </div>
        </form>
    </div>
@endsection