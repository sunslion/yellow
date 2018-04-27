<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

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

if (isset($_POST['edit_picture'])) {
    $vid = intval($_POST['vid']);
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
        $sql = "UPDATE picture SET title = '{$title}',keyword = '{$keyword}',des = '{$des}',category_id = '{$category_id}',description = '{$description}',utime='{$time}' WHERE VID = {$vid} LIMIT 1";
        $rs = $conn->execute($sql);
        if ($rs && $conn->Affected_Rows()>0) {
            $messages[] = '修改成功';
        }else{
            $errors[] = '修改失败';
        }
    }
}

$vid = intval($_GET['vid']);
$sql = 'SELECT title,category_id,keyword,des,description FROM picture WHERE VID = '.$vid.' LIMIT 1;';
$rs = $conn->execute($sql);
if($rs && $conn->Affected_Rows() > 0){
    $pictures = $rs->getrows();
    $smarty->assign('vid', $vid);
    $smarty->assign('picture', $pictures[0]);
}