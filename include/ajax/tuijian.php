<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR'].'/classes/auth.class.php';
Auth::checkAdmin();
if (isset($_POST['tuijian'])) {
	$filter     = new VFilter();
	$vid = $filter->get('vid');
	$tuijian = $filter->get('tuijian');
	$sql = "update video set tuijian = '".mysql_real_escape_string($tuijian)."' where VID = ".intval($vid);
	$urs = $conn->execute($sql);
	if ($urs) {
		$response['flag'] = 1;
	}else {
		$response['flag'] = 0;
	}
	echo json_encode($response) ;
}
