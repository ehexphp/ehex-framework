<!DOCTYPE HTML>
<html lang="en">
<head>

    <!-- Description -->
    <title>404</title>
    <meta name="description" content="{{ Config1::APP_DESCRIPTION }}">

    <!-- Favicon -->
    <link href="{{ asset('favicon.png') }}" rel="icon" sizes="16x16" type="image/png" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <style>body {  margin: 0 }</style>
</head>


<body>
    <div id="__next">
        <div style="color:#000;background:#fff;font-family: -apple-system, BlinkMacSystemFont, Roboto, 'Segoe UI', serif;, 'Fira Sans';, Avenir, 'Helvetica';, 'Lucida Grande';, sans-serif;height:100vh;text-align:center;display:flex;flex-direction:column;align-items:center;justify-content:center;" data-reactroot="">
            <div>
                <h1 style="display:inline-block;border-right:1px solid rgba(0, 0, 0,.3);margin:0;margin-right:20px;padding:10px 23px 10px 0;font-size:24px;font-weight:500;vertical-align:top;">404</h1>
                <div style="display:inline-block;text-align:left;line-height:49px;height:49px;vertical-align:middle"><h2 style="font-size:14px;font-weight:normal;line-height:inherit;margin:0;padding:0"> This page could not be found. </h2></div>
            </div>
        </div>
    </div>



    <!-- Footer Menu for all Menu-->
    @section('page_content')
        <script src="{{ shared_asset() }}/jquery/js/jquery3.3.1.min.js" type="text/javascript"></script>
        <?php echo HtmlWidget1::footerPopup( HtmlWidget1::listLink('Site Menu', routes(['current', 'index'], true)), 'Menu List', 'left'); ?>
    @show
</body>


