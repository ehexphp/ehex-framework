<?php
    $frontendPage = FrontendPage::getDefault();
    $blogList = Blog::fetchData();
?>
@extends('layouts.bootstrap.template', ['page_title'=>"Blog", 'frontendPage'=>$frontendPage])



@section('page_content')
    <section class="container">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
            </ol>
            <div class="carousel-inner">
                @foreach(Blog::selectMany(false, "WHERE is_active = '1' ORDER BY RAND() LIMIT 5") as $blog)
                    <div class="carousel-item {{ $loop->index == 0? 'active': '' }}">
                        <img class="d-block w-100" style="height:400px" src="{{ isset_or($blog['feature_picture_url'], HtmlAsset1::getImageThumb()) }}" alt="Blog slide">
                        <div class="carousel-caption d-md-block text-left jumbotron bg-dark" style="opacity: 0.7">
                            <h3>{{ ucfirst($blog->name) }}</h3>
                            <p>{!! Blog::getFilteredSummary($blog->body, 120) !!}</p>
                            <a href="{{ url("blog/$blog->slug") }}" class="text-warning">Read more...</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </section>


    <div class="container">
        <h3 class="mt-4 md-3 text-primary">Blog posts</h3>
        <div class="row">
            <div class="col-sm-6 col-md-8 col-lg-8 mt-3">
                <div class="row">
                    @forelse($blogList as $blog)
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ url("blog/$blog->slug") }}"><img style="width:298px;height:167px !important;" src="{{ isset_or($blog['feature_picture_url'], HtmlAsset1::getImageThumb()) }}" alt="" class="img-thumbnail img-responsive "></a>
                                    <p class="text-muted mt-2" style="height:40px;">By <span class="fa fa-user" aria-hidden="true"></span> {{ User::getField($blog->user_id, 'full_name', 'Anonymous') }} | <span class="fa fa-calendar" aria-hidden="true"></span> {{ $blog->updated_at }}</p>
                                    <h5><a href="{{ url("blog/$blog->slug") }}" class="text-primary">{{ ucfirst($blog->name) }}</a></h5>
                                    <p class="text-muted"  style="height:180px;overflow: hidden">{!! Blog::getFilteredSummary($blog->body, 210) !!}</p>
                                    <a href="{{ url("blog/$blog->slug") }}" class="btn btn-primary">Read more</a>
                                </div>
                            </div>
                            <br>
                        </div>
                    @empty
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"><div class="card"><div class="card-body"><h3> <i class="fa fa-folder-open"></i> Result Empty   </h3></div></div></div>
                    @endforelse
                </div>
                <div class="row"><div class="col-md-12">{!! $blogList !!}</div></div>
            </div>



            <div class="col-sm-6 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-body">

                        <h4 class="text-center">Search for posts</h4>
                        <form role="Form" method="GET" action="{{ url('/blog') }}" accept-charset="UTF-8">
                            <div class="form-group">
                                <div class="input-group">
                                    <input class="form-control" type="text" name="q" value="{{ old('q') }}" placeholder="Search..." required/>
                                    <span class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><span class="fa fa-search" aria-hidden="true"></span></button>
                                    </span>
                                </div>
                            </div>
                            <hr>
                        </form>


                        <div class="row">
                            <div class="col-md-12" style="max-height: {{ BlogCategory::count()>10? "515px": "auto" }};overflow-x:scroll">
                                <ul class="list-group">
                                    <li class="list-group-item"><strong>Select Category</strong></li>
                                    @foreach(BlogCategory::selectMany(false, "GROUP BY name") as $category)
                                        <a href="{{ url("blog?category=$category->name") }}" class="list-group-item {{ request()->category === $category->name? "active": "" }}" title="{{ $category->description }}">{{ ucwords($category->name) }} <span class="badge badge-primary float-right">{{ Blog::count("Where category_list like '%-$category->name-%' ") }}</span></a>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <h5 class="mt-4">Popular posts</h5><hr>
                        @foreach(Blog::selectMany(false, "WHERE is_active = '1' ORDER BY total_visited_count DESC LIMIT 5") as $blog)
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><a href="{{ url("blog/$blog->slug") }}"><img style="width: 83px; height:59px;" src="{{ isset_or($blog['feature_picture_url'], HtmlAsset1::getImageThumb()) }}" alt="" class="img-thumbnail img-responsive"></a></div>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                    <h6><a href="{{ url("blog/$blog->slug") }}">{{ ucfirst($blog->name) }}</a></h6>
                                    <p class="text-muted"><span class="fa fa-calendar" aria-hidden="true"></span> {{ $blog->updated_at }}</p>
                                </div>
                            </div>
                            <hr>
                        @endforeach

                        <div class="row">
                            <div class="col md 12">
                                <h4 class="text-center">Our Newsletter!</h4>
                                <form role="Form" method="post" action="{{ Form1::callController(NewsLetterSubscriber::class) }}" accept-charset="UTF-8">
                                    {!! form_token() !!}
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input class="form-control" type="email" name="email" placeholder="sign up for our newsletter..." required/>
                                            <span class="input-group-btn"><button class="btn btn-primary" type="submit">Sign up</button></span>
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

