<?php
    $userInfo = Auth1::userOrInit();
    $frontendPage = FrontendPage::getDefault();
    $page_title = 'About';
?>
@extends('layouts.bootstrap.template', ['page_title'=>$page_title, 'frontendPage'=>$frontendPage])







@section('page_content')

    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">About Us</h1>
            <p class="lead text-muted mb-0">{{ Config1::APP_DESCRIPTION }}</p>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">About</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>



    <div class="container">
        <div class="row">
            <div class="col-md-7 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="jumbotron clearfix">
                            <h3 class="mt-3 mb-3">ABOUT <span class="text-primary">{{ strtoupper(Config1::APP_TITLE) }}</span></h3>
                            <p>{!! $frontendPage->about_company !!}</p>
                            <p>Founder <strong>{!! $frontendPage->founder !!}</strong></p>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a class="btn btn-primary" href="{{ $frontendPage->social_facebook }}"><i class="fa fa-facebook-square fa-3x social"></i></a>
                        <a class="btn btn-info" href="{{ $frontendPage->social_twitter }}"><i class="fa fa-twitter-square fa-3x social"></i></a>
                        <a class="btn btn-danger" href="{{ $frontendPage->social_google_plus }}"><i class="fa fa-google-plus-square fa-3x social"></i></a>
                        <a class="btn btn-warning" href="mailto:{{ $frontendPage->contact_email }}"><i class="fa fa-envelope-square fa-3x social"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection








