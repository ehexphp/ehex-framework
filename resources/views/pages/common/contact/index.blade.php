<?php
    $frontendPage = FrontendPage::getDefault();
    $page_title = 'Contact Us';
?>
@extends('layouts.bootstrap.template', ['page_title'=>$page_title, 'frontendPage'=>$frontendPage])







@section('page_content')

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
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
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
                        <form method="post" action="{{ Form1::callController(ContactUs::class) }}" novalidate>
                            {!! form_token() !!}
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input name="full_name" value="{{ Auth1::userOrInit()->full_name }}"  type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input name="email" value="{{ Auth1::userOrInit()->email }}" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" required>
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
                        <a class="btn btn-primary" href="{{ $frontendPage->social_facebook }}"><i class="fa fa-facebook-square fa-3x social"></i></a>
                        <a class="btn btn-info" href="{{ $frontendPage->social_twitter }}"><i class="fa fa-twitter-square fa-3x social"></i></a>
                        <a class="btn btn-danger" href="{{ $frontendPage->social_google_plus }}"><i class="fa fa-google-plus-square fa-3x social"></i></a>
                        <a class="btn btn-warning" href="mailto:{{ $frontendPage->contact_email }}"><i class="fa fa-envelope-square fa-3x social"></i></a>
                    </div>
                </div>
            </div>


            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-header bg-primary text-white"><i class="fa fa-phone"></i> Request Callback</div>
                            <div class="card-body">
                                <form method="post" action="{{ Form1::callController(Callback::class) }}" novalidate>
                                    {!! form_token() !!}
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input name="full_name" value="{{ Auth1::userOrInit()->full_name }}"  type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Phone Number</label>
                                        <input name="phone_number" value="{{ Auth1::userOrInit()->phone_number }}"  type="tel" class="form-control" id="name" aria-describedby="phoneHelp" placeholder="Enter Phone Number" required>
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
                                <p><i class="icon_mail_alt"></i><strong>Email </strong> {!! $frontendPage->contact_email !!}</p><hr>
                                <p><i class="icon_phone"></i><strong>Phone Number </strong> {{ $frontendPage->contact_phone_number }}</p><hr>
                                <p><i class="icon_phone"></i> <strong>Work Hour  <span> {{ $frontendPage->contact_work_hour }}</span></strong></p><hr>
                                <p><i class="icon_pin"></i> <strong>Address </strong> {!! $frontendPage->contact_address !!}</p>
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


@endsection

