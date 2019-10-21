<?php
    $userInfo = User::getAllowedRoleLogin( User::getRolesFrom('admin') );
?>
@extends('layouts.shards_dashboard.template', ['page_title'=>'Admin Dashboard', 'allow_xcrud'=>true])





@section('page_content')

    <!-- / .main-navbar -->
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Manage Site</span>
                <h3 class="page-title">Admin Dashboard </h3>
            </div>
        </div>
        <!-- End Page Header -->







        <!-- Dashboard - Small Stats Blocks -->
        @if(!Page1::isMobile())
            <div class="row">
                @foreach(Dashboard::getDashboard() as $dashboard)
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                            <div class="dash-box dash-box-color-{{ 3 }}">   {{--  $loop->index + 1 > 4 ? 2: $loop->index   --}}
                                <div class="dash-box-icon"> <i class="{{ $dashboard['icon'] }}"></i> </div>
                                <div class="dash-box-body" style="box-shadow: 0 7px 7px 0 rgba(0, 0, 0, .14), 0 3px 1px -2px rgba(0, 0, 0, .2), 0 1px 5px 0 rgba(0, 0, 0, .12)  !important;"> <span class="dash-box-count">{{ Math1::toMoney($dashboard['value'], '', 0) }}</span> <span class="dash-box-title">{{ $dashboard['name'] }}</span> </div>
                                <div class="dash-box-action"> <button onclick="Url1.redirect('{{ url($dashboard['linkUrl']) }}')">{{ $dashboard['linkName'] }}</button> </div>
                            </div>
                    </div>
                @endforeach
            </div>
        @endif







        <!-- Manage by Isset-->
        @foreach(Class1::getClassesIf(function($class){ return $class::isTableExists(); }, 'Inbox', 'Callback', 'ContactUs', 'SupportTicket', 'User') as $class)
            @if(!class_exists($class)) @continue @endif
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                    <div class="card card-small mb-3">
                        <div class="card-body">
                            <h3>{{ $class::getModelClassName(true) }} <span class="badge badge-warning">{{ method_exists($class, "getActiveCount")? $class::getActiveCount(): '' }}</span> <hr/></h3>
                            {!! $class?  $class::manage()->render(): ''; !!}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach






        <!-- All Menu-->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                <div class="card card-small mb-3">
                    <div class="card-body">
                        <h5> All Menu </h5>
                        {!! HtmlWidget1::listAndMarkActiveLink( routes([], true) , 'font-weight:bolder; float:left;padding:15px; list-style-type:none;font-size:15px;', 'float:left;padding:15px; list-style-type:none;font-size:15px;') !!}
                    </div>
                </div>
            </div>
        </div>



    </div>
@endsection






