<style>
    body {  background: {{ isset($bg_image)? "url($bg_image)": ''  }} {{ HtmlStyle1::getFixBackgroundAttr() }};  }





    .box-shadow{ box-shadow: 0 2px 2px 0 rgba(0, 0, 0, .14), 0 3px 1px -2px rgba(0, 0, 0, .2), 0 1px 5px 0 rgba(0, 0, 0, .12);  }
    .card, .form {  font: 15px/1.6em Lato, serif;  color: #696969;   margin: 0 auto; margin-top:10px;   background: #fff;  padding: 20px;  border-radius: 10px;  }


    .form  {margin: 100px auto 0; max-width: 578px !important; padding:30px;  }
    .form > section div {  margin: 30px 0 0 0;  }
    .form > section a {  display: block;  margin: 15px 0 30px 0;  color: #0251c7;  }
    .form input[type=text],
    .form input[type=password] {  font-size: 15px;  border: none;  background: #e5e4e4;  box-shadow: none;  }
    .form > section button.btn-success {  font-size: 17px;  background: #14a016;  }
    p{  font-size: 15px;  text-align: center;  margin: 2em 0;  }
    a.back{ display: inline !important; color: #9c9c9c; text-decoration: none !important;padding:0 !important;margin:0 !important }

    .list li{ list-style-type: none; }
    .list li a{ display:block; padding:10px; border-radius: 10px; text-decoration: none;}
    .list li a:hover{ background-color: #e1e1e1 !important;}

</style>




{{--
 SAMPLE

    <section class="container">
        <form method="post" action="{{ routes()->login }}">
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

