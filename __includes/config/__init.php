<?php
/**
 * Ehex
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2015 - 20.., Xamtax Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NON INFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	Ehex (EX)
 * @author	Samson Iyanu (Xamtax Technnology)
 * @copyright	Copyright (c) Xamtax, Inc. (https://xamtax.com/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://ehex.xamtax.com
 * @since	Version 2.0
 * @filesource
 */

$exConfig = ['enable_whoop'=>true];

// is php version 7+
if(version_compare(PHP_VERSION, '7.0.0', '<')) die('<p>Ehex Requires (PHP VERSION 7+)</p>');

// access control origin
if(!empty(Config1::ACCESS_CONTROL_ALLOW_ORIGINAL)) {
    header('Access-Control-Allow-Origin: '.implode(',', Config1::ACCESS_CONTROL_ALLOW_ORIGINAL).(isset($_SERVER['HTTP_ORIGIN'])? ','.$_SERVER['HTTP_ORIGIN']: ''));
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
}



//  Define Current Location
define('DS',            DIRECTORY_SEPARATOR, true);
define('BASE_PATH',     dirname($_SERVER['SCRIPT_FILENAME']).DS, TRUE);

// Define Real-Path Declaration... Changeable
define('PATH_APP',      BASE_PATH.'app'.DS, TRUE);
define('PATH_RESOURCE', BASE_PATH.'resources'.DS, TRUE);
define('PATH_LAYOUTS',  PATH_RESOURCE.'views'.DS.'layouts'.DS, TRUE);
define('PATH_PLUGINS',  PATH_RESOURCE.'plugins'.DS, TRUE);
define('PATH_INCLUDE',  dirname(__DIR__).DS.'../'. array_reverse(explode('/', Config1::INCLUDES_PATH))[0].DS, TRUE);


// Define Include sub-folder
define('PATH_EASYCORE',      PATH_INCLUDE . 'easycore'.DS, TRUE);
define('PATH_LIBRARY',  PATH_EASYCORE . 'assets'.DS.'library'.DS, TRUE);

// Define shared path
define('PATH_SHARED',  PATH_INCLUDE . 'shared'.DS, TRUE);
define('PATH_SHARED_APP',  PATH_SHARED.'app'.DS, TRUE);
define('PATH_SHARED_RESOURCE',  PATH_SHARED.'resources'.DS, TRUE);

// start
include PATH_INCLUDE . 'config/__init_start.php';              // Start Default Config

// end
include PATH_INCLUDE . 'config/__init_end.php';               // End Default Config

// Un-Managed Third Party by Composer
//include BASE_PATH . '../vendor/autoload.php';



