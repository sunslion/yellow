<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
if (isset($_POST['cat_add'])) {
    $filter = new VFilter();
    $name = $filter->get('name');
    if (empty($name)) {
        $errors[] = '活动类别名称不能为空';
    }
    if (!$errors) {
        $time = time();
        $sql = "INSERT INTO hd_cat(name,atime) VALUES('{$name}',{$time})";echo $sql;
        $rs = $conn->execute($sql);
        if ($rs) {
            $msg = '添加成功!';
            VRedirect::go('hd.php?msg=' . $msg . '&m=cat_list');
        }else{
            $errors[] = '添加失败!';
        }
    }
}