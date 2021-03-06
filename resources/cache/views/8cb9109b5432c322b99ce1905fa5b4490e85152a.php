<?php register_path_for_layout_asset("layouts.bootstrap.template") ?>




<?php $__env->startSection('page_content'); ?>
    <?php echo $__env->make('layouts.bootstrap.inc.simple_form_style', ['bg_image'=>asset('/images/bg.svg')], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    

    <section class="container" style="opacity:0.9;">
        <div class="row">
            <div class="col-lg-5 col-md-6 mx-auto">
                <?php echo HtmlForm1::open("User@processLogin()", ['class'=>'login', 'id'=>'login_form']); ?>

                <h4><a href="<?php echo routes()->index; ?>" class="back"><i class="fa fa-home"></i></a>  Login <hr/> </h4>
                <?php echo HtmlForm1::addInput('Email / User Name', ['name'=>"user_name", ""]); ?>

                <?php echo HtmlForm1::addInput('Password', ['name'=>"password", 'type'=>'password', 'toggle'=>'true', ""]); ?>


                <div  style="margin:15px 0 10px 0;" class="clearfix">
                    <a href="<?php echo e(routes()->register); ?>" up-target="main" class="pull-right"> Register </a>
                    <span class="pull-right"> &nbsp;&nbsp;|&nbsp;&nbsp; </span>
                    <a href="<?php echo e(routes()->forgot_password); ?>" up-target="main" class="pull-right"> Forgot your password? </a>
                </div>

                <?php echo HtmlForm1::close('Login', ['class'=>'btn btn-block btn-primary']); ?>

            </div>
        </div>
    </section>

    <p class="mt-5 mb-5 text-center"><span  style="color: whitesmoke;letter-spacing:2px;background: #4896EC; padding:10px; border-radius:10px;">&copy; Copyright <strong><?php echo e(Config1::APP_TITLE); ?></strong>. <?php echo e(date('Y')); ?></span></p>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('page_footer'); ?> <?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.bootstrap.template', ['page_title'=>'Login Page'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>