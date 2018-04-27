<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

if (isset($_GET['a']) && isset($_GET['id'])) {
	$action = trim($_GET['a']);
	$id		= (int) trim($_GET['id']);
	switch ($action) {
		case 'delete':
			$conn->execute("DELETE FROM distributed WHERE id = ".$id." LIMIT 1");
			$messages[] = '已经删除';
			break;
		default:
			$errors[] = 'Invalid action specified!';
	}
}

$sql        = "SELECT * FROM distributed";
$rs         = $conn->execute($sql);
$distributeds    = $rs->getrows();

$smarty->assign('distributeds', $distributeds);
?>
