<?php
    $frontendPage = FrontendPage::getDefault();
    $page_title = 'Contact Us';
?>
<?php register_path_for_layout_asset("layouts.bootstrap.template") ?>







<?php $__env->startSection('page_content'); ?>

    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">CONTACT US</h1>
            <p class="lead text-muted mb-0">We will like to hear from you</p>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header bg-primary text-white"><i class="fa fa-envelope"></i> Contact us.</div>
                    <div class="card-body">
                        <form method="post" action="<?php echo e(Form1::callController(ContactUs::class)); ?>" novalidate>
                            <?php echo form_token(); ?>

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input name="full_name" value="<?php echo e(Auth1::userOrInit()->full_name); ?>"  type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input name="email" value="<?php echo e(Auth1::userOrInit()->email); ?>" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" required>
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            </div>
                            <div class="form-group">
                                <label for="description">Message</label>
                                <textarea name="description" class="form-control" id="description" rows="6" required></textarea>
                            </div>
                            <div class="mx-auto"><button type="submit" class="btn btn-primary text-right">Submit</button></div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-primary" href="<?php echo e($frontendPage->social_facebook); ?>"><i class="fa fa-facebook-square fa-3x social"></i></a>
                        <a class="btn btn-info" href="<?php echo e($frontendPage->social_twitter); ?>"><i class="fa fa-twitter-square fa-3x social"></i></a>
                        <a class="btn btn-danger" href="<?php echo e($frontendPage->social_google_plus); ?>"><i class="fa fa-google-plus-square fa-3x social"></i></a>
                        <a class="btn btn-warning" href="mailto:<?php echo e($frontendPage->contact_email); ?>"><i class="fa fa-envelope-square fa-3x social"></i></a>
                    </div>
                </div>
            </div>


            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-header bg-primary text-white"><i class="fa fa-phone"></i> Request Callback</div>
                            <div class="card-body">
                                <form method="post" action="<?php echo e(Form1::callController(Callback::class)); ?>" novalidate>
                                    <?php echo form_token(); ?>

                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input name="full_name" value="<?php echo e(Auth1::userOrInit()->full_name); ?>"  type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Phone Number</label>
                                        <input name="phone_number" value="<?php echo e(Auth1::userOrInit()->phone_number); ?>"  type="tel" class="form-control" id="name" aria-describedby="phoneHelp" placeholder="Enter Phone Number" required>
                                    </div>
                                    <div class="mx-auto"><button type="submit" class="btn btn-primary text-right">Submit</button></div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card bg-light mb-3">
                            <div class="card-header bg-success text-white text-uppercase"><i class="fa fa-home"></i> Address</div>
                            <div class="card-body">
                                <p><i class="icon_mail_alt"></i><strong>Email </strong> <?php echo $frontendPage->contact_email; ?></p><hr>
                                <p><i class="icon_phone"></i><strong>Phone Number </strong> <?php echo e($frontendPage->contact_phone_number); ?></p><hr>
                                <p><i class="icon_phone"></i> <strong>Work Hour  <span> <?php echo e($frontendPage->contact_work_hour); ?></span></strong></p><hr>
                                <p><i class="icon_pin"></i> <strong>Address </strong> <?php echo $frontendPage->contact_address; ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card bg-light mb-3">
                            <div class="card-header bg-success text-white text-uppercase"><i class="fa fa-map"></i> Map</div>
                            <div class="card-body">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d3736489.7218514383!2d90.21589792292741!3d23.857125486636733!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1506502314230" width="100%" height="315" frameborder="0" style="border:0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.bootstrap.template', ['page_title'=>$page_title, 'frontendPage'=>$frontendPage], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>