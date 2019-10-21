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
        echo "<h1 style='color:slategray;text-align:center;padding:150px'>LIBRARY MISSING<a target='_blank' href='https://ehex.xamtax.com/'><hr/></a><br/><small>Ehex<br/> Missing Core Lib </small></h1>";




