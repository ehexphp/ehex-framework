<?php
    // validate if model set
    $model_name = isset($_REQUEST['model'])? urldecode($_REQUEST['model']): die(Console1::println(' Model to manage is Not set, e.g try <code>Dashboard::getManageUrl(Model::class)</code> in your route '));
    if(!class_exists($model_name) || !method_exists($model_name, 'manage')) redirect_back(["Manage Failed", "$model_name Model Cannot be Manageable. Ensure manage() method exists and render() method could be called from it.", 'error']);

    // check if model is allowed or if permission is admin
    $pageConfig = Dashboard::getManagePageConfig();
    $userInfo = in_array($model_name, $pageConfig['bypass_model_list'])? User::getLogin(true): User::getAllowedRoleLogin( $pageConfig['role'] ); //$userInfo = User::getAllowedRoleLogin( method_exists(Dashboard::class, "getManagePagePermission")? Dashboard::getManagePagePermission(): ['admin'] );
?>
@extends('layouts.shards_dashboard.template', ['page_title'=>String1::convertToSnakeCase($model_name, " ")." Manage - Page", 'allow_xcrud'=>true])




@section('page_content')
    <div class="main-content-container container-fluid px-4">
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-12 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Manage {{ $model_name }}</span>
                <h3 class="page-title"> Model Overview <a href="{{ Url1::getPageFullUrl(['show_all'=>1]) }}" class="btn btn-warning float-right"><i class="fa fa-gear" aria-hidden="true"></i> Manage All Model</a></h3>
            </div>
        </div>



        <!-- Dashboard - Small Stats Blocks -->
        @if(method_exists($model_name, "getDashboard"))
            <div class="row">
                @foreach($model_name::getDashboard()?? [] as $dashboard)
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                        <div class="dash-box dash-box-color-{{ 2 }}">
                            <div class="dash-box-icon"> <i class="{{ $dashboard['icon'] }}"></i> </div>
                            <div class="dash-box-body" style="box-shadow: 0 7px 7px 0 rgba(0, 0, 0, .14), 0 3px 1px -2px rgba(0, 0, 0, .2), 0 1px 5px 0 rgba(0, 0, 0, .12)  !important;"> <span class="dash-box-count">{{ Math1::formatNumber($dashboard['value']) }}</span> <span class="dash-box-title">{{ $dashboard['name'] }}</span> </div>
                            <div class="dash-box-action"> <button onclick="Url1.redirect('{{ url($dashboard['linkUrl']) }}')">{{ $dashboard['linkName'] }}</button> </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif




        <div class="row">
            <div class="col mb-4">
                <div class="card card-small">
                    <div class="card-header border-bottom"><h6 class="m-0"> {!! $model_name::getModelClassName(true) !!} <a href="{{ Url1::getPageFullUrl(['show_asset'=>1]) }}" class="btn btn-outline-primary float-right"><i class="fa fa-file-image-o" aria-hidden="true"></i> Show Asset</a></h6> </div>
                    <div class="card-body pt-0" style="margin-top:10px;"> {!! $model_name::manage()->render() !!}</div>
                </div>
                @if(isset($_GET['show_asset']))
                    <div class="card card-small mt-4">
                        <div class="card-header border-bottom"><h6 class="m-0"> Model {{$model_name}} Asset</h6> </div>
                        <div class="card-body pt-0" style="margin-top:10px;">
                            <?php
                                // delete model asset
                                if(isset($_GET['delete_model_asset'])) User::findOrInit(['id'=>$_GET['delete_model_asset']])->deleteAssetDirectory();
                                // fetch all model asset
                                $paginate = Array1::paginate(FileManager1::getDirectoriesFolders($model_name::getModelAssetPath()), isset_or($_GET['limit'], 20));
                            ?>
                            @forelse($paginate->data as $path)
                                <?php
                                    $model_id = Array1::last( explode(DIRECTORY_SEPARATOR, rtrim($path, DIRECTORY_SEPARATOR)) );
                                    if(in_array($model_id, ['.', '..'])) continue;
                                    $isIdExist = is_numeric($model_id)? $model_name::getField($model_id, 'id'): false;
                                    $template = $isIdExist? "<span class='text-primary font-weight-bolder'> Model ($model_id) Exists! </span>": "<span class='text-danger font-weight-bolder'>Model ($model_id) Not Exists! </span>";
                                ?>
                                <div class="mt-3 p-3 border border-primary col-md-12" style="background:#eaeaea">
                                    <div class="mb-2">
                                        <button class="btn btn-danger btn-sm"  onclick="Popup1.confirmLink('Delete Asset', 'Delete Model ({{ $model_id }}) Asset directory', '{{ Url1::replaceParameterAndGetUrl(['delete_model_asset'=>$model_id]) }}')"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                        <strong>{!! $template !!}</strong>
                                    </div>
                                    <div>
                                        <?php
                                        foreach(FileManager1::getDirectoriesFiles($path) as $imagePath)
                                            echo  "<div style='float:left;width:100px;'>".HtmlWidget1::fileDeleteBox(-1, $imagePath, exUrl1::convertPathToUrl($imagePath), 'height:70px;width:100%;')."</div>";
                                        ?>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            @empty
                                <div class="mt-3 p-3"> <h5 class="text-center text-muted"><i class="fa fa-folder-open" aria-hidden="true"></i> Asset Empty</h5> </div>
                            @endforelse
                            {!! $paginate->paginate !!}
                        </div>
                    </div>
                @endif
            </div>










            @if(isset_or($_GET['show_all']))
                <div class="col-4 mb-4">
                    <div class="card card-small">
                        <div class="card-header border-bottom"><h6 class="m-0">All Model <a href="{{ Url1::getPageFullUrl(['show_all'=>'']) }}" class=" float-right"><i class="fa fa-times-circle-o text-danger" aria-hidden="true"></i></a></h6></div>
                        <div class="card-body pt-0" style="margin-top:10px;">
                            @foreach(Dashboard::getPageList() as $modelType=>$list)
                                <li class="list-group-item p-3"><strong style="font-size: 16px; font-weight: 700">{!! $modelType !!}</strong></li>
                                @foreach($list as $model)
                                    <li class="list-group-item p-3"> <a class="{{ Url1::ifUrlEquals(/*url("/site/page?edit=$model".Url1::getLastHashFragment()), 'active'*/) }}" href="{{ Dashboard::getManageUrl($model, array_merge(Url1::getParameter(true), ['array_page'=>1])) }}"><i class="fa fa-link" aria-hidden="true"></i> {!! $model !!}</a> </li>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection