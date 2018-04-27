<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$server = array('distributeds_id' => '', 'ip' => '', 'region' => '', 'url' => '', 'httpkey' => '', 'vid_min' => '', 'vid_max' => '', 'remark' => '');
if (isset($_POST['AddDistributed'])) {
	require $config['BASE_DIR']. '/classes/filter.class.php';
    require $config['BASE_DIR']. '/classes/validation.class.php';
    $filter             = new VFilter();
    $valid              = new VValidation();
	$distributeds_id				= $filter->get('distributeds_id');
	$ip			= $filter->get('ip');
	$region		= $filter->get('region');
	$url		= $filter->get('url');
	$httpkey			= $filter->get('httpkey');
	$vid_min			= $filter->get('vid_min');
	$vid_max			= $filter->get('vid_max');
	$remark			= $filter->get('remark');
	
	if ($distributeds_id == '') {
		$errors[] = '请选择线路！';
	} 
	
	if ($ip == '') {
		$errors[] = '请填写IP';
	}
	
	if ($region == '') {
		$errors[] = '请选择机房区域';
	} 
		
	if ($url == '') {
		$errors[] = '请填写URL';
	} 
	
	if ($httpkey == '') {
		$errors[] = '请填写HTTPKEY!';
	} 
	if ($vid_min == '') {
		$errors[] = '请填写最小VID!';
	} 
	if ($vid_max == '') {
		$errors[] = '请填写最大VID!';
	} 
	if ($remark == '') {
		$errors[] = '请填写备注';
	} 
	
	
	if (!$errors) {
		$sql = "INSERT INTO distributed
		        SET distributeds_id = '".mysql_real_escape_string($distributeds_id)."',
				    ip = '".mysql_real_escape_string($ip)."',
				    region = '".mysql_real_escape_string($region)."',
					url = '".mysql_real_escape_string($url)."',
					vid_min = '".mysql_real_escape_string($vid_min)."',
					vid_max = '".mysql_real_escape_string($vid_max)."',
					httpkey = '".mysql_real_escape_string($httpkey)."',
					addtime = '".mysql_real_escape_string(time())."',
					remark = '".mysql_real_escape_string($remark)."'";
		$conn->execute($sql);
		$messages[] = '添加完成！';
	}	
}

$sql = "SELECT `distributeds_id`,`gname` FROM distributeds;";
$rs  = $conn->execute($sql);
if ($conn->Affected_Rows()) {
	$distributeds = $rs->getrows();
}

$smarty->assign('distributeds', $distributeds);
?>
