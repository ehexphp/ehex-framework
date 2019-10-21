<?php
include('xcrud.php');
// XAMTAX EDIT
include('../../../Ehex.php');
header('Content-Type: text/html; charset=' . Xcrud_config::$mbencoding);
echo Xcrud::get_requested_instance();
