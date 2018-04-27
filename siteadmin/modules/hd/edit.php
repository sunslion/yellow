<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();
$sql = 'SELECT id,name FROM hd_cat ORDER BY id DESC;';
$rs = $conn->execute($sql);
$hd_cats = $rs ? $rs->getrows() : NULL;

$id = intval($_GET['id']);
$sql = 'SELECT * FROM hd WHERE id ='.$id.' LIMIT 1;';
$rs = $conn->execute($sql);
$hds = $rs ? $rs->getrows() : NULL;
$hd  = count($hds) > 0 ? $hds['0'] :NULL;
if (isset($_POST['edit_hd'])) {
    $filter = new VFilter();
    $id = $filter->get('id','INTEGER');
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
        $sql = "UPDATE hd SET cid ={$cid},title='{$title}',context='{$context}',url='{$url}',ispopular={$ispopular},stime={$stime},etime={$etime},keyword='{$keyword}',utime={$time} WHERE id ={$id}";
        $rs = $conn->execute($sql);
        if ($rs) {
            if ($_FILES['img']['tmp_name'] != '') {
                require $config['BASE_DIR']. '/classes/image.class.php';
                $image = new VImageConv();
                $image->process($_FILES['img']['tmp_name'], $chimg. '/' .$id. '.jpg', 'MAX_WIDTH', 220, 130);
                $image->canvas(220, 130, '000000', true);
            }
            $msg = '修改成功!';
            VRedirect::go('hd.php?msg=' . $msg . '&m=list');
        }else{
            $errors[] = '修改失败!';
        }
    }
}

$smarty->assign('categories', $hd_cats);
$smarty->assign('hd', $hd);
$smarty->assign('id', $id);