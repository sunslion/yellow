<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$server = array('gname' => '', 'permisions' => '', 'status' => '', 'remark' => '');
if (isset($_POST['AddDistributeds'])) {
	require $config['BASE_DIR']. '/classes/filter.class.php';
    require $config['BASE_DIR']. '/classes/validation.class.php';
    $filter             = new VFilter();
    $valid              = new VValidation();
	$gname				= $filter->get('gname');
	$permisions			= explode_array(@$_POST['permisions']);
	$status		= $filter->get('status');
	$remark		= $filter->get('remark');
	
	if ($gname == '') {
		$errors[] = '线路名字不能为空！';
	}else{
		$distributeds['gname'] = $gname;
	}

	if ($permisions == '') {
		$errors[] = '权限要选择至少一个';
	}else{
		$distributeds['permisions'] = $permisions;
	}
		
	if ($status == '') {
		$errors[] = '状态不能为空';
	}else{
		$distributeds['status'] = $status;
	}
	
	if ($remark == '') {
		$errors[] = '请填写备注';
	}else{
		$distributeds['remark'] = $remark;
	}
			
	if (!$errors) {
		$sql = "INSERT INTO distributeds
		        SET gname = '".mysql_real_escape_string($gname)."',
				    permisions = '".mysql_real_escape_string($permisions)."',
				    status = '".mysql_real_escape_string($status)."',
					remark = '".mysql_real_escape_string($remark)."',
					addtime = '".mysql_real_escape_string(time())."'";
		$conn->execute($sql);
		$messages[] = '添加完成';
	}	
}

?>
