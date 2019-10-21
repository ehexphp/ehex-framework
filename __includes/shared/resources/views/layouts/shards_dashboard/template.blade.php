<!doctype html>
<html class="no-js h-100" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Description -->
    <title>{!! String1::if_empty($page_title, Config1::APP_TITLE, $page_title.' &raquo; '.Config1::APP_TITLE) !!}</title>
    <meta name="description" content="{{ Config1::APP_DESCRIPTION }}">

    <!-- Favicon -->
    <link href="{{ asset('favicon.png') }}" rel="icon" sizes="16x16" type="image/png" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">



    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{--<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">--}}

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ layout_asset('', 'assets', 'shards_dashboard')  }}/styles/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="{{ layout_asset('', 'assets', 'shards_dashboard')  }}/styles/shards-dashboards.1.1.0.min.css">
    <link rel="stylesheet" href="{{ layout_asset('', 'assets', 'shards_dashboard') }}/styles/extras.1.1.0.min.css">
    <script async defer src="{{ layout_asset('', 'assets', 'shards_dashboard')  }}/scripts/buttons.js"></script>

    <!-- editable-select -->
    <link rel="stylesheet" href="{{ shared_asset('jquery-editable-select/jquery-editable-select.min.css') }}" />
    <meta name="theme-color" content="#fbfbfb" />


    {{--<!-- Unpoly files -->
    <script src="https://unpkg.com/unpoly@0.60.3/dist/unpoly.min.js" integrity="sha384-d0dZGRjXkcYffI0McmqJSm3er7T9PL52pR0NaeTLevHLCZ8ioS9xBvRa82r3inPZ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/unpoly@0.60.3/dist/unpoly.min.css" integrity="sha384-Au6LjS9fxDpwn3+26YmukmOumZUmryd8ONenkVIoH4eEPH1tACqLsVfqz9tBrvQy" crossorigin="anonymous">
    <!-- Unpoly's Bootstrap integration -->
    <script src="https://unpkg.com/unpoly@0.60.3/dist/unpoly-bootstrap3.min.js" integrity="sha384-lMc46x3hWx64BAq3vrNJ8iw+OxCsmd7wjW0s6R5OQ1hRS7wM/j89SjW/42xU2pRN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/unpoly@0.60.3/dist/unpoly-bootstrap3.min.css" integrity="sha384-oJV80YWkwBRAQFFmBo1hi8Wrh2PkisM2RttMUv4cvHABmxpez4yrECLKvs07ayJW" crossorigin="anonymous">
    <!-- Unpoly's Custom style -->
    <style>.up-modal-content{padding:10px;}</style>--}}


    <!-- Tags Input-->
    {{--<link href="{{ shared_asset() }}/bootstrap-tagsinput/bootstrap-tagsinput.min.css" rel="stylesheet"/>--}}
    {{--<style>  .bootstrap-tagsinput{ display: block !important; padding: 10px; min-height:60px; }   .bootstrap-tagsinput .tag{ color:white;background-color: #2d7cb5 !important; border: 1px solid #475eff; padding:5px;} </style>--}}





    <!-- Fancy Dashboard Analytical Widget-->
    <style>.dash-box{position:relative;background:rgb(255,86,65);background:-moz-linear-gradient(top,rgba(255,86,65,1)0%,rgba(253,50,97,1)100%);background:-webkit-linear-gradient(top,rgba(255,86,65,1)0%,rgba(253,50,97,1)100%);background:linear-gradient(to bottom,rgba(255,86,65,1)0%,rgba(253,50,97,1)100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff5641',endColorstr='#fd3261',GradientType=0);border-radius:4px;text-align:center;margin:60px 0 50px;}.dash-box-icon{position:absolute;transform:translateY(-50%)translateX(-50%);left:50%;}.dash-box-action{transform:translateY(-50%)translateX(-50%);position:absolute;left:50%;}.dash-box-body{padding:50px 20px;}.dash-box-icon:after{width:60px;height:60px;position:absolute;background:rgba(247,148,137,0.91);content:'';border-radius:50%;left:-10px;top:-10px;z-index:-1;}.dash-box-icon>i{background:#ff5444;border-radius:50%;line-height:40px;color:#FFF;width:40px;height:40px;font-size:22px;}.dash-box-icon:before{width:75px;height:75px;position:absolute;background:rgba(253,162,153,0.34);content:'';border-radius:50%;left:-17px;top:-17px;z-index:-2;}.dash-box-action>button{border:none;background:#FFF;border-radius:19px;padding:7px 16px;text-transform:uppercase;font-weight:500;font-size:11px;letter-spacing:.5px;color:#003e85;box-shadow:0 3px 5px#d4d4d4;}.dash-box-body>.dash-box-count{display:block;font-size:30px;color:#FFF;font-weight:300;}.dash-box-body>.dash-box-title{font-size:13px;color:rgba(255,255,255,0.81);}.dash-box.dash-box-color-2{background:rgb(252,190,27);background:-moz-linear-gradient(top,rgba(252,190,27,1)1%,rgba(248,86,72,1)99%);background:-webkit-linear-gradient(top,rgba(252,190,27,1)1%,rgba(248,86,72,1)99%);background:linear-gradient(to bottom,rgba(252,190,27,1)1%,rgba(248,86,72,1)99%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#fcbe1b',endColorstr='#f85648',GradientType=0);}.dash-box-color-2.dash-box-icon:after{background:rgba(254,224,54,0.81);}.dash-box-color-2.dash-box-icon:before{background:rgba(254,224,54,0.64);}.dash-box-color-2.dash-box-icon>i{background:#fb9f28;}.dash-box.dash-box-color-3{background:rgb(183,71,247);background:-moz-linear-gradient(top,rgba(183,71,247,1)0%,rgba(108,83,220,1)100%);background:-webkit-linear-gradient(top,rgba(183,71,247,1)0%,rgba(108,83,220,1)100%);background:linear-gradient(to bottom,rgba(183,71,247,1)0%,rgba(108,83,220,1)100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#b747f7',endColorstr='#6c53dc',GradientType=0);}.dash-box-color-3.dash-box-icon:after{background:rgba(180,70,245,0.76);}.dash-box-color-3.dash-box-icon:before{background:rgba(226,132,255,0.66);}.dash-box-color-3.dash-box-icon>i{background:#8150e4;}</style>
    {{--
        <div class="col-lg-2 col-md-3 col-sm-3 col-xs-6">
            <div class="dash-box dash-box-color-{{ 3 }}">
                <div class="dash-box-icon"> <i class="{{ $dashboard['icon'] }}"></i> </div>
                <div class="dash-box-body" style="box-shadow: 0 7px 7px 0 rgba(0, 0, 0, .14), 0 3px 1px -2px rgba(0, 0, 0, .2), 0 1px 5px 0 rgba(0, 0, 0, .12)  !important;"> <span class="dash-box-count">{{ Math1::toMoney($dashboard['value'], '', 0) }}</span> <span class="dash-box-title">{{ $dashboard['name'] }}</span> </div>
                <div class="dash-box-action"> <button onclick="Url1.redirect('{{ url($dashboard['linkUrl']) }}')">{{ $dashboard['linkName'] }}</button> </div>
            </div>
        </div>
    --}}




    <!-- Default Plugins -->
    <link href="{{ shared_asset() }}/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ shared_asset() }}/sweetalert2/sweetalert2.min.css" rel="stylesheet"/>
    <script src="{{ shared_asset() }}/sweetalert2/sweetalert2.min.js"></script>
</head>



<body class="h-100">

{{--<div class="color-switcher-toggle animated pulse infinite">--}}
    {{--<i class="material-icons">setting</i>--}}
{{--</div>--}}



<div class="container-fluid">
    <div class="row">




        <!-- Main Sidebar -->
        @if(!isset_or($page_disable_sidebar))
            <aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0" style="z-index:1000">
            @section('page_sidebar')
                <!-- logo-->
                    <div class="main-navbar">
                        <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
                            <a class="navbar-brand w-100 mr-0" href="{{ url('/dashboard') }}" style="line-height: 25px;"> <div class="d-table m-auto"> <img style="height:40px; width:40px;" id="main-logo" class="d-inline-block align-top mr-1" src="{{ Dashboard::logo() }}" alt="{{ Config1::APP_TITLE}} Dashboard"></div> </a>
                            <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none"><i class="fa fa-bars"></i></a>
                        </nav>
                    </div>


                    <!-- Main Search-->
                    <form  action="{{ Form1::callController(Dashboard::class, 'search()') }}" class="main-sidebar__search w-100 border-right d-sm-flex">{{--d-md-none d-lg-none--}}
                        {!! form_token() !!}
                        <div class="input-group input-group-seamless ml-3">
                            <div class="input-group-prepend"> <div class="input-group-text"> <i class="fa fa-search"></i> </div> </div>
                            <input name="q" id="sidebar_searchbar" value="{{ request()->q }}" class="navbar-search form-control" type="text" placeholder="Search for something..." aria-label="Search">
                            <script> $(function(){ Html1.enableSearchFilter('sidebar_searchbar', 'sidebar_containner', 'li'); }); </script>
                        </div>
                    </form>


                    <!-- Sidebar Menu-->
                    <div class="nav-wrapper">
                        <style>
                            .menuBreak { background: #ECEDF0;padding:10px; font-weight:800;font-size: 19px; }
                            #sidebar_containner li div div{ margin-left:10px}
                        </style>
                        <ul id="sidebar_containner" class="nav flex-column pb-5"  style="border-bottom:20px solid transparent;">
                            <?php $current_url = Url1::getCurrentUrl(false); ?>
                            @foreach(Dashboard::getMenuSideBar() as $menuCategory=>$menu)
                                <?php
                                    $isOpen = (isset($menu[$current_url]) || (starts_with($menuCategory, '#')) || (isset_or($_GET["menu"]) === $menuCategory) );
                                    $menuCategory = ltrim("$menuCategory", "# ");
                                ?>
                                <li class="nav-item dropdown {{ $isOpen? 'show': '' }}">
                                    <a class="nav-link dropdown-toggle menuBreak" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="{{ $isOpen? 'true': 'false' }}"> <strong>{!! $menuCategory !!}</strong> </a>
                                    <div class="dropdown-menu dropdown-menu-small {{ $isOpen? 'show': '' }}" x-placement="bottom-start" style="display: {{ $isOpen? 'block': 'none' }}; position: absolute; transform: translate3d(-6px, 50px, 0px); top: 0; left: 0; will-change: transform;">
                                        @foreach($menu as $link=>$name)
                                            <?php $menu_name = 'menu_'.$loop->parent->index.'_'.$loop->index; ?>
                                            <div class="nav-item"><a name="{{ $menu_name }}"></a><a up-target="main" class="nav-link {{ Url1::ifUrlEquals($link, 'active') }}" href="{{ $link }}#{{ $menu_name }}">{!! $name !!}</a></div>
                                        @endforeach
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @show
            </aside>
        @endif

        <!-- End Main Sidebar -->










        <?php $sidebarWiseClass = (!isset_or($page_disable_sidebar)? 'col-lg-10 col-md-9 col-sm-12  offset-lg-2 offset-md-3': 'col-12') ?>
        <main class="main-content p-0 <?= $sidebarWiseClass ?>">
            <div class="main-navbar sticky-top bg-white">
                <!-- Main Navbar -->
                <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
                    <form action="{{ Form1::callController(Dashboard::class, 'search()') }}" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex">
                        {!! form_token() !!}
                        <div class="input-group input-group-seamless ml-3">
                            <div class="input-group-prepend"><div class="input-group-text"> <i class="fa fa-search"></i> </div></div>
                            <input name="q" value="{{ request()->q }}" class="navbar-search form-control" type="text" placeholder="Search for something..." aria-label="Search">
                        </div>
                    </form>


                    <ul class="navbar-nav border-left flex-row ">
                        <li class="nav-item border-right dropdown notifications">
                            <?php $notification = Dashboard::getNotification(); ?>
                            <a class="nav-link nav-link-icon text-center" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="nav-link-icon__wrapper"> <i class="material-icons">&#xE7F4;</i> <span class="badge badge-pill badge-danger">{{ $notification['count'] }}</span> </div>
                            </a>

                            <div class="dropdown-menu dropdown-menu-small" aria-labelledby="dropdownMenuLink">
                                @foreach($notification['message'] as $message)
                                    <a class="dropdown-item" href="{{ @$notification['link'] }}">
                                        <div class="notification__icon-wrapper"><div class="notification__icon"><i class="material-icons">&#xE6E1;</i></div></div>
                                        <div class="notification__content"><span class="notification__category">{!! $message['title'] !!}</span><p> {!! $message['description'] !!}</p></div>
                                    </a>
                                @endforeach
                                <a class="dropdown-item notification__all text-center" href="{{ $notification['link'] }}"> View all Notifications </a>
                            </div>
                        </li>




                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                <img  style="height:40px;width:40px !important;" class="user-avatar rounded-circle mr-2" src="{{ $userInfo->getAvatar() }}" alt="User Avatar">
                                <span class="d-none d-md-inline-block">{{ $userInfo->full_name }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-small">
                                @foreach(Dashboard::getMenuHeader() as $link=>$name)
                                    <a class="dropdown-item" href="{{ $link }}"> {!! $name !!}</a>
                                @endforeach
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="{{ url('/logout') }}"> <i class="fa fa-sign-out"></i> Logout </a>
                            </div>
                        </li>
                    </ul>

                    <nav class="nav">
                        <a href="#" class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left" data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar"> <i class="material-icons">&#xE5D2;</i> </a>
                    </nav>
                </nav>
            </div>





















            <!-- Notification -->
            @if(Session1::isStatusSet())
                <div class="container-fluid px-0">
                    <div class="alert alert-info alert-dismissible fade show m-0" role="alert">
                        <strong style="color:white">Alert! -  {!! Session1::popupStatus(null, false)->getBody() !!}</strong> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                    </div>
                </div>
            @endif



            <!-- Page Content -->
            @yield('page_content')










            @section('page_footer')
                <footer class="main-footer d-flex p-2 px-3 bg-white border-top">
                    <ul class="nav">
                        @foreach(Dashboard::getMenuFooter() as $link=>$name)
                            <li class="nav-item"> <a class="nav-link" href="{{ $link }}">{!! $name !!}</a></li>
                        @endforeach
                    </ul>

                    @if(method_exists(Dashboard::class, 'getFooterCopyrightBody'))
                        <span class="copyright ml-auto my-auto mr-2 text-right">{!! Dashboard::getFooterCopyrightBody() !!}</span>
                    @else
                        <span class="copyright ml-auto my-auto mr-2 text-right">Copyright © {{ date('Y') }} <a href="{{ Url1::getSiteMainAddress() }}" rel="nofollow">{{ Config1::APP_TITLE }}</a> Designed by <a href="{{ Config1::APP_DEVELOPER_WEBSITE }}" rel="nofollow">{{ Config1::APP_DEVELOPER_NAME }}</a>. <br/>Proudly Powered by <a href="https://ehex.xamtax.com" rel="nofollow">Ehex</a>&nbsp;&nbsp; </span>
                    @endif
                </footer>
            @show
        </main>
    </div>
</div>




<script>
    if (typeof(jQuery) == 'undefined')  document.write("<scr" + "ipt src='{{ shared_asset() }}/jquery/js/jquery2.1.3.min.js'></scr" + "ipt>");
</script>
{{--<script> if (typeof(jQuery) == 'undefined')  document.write("<scr" + "ipt src='{{ layout_asset('', 'assets', 'shards_dashboard')  }}/scripts/jquery3.3.1.min.js'></scr" + "ipt>");  </script>--}}
{{--<script src="{{ layout_asset('', 'assets', 'shards_dashboard')  }}/scripts/jquery3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>--}}

<!-- Menu Toggle Script-->
{{--@if(!isset($allow_xcrud) || ($allow_xcrud != true) )   @endif--}}
<script src="{{ layout_asset('', 'assets', 'shards_dashboard')  }}/scripts/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="{{ layout_asset('', 'assets', 'shards_dashboard')  }}/scripts/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
{{--<script src="{{ layout_asset('', 'assets', 'shards_dashboard')  }}/scripts/app/app-blog-overview.1.1.0.min.js"></script>--}}

<!-- Tags -->
{{--<script src="{{ shared_asset() }}/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>--}}

<!-- Other Script-->
<script src="{{ layout_asset('', 'assets', 'shards_dashboard')  }}/scripts/Chart.min.js"></script>
<script src="{{ layout_asset('', 'assets', 'shards_dashboard')  }}/scripts/shards-dashboards.1.1.0.min.js"></script>

<!-- editable-select -->
<script src="{{ shared_asset('/jquery-editable-select/jquery-editable-select.min.js') }} "></script>






@section('page_footer_script')
    <!-- editable-select -->
    <script>$('.editable-select').editableSelect(); </script>

    <!-- tinyMCE Editor-->
    {{--<script src="{{ shared_asset('tinymce/jquery.tinymce.min.js') }} "></script>--}}

    <!-- tinyMCE Editor-->
    <script src="{{ shared_asset('tinymce/tinymce.min.js') }} "></script>
    <script>
        var tinyconfig = {
            selector:'.richeditor',
            content_style: ".mce-content-body {font-size:16px;font-family:Calibri,Arial,sans-serif;}",
            browser_spellcheck : true,
            image_advtab: true ,

            // external_filemanager_path:"/tinymce/filemanager/",
            // filemanager_title:"Responsive Filemanager" ,
            // relative_urls: false,
            // remove_script_host : false,

            // setup : function(ed){
            //     ed.on('init', function()
            //     {
            //         this.execCommand("fontName", false, "tahoma");
            //         this.execCommand("fontSize", false, "18px");
            //         this.execCommand("lineSpacing", false, "18px");
            //     });
            // },
            extended_valid_elements : "span[!class]", // output clean html
            plugins: [//'responsivefilemanager', 'directionality'
                'legacyoutput', 'spellchecker', 'fullscreen', 'emoticons', 'insertdatetime', 'image',
                'imagetools', 'textcolor', 'colorpicker', 'contextmenu', 'template',
                'advlist',  'searchreplace', 'print', 'preview', 'pagebreak',
                'codesample', 'charmap', 'code', 'lists', 'toc',
                'link', 'paste', 'table', 'bdesk_photo' //'bbcode',
            ],

            toolbar: 'undo redo | codesample  legacyoutput  ' +
                'visualblock visualchars textpattern nonbreaking  ' +
                'list pagebreak hr forecolor backcolor | styleselect | ' +
                'bold italic | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | link image | ' +
                ' emoticons searchreplace bbcode advlist tabfocus | bdesk_photo'
        };
        tinymce.init(tinyconfig);
    </script>
@show

<!-- Popup Any Notification -->
<?php Session1::popupStatus()->toSwalAlert();  ?>
</body>
</html>