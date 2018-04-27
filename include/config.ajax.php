<?php
defined('_VALID') or die('Restricted Access!');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require 'debug.php';
require 'config.paths.php';
require 'config.db.php';
require 'config.local.php';
require 'adodb/adodb.inc.php';
require 'dbconn.php';
require 'function_global.php';
ob_start();
require 'sessions.php';
ob_end_clean();
require 'security.php';
require 'smarty/libs/Smarty.class.php';
require_once 'function_frontend.php';
require 'config.language.php';
require 'smarty.php';
require 'function_smarty.php';

if (!isset($_SESSION['uid'])) {
    $type_of_user = "guest";
}
elseif (!isset($_SESSION['uid_premium']) && isset($_SESSION['uid'])) {
    $type_of_user = "free";
}
else {
    $type_of_user = "premium";
}