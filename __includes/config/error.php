<?php
/**
 * Created by PhpStorm.
 * User: samtax
 * Date: 08/07/2018
 * Time: 7:47 AM
 */





/************************************************
 *  Whoop Error Config
 *  https://github.com/filp/whoops
 ************************************************/
if(is_debug_mode() && $exConfig['enable_whoop']){
    FileManager1::loadComposerPackage(PATH_LIBRARY."whoops");
    $whoops = new \Whoops\Run;
    $handler = new Whoops\Handler\PrettyPageHandler;
    $handler->setPageTitle('EX Detect Error');
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}

