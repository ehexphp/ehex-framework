


@extends('layouts.bootstrap.template', ['page_title'=>'Reset Password'])




@section('page_content')
    @include('layouts.bootstrap.inc.simple_form_style', ['bg_image'=>asset('/images/bg.svg')])
    {{--{!! HtmlWidget1::menuOverlay(array_flip(FrontendPage::getMenuCommon()))  !!}--}}

    <section class="container" style="opacity:0.9">
        <div class="row">
            <div class="col-lg-5 col-md-6 mx-auto">
                {!! HtmlForm1::open("User@processResetPassword()", ['class'=>'login']) !!}
                <h4><a href="{!! routes()->index !!}" class="back"><i class="fa fa-home"></i></a>  Reset Password <hr/> </h4>
                {!! HtmlForm1::addInput('Access Token', ['placeholder'=>'Your Access Token', 'name'=>"access_token", 'required']) !!}
                {!! HtmlForm1::addInput('New Password', ['type'=>'password', 'placeholder'=>'Your New Password', 'name'=>"password", 'required']) !!}

                <div  style="margin:15px 0 10px 0;" class="clearfix"> <span class="pull-right"> <a href="{{ routes()->forgot_password }}" up-target="main">Resend Token</a></span> </div>
                {!! HtmlForm1::close('Reset', ['class'=>'btn btn-block btn-primary']) !!}
            </div>
        </div>
    </section>

    <p class="mt-5 mb-5 text-center"><span  style="color: whitesmoke;letter-spacing:2px;background: #4896EC; padding:10px; border-radius:10px;">&copy; Copyright <strong>{{ Config1::APP_TITLE }}</strong>. {{ date('Y') }}</span></p>
@endsection


@section('page_footer') @endsection



























