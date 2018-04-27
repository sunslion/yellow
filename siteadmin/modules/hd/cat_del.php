<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
$id = intval($_GET['id']);
$sql = 'DELETE FROM hd_cat WHERE id ='.$id;
$rs = $conn->execute($sql);
if($rs){
    $msg = '删除成功!';
    VRedirect::go('hd.php?msg=' . $msg . '&m=cat_list');
}else{
    $errors[] = '删除失败!';
}