<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

if (isset($_GET['a']) && isset($_GET['id'])) {
	$action = trim($_GET['a']);
	$id		= (int) trim($_GET['id']);
	switch ($action) {
		case 'delete':
			$conn->execute("DELETE FROM servers WHERE server_id = ".$id." LIMIT 1");
			$messages[] = 'Server was succcesfuly deleted!';
			break;
		case 'activate':
		case 'suspend':
			$status = ($action == 'suspend') ? 0 : 1;
			$msg    = ($action == 'suspend') ? 'Video was successfuly suspended!' : 'Video was successfuly activated!';
			$conn->execute("UPDATE servers SET status = '".$status."' WHERE server_id = ".$id." LIMIT 1");
			$messages[] = $msg;
			break;
		default:
			$errors[] = 'Invalid action specified!';
	}
}

$sql        = "SELECT * FROM servers";
$rs         = $conn->execute($sql);
$servers    = $rs->getrows();

$smarty->assign('servers', $servers);
?>
