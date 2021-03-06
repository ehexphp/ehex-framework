<?php
/**
 * Created by PhpStorm.
 * User: samtax
 * Date: 08/07/2018
 * Time: 7:47 AM
 */





/**
    @see https://github.com/nezamy/route
    How it works
    Routing is done by matching a URL pattern with a callback function.

    Route for index.php, might be
    $route->any('/', function() {
        echo 'Hello World';
    });


    $route->any('/about', function() {
        echo 'About';
    });

    $route->get(['/', 'index', 'home'], function() {
        // Will match 3 pages with one function
    });



    =========== For “unlimited” optional parameters, you can do this: ================

    // This example will match anything after blog/ - unlimited arguments
    $route->get('/blog/*', function() {
        // [$this] instanceof ArrayObject so you can get all args by getArrayCopy()
        pre($this->getArrayCopy());
        pre($this[1]);
        pre($this[2]);
    });




    ====================================================================================================== c


    function pages() {
        echo 'Page Content';
    }
    $route->get('/', 'pages');




    ================================================================================================================================
    class Home
    {
        function pages() {
            echo 'Home page Content';
        }
    }
    $route->get('/', ['Home', 'pages']);
    // OR
    $home = new Home;
    $route->get('/', [$Home, 'pages']);
    // OR
    $route->get('/', 'Home@pages');





    ================================================================================================================================

    $route->any('/', function() {
        // Any method requests
    });

    $route->get('/', function() {
        // Only GET requests
    });

    $route->post('/', function() {
        // Only POST requests
    });

    $route->put('/', function() {
        // Only PUT requests
    });

    $route->patch('/', function() {
        // Only PATCH requests
    });

    $route->delete('/', function() {
        // Only DELETE requests
    });

    // You can use multiple methods. Just add _ between method names
    $route->get_post('/', function() {
        // Only GET and POST requests
    });



    ============== Parameters ============


    / This example will match any page name
    $route->get('/?', function($page) {
        echo "you are in $page";
    });

    // This example will match anything after post/ - limited to 1 argument
    $route->get('/post/?', function($id) {
        // Will match anything like post/hello or post/5 ...
        // But not match /post/5/title
        echo "post id $id";
    });

    // more than parameters
    $route->get('/post/?/?', function($id, $title) {
        echo "post id $id and title $title";
    });







    ============= Named Parameters =========


    $route->get('/{username}/{page}', function($username, $page) {
        echo "Username $username and Page $page <br>";
        // OR
        echo "Username {$this['username']} and Page {$this['page']}";
    });




    ============= Named Parameters ===========
*/






/************************************************
 *  Route Config
 ************************************************/
    require PATH_LIBRARY ."route/RouteSystem.php";
    $app            = RouteApp::instance();
    $app->request   = RouteRequest::instance();
    $app->route     = RouteSystem::instance($app->request);
    $route = $app->route;







/************************************************
 *  Route Init/Include
 ************************************************/
    $FORM_ACTION_SHOULD_REDIRECT = true;

    //require PATH_APP."route.php";
    function api_and_form_default_route(){
        global $route;
        $route->any('form/*', function ($url){

            global $FORM_ACTION_SHOULD_REDIRECT;
            Session1::set('old', $_REQUEST);

            // render function
            \ServerRequest1::callFunction(urldecode($url), ',', false);

            if(!$FORM_ACTION_SHOULD_REDIRECT) return $FORM_ACTION_SHOULD_REDIRECT = true;
            else return Url1::redirect(String1::isset_or($_REQUEST['redirect_to'], Url1::backUrl()));
        });
        $route->any('api/*', function (){
            // render result
            echo json_encode(\Api1::callFunction(urldecode(Url1::getPageName()), ',', true));
        });
    }





    /**
     * @param $name
     * @param $actionFunction
     */
    function make_route($name, $actionFunction) { global $route; $route->any($name, $actionFunction); }


    api_and_form_default_route();
    Config1::onRoute(exRoute1::getRoute());
    $route->end();