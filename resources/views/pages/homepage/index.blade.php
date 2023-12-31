<?php
    $frontendPage = FrontendPage::getDefault();
    $userInfo = User::getLogin(false);
?>
@extends('layouts.bootstrap.template', ['page_title'=>'HomePage', 'frontendPage'=>$frontendPage ])



@section('page_content')
    <div class="container" style="min-height: 80vh">
        <main role="main">
            <div class="jumbotron mt-4">
                <div class="row">
                    <div class="col-sm-8 mx-auto">

                        {{--{!! HtmlForm1::addTextArea("JSON", ['value'=> Array1::toJSON(DemoProduct::getProductCategoryList()), 'rows'=>'20'   ]) !!}--}}

                        <div class="d-flex">
                            <img src="{{ asset('favicon.png') }}" style="max-height:50px;" class="mr-2"/>
                            <h1 style="background: -webkit-linear-gradient(#1a1e19,tomato); -webkit-background-clip: text;  -webkit-text-fill-color: transparent;"><u>E</u><span>he</span><u>x</u></h1>
                        </div>

                        <p class="text-muted">ex v{{ framework_info()['version'] }}<br/>Ehex, your most friendly and powerful framework is<br/>up  and running. Modify your app settings accordingly<br/> in .config.php file. Then try <a href="{{ url('/?db_help') }}" class="text-info">Db Help</a>.</p>
                        <p><a target="_blank"  rel="noopener" class="btn btn-primary" href="https://github.com/ehexphp/ehex-docs" role="button">View Documentation &raquo;</a></p>
                    </div>
                </div>
            </div>
        </main>
    </div>


@endsection