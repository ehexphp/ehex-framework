<?php
    $userInfo = User::getAllowedRoleLogin(['admin']);
    if(isset($_GET['delete'])) AppSettings::deleteDirectory($_GET['delete']);
?>

@extends('layouts.shards_dashboard.template', ['page_title'=>'Admin Edit Page', 'allow_xcrud'=>true])




@section('page_content')
    <!-- / .main-navbar -->
    <div class="main-content-container container-fluid px-4">

        <!-- Page Menu Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-12 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle"> Information Panel </span>
                <h3 class="page-title"><i class="fa fa-gear" aria-hidden="true"></i> Website Settings </h3>
            </div>
        </div>
        <!-- End Page Header -->




        <!-- Manage Model -->
        <div class="row">

            <!-- File Explorer -->
            <div class="col-md-12">
                <div class="card card-small mb-3">
                    <div class="card-body">
                        <div>
                            <?php $unique_title = 'Code Explorer';
                            $slug = String1::convertWordToSlug($unique_title); ?>
                            <h3><i class="fa fa-code" aria-hidden="true"></i> {{ $unique_title }}</h3><hr/><a name="{{ $slug }}"></a>
                            @if(isset($_GET["$slug"]) || isset($_GET["p"]))
                                @include("pages.common.filemanager.tinyfilemanager")
                            @else
                                {!! "<a href='".routes()->current."?$slug#$slug'>$unique_title</a>" !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>







            <!-- Side List Toggle -->
            <div class="col-md-12">
                <div class="row">
                    @foreach(AppSettings::getSideBar() as $data)
                        <div class="col-md-4">
                            <div class="card card-small mb-3">
                                <div class="card-body">
                                    <a name="{{ $data['id'] }}"></a>
                                    <h5>{{ $data['header_title'] }} <span class="pull-right badge badge-warning">{{ String1::isSetOr(count($data['data'])) }}</span> </h5>
                                    @if((String1::isset_or($_GET["id"], 0) == $data['id']))

                                        @foreach($data['data'] as $category=>$list)
                                            <li class="list-group-item p-3"><strong style="font-size: 16px; font-weight: 700">{!! $category !!}</strong> <span class="pull-right badge badge-warning">{{ String1::isSetOr(count($list)-2) }}</span></li>
                                            @foreach($list as $path)
                                                @if(String1::endsWith(rtrim($path, '/'), '..') || String1::endsWith(rtrim($path, '/'), '.')) @continue @endif
                                                <li class="list-group-item p-3"> &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <a style="" href="{{ Url1::pathToUrl($path.'README.md') }}"><i class="fa fa-link" aria-hidden="true"></i> {!! AppSettings::cleanFileName($path) !!}</a>
                                                    <a  class="pull-right" href="javascript:void(0)" onclick="Popup1.confirmLink('Are you sure?', 'This Action Cannot be Undo <br/><small><code>{{$path}}</code></small>', '{{ Url1::getPageFullUrl(['delete'=>$path]) }}')"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                </li>
                                            @endforeach
                                        @endforeach

                                    @else
                                        {!! '<a class="btn btn-primary" href="?id='.$data['id'].'#'.$data['id'].'"><i class="fa fa-eye" aria-hidden="true"></i> View </a>' !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>



        </div>
    </div>
@endsection



















@section('page_footer_script')

@endsection































