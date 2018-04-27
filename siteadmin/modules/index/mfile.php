<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$allowed_acts  = array('index');
$act           = ( isset($_GET['act']) ) ? $_GET['act'] : '';
if ($act!='' && !in_array($act, $allowed_acts) ) {
    $act   = NULL;
    $err    = 'Invalid page name!';
}

?>
