<?php
$userInfo = Auth1::userOrInit();
$frontendPage = FrontendPage::getDefault();
$page_title = 'Privacy policy';
?>
@extends('layouts.bootstrap.template', ['page_title'=>$page_title, 'frontendPage'=>$frontendPage])







@section('page_content')
    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">{{ $page_title }}</h1>
            <p>How we maintain your privacy</p>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">PrivacyPolicy</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="jumbotron clearfix">
                            <h3 class="text-danger">Privacy policy</h3>
                            <div class="mt-3" style="text-align: justify !important;text-justify: inter-word !important;">{!! $frontendPage->privacy_policy !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


















