<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$date = strtotime(date('Y-m-d'));
$option = array('sort'=>'advid','order'=>'asc');
$sql_add = ' ORDER BY '.$option['sort'].' '.$option['order'];
if (isset($_POST['search_adv_count'])) {
	if (isset($_POST['date']) && $_POST['date'] != '') {
		$date = strtotime(trim($_POST['date']));
	}
	if (isset($_POST['sort']) && $_POST['sort'] != '') {
		$option['sort'] = trim($_POST['sort']);
	}
	if (isset($_POST['order']) && $_POST['order'] != '') {
		$option['order'] = trim($_POST['order']);
	}
	$sql_add = ' ORDER BY '.$option['sort'].' '.$option['order'];
}

$sql = "SELECT * FROM adv_count WHERE date = {$date}{$sql_add};";
$rs = $conn->execute($sql);
$advcounts  = $rs->getrows();
$smarty->assign('advcounts', $advcounts);
$smarty->assign('date', date('Y-m-d',$date));
$smarty->assign('option', $option);