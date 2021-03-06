<?php register_path_for_layout_asset("layouts.bootstrap.template") ?>




<?php $__env->startSection('page_content'); ?>
    <?php echo $__env->make('layouts.bootstrap.inc.simple_form_style', ['bg_image'=>asset('/images/bg.svg')], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    

    <section class="container" style="opacity:0.9">
        <div class="row">
            <div class="col-lg-5 col-md-6 mx-auto">
                <?php echo HtmlForm1::open("User@processRegister()", ['class'=>'login']); ?>


                <h4><a href="<?php echo routes()->index; ?>" class="back"><i class="fa fa-home"></i></a>  Register <hr/> </h4>
                <div class="row">
                    <div class="col-md-12" style="margin-bottom: 30px;">
                        <div style="text-align: center !important;">
                            <img onclick="document.getElementById('dp_avatar').click()" src="<?php echo e((new User())->getAvatar()); ?>" id="image_preview" style="height:100px;width:100px; border-radius:50%;" />
                            <br/><br/><label class="btn btn-outline-primary">Upload Image<input style="display: none" id="dp_avatar" class="form-control" type="file" name="dp_avatar" onchange="Picture1.uploadPreview(this, 'image_preview')"></label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 "> <?php echo HtmlForm1::addInput('Username', [ 'placeholder'=>'Your User Name', 'name'=>"user_name", 'required']); ?> </div>
                    <div class="col-sm-6 "> <?php echo HtmlForm1::addInput('Phone Number', [ 'placeholder'=>'Your Phone Number', 'name'=>"phone_number", 'required']); ?> </div>
                </div>

                <div class="row">
                    <div class="col-sm-12"> <?php echo HtmlForm1::addInput('Full Name', [ 'placeholder'=>'Your Full Name', 'name'=>"full_name", 'required']); ?></div>
                    <div class="col-md-12"> <?php echo HtmlForm1::addInput('Email Address', [ 'placeholder'=>'Your Email', 'type'=>'email', 'name'=>"email", 'required']); ?></div>
                </div>

                <div class="row">
                    <div class="col-sm-6 "> <?php echo HtmlForm1::addInput('Password', [ 'placeholder'=>'Your Password', 'type'=>'password', 'name'=>"password", 'required', 'toggle'=>'true']); ?></div>
                    <div class="col-sm-6 "> <?php echo HtmlForm1::addSelect('Country', [ 'name'=>"country", 'selected'=>'Nigeria', 'value'=>Array1::reUseValueAsKey(DemoCountry::getCountries()), 'required']); ?></div>
                </div>

                <div  style="margin:15px 0 10px 0;" class="clearfix"><a href="<?php echo e(routes()->login); ?>" up-target="main" class="pull-right"><i class="fa fa-lock" aria-hidden="true"></i> Login</a></div>
                <?php echo HtmlForm1::close('Register Account', ['class'=>'btn btn-block btn-primary']); ?>

            </div>
        </div>
    </section>

    <p class="mt-5 mb-5 text-center"><span  style="color: whitesmoke;letter-spacing:2px;background: #4896EC; padding:10px; border-radius:10px;">&copy; Copyright <strong><?php echo e(Config1::APP_TITLE); ?></strong>. <?php echo e(date('Y')); ?></span></p>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('page_footer'); ?> <?php $__env->stopSection(); ?>








<?php echo $__env->make('layouts.bootstrap.template', ['page_title'=>'Register Page'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>