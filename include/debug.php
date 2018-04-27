<?php
defined('_VALID') or die('Restricted Access!');
define('DEBUG', 0);
ini_set('display_errors', 0);
if ( DEBUG ) {
    error_reporting(E_ALL&~E_NOTICE);
    ini_set('display_errors', 1);
}
