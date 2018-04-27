<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$sql        = "SELECT * FROM adv_zone";
$rs         = $conn->execute($sql);
$advzones  = $rs->getrows();


$smarty->assign('advzones', $advzones);
?>
