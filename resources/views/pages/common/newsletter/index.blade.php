<?php
    $userInfo = Auth1::userOrInit();
    $frontendPage = FrontendPage::getDefault();
    $page_title = 'Newsletter';
?>
@extends('layouts.bootstrap.template', ['page_title'=>$page_title, 'frontendPage'=>$frontendPage])







@section('page_content')
    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">{{ $page_title }}</h1>
            <p>Start receiving update from us</p>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Newsletter</li>
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

                            <div style="height:auto;background-image: url('{{ asset() }}/images/bg.jpg');">
                                <form action="{{ Form1::callController(NewsLetterSubscriber::class) }}">
                                    {!! form_token() !!}
                                    <div class="row mt-2 mb-3">
                                        <div class="col-md-12">
                                            <h4 class="text-muted"><strong>Signup for latest news & updates <br/><small>Newsletter Subscribe / Un-Subscribe</small></strong></h4>
                                            <div class="mt-4">{!! HtmlForm1::addInput("Full Name", ["name"=>"full_name", 'value'=>$userInfo, "placeholder"=>"input your full name"]) !!}</div>
                                            <div class="mt-2">{!! HtmlForm1::addInput("Phone Number", ["name"=>"phone_number", 'value'=>$userInfo, "placeholder"=>"+234"]) !!}</div>
                                            <div class="mt-2">{!! HtmlForm1::addInput("Email Address", ["name"=>"email", 'value'=>$userInfo, "placeholder"=>"your email address"]) !!}</div>
                                            <div class="mt-4">
                                                <button class="float-left btn btn-warning">Subscribe</button>
                                                <button class="float-left btn btn-link" name="is_unsubscribed">Un Subscribe</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection































