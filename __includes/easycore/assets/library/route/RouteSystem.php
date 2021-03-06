<?php
/**
 * Just Framework - It's a PHP micro-framework for Full Stack Web Developer
 *
 * @package     Just Framework
 * @copyright   2016 (c) Mahmoud Elnezamy
 * @author      Mahmoud Elnezamy <http://nezamy.com>
 * @link        http://justframework.com
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 * @version     1.0.0
 */


/**
 * RouteApp
 *
 * @package     Just Framework
 * @author      Mahmoud Elnezamy <http://nezamy.com>
 * @since       1.0.0
 */

class RouteApp{
    private static $instance;

    /**
     * Constructor - Define some variables.
     */
    public function __construct() { $this->autoload(); }



    /**
     * Singleton instance.
     *
     * @return $this
     */
    public static function instance() {
        if (null === static::$instance) { static::$instance = new static; }
        return static::$instance;
    }



    /**
     * Magic autoload.
     */
    public function autoload()
    {
        spl_autoload_register(function($className)
        {
            $currentNamespace = strtolower(str_replace("\\", DS, __NAMESPACE__));
            $currentNamespace = empty($currentNamespace) ? "" : $currentNamespace . DS;
            $className = str_replace("\\", DS, $className);
            $classNameOnly = basename($className);
            $namespace = strtolower(substr($className, 0, -strlen($classNameOnly)));

            if (is_file($class = BASE_PATH . $namespace . "{$classNameOnly}.php")) {
                return include_once($class);
            } elseif (is_file($class = BASE_PATH . $namespace . ucfirst($classNameOnly).'.php')) {
                return include_once($class);
            } elseif (is_file($class = BASE_PATH . $currentNamespace . $namespace . "{$classNameOnly}.php")) {
                return include_once($class);
            } elseif (is_file($class = BASE_PATH . $currentNamespace . $namespace . ucfirst($classNameOnly).'.php')) {
                return include_once($class);
            }
            return false;
        });
    }


    /**
     * Magic call.
     *
     * @param string   $method
     * @param array    $args
     *
     * @return mixed
     */
    public function __call($method, $args){return  isset($this->{$method}) && is_callable($this->{$method}) ? call_user_func_array($this->{$method}, $args) : null;}


    /**
     * Set new variables and functions to this class.
     *
     * @param string      $k
     * @param mixed    $v
     */
    public function __set($k, $v){$this->{$k} = $v instanceof \Closure ? $v->bindTo($this) : $v;}
}






















































/**
 * RouteRequest
 *
 * @package     Just Framework
 * @author      Mahmoud Elnezamy <http://nezamy.com>
 * @since       1.0.0
 */

class RouteRequest
{
    private static $instance;

    /**
     * Constructor - Define some variables.
     */
    public function __construct()
    {
        $this->server = $_SERVER;

        $uri = parse_url($this->server["REQUEST_URI"], PHP_URL_PATH);
        $script = $_SERVER['SCRIPT_NAME'];
        $parent = dirname($script);

        // Fix path if not running on domain or local domain.
        if (stripos($uri, $script) !== false) {
            $this->path = substr($uri, strlen($script));
        } elseif (stripos($uri, $parent) !== false) {
            $this->path = substr($uri, strlen($parent));
        } else {
            $this->path = $uri;
        }

        $this->path = preg_replace('/\/+/', '/', '/' . trim(urldecode($this->path), '/') . '/');
        $this->hostname = str_replace('/:(.*)$/', "", $_SERVER['HTTP_HOST']);
        $this->servername = empty($_SERVER['SERVER_NAME']) ? $this->hostname : $_SERVER['SERVER_NAME'];
        $this->secure = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on');
        $this->port = isset($_SERVER['SERVER_PORT']) ? $_SERVER['SERVER_PORT'] : null;
        $this->protocol = $this->secure ? 'https' : 'http';
        $this->url = strtolower($this->protocol . '://' . $this->servername);
        if($this->servername == 'localhost'){
            $this->url = strtolower(
                $this->protocol . '://' . $this->servername .
                str_replace($this->path, '', $this->server['REQUEST_URI'])
            );
        }
        $this->curl = rtrim($this->url, '/') . $this->path;
        $this->extension = pathinfo($this->path, PATHINFO_EXTENSION);
        $this->headers = call_user_func(function () {
            $r = [];
            foreach ($_SERVER as $k => $v) {
                if (stripos($k, 'http_') !== false) {
                    $r[strtolower(substr($k, 5))] = $v;
                }
            }
            return $r;
        });
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->query = $_GET;
        $this->args = [];
        foreach ($this->query as $k => $v) {
            $this->query[$k] = preg_replace('/\/+/', '/', str_replace(['..', './'], ['', '/'], $v));
        }

        if (isset($this->headers['content_type']) && $this->headers['content_type'] == 'application/x-www-form-urlencoded') {
            parse_str(file_get_contents("php://input"), $input);
        } else {
            $input = json_decode( file_get_contents("php://input"), true);
            //$input = $input? $input: $_REQUEST;
        }

        $this->body = is_array($input) ? $input : [];
        $this->body = array_merge($this->body, $_POST);
        $this->files = isset($_FILES) ? $_FILES : [];
        $this->cookies = $_COOKIE;
        $x_requested_with = isset($this->headers['x_requested_with']) ? $this->headers['x_requested_with'] : false;

        $this->ajax = $x_requested_with === 'XMLHttpRequest' || String1::startsWith($this->path, '/api/');
    }

    /**
     * Singleton instance.
     *
     * @return $this
     */
    public static function instance()
    {
        if (null === static::$instance) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    /**
     * Get user IP.
     *
     * @return string
     */
    public function ip()
    {
        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED"];
        } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
            $ip = $_SERVER["HTTP_FORWARDED"];
        } elseif (isset($_SERVER["REMOTE_ADDR"])) {
            $ip = $_SERVER["REMOTE_ADDR"];
        } else {
            $ip = getenv("REMOTE_ADDR");
        }

        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return 'unknown';
        }

        return $ip;
    }

    /**
     * Get user browser.
     *
     * @return string
     */
    public function browser()
    {
        if (strpos($this->server['HTTP_USER_AGENT'], 'Opera') || strpos($this->server['HTTP_USER_AGENT'], 'OPR/')) {
            return 'Opera';
        } elseif (strpos($this->server['HTTP_USER_AGENT'], 'Edge')) {
            return 'Edge';
        } elseif (strpos($this->server['HTTP_USER_AGENT'], 'Chrome')) {
            return 'Chrome';
        } elseif (strpos($this->server['HTTP_USER_AGENT'], 'Safari')) {
            return 'Safari';
        } elseif (strpos($this->server['HTTP_USER_AGENT'], 'Firefox')) {
            return 'Firefox';
        } elseif (strpos($this->server['HTTP_USER_AGENT'], 'MSIE') || strpos($this->server['HTTP_USER_AGENT'], 'Trident/7')) {
            return 'Internet Explorer';
        }
        return 'unknown';
    }

    /**
     * Get user platform.
     *
     * @return string
     */
    public function platform()
    {
        if (preg_match('/linux/i', $this->server['HTTP_USER_AGENT'])) {
            return 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $this->server['HTTP_USER_AGENT'])) {
            return 'mac';
        } elseif (preg_match('/windows|win32/i', $this->server['HTTP_USER_AGENT'])) {
            return 'windows';
        }
        return 'unknown';
    }

    /**
     * Check whether user has connected from a mobile device (tablet, etc).
     *
     * @return bool
     */
    public function isMobile()
    {
        $aMobileUA = array(
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );

        // Return true if mobile User Agent is detected.
        foreach ($aMobileUA as $sMobileKey => $sMobileOS) {
            if (preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])) {
                return true;
            }
        }
        // Otherwise, return false.
        return false;
    }

    /**
     * Magic call.
     *
     * @param string $method
     * @param array $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        return isset($this->{$method}) && is_callable($this->{$method})
            ? call_user_func_array($this->{$method}, $args) : null;
    }

    /**
     * Set new variables and functions to this class.
     *
     * @param string $k
     * @param mixed $v
     */
    public function __set($k, $v)
    {
        $this->{$k} = $v instanceof \Closure ? $v->bindTo($this) : $v;
    }
}














































/**
 * RouteSystem
 *
 * @package     Just Framework
 * @author      Mahmoud Elnezamy <http://nezamy.com>
 * @since       1.0.0
 */
class RouteSystem
{
    private static $instance;
    /**
     * Named parameters list.
     */
    protected $pattern = [
        '/*' => '/(.*)',
        '/?' => '/([^\/]+)',
        'int' => '/([0-9]+)',
        'multiInt' => '/([0-9,]+)',
        'title' => '/([a-z_-]+)',
        'key' => '/([a-z0-9_]+)',
        'multiKey' => '/([a-z0-9_,]+)',
        'isoCode2' => '/([a-z]{2})',
        'isoCode3' => '/([a-z]{3})',
        'multiIsoCode2' => '/([a-z,]{2,})',
        'multiIsoCode3' => '/([a-z,]{3,})'
    ];
    private $routes = [];
    private $group = '';
    private $matchedPath = '';
    private $matched = false;
    private $pramsGroup = [];
    private $matchedArgs = [];
    private $pattGroup = [];
    private $fullArg = '';
    private $isGroup = false;
    private $groupAs = '';
    private $currentGroupAs = '';
    private $currentGroup = [];
    private $prams;
    private $currentUri;
    private $routeCallback = [];
    private $patt;
    public $Controller;
    public $Method;
    private $before = [];
    private $after = [];

    // [XAMTAX] Use to extract all route so i can call them by name as ArrayObject
    function getAllRoutes(){
        return $this->routes;
    }



    // [XAMTAX] Use to extract all route so i can call them by name as ArrayObject

    /**
     * Convert all View in Directory to Route. Using the view name as route name
     * @param $viewPath_or_fullPath (path of view e.g pages.auth)
     * @param bool $recursive (allow deep convert)
     * @param string $groupName (group your route, so there won't be name conflict)
     * @param string $routeListHolder (specify return name, in-case you want to add it to be listed out in menu.) e.g  HtmlWidget1::listAndMarkActiveLink(  $allRoute... )
     * @param array $renameRouteName_oldName_equals_newName (re adjust route name)
     * @param bool $returnOriginalName
     */
    function directory($viewPath_or_fullPath, $recursive = false, $groupName = '', $routeListHolder = 'route_list', $renameRouteName_oldName_equals_newName = [], $returnOriginalName = false){
        $fullPath = (String1::contains( DS, $viewPath_or_fullPath)? $viewPath_or_fullPath: viewpath_to_path($viewPath_or_fullPath, false) );

        //dd(get_all_view_in_directory($fullPath, false, $recursive));

        $route_equal_view = [];
        $route_equal_view_for_return = [];
        array_map(function($view) use($renameRouteName_oldName_equals_newName, $groupName, &$route_equal_view, &$route_equal_view_for_return, $returnOriginalName){
            $route_name_init = Array1::last( explode('.', $view) );
            $route_name = isset($renameRouteName_oldName_equals_newName[$route_name_init])? $renameRouteName_oldName_equals_newName[$route_name_init]: $route_name_init;
            $route_name = (empty($groupName)? '': rtrim($groupName).'/').$route_name;
            $route_equal_view[$route_name] = $view;

            // create index for group route
            if(String1::endsWith($route_name, '/index') && !empty($groupName)) {
                $route = String1::replaceEnd($route_name, '/index', '');
                $route_equal_view[$route] = $view;
                $route_equal_view_for_return[$route] = url($route_name);
            }



            //filter name to readable name
            $new_name = $returnOriginalName? $route_name:  trim(ucwords(String1::replace(String1::convertToCamelCase($route_name_init, ' '), '/', ' ')));
            $route_equal_view_for_return[ $new_name ] = url($route_name);
        }, get_all_view_in_directory($fullPath, false, $recursive));

        // add all to route
        foreach ($route_equal_view as $name=>$view) $this->view( $name, $view, [$routeListHolder=>$route_equal_view_for_return]);//$routeListHolder
    }


























    /**
     * Constructor - Define some variables.
     * @param RouteRequest $req
     */
    public function __construct(RouteRequest $req){
        $this->req = $req;
        // [XAMTAX] remove absolute path from URL
        $unwanted_fixurl = str_replace('index.php', '', $_SERVER['PHP_SELF']); // use replace last
        $wanted_url = str_replace($unwanted_fixurl, '/', ((isset($_SERVER['REDIRECT_URL']) && !empty($_SERVER['REDIRECT_URL'])) ?$_SERVER['REDIRECT_URL']: '/')); // use replace first
        $this->req->path = rtrim($wanted_url, '/').'/';
        @defined('URL') || @define('URL', $req->url, TRUE);
        // middleware
        if(!Config1::onMiddleware($this->req)) die(json_encode(ResultObject1::falseMessage('Forbidden: Middleware Denied!', 403)));
    }

    /**
     * Singleton instance.
     *
     * @param RouteRequest $req
     * @return RouteSystem|Route $this
     */
    public static function instance(RouteRequest $req){
        if (null === static::$instance) static::$instance = new static($req);
        return static::$instance;
    }

    /**
     * Register a route with callback.
     *
     * @param array $method
     * @param string|array $uri
     * @param callable $callback
     * @param array $options
     *
     * @return $this
     */
    public function route(array $method, $uri, $callback, $options = []) {
        if (is_array($uri)) {
            foreach ($uri as $u) $this->route($method, $u, $callback, $options);
            return $this;
        }

        $options = array_merge(['ajaxOnly' => false, 'continue' => false], (array)$options);
        if ($uri != '/') {
            $uri = $this->removeDuplSlash($uri) . '/';
        }

        // Replace named uri param to regex pattern.
        $pattern = $this->namedParameters($uri);
        $this->currentUri = $pattern;

        if ($options['ajaxOnly'] == false || $options['ajaxOnly'] && $this->req->ajax) {
            // If matched before, skip this.
            if ($this->matched === false) {
                // Prepare.
                $pattern = $this->prepare(
                    str_replace(['/?', '/*'], [$this->pattern['/?'], $this->pattern['/*']], $this->removeDuplSlash($this->group . $pattern))
                );
                // If matched.
                $method = count($method) > 0 ? in_array($this->req->method, $method) : true;
                if ($method && $this->matched($pattern)) {
                    if ($this->isGroup) {
                        $this->prams = array_merge($this->pramsGroup, $this->prams);
                    }
                    $this->req->args = $this->bindArgs($this->prams, $this->matchedArgs);
                    $this->matchedPath = $this->currentUri;
                    $this->routeCallback[] = $callback;
                    if ($options['continue']) $this->matched = false;
                }
            }
        }

        $this->_as($this->removeParameters($this->trimSlash($uri)));
        return $this;
    }

    /**
     * Group of routes.
     *
     * @param string|array $group
     * @param callable $callback
     *
     * @param array $options
     * @return $this
     */
    public function group($group, callable $callback, array $options = []){
        $options = array_merge([
            'as' => $group,
            'namespace' => $group
        ], $options);


        if (is_array($group)) {
            foreach ($group as $k => $p) {
                $this->group($p, $callback, [
                    'as' => $options['as'][$k],
                    'namespace' => $options['namespace'][$k]
                ]);
            }
            return $this;
        }
        $this->setGroupAs($options['as']);
        $group = $this->removeDuplSlash($group . '/');
        $group = $this->namedParameters($group, true);

        $this->matched($this->prepare($group, false), false);

        $this->currentGroup = $group;
        // Add this group and sub-groups to append to route uri.
        $this->group .= $group;
        // Bind to RouteSystem Class.
//        $callback = $callback->bindTo($this);
        $callback = Closure::bind($callback, $this, get_class());
        // Call with args.
        call_user_func_array($callback, $this->bindArgs($this->pramsGroup, $this->matchedArgs));

        $this->isGroup = false;
        $this->pramsGroup = $this->pattGroup = [];
        $this->group = substr($this->group, 0, -strlen($group));
        $this->setGroupAs(substr($this->getGroupAs(), 0, -(strlen($options['as']) + 2)), true);

        return $this;
    }

