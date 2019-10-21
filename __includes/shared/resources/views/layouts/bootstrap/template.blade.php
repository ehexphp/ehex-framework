<?php
	//register_path_for_layout_asset()
?>

<!DOCTYPE html>
<html>
<head>
	@yield('page_header')

	<!-- Description -->
	<title>{!! String1::if_empty($page_title, Config1::APP_TITLE, $page_title.' &raquo; '.Config1::APP_TITLE) !!}</title>
	<meta name="description" content="{{ Config1::APP_DESCRIPTION }}">

	<!-- Favicon -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="{{ asset('favicon.png') }}" rel="icon" sizes="16x16" type="image/png" />
	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
	<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Default Style -->
    <link href="{{ shared_asset() }}/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ shared_asset() }}/sweetalert2/sweetalert2.min.css" rel="stylesheet"/>
	<link href="{{ shared_asset() }}/bootstrap/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

	<!-- Extension -->
	<link href="{{ layout_asset() }}/style.css" rel="stylesheet" id="bootstrap-css">

	<!-- Pace -->
	{{--<link href="{{ shared_asset() }}/pace/flash.red.css" rel="stylesheet" type="text/css"/>--}}
	{{--<script src="{{ shared_asset() }}/pace/pace.min.js" type="text/javascript"></script>--}}


	<!-- Default Script -->
	<script src="{{ shared_asset() }}/sweetalert2/sweetalert2.min.js"></script>
	<script src="{{ shared_asset() }}/jquery/js/jquery3.3.1.min.js"></script>
	<script src="{{ shared_asset() }}/bootstrap/js/bootstrap.min.js"></script>

</head>
<body>



	@yield('page_content')

	{{--@if(!isset($allow_xcrud) || !isset($_GET['allow_xcrud']))
		<script src="{{ shared_asset() }}/jquery/js/jquery3.3.1.min.js"></script>
	@endif--}}
	@if(isset($includes) && isset( array_flip($includes)['edit']))
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>


		<!-- editable-select -->
		<link rel="stylesheet" href="{{ shared_asset('jquery-editable-select/jquery-editable-select.min.css') }}" />
		<!-- Tags Input-->
		<link rel="stylesheet" href="{{ shared_asset() }}/bootstrap-tagsinput/bootstrap-tagsinput.min.css"/>
		<!-- Tags -->
		<script src="{{ shared_asset() }}/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
		<script>
            // $('#myTags').tagsinput({
            //     typeahead: {source: ['Amsterdam', 'Washington', 'Sydney', 'Beijing', 'Cairo'] },
            //    // freeInput: true
            // });
		</script>



		<!-- editable-select -->
		<script src="{{ shared_asset('/jquery-editable-select/jquery-editable-select.min.js') }} "></script>
		<!-- tinyMCE Editor-->
		<script src="{{ shared_asset('tinymce/jquery.tinymce.min.js') }} "></script>
		<!-- editable-select -->
		<script>$('.editable-select').editableSelect(); </script>
		<!-- tinyMCE Editor-->
		<script src="{{ shared_asset('tinymce/tinymce.min.js') }} "></script>
		<script>
            var tinyconfig = {
                selector:'.richeditor',
                extended_valid_elements : "span[!class]", // output clean html
                plugins: [
                    'legacyoutput', 'spellchecker', 'fullscreen', 'emoticons', 'insertdatetime', 'image',
                    'imagetools', 'textcolor', 'colorpicker', 'contextmenu', 'template',
                    'advlist',  'searchreplace', 'print', 'preview', 'pagebreak',
                    'codesample', 'charmap', 'code', 'lists', 'toc',
                    'link', 'paste', 'table', 'bdesk_photo' //'bbcode',
                ],

                toolbar: 'undo redo | codesample  legacyoutput  ' +
                    'visualblock visualchars textpattern nonbreaking  ' +
                    'list pagebreak hr forecolor backcolor | styleselect | ' +
                    'bold italic | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | link image | ' +
                    ' emoticons searchreplace bbcode advlist tabfocus | bdesk_photo'
            };
            tinymce.init(tinyconfig);
		</script>
	@endif
	@yield('page_footer')
</body>
<?php /* Error Alert */  if (Session1::isStatusSet()) echo Session1::popupStatus()->toSwalAlert(); ?>
</html>
