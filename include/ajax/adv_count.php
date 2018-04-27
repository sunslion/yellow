<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
$message            = '广告点击量统计';

if (isset($_POST['id'])) {
	 $filter     = new VFilter();
	 $id = $filter->get('id','INTEGER');
	 $title = $filter->get('title');
	 $zone_name = $filter->get('zone_name');
	 $date = strtotime(date('Y-m-d'));
	 
	 $sql = "SELECT id FROM adv_count WHERE advid = {$id} AND date ={$date} LIMIT 1;";
	 $conn->execute($sql);
	 if ( $conn->Affected_Rows() == 1 ) {
	 	$sql = "UPDATE adv_count SET count = count + 1 WHERE advid = {$id} AND date ={$date} LIMIT 1;";
	 	$urs = $conn->execute($sql);
	 	if($urs)
	 		$message = "广告({$title})点击量成功增加";
	 }else{
	 	$sql = "INSERT INTO adv_count (advid,date,count,title,zone_name) VALUES ({$id},{$date},1,'{$title}','{$zone_name}');";
	 	$urs = $conn->execute($sql);
	 	if($urs)
	 		$message = "广告({$title})点击量成功添加";
	 }
}
echo show_msg_mb($message);
die();