<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$id = (isset($_GET['id']) && is_numeric($_GET['id']) ) ? (int) $_GET['id'] : 0;
if (!$id) {
	$errors[] = '分布式服务器ID不能为空!';
}

$distributed = array('distributeds_id' => '', 'ip' => '', 'region' => '', 'url' => '',
                'vid_min' => '', 'vid_max' => '', 'remark' => '', 'httpkey' => '');
if (isset($_POST['edit_distributed']) && $id) {
	require $config['BASE_DIR']. '/classes/filter.class.php';
    require $config['BASE_DIR']. '/classes/validation.class.php';
    $filter             = new VFilter();
    $valid              = new VValidation();
	$distributeds_id				= $filter->get('distributeds_id', 'INTEGER');
	$ip			= $filter->get('ip');
	$region		= $filter->get('region');
	$url		= $filter->get('url');
	$vid_min			= $filter->get('vid_min', 'INTEGER');
	$vid_max				= $filter->get('vid_max', 'INTEGER');
	$remark				= $filter->get('remark');
	$httpkey				= $filter->get('httpkey');
	
	if ($distributeds_id == '') {
		$errors[] = '请选择所属线路!';
	}

    if ($ip == '') {
        $errors[] = 'IP地址不可以为空!';
    }
	
	if ($region == '') {
		$errors[] = '机房区域不可为空!';
	}
	
	if ($url == '') {
		$errors[] = 'URL不能为空!';
	}
	
	if ($vid_min == '') {
		$errors[] = '最小ID不能为空!';
	}
	
	if ($vid_max == '') {
			$errors[] = '最大ID不能为空!';
	}
	
	if ($httpkey == '') {
		$errors[] = '请填写防盗链KEY';
		}
	
	if (!$errors) {
		$sql = "UPDATE distributed
		        SET distributeds_id = '".mysql_real_escape_string($distributeds_id)."',
				    ip = '".mysql_real_escape_string($ip)."',
				    region = '".mysql_real_escape_string($region)."',
					url = '".mysql_real_escape_string($url)."',
					vid_min = '".mysql_real_escape_string($vid_min)."',
					httpkey = '".mysql_real_escape_string($httpkey)."',
					vid_max = '".mysql_real_escape_string($vid_max)."',
					addtime = '".time()."',
					remark = '".$remark."'
				WHERE id = ".$id."
				LIMIT 1";
		$conn->execute($sql);
		$messages[] = 'Distributed was successfuly updated!';
	}	
}

$sql = "SELECT * FROM distributed WHERE id = ".$id." LIMIT 1";
$rs  = $conn->execute($sql);
if ($conn->Affected_Rows()) {
	$distributed = $rs->getrows();
	$distributed = $distributed['0'];
}

$sql = "SELECT * FROM distributeds;";
$rs  = $conn->execute($sql);
if ($conn->Affected_Rows()) {
	$distributeds = $rs->getrows();
}


//print_r($distributed);
$smarty->assign('distributed', $distributed);
$smarty->assign('distributeds', $distributeds);
?>
