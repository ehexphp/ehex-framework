<?php
    $userInfo = Auth1::userOrInit();
    $frontendPage = FrontendPage::getDefault();
    $page_title = 'Copyright Infringement';
?>
@extends('layouts.bootstrap.template', ['page_title'=>$page_title, 'frontendPage'=>$frontendPage])







@section('page_content')
    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">{{ $page_title }}</h1>
            <p>Copyright Infringement on property</p>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">CIP</li>
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
                                <h3 class="text-muted">Copyright Infringement on property</h3>
                                <form method="post" action="{{ Form1::callController("CopyrightInfringement@processSave()") }}" enctype="multipart/form-data">
                                    {!! form_token() !!}
                                    {!! HtmlForm1::addHidden('is_active', '1') !!}
                                    <div class="row">
                                        {{--
                                        <div class="col-md-12" style="margin-bottom: 30px;">
                                            <div style="text-align: center !important;">
                                                <img onclick="document.getElementById('dp_avatar').click()" src="{{ $userInfo? $userInfo->getAvatar(): (new User())->getAvatar() }}" id="image_preview" style="height:100px;width:100px; border-radius:50%;" />
                                                <br/><br/><label class="btn btn-default">Upload Avatar<input style="display: none" id="dp_avatar" class="form-control" type="file" name="image" onchange="Picture1.uploadPreview(this, 'image_preview')"></label>
                                            </div>
                                        </div>--}}
                                        <div class="col-md-12">  {!! HtmlForm1::addInput('<br/>Product Link<br/>', ['placeholder'=>Url1::getSiteMainAddress().'/product_link', 'name'=>"product_link"]) !!} </div>
                                        <div class="col-md-12">  {!! HtmlForm1::addInput('<br/>Official Website<br/>', [ 'value'=>old('official_website'), 'placeholder'=>'Official Website', 'name'=>"official_website"]) !!} </div>
                                        <div class="col-md-12">  {!! HtmlForm1::addInput('<br/>Email<br/>', ['value'=>$userInfo, 'placeholder'=>'Your Email', 'name'=>"email", 'required']) !!} </div>
                                        <div class="col-md-12">  {!! HtmlForm1::addTextArea('<br/>Say Something<br/>', ['style'=>'height:300px;', 'value'=>old('description'), 'placeholder'=>'Say Something on it...', 'name'=>"description", 'required']) !!} </div>
                                        {{--<div class="col-md-12" style="font-size: 5px;">{!! HtmlWidget1::rating('star') !!}</div>--}}
                                        <div class="col-md-12">
                                            <br/><input type="submit" class="btn btn-primary btn-block" value="Submit" />
                                        </div>
                                    </div> <!-- end of registration section -->
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection












