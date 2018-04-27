<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

if (isset($_GET['a']) && isset($_GET['id'])) {
	$action = trim($_GET['a']);
	$id		= (int) trim($_GET['id']);
	switch ($action) {
		case 'delete':
			$conn->execute("DELETE FROM distributeds WHERE distributeds_id = ".$id." LIMIT 1");
			$messages[] = '已经删除!';
			break;
		case 'off':
		case 'on':
		if($action==='off'){$status='1';}elseif($action==='on'){$status='0';}
			$conn->execute("UPDATE distributeds SET status = '".$status."' WHERE distributeds_id = ".$id." LIMIT 1");
			$messages[] = '修改完成';
			break;
		default:
			$errors[] = 'Invalid action specified!';
	}
}

$sql        = "SELECT * FROM distributeds";
$rs         = $conn->execute($sql);
$distributeds    = $rs->getrows();

$smarty->assign('distributeds', $distributeds);
?>
