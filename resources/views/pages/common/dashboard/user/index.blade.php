<?php $userInfo = User::getLogin(true); ?>
@extends('layouts.shards_dashboard.template', ['page_title'=>'Dashboard', 'allow_xcrud'=>true])


@section('page_content')

    <!-- / .main-navbar -->
    <div class="main-content-container container-fluid px-4">

        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">{{ $userInfo->full_name.'\'s Dashboard' }}</span>
                <h3 class="page-title">User Dashboard </h3>
            </div>
        </div>
        <!-- End Page Header -->




        <!-- Dashboard - Has User validate email -->
        @if($userInfo->status === 'inactive')
            <div class="row mb-2">
                <div class="col-12">
                    <div class="card card-small border-top">
                        <div class="card-body bg-danger text-white">
                            <div class="mt-1 pull-left"><i class="fa fa-warning" aria-hidden="true"></i> Email Confirmation Required</div>
                            <a href="{{ url('profile') }}" class="pull-right btn btn-primary btn-sm">Change email</a>
                            <a href="{{ Form1::callController("User@sendVerificationMail(".$userInfo->email.", ".$userInfo->user_name.", true)").'?token='.token() }}" class="mr-2 pull-right btn btn-warning btn-sm">Resend Mail</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif




        <!-- Dashboard - Role -->
        <div class="row mb-2">
            <div class="col-12">
                <div class="card card-small">
                    <div class="card-body">
                        <h4><strong><i class="fa fa-warning text-danger" aria-hidden="true"></i> No Role</strong></h4><hr>
                        <h5><i class="fa fa-times-circle" aria-hidden="true"></i> Account has no role</h5>
                        <p>Your Account is Restricted and cannot perform any additional function on this site. <br/>If you are a staff and you know you deserve a role, <a href="tel:">Please request now</a>.</p>
                    </div>
                </div>
            </div>
        </div>



    </div>

@endsection