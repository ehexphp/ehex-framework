@extends('layouts.bootstrap.template', ['page_title'=>'Login Page'])




@section('page_content')
    @include('layouts.bootstrap.inc.simple_form_style', ['bg_image'=>asset('/images/bg.svg')])
    {{--{!! HtmlWidget1::menuOverlay(array_flip(FrontendPage::getMenuCommon()))  !!}--}}

    <section class="container" style="opacity:0.9;">
        <div class="row">
            <div class="col-lg-5 col-md-6 mx-auto">
                {!! HtmlForm1::open("User@processLogin()", ['class'=>'login', 'id'=>'login_form']) !!}
                <h4><a href="{!! routes()->index !!}" class="back"><i class="fa fa-home"></i></a>  Login <hr/> </h4>
                {!! HtmlForm1::addInput('Email / User Name', ['name'=>"user_name", ""]) !!}
                {!! HtmlForm1::addInput('Password', ['name'=>"password", 'type'=>'password', 'toggle'=>'true', ""]) !!}

                <div  style="margin:15px 0 10px 0;" class="clearfix">
                    <a href="{{ routes()->register }}" up-target="main" class="pull-right"> Register </a>
                    <span class="pull-right"> &nbsp;&nbsp;|&nbsp;&nbsp; </span>
                    <a href="{{ routes()->forgot_password }}" up-target="main" class="pull-right"> Forgot your password? </a>
                </div>

                {!! HtmlForm1::close('Login', ['class'=>'btn btn-block btn-primary']) !!}
            </div>
        </div>
    </section>

    <p class="mt-5 mb-5 text-center"><span  style="color: whitesmoke;letter-spacing:2px;background: #4896EC; padding:10px; border-radius:10px;">&copy; Copyright <strong>{{ Config1::APP_TITLE }}</strong>. {{ date('Y') }}</span></p>
@endsection



@section('page_footer') @endsection