    public function resource($uri, $controller, $options = []){

        $options = array_merge([
            'ajaxOnly' => false,
            'idPattern' => ':int',
            'slugPattern' => ':multiKey',
            'multiIdPattern' => ':multiInt'
        ], $options);

        //$controllers = $controllers;
        if (class_exists($controller)) {
            if(!Class1::isInterfaceImplementExistIn($controller,Controller1RouteInterface::class)) return Console1::dd(' Class '.$controller.' Does not implement [ '.Controller1RouteInterface::class.'].');
            $this->generated = false;

            $as = trim($uri, '/\\');

            $as = ($this->getGroupAs() . '.') . $as;


            $withID = $uri.'/{id}'.$options['slugPattern'];
            $deleteMulti = $uri.'/{id}'.$options['multiIdPattern'];

            $this->route(["GET"], $uri, [$controller, "index"], $options)->_as($as);

            $this->route(["GET"], $uri. "/all", [$controller, "all"], $options)->_as($as.".all");

            $this->route(["GET"], $uri . "/create", [$controller, "create"], $options)->_as($as.".create");

            $this->route(["GET"], $uri . "/manage", [$controller, "manage"], $options)->_as($as.".manage");

            $this->route(["GET"], $withID . "/edit", [$controller, "edit"], $options)->_as($as.".edit");

            $this->route(["GET"], [$uri . "/search", $uri . "/search/{id}"], [$controller, "search"], $options)->_as($as.".search");

            $this->route(["PUT", "PATCH", "POST"], $withID, [$controller, "processSave"], $options)->_as($as.".update");

            $this->route(["DELETE"], $deleteMulti, [$controller, "processDestroy"], $options)->_as($as.".destroy");

            $this->route(["GET"], $uri . "/*", [$controller, "show"], $options)->_as($as.".show");

            /*$this->route([], $uri . '/*', function (RouteRequest $req, Response $res) {
                http_response_code(404);
                $res->json(['error'=>'resource 404']);
            });*/

        } else {
            throw new \Exception("Not found Controller {$controller} try with namespace");
        }
    }




    public function controller($uri, $controller, $options = []){
        $camelCase = function($input) {
            return preg_replace_callback(
                "/(^|_)([a-z])/",
                function($m) { return strtoupper("$m[2]"); },
                $input
            );
        };

        //$controllers = $controllers;
        if (class_exists($controller)) {
            $methods = get_class_methods($controller);
            foreach ($methods as $k => $v) {

                $split 		= $camelCase($v);
                $request 	= strtoupper(array_shift($split));
                $fullUri 	= $uri .'/'. implode('-', $split);

                if (isset($split[0]) && $split[0] == 'Index') {
                    $fullUri= $uri .'/';
                }

                //$as 		= $this->trimc(strtolower($fullUri));
                $as 		= trim(strtolower($fullUri), '/\\');

                $as 		= ($this->getGroupAs() . '.') . $as;
                $fullUri 	= [$fullUri.'/*', $fullUri];
                $call 		= [$controller, $v];

                if (isset($split[0]) && $split[0] == 'Index') {
                    $fullUri = $uri;
                }

                if (in_array($request, ['POST', 'GET', 'PUT','PATCH','DELETE']))  $this->route([$request], $fullUri, $call, $options)->_as($as);
            }
        } else {
            throw new \Exception("Not found Controller {$controller} try with namespace");
        }
    }

    /**
     * Bind args and parameters.
     *
     * @param array $pram
     * @param array $args
     *
     * @return array
     */
    protected function bindArgs(array $pram, array $args)
    {
        if (count($pram) == count($args)) {
            $newArgs = array_combine($pram, $args);
        } else {
            $newArgs = [];
            foreach ($pram as $p) {
                $newArgs[$p] = array_shift($args);
            }

            if (isset($args[0]) && count($args) == 1) {
                foreach (explode('/', '/' . $args[0]) as $arg) {
                    $newArgs[] = $arg;
                }
                $this->fullArg = $newArgs[0] = $args[0];
            }
            // pre($args);
            if (count($args)) {
                $newArgs = array_merge($newArgs, $args);
            }
        }
        return $newArgs;
    }

