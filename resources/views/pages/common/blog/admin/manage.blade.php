<?php
    $route_name = 'blog';
    $model_name = Blog::class;
    $model_category = BlogCategory::class;
    $userInfo = User::getAllowedRoleLogin(['admin']);
?>
@extends('layouts.shards_dashboard.template', ['page_title'=>"$model_name Manage - Page", 'allow_xcrud'=>true])




@section('page_content')

    <!-- / .main-navbar -->
    <div class="main-content-container container-fluid px-4">

        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Manage {{ $model_name }}</span>
                <h3 class="page-title"> {{ $model_name }} Overview</h3>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Dashboard - Small Stats Blocks -->
        <div class="row">
            @foreach($model_name::getDashboard() as $dashboard)
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                    <div class="dash-box dash-box-color-{{ 2 }}">
                        <div class="dash-box-icon"> <i class="{{ $dashboard['icon'] }}"></i> </div>
                        <div class="dash-box-body" style="box-shadow: 0 7px 7px 0 rgba(0, 0, 0, .14), 0 3px 1px -2px rgba(0, 0, 0, .2), 0 1px 5px 0 rgba(0, 0, 0, .12)  !important;"> <span class="dash-box-count">{{ Math1::toMoney($dashboard['value'], '', 0) }}</span> <span class="dash-box-title">{{ $dashboard['name'] }}</span> </div>
                        <div class="dash-box-action"> <button onclick="Url1.redirect('{{ url($dashboard['linkUrl']) }}')">{{ $dashboard['linkName'] }}</button> </div>
                    </div>
                </div>
            @endforeach
        </div>





        <!-- All Blog - Table -->
        <div class="row">
            @foreach($model_name::selectMany(true, "  ORDER BY id DESC LIMIT 4") as $row) {{-- WHERE user_id = '$userInfo->id' --}}
                <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                    <div class="card card-small card-post card-post--1">
                        <div class="card-post__image" style="background-image: url('{{ $row['feature_picture_url'] }}');">
                            <a href="#" class="card-post__category badge badge-pill badge-dark">{{ $model_category::find($row->id, 'id', '', ['name'])->name }}</a>
                            <div class="card-post__author d-flex">
                                <a href="#" class="card-post__author-avatar card-post__author-avatar--small" style="background-image: url('{{ $userInfo->getAvatar() }}');">Created by -admin- {{--{{ User::find($row->user_id, 'id', '', ['full_name'])['full_name'] or 'Unknown' }}--}}</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">
                                <a class="text-fiord-blue" href="{{ url("/{$route_name}/".$row->slug) }}">{{ $row->name }}</a>
                            </h5>
                            <p class="card-text d-inline-block mb-3" style="height:90px;">{!! String1::getSomeText(Html1::removeTag(String1::getSomeText($row->body, 500, '')), 128) !!}</p>
                            <div> <a href="{{ url("/{$route_name}/".$row->id."/edit") }}">Edit</a> |
                                @if($row->is_active) <a href="{{ url("/{$route_name}/".$row->slug) }}">Read More</a> @else <span class="text-muted">Not Published</span> @endif
                                <span class="text-muted pull-right">{!! date(DateManager1::$date_asText, strtotime($row->created_at)) !!}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>












        <!-- All Data - Table -->
        <div class="row">
            <!-- Table Stats -->
            <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                <div class="card card-small">
                    <div class="card-header border-bottom">
                        <h6 class="m-0">All {{ $model_name }}

                            <div class="pull-right">
                                <button onclick="Popup1.confirmForm('Delete All {{ $model_name }}', 'This Action Cannot Be Undo. Are you sure?', '{{ Form1::callController("{$model_name}::deleteAll()?token=".token()) }}')"  class="btn btn-outline-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete All</button>
                                <a href="{{ url("/{$route_name}/create") }}" class="btn btn-outline-primary"><i class="fa fa-plus" aria-hidden="true"></i> Create New</a>
                            </div>

                        </h6>
                    </div>
                    <div class="card-body pt-0">{!! $model_name::manage()->render(); !!}</div>
                </div>
            </div>
            <!-- End Table -->
        </div>








        <!-- All Category - Table -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                <div class="card card-small">
                    <div class="card-header border-bottom"><h6 class="m-0">All {{ $model_category }} <a class="pull-right btn btn-outline-primary" href="#" onclick="Popup1.confirmForm('Are you Sure', 'Will you like to Add Default Category of [Local News, Company News]', '{{ Form1::callController("$model_category::initDefaultData()?token=".token()) }}')"><i class="fa fa-refresh" aria-hidden="true"></i> Add Default Category</a></h6></div>
                    <div class="card-body pt-0 mt-3">
                        {!! Dashboard::renderOnClick($model_category) !!}
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection