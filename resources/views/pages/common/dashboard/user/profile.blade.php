<?php $userInfo = User::getLogin(true); ?>
@extends('layouts.shards_dashboard.template', ['page_title'=>'Dashboard'])




@section('page_content')
    <!-- / .main-navbar -->
    <div class="main-content-container container-fluid px-4">

        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">{{ $userInfo->full_name.'\'s Profile' }}</span>
                <h3 class="page-title">Account Settings </h3>
            </div>
        </div>
        <!-- End Page Header -->







        <!-- Dashboard - Small Stats Blocks -->
        <div class="row" style="margin-bottom: 200px;">




                <div class="col-md-6 offset-2">
                    <form method="post" action="{{ Form1::callController(User::class, 'processSave()') }}" enctype="multipart/form-data">
                        <?php echo  form_token() ?>
                        <div class="card card-small">
                            <div class="card-body">

                                <h5><i class="fa fa-gear" aria-hidden="true"></i> Edit Profile <button onclick="Popup1.confirmForm('Delete Account', 'Are you sure about this action?', '{{ Form1::callController(User::class,  "processDelete()") }}', {action:'delete'})" class="btn btn-outline-danger pull-right" type="button"><i class="fa fa-trash" aria-hidden="true"></i> Delete Account</button></h5><hr/>

                                <!-- Basic information -->
                                <div class="row" style="margin-top:20px;">
                                    <div class="col-md-12"><h5>Basic info</h5></div>
                                    <div class="col-md-6" style="margin-bottom: 30px;">
                                        <div style="text-align: center !important;">
                                            <img onclick="document.getElementById('dp_avatar').click()" src="{{ $userInfo->getAvatar() }}" id="image_preview" style="height:100px;width:100px; border-radius:50%;" />
                                            <br/><br/><label class="btn btn-default">Upload Avatar<input style="display: none" id="dp_avatar" class="form-control" type="file" name="dp_avatar" onchange="Picture1.uploadPreview(this, 'image_preview')"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        {!! HtmlForm1::addInput('User Name', ['name'=>'user_name', 'value'=>$userInfo ]) !!}
                                        {!! HtmlForm1::addInput('Email', ['name'=>'email', 'value'=>$userInfo ]) !!}
                                    </div>
                                </div>



                                <!-- More information -->
                                <div class="row" style="margin-top:20px;">
                                    <div class="col-md-12"><h5>Secondary info</h5></div>
                                    <div class="col-md-6">
                                        {!!  $userInfo->form(['full_name',  'phone_number', 'about', 'birth_date'])->setTitle('')->render() !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! HtmlForm1::addSelect("Country", ['name'=>'sex', 'selected'=>$userInfo, 'value'=>Array1::reUseValueAsKey(DemoCountry::getCountries())]) !!}
                                        {!! HtmlForm1::addInput("State", ['name'=>'state', 'value'=>$userInfo ]) !!}
                                        {!! HtmlForm1::addInput("City", ['name'=>'city', 'value'=>$userInfo ]) !!}
                                        {!! HtmlForm1::addInput("Address", ['name'=>'address', 'value'=>$userInfo]) !!}
                                        {!! HtmlForm1::addInput("Work Title", ['name'=>'work_title', 'value'=>$userInfo]) !!}
                                    </div>
                                </div>



                                <!-- Password information -->
                                <div class="row" style="margin-top:20px;">
                                    <div class="col-md-12"><h5>Change Password</h5></div>
                                    <div class="col-md-6">{!! HtmlForm1::addInput('Old Password', ['name'=>'old_password', 'type'=>'password', 'toggle'=>'true']) !!}</div>
                                    <div class="col-md-6">{!! HtmlForm1::addInput('New Password', ['name'=>'new_password', 'type'=>'password', 'toggle'=>'true']) !!}</div>
                                </div>

                                <button type="submit" name="btn_submit" class="btn btn-lg btn-block btn-success">Update Now</button>
                            </div>
                        </div>
                    </form>
                </div>

        </div>
    </div>


@endsection