    /**
     * Register a parameter name with validation from route uri.
     *
     * @param string $uri
     * @param bool $isGroup
     *
     * @return mixed
     */
    protected function namedParameters($uri, $isGroup = false){
        // Reset pattern and parameters to empty array.
        $this->patt = [];
        $this->prams = [];

        // Replace named parameters to regex pattern.
        return preg_replace_callback('/\/\{([a-z-0-9]+)\}\??(:\(?[^\/]+\)?)?/i', function ($m) use ($isGroup) {
            // Check whether validation has been set and whether it exists.
            if (isset($m[2])) {
                $rep = substr($m[2], 1);
                $patt = isset($this->pattern[$rep]) ? $this->pattern[$rep] : '/' . $rep;
            } else {
                $patt = $this->pattern['/?'];
            }
            // Check whether parameter is optional.
            if (strpos($m[0], '?') !== false) {
                $patt = str_replace('/(', '(/', $patt) . '?';
            }

            if ($isGroup) {
                $this->isGroup = true;
                $this->pramsGroup[] = $m[1];
                $this->pattGroup[] = $patt;
            } else {
                $this->prams[] = $m[1];
                $this->patt[] = $patt;
            }

            return $patt;
        }, trim($uri));
    }

    /**
     * Prepare a regex pattern.
     *
     * @param string $patt
     * @param bool $strict
     *
     * @return string
     */
    protected function prepare($patt, $strict = true)
    {
        // Fix group if it has an optional path on start
        if (substr($patt, 0, 3) == '/(/') {
            $patt = substr($patt, 1);
        }

        return '~^' . $patt . ($strict ? '$' : '') . '~i';
    }

    /**
     * Checks whether the current route matches the specified pattern.
     *
     * @param string $patt
     * @param bool $call
     *
     * @return bool
     */
    protected function matched($patt, $call = true) {
        if (preg_match($patt, $this->req->path, $m)) {
            if ($call)  $this->matched = true;
            array_shift($m);
            $this->matchedArgs = array_map([$this, 'trimSlash'], $m);
            return true;
        }
        return false;
    }

    /**
     * @param $routeName
     * Not working yet
     * @return false|int
     */
    public  function isExists($routeName){ return String1::contains($routeName, $this->getRouteAndViewList()); }


    /**
     * Remove duplicate slashes.
     *
     * @param string $uri
     *
     * @return string
     */
    protected function removeDuplSlash($uri)
    {
        return preg_replace('/\/+/', '/', '/' . $uri);
    }

    /**
     * Trim slashes.
     *
     * @param string $uri
     *
     * @return string
     */
    protected function trimSlash($uri)
    {
        return trim($uri, '/');
    }

    /**
     * Add pattern to the named parameters list.
     *
     * @param array $patt key value  i.e ['key' => '/([a-z0-9_]+)']
     */
    public function addPattern(array $patt)
    {
        $this->pattern = array_merge($this->pattern, $patt);
    }

    /**
     * Set a route name.
     *
     * @param string $name
     * @return $this
     * @throws \Exception
     */
    public function _as($name){
        if (empty($name)) return $this;
        $name = rtrim($this->getGroupAs() . str_replace('/', '.', strtolower($name)), '.');
//        if (array_key_exists($name, $this->routes)) {
//            throw new \Exception("RouteSystem name ($name) already registered.");
//        }

        $patt = $this->patt;
        $pram = $this->prams;
        // Merge group parameters with route parameters.
        if ($this->isGroup) {
            $patt = array_merge($this->pattGroup, $patt);
            if (count($patt) > count($pram)) {
                $pram = array_merge($this->pramsGroup, $pram);
            }
        }

        // :param
        if (count($pram)) {
            foreach ($pram as $k => $v) {
                $pram[$k] = '/:' . $v;
            }
        }

        // Replace pattern to named parameters.
        $replaced = $this->group . $this->currentUri;
        foreach ($patt as $k => $v) {
            $pos = strpos($replaced, $v);
            if ($pos !== false) {
                $replaced = substr_replace($replaced, $pram[$k], $pos, strlen($v));
            }
        }

        $this->routes[$name] = ltrim($this->removeDuplSlash(strtolower($replaced)), '/');
        return $this;
    }

