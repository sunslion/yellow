<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$id = (isset($_GET['id']) && is_numeric($_GET['id']) ) ? (int) $_GET['id'] : 0;
if (!$id) {
	$errors[] = 'Invalid server id! Are you sure this server exists!';
}

$server = array('url' => '', 'video_url' => '', 'server_ip' => '', 'ftp_username' => '',
                'ftp_password' => '', 'ftp_root' => '', 'status' => '0', 'current_used' => '0');
if (isset($_POST['edit_server']) && $id) {
	require $config['BASE_DIR']. '/classes/filter.class.php';
    require $config['BASE_DIR']. '/classes/validation.class.php';
    $filter             = new VFilter();
    $valid              = new VValidation();
	$url				= $filter->get('url');
	$server_ip			= $filter->get('server_ip');
	$ftp_username		= $filter->get('ftp_username');
	$ftp_password		= $filter->get('ftp_password');
	$ftp_root			= $filter->get('ftp_root');
	$status				= $filter->get('status', 'INTEGER');
	$used				= $filter->get('current_used', 'INTEGER');
	$video_url			= $filter->get('video_url');
	
	if ($url == '') {
		$errors[] = 'Server url cannot be left blank!';
	}

    if ($video_url == '') {
        $errors[] = 'Server video url cannot be left blank!';
    } else {
        $server['url'] = $url;
    }	
	
	if ($server_ip == '') {
		$errors[] = 'Server ip cannot be left blank!';
	}
	
	if ($ftp_username == '') {
		$errors[] = 'Server FTP username cannot be left blank!';
	}
	
	if ($ftp_password == '') {
		$errors[] = 'Server FTP password cannot be left blank!';
	}
	
	if (!$errors) {
		$sql = "UPDATE servers
		        SET url = '".mysql_real_escape_string($url)."',
				    video_url = '".mysql_real_escape_string($video_url)."',
				    server_ip = '".mysql_real_escape_string($server_ip)."',
					ftp_username = '".mysql_real_escape_string($ftp_username)."',
					ftp_password = '".mysql_real_escape_string($ftp_password)."',
					ftp_root = '".mysql_real_escape_string($ftp_root)."',
					current_used = '".$used."',
					status = '".$status."'
				WHERE server_id = ".$id."
				LIMIT 1";
		$conn->execute($sql);
		$messages[] = 'Server was successfuly updated!';
	}	
}

$sql = "SELECT * FROM servers WHERE server_id = ".$id." LIMIT 1";
$rs  = $conn->execute($sql);
if ($conn->Affected_Rows()) {
	$server = $rs->getrows();
	$server = $server['0'];
}

$smarty->assign('server', $server);
?>
