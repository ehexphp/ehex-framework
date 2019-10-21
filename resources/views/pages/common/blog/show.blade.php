<?php
    $frontendPage = FrontendPage::getDefault();
    $blogInfo = Blog::findOrFail(isset_or($slug), 'slug', function(){
        return redirect('/blog', ['Content Missing', 'Content is no longer Available', 'error']);
    });
    $authorInfo = User::findOrInit([], $blogInfo->user_id);
    $categoryList = Blog::getCategoryList($blogInfo->category_list);
?>
@extends('layouts.bootstrap.template', ['page_title'=>"Blog", 'frontendPage'=>$frontendPage, "page_keywords"=>$blogInfo->tag_list])



@section('page_content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-8 col-lg-8 mt-3">
                @if(Auth1::id() === $authorInfo->id) <hr><a href="{{ url("blog/$blogInfo->id/edit") }}"><i class="fa fa-edit" aria-hidden="true"></i> Edit Blog</a> <em class="float-right">Only you can see this edit button</em><hr>@endif
                <img class="d-block w-100" style="max-height:400px" src="{{ $blogInfo['feature_picture_url'] }}" alt="">
                <hr>
                <div class="text-muted mt-2">
                    <small>{{ date(DateManager1::$date_asNumber, strtotime($blogInfo['created_at'])) /*DateManager1::diffForHumans($blogInfo['created_at'])*/ }} by {{ ucfirst(isset_or($authorInfo['full_name'], 'Anonymous')) }}</small>
                    <span class="pull-right">
                        <small><em>Last Visited {{ DateManager1::diffForHumans($blogInfo['last_visited_at']) }}</em></small>
                        <?php $blogInfo->update(['last_visited_at'=>now(), 'total_visited_count'=>$blogInfo->total_visited_count+1, 'updated_at'=>$blogInfo->updated_at]) ?>
                    </span>
                    <div>
                        @foreach($categoryList as $cat)
                            <small style="border:1px solid gray;padding:3px;margin:3px;"><a class="text-dark" href="{{ url("/blog?category=$cat") }}">{{ $cat }}</a></small>
                        @endforeach
                    </div>
                </div>
                <hr>
                <h4 class="text-muted mt-3 md-3">{{ ucfirst($blogInfo->name) }}</h4>


                <div class="card">
                    <div class="card-body">
                        {!! $blogInfo['body'] !!}
                    </div>
                </div>
                <div class="mt-2">
                    @foreach(Array1::filterArrayItem(explode(',', $blogInfo->tag_list)) as $tag)
                        <small style="border:1px solid gray;padding:3px;margin:3px;">{{ $tag }}</small>
                    @endforeach
                </div>

                @if(strlen($blogInfo->download_url)>2)
                    <div class="card mt-2">
                        <div class="card-body">
                            <a style="font-size:20px;font-weight:800" class="btn btn-success" href="{{ $blogInfo->download_url }}"><i class="fa fa-download" aria-hidden="true"></i> Download </a>
                        </div>
                    </div>
                @endif

                @if($blogInfo->allow_comment)
                    <div class="card mt-3">
                        <div class="card-body">
                            {!! exWidget1::getDisqusCommentBox()  !!}
                        </div>
                    </div>
                @else
                    <h2 class="card mt-3" style="background: #e0e0e0; border: 2px solid #a2a2a2;padding:20px;color:#a2a2a2"><strong>Comment Disabled!</strong></h2>
                @endif




                <div class="card mt-3">
                    <div class="card-body">
                        <?php $prevPost = $blogInfo->getPreviousModel() ?>
                        @if($prevPost)
                            <div class="float-left">
                                <span>{{ $prevPost->name }}</span><br>
                                <a class="btn btn-outline-primary" href="{{ url('/blog/'.$prevPost->slug) }}"><i class="fa fa-chevron-left" aria-hidden="true"></i> Previous Post</a>
                            </div>
                        @endif

                        <?php $nextPost = $blogInfo->getNextModel() ?>
                        @if($nextPost)
                            <div class="float-right">
                                <span>{{ $nextPost->name }}</span><br/>
                                <a class="btn btn-outline-primary" href="{{ url('/blog/'.$nextPost->slug) }}">Next Post <i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>


            <div class="col-sm-6 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-body">

                        <!-- Search -->
                        <h4 class="text-center">Search for posts</h4>
                        <form role="Form" method="GET" action="{{ url('blog') }}" accept-charset="UTF-8">
                            <div class="form-group">
                                <div class="input-group">
                                    <input class="form-control" type="text" name="q" placeholder="Search..." required/>
                                    <span class="input-group-btn"><button class="btn btn-primary" type="submit"><span class="fa fa-search" aria-hidden="true"></span></button></span>
                                </div>
                            </div>
                            <hr>
                        </form>

                        <!-- Popular Post -->
                        <h5>Popular posts</h5><hr>
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

                        <!-- Category -->
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
                        <hr>

                        <!-- About Me -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5>About Author</h5>
                                <a target="_blank" href="{{ $authorInfo->getAvatar() }}"><img align="left" style="margin:4px;width: 100px;height: 100px" src="{{ $authorInfo->getAvatar() }}" alt="" class="img-thumbnail img-responsive"></a>
                                <h5 align="left" class="text-center">{{ ucwords($authorInfo->full_name).(!empty($authorInfo->work_title)? " ($authorInfo->work_title)": "") }}</h5>
                                <p style="padding:5px">{{ ucfirst($authorInfo->about) }}</p>
                            </div>
                        </div>
                        <hr>



                        <!-- Newsletter -->
                        <div class="row">
                            <div class="col md 12">
                                <h5>Our Newsletter</h5>
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

        <!-- Suggestion -->
        @foreach(["You can also check"=>"", "Similar Content"=>(!empty($categoryList)? " AND ".MySql1::toWhereValuesInColumnsQuery(['category_list'], $categoryList ): "")] as $title=>$value)
            <h3 class="text-muted mt-3 mb-3">{{ $title }}</h3>
            <div class="row">
                @foreach(Blog::selectMany(false, "WHERE is_active = '1' $value ORDER BY RAND() LIMIT 3") as $blog)
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ url("blog/$blog->slug") }}"><img style="width:298px;height:167px !important;" src="{{ isset_or($blog['feature_picture_url'], HtmlAsset1::getImageThumb()) }}" alt="" class="img-thumbnail img-responsive "></a>
                                <p class="text-muted mt-2" style="height:40px;">By <span class="fa fa-user" aria-hidden="true"></span> {{ User::getField($blog->user_id, 'full_name', 'Anonymous') }} | <span class="fa fa-calendar" aria-hidden="true"></span> {{ $blog->updated_at }}</p>
                                <h5 class="text-primary">{{ ucfirst($blog->name) }}</h5>
                                <p class="text-muted" style="height:180px;overflow: hidden">{!! Blog::getFilteredSummary($blog->body, 210) !!}</p>
                                <a href="" class="btn btn-primary">Read more</a>
                            </div>
                        </div>
                        <br>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>





    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5d3995278a7a4fe2"></script>
@endsection

