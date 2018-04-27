<?php
define('_VALID', true);
define('_ADMIN', true);
require('../include/config.php');

$_SESSION['AUID'] 		= '';
$_SESSION['APASSWORD'] 	= '';
$_SESSION['ATYPE'] = '';
unset($_SESSION['AUID']);
unset($_SESSION['APASSWORD']);
unset($_SESSION['ATYPE']);

session_write_close();
header('Location: index.php');
die();
?>
