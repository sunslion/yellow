<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$id = (isset($_GET['id']) && is_numeric($_GET['id']) ) ? (int) $_GET['id'] : 0;
if (!$id) {
	$errors[] = 'ID不可以为空!';
}

$distributeds = array('gname' => '', 'permisions' => '', 'status' => '', 'remark' => '');

if (isset($_POST['distributeds']) && $id) {
require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/classes/validation.class.php';
    $filter             = new VFilter();
    $valid              = new VValidation();
		$gname				= $filter->get('gname');
		$permisions			= explode_array(@$_POST['permisions']);
	$status		= $filter->get('status');
	$remark		= $filter->get('remark');
	
	if ($gname == '') {
		$errors[] = '必须填写线路名字 !';
	}
	
	if ($permisions == '') {
		$errors[] = '必须设置被仿权限!';
	}
	
	if ($status == '') {
		$errors[] = '状态不能为空!';
	}

	if (!$errors) {
		$sql = "UPDATE distributeds
		        SET gname = '".mysql_real_escape_string($gname)."',
				    permisions = '".mysql_real_escape_string($permisions)."',
				    status = '".mysql_real_escape_string($status)."',
					remark = '".mysql_real_escape_string($remark)."'
					WHERE distributeds_id = ".$id."
				LIMIT 1";
		$conn->execute($sql);
		$messages[] = '线路修改完毕!';
	}	
	
	
}

$sql = "SELECT * FROM distributeds WHERE distributeds_id = ".$id." LIMIT 1";
$rs  = $conn->execute($sql);
if ($conn->Affected_Rows()) {
	$distributeds = $rs->getrows();
	$distributeds = $distributeds['0'];
	$permisions = explode(',',$distributeds['permisions']);
	$in_guest = in_array('guest',$permisions);
	$in_free = in_array('free',$permisions);
	$in_premium = in_array('premium',$permisions);
}

$smarty->assign('distributeds', $distributeds);
$smarty->assign('in_guest', $in_guest);
$smarty->assign('in_free', $in_free);
$smarty->assign('in_premium', $in_premium);
?>
