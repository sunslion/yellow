<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
$errors = array();
if (isset($_POST['add_picture'])) {
    $title = trim($_POST['title']);
    $keyword = trim($_POST['keyword']);
    $des = trim($_POST['des']);
    $category_id = intval($_POST['category_id']);
    $description = trim($_POST['description']);
    
    if (empty($title)) {
        $errors[] = '请填写标题 ';
    }
    if (empty($keyword)) {
        $errors[] = '请填写关键词';
    }
    if (empty($des)) {
        $errors[] = '请填写简单描述';
    }
    if ($category_id === 0) {
        $errors[] = '请选择类型';
    }

    if (!$errors) {
        $title = mysql_real_escape_string($title);
        $keyword = mysql_real_escape_string($keyword);
        $des = mysql_real_escape_string($des);
        $category_id = mysql_real_escape_string($category_id);
        $description = mysql_real_escape_string($description);
        $time = time();
        $sql = 'INSERT INTO picture (title,keyword,des,category_id,description,atime) VALUES('."'{$title}','{$keyword}','{$des}','{$category_id}','{$description}','{$time}')";
        $rs = $conn->execute($sql);
        if ($rs && $conn->Affected_Rows()>0) {
            $messages[] = '添加成功';
        }else{
            $errors[] = '添加失败';
        }
    }
}

$chid = 7;
$sql = 'SELECT CHID,name FROM channel WHERE parentid ='.$chid.' ORDER BY CHID DESC';
$rs = $conn->execute($sql);
$channels = array();
if ($rs && $conn->Affected_Rows() > 0) {
    $rows = $rs->getrows();
    foreach ($rows as $k => $v) {
        $channels[$k]['CHID'] = $v['CHID'];
        $channels[$k]['name'] = $v['name'];
    }
}
$smarty->assign('channels', $channels);
