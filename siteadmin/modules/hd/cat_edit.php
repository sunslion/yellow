<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
if (isset($_POST['cat_edit'])) {
    $filter = new VFilter();
    $name = $filter->get('name');
    if (empty($name)) {
        $errors[] = '活动类别名称不能为空';
    }
    if (!$errors) {
        $time = time();
        $sql = "UPDATE hd_cat SET name ='{$name}',utime = {$time}";
        $rs = $conn->execute($sql);
        if ($rs) {
            $msg = '修改成功!';
            VRedirect::go('hd.php?msg=' . $msg . '&m=cat_list');
        }else{
            $errors[] = '修改失败!';
        }
    }
}
$id = intval($_GET['id']);
$sql = 'SELECT name FROM hd_cat WHERE id ='.$id.' LIMIT 1';
$rs = $conn->execute($sql);
$cat_hds = $rs->getrows();
$cat_hd = $cat_hds[0];

$smarty->assign('row', $cat_hd);
$smarty->assign('id', $id);