<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();
$id = intval($_GET['id']);
$sql = "DELETE FROM hd WHERE id =".$id;
$rs = $conn->execute($sql);
if($rs){
    $chimg = $config['BASE_DIR']. '/media/hd';
    $filepath = $chimg.'/'.$id.'.jpg';
    if (file_exists($filepath)) {
        unlink($filepath);
    }
    $msg = '删除成功!';
    VRedirect::go('hd.php?msg=' . $msg . '&m=list');
}else{
    $errors[] = '删除失败!';
}