    /**
     * @param $as
     * @param bool $replace
     * @return $this
     */
    public function setGroupAs($as, $replace = false){
        $as = str_replace('/', '.', $this->trimSlash(strtolower($as)));
        $as = $this->removeParameters($as);
        $this->currentGroupAs = $as;
        if ($this->groupAs == '' || empty($as) || $replace) {
            $this->groupAs = $as;
        } else {
            $this->groupAs .= '.' . $as;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getGroupAs()
    {
        if ($this->groupAs == '')
            return $this->groupAs;
        else
            return $this->groupAs . '.';
    }

    protected function removeParameters($name)
    {
        if (preg_match('/[{}?:()*]+/', $name)) {
            $name = '';
        }
        return $name;
    }

    /**
     * Register a new listener into the specified event.
     *
     * @param string $name
     * @param array $args
     *
     * @return string|null
     */
    public function getRoute($name, array $args = []){
        $name = strtolower($name);

        if (isset($this->routes[$name])) {
            $route = $this->routes[$name];
            foreach ($args as $k => $v) {
                $route = str_replace(':' . $k, $v, $route);
            }
            return $route;
        }
        return null;
    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    public function _use($callback, $event = 'before')
    {
        switch ($event) {
            case 'before':
                return $this->before('/*', $callback);
            default:
                return $this->after('/*', $callback);
        }
    }

    public function before($uri, $callback)
    {
        $this->before[] = [
            'uri' => $uri,
            'callback' => $callback
        ];
        return $this;
    }

    public function after($uri, $callback)
    {
        $this->after[] = [
            'uri' => $uri,
            'callback' => $callback
        ];
        return $this;
    }

    protected function emit(array $events) {
        $continue = true;
        foreach ($events as $cb) {
            if ($continue !== false) {
                $uri = $cb['uri'];
                $except = false;
                if (strpos($cb['uri'], '/*!') !== false){
                    $uri = substr($cb['uri'], 3);
                    $except = true;
                }

                $list = array_map('trim', explode('|', strtolower($uri)));
                foreach ($list as $item) {
                    $item = $this->removeDuplSlash($item);
                    if( $except){
                        if($this->matched($this->prepare($item, false), false) === false ){
                            $continue = $this->callback($cb['callback'], $this->req->args);
                            break;
                        }
                    } elseif ( $list[0] == '/*' || $this->matched($this->prepare($item, false), false) !== false ) {
                        $continue = $this->callback($cb['callback'], $this->req->args);
                        break;
                    }
                }

            }
        }
    }


    public $fixed = [];
    /**
     * List of important route
     * @param array $routeList
     * @return RouteSystem
     */
    public function fixed($routeList = ['error404'=>'pages.common.error404', 'maintenance'=>'layouts.coming_soon.index']) {
        $this->fixed = $routeList;
        return $this;
    }

    /**
     * Get the dashboard route. This can be modified in the .config onRoute $route->fixed field.
     * @param null $default
     * @return string
     */
    function getDashboardRoute($default = null){
        return String1::isset_or($this->fixed['dashboard_route'], $default);
    }


    /**
     * Run and get a response.
     * @return null
     * @throws Throwable
     */
    public function end(){



        // is maintenance mode
        if( Config1::MAINTENANCE_MODE && !is_debug_mode()){
            if(isset($this->fixed['maintenance']) && view_exists($this->fixed['maintenance'])) return view($this->fixed['maintenance']);
            else die('<div align="center" style="padding:50px;"><h1>Site Under Maintenance</h1><h5>Error! Maintenance View Not Found <hr/> '.$this->fixed['maintenance'].'</h5></div>');
        }



        ob_start();
            if ($this->matched && count($this->routeCallback)) {
                count($this->before) && $this->emit($this->before);
                foreach ($this->routeCallback as $call) {
                    $this->callback($call, $this->req->args);
                }
                count($this->after) && $this->emit($this->after);

            } else {
                http_response_code(404);
                if( isset($this->fixed['error404'])){
                    if(view_exists($this->fixed['error404'])) return view($this->fixed['error404']);
                    else die('<h2 align="center" style="padding:50px;">Error 404 View Not Found <hr/> '.$this->fixed['error404'].'<h2>');
                }
                else echo('<div style="text-align:center;margin:50px;"><h1> error 404 </h1><h4>Page Not Available</h4> <a href="'.url('/').'">Home</a></div>');
            }
        ob_end_flush();
        exit;
    }

    /**
     * Call a route that has been matched.
     *
     * @param mixed $callback
     * @param array $args
     * @return string
     * @throws \Exception
     */
    protected function callback($callback, array $args = []){
        if (isset($callback)) {
            if (is_callable($callback) && $callback instanceof \Closure) {
                // Set new object and append the callback with some data.
                $o = new \ArrayObject($args);
                $o->app = RouteApp::instance();
                $callback = $callback->bindTo($o);
            } elseif (is_string($callback) && strpos($callback, '@') !== false) {
                $fixCallback = explode('@', $callback, 2);
                $this->Controller = $fixCallback[0];

                if (is_callable(
                    $callback = [$fixCallback[0], (isset($fixCallback[1]) ? $fixCallback[1] : 'index')]
                )) {
                    $this->Method = $callback[1];
                } else {
                    throw new \Exception("Callable error on {$callback[0]} -> {$callback[1]} !");
                }
            }

            if (is_array($callback) && !is_object($callback[0])) { $callback[0] = new $callback[0]; }

            if (isset($args[0]) && $args[0] == $this->fullArg) { array_shift($args); }

            // Finally, call the method.
            return call_user_func_array($callback, $args);
        }
        return false;
    }

    /** @return array */
    private $all_routes = [];
    public function getRouteVerboseList(){ return $this->all_routes; }

    /** @return array */
    private $route_and_view_list = [];
    public function getRouteAndViewList(){ return $this->route_and_view_list; }

    /**
     * Magic call.
     *
     * @param string $method
     * @param array $args
     *
     * @return mixed
     */
    public function __call($method, $args) {
        // Add Route and View
        $all_routes[] = $args;
        if( isset($args[0]) && isset($args[1]) && is_string($args[1])) @$this->route_and_view_list[$args[0]] = $args[1];

        switch (strtoupper($method)) {
            case 'AS': return call_user_func_array([$this, '_as'], $args);
            case 'USE': return call_user_func_array([$this, '_use'], $args);
            case 'ANY':
                array_unshift($args, []);
                return call_user_func_array([$this, 'route'], $args);
            case 'VIEW':
                return $this->get($args[0], function () use ($args){ is_string($args[1])?  view($args[1], array_merge(RouteApp::instance()->request->args, String1::isset_or($args[2], []))) :Console1::println("EX error 202. Invalid Route Declaration<hr/>Invalid View Path Supplied. <br/>ROUTE URL : '$args[0]'<br/>VIEW NAME : '".gettype($args[1])."' instead of string", true); });
        }
        // Check whether the method is dynamic (i.e.: get, post, get_post).
        $method = explode('_', $method);
        $exists = [];
        foreach ($method as $v) {
            if (in_array($v = strtoupper($v), ['POST', 'GET', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'])) {
                $exists[] = $v;
            }
        }

        if (count($exists)) {
            array_unshift($args, $exists);
            return call_user_func_array([$this, 'route'], $args);
        }

        return is_string($method) && isset($this->{$method}) && is_callable($this->{$method})? call_user_func_array($this->{$method}, $args) : null;
    }

    /**
     * Set new variables and functions to this class.
     *
     * @param string $k
     * @param mixed $v
     */
    public function __set($k, $v)
    {
        $this->{$k} = $v instanceof \Closure ? $v->bindTo($this) : $v;
    }

}













