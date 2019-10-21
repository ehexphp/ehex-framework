<?php
    $userInfo = Auth1::userOrInit();
    $frontendPage = FrontendPage::getDefault();
    $page_title = 'FAQs';
?>
@extends('layouts.bootstrap.template', ['page_title'=>$page_title, 'frontendPage'=>$frontendPage])







@section('page_content')



    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">FAQs</h1>
            <p class="lead text-muted mb-0">Frequently Asked Questions</p>
        </div>
    </section>


    <div class="container">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">FAQs</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>



    <div class="container" style="margin-bottom: 300px;">
        <div class="row">
            <div class="col-md-8 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="jumbotron clearfix">
                            <h3 class="mt-3 mb-3"> <span class="text-primary">Frequently Asked Questions</span></h3>
                            @foreach(Faqs::selectManyAsKeyValue(' where is_active = "1" ORDER BY `updated_at` DESC ', 'title', 'description') as $quest=>$ans)
                                <div class="card">
                                    <div class="card-header"><h5 class="entry-title">({{ $loop->index + 1 }}) {!! $quest !!}</h5></div>
                                    <div class="card-body mt-3">
                                        <article>
                                            <input type="hidden" class="frizzly">
                                            {!! $ans !!}
                                            <div class="heateorSssClear"></div>
                                        </article>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection














