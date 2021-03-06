<?php register_path_for_layout_asset("layouts.bootstrap.template") ?>




<?php $__env->startSection('page_content'); ?>
    <?php echo $__env->make('layouts.bootstrap.inc.simple_form_style', ['bg_image'=>asset('/images/bg.svg')], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    

    <section class="container" style="opacity:0.9">
        <div class="row">
            <div class="col-lg-5 col-md-6 mx-auto">
                <?php echo HtmlForm1::open("User@processForgotPassword()", ['class'=>'login']); ?>

                <h4><a href="<?php echo routes()->index; ?>" class="back"><i class="fa fa-home"></i></a> Forgot Password <hr/> </h4>
                <?php echo HtmlForm1::addInput('Email / Username', ['placeholder'=>'Your email', 'name'=>"user_name", 'required']); ?>


                <div style="margin:15px 0 10px 0;" class="clearfix"><span class="pull-right"> <small>I have Access token,</small> <a href="<?php echo e(routes()->reset_password); ?>" up-target="main">Reset Password</a></span></div>
                <?php echo HtmlForm1::close('Send Mail', ['class'=>'btn btn-block btn-primary']); ?>

            </div>
        </div>
    </section>

    <p class="mt-5 mb-5 text-center"><span  style="color: whitesmoke;letter-spacing:2px;background: #4896EC; padding:10px; border-radius:10px;">&copy; Copyright <strong><?php echo e(Config1::APP_TITLE); ?></strong>. <?php echo e(date('Y')); ?></span></p>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('page_footer'); ?> <?php $__env->stopSection(); ?>








<?php echo $__env->make('layouts.bootstrap.template', ['page_title'=>'Forgot Password'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>