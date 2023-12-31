<?php
/**
 * Ehex - Simplex and Fastest PHP Framework
 *
 * @package  Ehex
 * @author   Samson Oyetola <samson.oyetola@xamtax.com>
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

const BASE_PATH = __DIR__.DIRECTORY_SEPARATOR;
const EHEX_PATH = BASE_PATH.'vendor'.DIRECTORY_SEPARATOR.'ehexphp'.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR;

if (!(@include(EHEX_PATH.'config/__init.php') ))
    echo "<style>a{text-decoration:none; color:red}</style><div style='color:slategray;text-align:center;padding:150px'><h1><a target='_blank' href='https://ehex.xamtax.com/'>Missing EhexCore Library</a><hr/><small>You need to include the ehexphp/core library! </small></h1> <dt><code>Either run <em><dt>composer require ehexphp/core</dt></em><br>or clone <a target='_blank' href='https://github.com/ehexphp/core'>https://github.com/ehexphp/core</a> and add to the vendor's folder.</code></dt></div>";





