<?php register_path_for_layout_asset() ?>

<!DOCTYPE html>
<html>
<head>
	@yield('page_header')
	<!-- Description -->
	<title>{!! String1::if_empty($page_title, Config1::APP_TITLE, $page_title.' &raquo; '.Config1::APP_TITLE) !!}</title>
	<meta name="description" content="{{ Config1::APP_DESCRIPTION }}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="{{ isset_or($page_keywords, "") }}">

	<!-- Favicon -->
	<link href="{{ asset('favicon.png') }}" rel="icon" sizes="16x16" type="image/png" />
	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
	<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <!-- Default Style -->
    <link href="{{ shared_asset() }}/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ shared_asset() }}/sweetalert2/sweetalert2.min.css" rel="stylesheet"/>
	<link href="{{ shared_asset() }}/bootstrap/v4/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="{{ shared_asset() }}/jquery/js/jquery3.3.1.min.js" type="text/javascript"></script>

	<!-- fonts -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,800&display=swap" rel="stylesheet">
	<style>body {font-family: 'Montserrat', sans-serif !important;}</style>


	<!-- Unpoly files -->
	<script src="https://unpkg.com/unpoly@0.60.3/dist/unpoly.min.js" integrity="sha384-d0dZGRjXkcYffI0McmqJSm3er7T9PL52pR0NaeTLevHLCZ8ioS9xBvRa82r3inPZ" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://unpkg.com/unpoly@0.60.3/dist/unpoly.min.css" integrity="sha384-Au6LjS9fxDpwn3+26YmukmOumZUmryd8ONenkVIoH4eEPH1tACqLsVfqz9tBrvQy" crossorigin="anonymous">
	<!-- Unpoly's Bootstrap integration -->
	<script src="https://unpkg.com/unpoly@0.60.3/dist/unpoly-bootstrap3.min.js" integrity="sha384-lMc46x3hWx64BAq3vrNJ8iw+OxCsmd7wjW0s6R5OQ1hRS7wM/j89SjW/42xU2pRN" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://unpkg.com/unpoly@0.60.3/dist/unpoly-bootstrap3.min.css" integrity="sha384-oJV80YWkwBRAQFFmBo1hi8Wrh2PkisM2RttMUv4cvHABmxpez4yrECLKvs07ayJW" crossorigin="anonymous">
	<!-- Unpoly's Custom style -->
	<style>.up-modal-content{padding:10px;}</style>


	<!-- Open Graph -->
	<meta property="og:image" content="{{ asset('favicon.png') }}"/>{{--<meta property="og:image:width" content="800" /><meta property="og:image:height" content="543" />--}}
	<!-- Header Color -->
	<meta content="#3175D1" name="theme-color"/>
	<meta content="#3175D1" name="msapplication-TileColor"/>
</head>
<body>

	<!-- Menu -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navTopMenu" aria-controls="navTopMenu" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
		<a class="navbar-brand" up-target="main" href="{{ url("/")  }}"> <!-- <img src="{ { asset("/favicon.png") }}" alt="Logo"> --> {{ Config1::APP_TITLE }}</a>

		<div class="collapse navbar-collapse" id="navTopMenu">
			<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
				{!! HtmlWidget1::urlActiveTag(url("/"), '<a class="nav-link" up-target="main" href="'.url('/').'">Home <span class="sr-only">(current)</span></a>', 'active', 'nav-item', [], 'li', true) !!}
				@if(Auth1::isGuest())
					{!! HtmlWidget1::urlActiveTag(url('login'), '<a class="nav-link" up-target="main" href="'.url('login').'">Login</a>', 'active', 'nav-item') !!}
					{!! HtmlWidget1::urlActiveTag(url('register'), '<a class="nav-link" up-target="main" href="'.url('register').'">Register</a>', 'active', 'nav-item') !!}
				@elseif(Auth1::isAdmin())
					{!! HtmlWidget1::urlActiveTag(url('dashboard'), '<a class="nav-link" href="'.url('dashboard').'">Admin Dashboard</a>', 'active', 'nav-item') !!}
					{!! HtmlWidget1::urlActiveTag(url('logout'), '<a class="nav-link" href="'.url('logout').'">Logout</a>', 'active', 'nav-item') !!}
				@else
					{!! HtmlWidget1::urlActiveTag(url('dashboard'), '<a class="nav-link" href="'.url('dashboard').'">Dashboard</a>', 'active', 'nav-item') !!}
					{!! HtmlWidget1::urlActiveTag(url('logout'), '<a class="nav-link" href="'.url('logout').'">Logout</a>', 'active', 'nav-item') !!}
				@endif
			</ul>

			<form action="{{ Url1::actionLink("Dashboard@search()") }}" class="form-inline my-2 my-lg-0">
				{!! form_token() !!}
				<input class="form-control mr-sm-2" type="search" placeholder="Search" name="q" aria-label="Search">
				<button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
			</form>
		</div>
	</nav>


	<!-- Page Content -->
	<main>
		@yield('page_content')

		<!-- Footer Content -->
		@section('page_footer')
			<footer class="page-footer footer bg-dark py-3 mt-5">
				<div class="container">
					<div class="text-right">
						<span class="float-left text-white-50 mt-2">Copyright {{ date("Y") }}. {{ Config1::APP_TITLE }}</span>
						<a class="btn btn-link" href="{{ url('/') }}">Home</a>
						<a class="btn btn-link" href="{{ url('/blog') }}">Blog</a>
						<a class="btn btn-link" href="{{ url('/about') }}">About</a>
						<a class="btn btn-link" href="{{ url('/contact') }}">Contact</a>
						<a class="btn btn-link" href="{{ url('/terms_and_condition') }}">Term and Condition</a>
					</div>
				</div>
			</footer>
		@show
	</main>





	<!-- Default Script -->
	<script src="{{ shared_asset() }}/sweetalert2/sweetalert2.min.js"></script>
	<script src="{{ shared_asset() }}/bootstrap/v4/bootstrap.min.js"></script>
</body>
<?php  if (Session1::isStatusSet()) echo Session1::popupStatus()->toSwalAlert(); ?>
</html>
