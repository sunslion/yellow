<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

$sql = 'SELECT id,name FROM hd_cat ORDER BY id DESC;';
$rs = $conn->execute($sql);
$hd_cats = $rs ? $rs->getrows() : NULL;

if (isset($_POST['add_hd'])) {
    $filter = new VFilter();
    $title = $filter->get('title');
    if (empty($title)) {
        $errors[] = '活动标题不能为空';
    }
    $url = $filter->get('url');
    $ispopular = isset($_POST['ispopular']) ? $filter->get('ispopular') : 0;
    $context   = $_POST['context'];
    $keyword   = $filter->get('keyword');
    $cid       = intval($filter->get('cid','INTEGER'));
    $stime     = strtotime($filter->get('stime'));
    $etime     = strtotime($filter->get('etime'));
    if (!$errors) {
        $chimg = $config['BASE_DIR']. '/media/hd';
        $time = time();
        $sql = "INSERT INTO hd(cid,title,context,url,ispopular,stime,etime,keyword,atime) VALUES ({$cid},'{$title}','{$context}','{$url}',{$ispopular},{$stime},{$etime},'{$keyword}',{$time})";
        $rs = $conn->execute($sql);
        $chid = $conn->Insert_ID();
        if ($rs) {
            if ($_FILES['img']['tmp_name'] != '') {
                require $config['BASE_DIR']. '/classes/image.class.php';
                $image = new VImageConv();
                $image->process($_FILES['img']['tmp_name'], $chimg. '/' .$chid. '.jpg', 'MAX_WIDTH', 220, 130);
                $image->canvas(220, 130, '000000', true);
            }
            $msg = '添加成功!';
            VRedirect::go('hd.php?msg=' . $msg . '&m=list');
        }else{
            $errors[] = '添加失败!';
        }
    }
}
$smarty->assign('categories', $hd_cats);