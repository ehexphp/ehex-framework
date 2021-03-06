<?php
/**
 * Ehex - Simplex and Fastest PHP Framework
 *
 * @package  Ehex
 * @author   Samson Iyanu <samsoniyanu@xamtax.com>
 */













/*
|--------------------------------------------------------------------------
| Import Config Library File
|--------------------------------------------------------------------------
|
| .config config file is required to setup ehex. This file consist of
| Class named Config1
|
*/
include_once '.config.php';
    if (!(include(Config1::INCLUDES_PATH.'/config/__init.php') ))
        echo "<style>a{text-decoration:none; color:red}</style><div style='color:slategray;text-align:center;padding:150px'><h1><a target='_blank' href='https://ehex.xamtax.com/'>Missing Ehex Library</a><hr/><small>The almighty __includes folder is missing! </small></h1> <dt><code>Clone <a target='_blank' href='https://github.com/ehexphp/__includes'>https://github.com/ehexphp/__includes</a> and add it to the project root folder.</code></dt></div>";




