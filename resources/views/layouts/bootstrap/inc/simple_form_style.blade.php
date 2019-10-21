<style>
    body {  background: {{ isset($bg_image)? "url($bg_image)": ''  }} {{ HtmlStyle1::getFixBackgroundAttr() }};  }
    form.login {
        margin-top:50px;
        color: #696969;
        background: #fff;
        padding: 30px;
        border-radius: 10px;
    }
</style>




{{--
 SAMPLE

    <section class="container">
        <form method="post" class="login" action="{{ routes()->login }}">
            <section>



                <div style="text-align: center !important;"><img src="{{ (new User())->getAvatar() }}"/></div>
                {!! HtmlForm1::addInput('Email / User Name', ['name'=>"user_name"]) !!}
                {!! HtmlForm1::addInput('Password', ['name'=>"password", 'type'=>'password']) !!}
                <a href="#">Forgot your password?</a>
                <button type="submit" name="btn_submit" class="btn btn-lg btn-block btn-success">Login Now</button>




            </section>
        </form>
        <p class="signup"><a style="color: #fff;" href="{{ routes()->register }}">Register an account</a></p>
    </section>
--}}

