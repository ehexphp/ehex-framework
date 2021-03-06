@extends('layouts.bootstrap.template', ['page_title'=>'Register Page'])




@section('page_content')
    @include('layouts.bootstrap.inc.simple_form_style', ['bg_image'=>asset('/images/bg.svg')])
    {{--{!! HtmlWidget1::menuOverlay(array_flip(FrontendPage::getMenuCommon()))  !!}--}}

    <section class="container" style="opacity:0.9">
        <div class="row">
            <div class="col-lg-5 col-md-6 mx-auto">
                {!! HtmlForm1::open("User@processRegister()", ['class'=>'login']) !!}

                <h4><a href="{!! routes()->index !!}" class="back"><i class="fa fa-home"></i></a>  Register <hr/> </h4>
                <div class="row">
                    <div class="col-md-12" style="margin-bottom: 30px;">
                        <div style="text-align: center !important;">
                            <img onclick="document.getElementById('dp_avatar').click()" src="{{ (new User())->getAvatar() }}" id="image_preview" style="height:100px;width:100px; border-radius:50%;" />
                            <br/><br/><label class="btn btn-outline-primary">Upload Image<input style="display: none" id="dp_avatar" class="form-control" type="file" name="dp_avatar" onchange="Picture1.uploadPreview(this, 'image_preview')"></label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 "> {!! HtmlForm1::addInput('Username', [ 'placeholder'=>'Your User Name', 'name'=>"user_name", 'required']) !!} </div>
                    <div class="col-sm-6 "> {!! HtmlForm1::addInput('Phone Number', [ 'placeholder'=>'Your Phone Number', 'name'=>"phone_number", 'required']) !!} </div>
                </div>

                <div class="row">
                    <div class="col-sm-12"> {!! HtmlForm1::addInput('Full Name', [ 'placeholder'=>'Your Full Name', 'name'=>"full_name", 'required']) !!}</div>
                    <div class="col-md-12"> {!! HtmlForm1::addInput('Email Address', [ 'placeholder'=>'Your Email', 'type'=>'email', 'name'=>"email", 'required']) !!}</div>
                </div>

                <div class="row">
                    <div class="col-sm-6 "> {!! HtmlForm1::addInput('Password', [ 'placeholder'=>'Your Password', 'type'=>'password', 'name'=>"password", 'required', 'toggle'=>'true']) !!}</div>
                    <div class="col-sm-6 "> {!! HtmlForm1::addSelect('Country', [ 'name'=>"country", 'selected'=>'Nigeria', 'value'=>Array1::reUseValueAsKey(DemoCountry::getCountries()), 'required']) !!}</div>
                </div>

                <div  style="margin:15px 0 10px 0;" class="clearfix"><a href="{{ routes()->login }}" up-target="main" class="pull-right"><i class="fa fa-lock" aria-hidden="true"></i> Login</a></div>
                {!! HtmlForm1::close('Register Account', ['class'=>'btn btn-block btn-primary']) !!}
            </div>
        </div>
    </section>

    <p class="mt-5 mb-5 text-center"><span  style="color: whitesmoke;letter-spacing:2px;background: #4896EC; padding:10px; border-radius:10px;">&copy; Copyright <strong>{{ Config1::APP_TITLE }}</strong>. {{ date('Y') }}</span></p>
@endsection



@section('page_footer') @endsection







