<!doctype html>
<html class="no-js h-100" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Description -->
    <title><?php echo String1::if_empty($page_title, Config1::APP_TITLE, $page_title.' &raquo; '.Config1::APP_TITLE); ?></title>
    <meta name="description" content="<?php echo e(Config1::APP_DESCRIPTION); ?>">

    <!-- Favicon -->
    <link href="<?php echo e(asset('favicon.png')); ?>" rel="icon" sizes="16x16" type="image/png" />
    <link rel="shortcut icon" href="<?php echo e(asset('favicon.ico')); ?>">
    <link rel="icon" type="image/png" href="<?php echo e(asset('favicon.png')); ?>">



    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(layout_asset('', 'assets', 'shards_dashboard')); ?>/styles/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="<?php echo e(layout_asset('', 'assets', 'shards_dashboard')); ?>/styles/shards-dashboards.1.1.0.min.css">
    <link rel="stylesheet" href="<?php echo e(layout_asset('', 'assets', 'shards_dashboard')); ?>/styles/extras.1.1.0.min.css">
    <script async defer src="<?php echo e(layout_asset('', 'assets', 'shards_dashboard')); ?>/scripts/buttons.js"></script>

    <!-- editable-select -->
    <link rel="stylesheet" href="<?php echo e(shared_asset('jquery-editable-select/jquery-editable-select.min.css')); ?>" />
    <meta name="theme-color" content="#fbfbfb" />


    <!-- Unpoly files -->
    <script src="https://unpkg.com/unpoly@0.60.3/dist/unpoly.min.js" integrity="sha384-d0dZGRjXkcYffI0McmqJSm3er7T9PL52pR0NaeTLevHLCZ8ioS9xBvRa82r3inPZ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/unpoly@0.60.3/dist/unpoly.min.css" integrity="sha384-Au6LjS9fxDpwn3+26YmukmOumZUmryd8ONenkVIoH4eEPH1tACqLsVfqz9tBrvQy" crossorigin="anonymous">
    <!-- Unpoly's Bootstrap integration -->
    <script src="https://unpkg.com/unpoly@0.60.3/dist/unpoly-bootstrap3.min.js" integrity="sha384-lMc46x3hWx64BAq3vrNJ8iw+OxCsmd7wjW0s6R5OQ1hRS7wM/j89SjW/42xU2pRN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/unpoly@0.60.3/dist/unpoly-bootstrap3.min.css" integrity="sha384-oJV80YWkwBRAQFFmBo1hi8Wrh2PkisM2RttMUv4cvHABmxpez4yrECLKvs07ayJW" crossorigin="anonymous">
    <!-- Unpoly's Custom style -->
    <style>.up-modal-content{padding:10px;}</style>


    <!-- Tags Input-->
    
    





    <!-- Fancy Dashboard Analytical Widget-->
    <style>.dash-box{position:relative;background:rgb(255,86,65);background:-moz-linear-gradient(top,rgba(255,86,65,1)0%,rgba(253,50,97,1)100%);background:-webkit-linear-gradient(top,rgba(255,86,65,1)0%,rgba(253,50,97,1)100%);background:linear-gradient(to bottom,rgba(255,86,65,1)0%,rgba(253,50,97,1)100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff5641',endColorstr='#fd3261',GradientType=0);border-radius:4px;text-align:center;margin:60px 0 50px;}.dash-box-icon{position:absolute;transform:translateY(-50%)translateX(-50%);left:50%;}.dash-box-action{transform:translateY(-50%)translateX(-50%);position:absolute;left:50%;}.dash-box-body{padding:50px 20px;}.dash-box-icon:after{width:60px;height:60px;position:absolute;background:rgba(247,148,137,0.91);content:'';border-radius:50%;left:-10px;top:-10px;z-index:-1;}.dash-box-icon>i{background:#ff5444;border-radius:50%;line-height:40px;color:#FFF;width:40px;height:40px;font-size:22px;}.dash-box-icon:before{width:75px;height:75px;position:absolute;background:rgba(253,162,153,0.34);content:'';border-radius:50%;left:-17px;top:-17px;z-index:-2;}.dash-box-action>button{border:none;background:#FFF;border-radius:19px;padding:7px 16px;text-transform:uppercase;font-weight:500;font-size:11px;letter-spacing:.5px;color:#003e85;box-shadow:0 3px 5px#d4d4d4;}.dash-box-body>.dash-box-count{display:block;font-size:30px;color:#FFF;font-weight:300;}.dash-box-body>.dash-box-title{font-size:13px;color:rgba(255,255,255,0.81);}.dash-box.dash-box-color-2{background:rgb(252,190,27);background:-moz-linear-gradient(top,rgba(252,190,27,1)1%,rgba(248,86,72,1)99%);background:-webkit-linear-gradient(top,rgba(252,190,27,1)1%,rgba(248,86,72,1)99%);background:linear-gradient(to bottom,rgba(252,190,27,1)1%,rgba(248,86,72,1)99%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#fcbe1b',endColorstr='#f85648',GradientType=0);}.dash-box-color-2.dash-box-icon:after{background:rgba(254,224,54,0.81);}.dash-box-color-2.dash-box-icon:before{background:rgba(254,224,54,0.64);}.dash-box-color-2.dash-box-icon>i{background:#fb9f28;}.dash-box.dash-box-color-3{background:rgb(183,71,247);background:-moz-linear-gradient(top,rgba(183,71,247,1)0%,rgba(108,83,220,1)100%);background:-webkit-linear-gradient(top,rgba(183,71,247,1)0%,rgba(108,83,220,1)100%);background:linear-gradient(to bottom,rgba(183,71,247,1)0%,rgba(108,83,220,1)100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#b747f7',endColorstr='#6c53dc',GradientType=0);}.dash-box-color-3.dash-box-icon:after{background:rgba(180,70,245,0.76);}.dash-box-color-3.dash-box-icon:before{background:rgba(226,132,255,0.66);}.dash-box-color-3.dash-box-icon>i{background:#8150e4;}</style>
    




    <!-- Default Plugins -->
    <link href="<?php echo e(shared_asset()); ?>/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo e(shared_asset()); ?>/sweetalert2/sweetalert2.min.css" rel="stylesheet"/>
    <script src="<?php echo e(shared_asset()); ?>/sweetalert2/sweetalert2.min.js"></script>
</head>



<body class="h-100">


    




<div class="container-fluid">
    <div class="row">

        <!-- Main Sidebar -->
        <?php if(!isset_or($page_disable_sidebar)): ?>
            <aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0" style="z-index:1000">
            <?php $__env->startSection('page_sidebar'); ?>
                <!-- logo-->
                    <div class="main-navbar">
                        <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
                            <a class="navbar-brand w-100 mr-0" href="<?php echo e(url('/')); ?>" style="line-height: 25px;"> <div class="d-table m-auto"> <img style="height:40px; width:40px;" id="main-logo" class="d-inline-block align-top mr-1" src="<?php echo e(Dashboard::logo()); ?>" alt="<?php echo e(Config1::APP_TITLE); ?> Dashboard"></div> </a>
                            <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none"><i class="fa fa-bars"></i></a>
                        </nav>
                    </div>


                    <!-- Main Search-->
                    <form  action="<?php echo e(Form1::callController(Dashboard::class, 'search()')); ?>" class="main-sidebar__search w-100 border-right d-sm-flex">
                        <?php echo form_token(); ?>

                        <div class="input-group input-group-seamless ml-3">
                            <div class="input-group-prepend"> <div class="input-group-text"> <i class="fa fa-search"></i> </div> </div>
                            <input name="q" id="sidebar_searchbar" value="<?php echo e(request()->q); ?>" class="navbar-search form-control" type="text" placeholder="Search for something..." aria-label="Search">
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
                            <?php $__currentLoopData = Dashboard::getMenuSideBar(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuCategory=>$menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $isOpen = (isset($menu[$current_url]) || (starts_with($menuCategory, '#')) || (isset_or($_GET["menu_category"]) === $menuCategory) );
                                    $menuCategory = ltrim("$menuCategory", "# ");
                                ?>
                                <li class="nav-item dropdown <?php echo e($isOpen? 'show': ''); ?>">
                                    <a class="nav-link dropdown-toggle menuBreak" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="<?php echo e($isOpen? 'true': 'false'); ?>"> <strong><?php echo $menuCategory; ?></strong> </a>
                                    <div class="dropdown-menu dropdown-menu-small <?php echo e($isOpen? 'show': ''); ?>" x-placement="bottom-start" style="display: <?php echo e($isOpen? 'block': 'none'); ?>; position: absolute; transform: translate3d(-6px, 50px, 0px); top: 0; left: 0; will-change: transform;">
                                        <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link=>$name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $link = Url1::buildParameter(['menu_category'=>$menuCategory], $link);
                                                $menu_name = 'menu_'.$loop->parent->index.'_'.$loop->index;
                                            ?>
                                            <div class="nav-item"><a id="<?php echo e($menu_name); ?>"></a><a up-target=".main-content-container" class="nav-link <?php echo e(Url1::ifUrlEquals($link, 'active')); ?>" href="<?php echo e($link); ?>#<?php echo e($menu_name); ?>"><?php echo $name; ?></a></div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php echo $__env->yieldSection(); ?>
            </aside>
        <?php endif; ?>

        <!-- End Main Sidebar -->










        <?php $sidebarWiseClass = (!isset_or($page_disable_sidebar)? 'col-lg-10 col-md-9 col-sm-12  offset-lg-2 offset-md-3': 'col-12') ?>
        <main class="main-content p-0 <?= $sidebarWiseClass ?>">
            <div class="main-navbar sticky-top bg-white">
                <!-- Main Navbar -->
                <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
                    <form action="<?php echo e(Form1::callController(Dashboard::class, 'search()')); ?>" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex">
                        <?php echo form_token(); ?>

                        <div class="input-group input-group-seamless ml-3">
                            <div class="input-group-prepend"><div class="input-group-text"> <i class="fa fa-search"></i> </div></div>
                            <input name="q" value="<?php echo e(request()->q); ?>" class="navbar-search form-control" type="text" placeholder="Search for something..." aria-label="Search">
                        </div>
                    </form>


                    <ul class="navbar-nav border-left flex-row ">
                        <li class="nav-item border-right dropdown notifications">
                            <?php $notification = Dashboard::getNotification(); ?>
                            <a class="nav-link nav-link-icon text-center" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="nav-link-icon__wrapper"> <i class="material-icons">&#xE7F4;</i> <span class="badge badge-pill badge-danger"><?php echo e($notification['count']); ?></span> </div>
                            </a>

                            <div class="dropdown-menu dropdown-menu-small" aria-labelledby="dropdownMenuLink">
                                <?php $__currentLoopData = $notification['message']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class="dropdown-item" href="<?php echo e(@$notification['link']); ?>">
                                        <div class="notification__icon-wrapper"><div class="notification__icon"><i class="material-icons">&#xE6E1;</i></div></div>
                                        <div class="notification__content"><span class="notification__category"><?php echo $message['title']; ?></span><p> <?php echo $message['description']; ?></p></div>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <a class="dropdown-item notification__all text-center" href="<?php echo e($notification['link']); ?>"> View all Notifications </a>
                            </div>
                        </li>




                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                <img  style="height:40px;width:40px !important;" class="user-avatar rounded-circle mr-2" src="<?php echo e($userInfo->getAvatar()); ?>" alt="User Avatar">
                                <span class="d-none d-md-inline-block"><?php echo e($userInfo->full_name); ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-small">
                                <?php $__currentLoopData = Dashboard::getMenuHeader(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link=>$name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class="dropdown-item" href="<?php echo e($link); ?>"> <?php echo $name; ?></a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="<?php echo e(url('/logout')); ?>"> <i class="fa fa-sign-out"></i> Logout </a>
                            </div>
                        </li>
                    </ul>

                    <nav class="nav">
                        <a href="#" class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left" data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar"> <i class="material-icons">&#xE5D2;</i> </a>
                    </nav>
                </nav>
            </div>





















            <!-- Notification -->
            <?php if(Session1::isStatusSet()): ?>
                <div class="container-fluid px-0">
                    <div class="alert alert-info alert-dismissible fade show m-0" role="alert">
                        <strong style="color:white">Alert! -  <?php echo Session1::popupStatus(null, false)->getBody(); ?></strong> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                    </div>
                </div>
            <?php endif; ?>



            <!-- Page Content -->
            <?php echo $__env->yieldContent('page_content'); ?>

            <?php $__env->startSection('page_footer'); ?>
                <footer class="main-footer d-flex p-2 px-3 bg-white border-top">
                    <ul class="nav">
                        <?php $__currentLoopData = Dashboard::getMenuFooter(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link=>$name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item"> <a class="nav-link" href="<?php echo e($link); ?>"><?php echo $name; ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>

                    <?php if(method_exists(Dashboard::class, 'getFooterCopyrightBody')): ?>
                        <span class="copyright ml-auto my-auto mr-2 text-right"><?php echo Dashboard::getFooterCopyrightBody(); ?></span>
                    <?php else: ?>
                        <span class="copyright ml-auto my-auto mr-2 text-right">Copyright © <?php echo e(date('Y')); ?> <a href="<?php echo e(Url1::getSiteMainAddress()); ?>" rel="nofollow"><?php echo e(Config1::APP_TITLE); ?></a> Designed by <a href="<?php echo e(Config1::APP_DEVELOPER_WEBSITE); ?>" rel="nofollow"><?php echo e(Config1::APP_DEVELOPER_NAME); ?></a>. <br/>Proudly Powered by <a href="https://ehex.xamtax.com" rel="nofollow">Ehex</a>&nbsp;&nbsp; </span>
                    <?php endif; ?>
                </footer>
            <?php echo $__env->yieldSection(); ?>

        </main>
    </div>
</div>




<script>
    if (typeof(jQuery) == 'undefined')  document.write("<scr" + "ipt src='<?php echo e(shared_asset()); ?>/jquery/js/jquery2.1.3.min.js'></scr" + "ipt>");
</script>



<!-- Menu Toggle Script-->

<script src="<?php echo e(layout_asset('', 'assets', 'shards_dashboard')); ?>/scripts/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="<?php echo e(layout_asset('', 'assets', 'shards_dashboard')); ?>/scripts/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


<!-- Tags -->


<!-- Other Script-->
<script src="<?php echo e(layout_asset('', 'assets', 'shards_dashboard')); ?>/scripts/Chart.min.js"></script>
<script src="<?php echo e(layout_asset('', 'assets', 'shards_dashboard')); ?>/scripts/shards-dashboards.1.1.0.min.js"></script>

<!-- editable-select -->
<script src="<?php echo e(shared_asset('/jquery-editable-select/jquery-editable-select.min.js')); ?> "></script>






<?php $__env->startSection('page_footer_script'); ?>
    <!-- editable-select -->
    <script>$('.editable-select').editableSelect(); </script>

    <!-- tinyMCE Editor-->
    

    <!-- tinyMCE Editor-->
    <script src="<?php echo e(shared_asset('tinymce/tinymce.min.js')); ?> "></script>
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
<?php echo $__env->yieldSection(); ?>

<!-- Popup Any Notification -->
<?php Session1::popupStatus()->toSwalAlert();  ?>
</body>
</html>