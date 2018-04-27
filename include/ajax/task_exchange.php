<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require '';
disableRegisterGlobals();
$response = array('flag'=>1,'msg'=>'');
