<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';
require $config['BASE_DIR'].'/include/config.rank.php';
$uid = intval($_GET['uid']);
$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;
$order = 'id desc';
$page_items = 10;
$where = '';
$option = array('display'=>'','order'=>'','isget_sebi'=>'','sdate'=>'','edate'=>'');
if (isset($_POST['search_deposit'])) {
    unset($_SESSION['option']);
    if (isset($_POST['display'])) {
        $option['display'] = $page_items;
    }
    if (isset($_POST['order'])) {
        if ($_POST['order'] == 'ASC') {
            $option['order'] = $_POST['order'];
        }
    }
    if (isset($_POST['isget_sebi'])) {
        $option['isget_sebi'] = $_POST['isget_sebi'];
    }
    if (isset($_POST['sdate']) && !empty($_POST['sdate'])) {
        $option['sdate'] = $_POST['sdate'];
    }
    if (isset($_POST['edate']) && !empty($_POST['edate'])) {
        $option['edate'] = $_POST['edate'];
    }
    $_SESSION['option'] = $option;
}
$option = isset($_SESSION['option']) ? $_SESSION['option']:$option;
$remove = '';
if ($option['display'] != '') {
    $page_items = intval($option['display']);
}
if ($option['order'] != '') {
    if ($_POST['order'] == 'ASC') {
        $order = 'id ASC';
    }
}
if ($option['isget_sebi'] != '') {
    $where = ' AND isget_sebi='.intval($option['isget_sebi']);
}
if ($option['sdate'] !='') {
    $sdate = strtotime($option['sdate']);
    $where .= ' AND dtime > '.$sdate;
}
if ($option['edate'] !='') {
    $edate = strtotime($option['edate']);
    $where .= ' AND dtime < '.$edate;
}

if (isset($_GET['a']) && $_GET['a'] == 'delete') {
    $id = intval($_GET['id']);
    $sql = "SELECT uid ,sebi,get_sebi FROM user_deposit WHERE id = {$id} LIMIT 1;";
    $rs = $conn->execute($sql);
    $uid = $rs->fields['uid'];
    $sebi = $rs->fields['sebi'];
    $get_sebi = $rs->fields['get_sebi'];

    $send_total_surplus = $sebi + $get_sebi;

    $sql = "UPDATE user_sebi SET sebi_total = sebi_total - {$send_total_surplus},sebi_surplus=sebi_surplus-{$send_total_surplus} WHERE uid = {$uid};";
    $rs = $conn->execute($sql);
    if ($rs) {
        $sql = "DELETE FROM user_deposit WHERE id = {$id}";
        $rs = $conn->execute($sql);
        if($rs){
            $sql = "SELECT sebi_surplus FROM user_sebi WHERE uid={$uid} LIMIT 1;";
            $rs = $conn->execute($sql);
            $sebi_surplus = $rs->fields['sebi_surplus'];
            $range = 0;
            foreach ($rank_range as $k => $v) {
                list($min,$max) = $v;
                if ($min <= $sebi_surplus && $max >= $sebi_surplus) {
                    $range = $k;
                    break;
                }
            }
            $new_premium = 0;
            foreach ($user_rank_range as $key => $value) {
                if (in_array($range, $value)) {
                    $new_premium = $key;
                    break;
                }
            }
            $sql = "SELECT premium FROM signup WHERE UID = {$uid} LIMIT 1;";
            $rs = $conn->execute($sql);
            $premium = $rs->fields['premium'];
            if ($premium != $new_premium) {
                $sql = "UPDATE signup SET premium = {$new_premium} WHERE UID = {$uid} LIMIT 1;";
                $conn->execute($sql);
            }
            $messages[] ='删除成功';
        }else{
            $errors[] = '删除失败';
        }
    }
    else{
        $errors[] = '删除失败';
    }
    $smarty->assign('uid',$uid);
}

$query_count = "SELECT COUNT(id) as total FROM user_deposit WHERE uid = {$uid}{$where} LIMIT 1;";
$rs = $conn->execute($query_count);
$total = 0;
if ($rs) {
    $total = $rs->fields['total'];
}
$pagination     = new Pagination($page_items);
$limit          = $pagination->getLimit($total);
$paging         = $pagination->getAdminPagination($remove);
$query = "SELECT * FROM user_deposit WHERE uid = {$uid}{$where} ORDER BY {$order} LIMIT {$limit}";
$rs = $conn->execute($query);
if ($rs) {
    $deposits = $rs->getrows();
    $smarty->assign('deposits',$deposits);
}
$sql = "SELECT money, sebi,get_sebi FROM user_deposit WHERE uid = {$uid} {$where}";
$rs = $conn->execute($sql);
$rows = $rs->getrows();
$dsebi = 0;
$psebi = 0;
$money = 0 ;
foreach ($rows as $r) {
    $dsebi += $r['sebi'];
    $psebi += $r['get_sebi'];
    $money += $r['money'];
}
$sql = "SELECT username FROM signup WHERE uid={$uid} LIMIT 1;";
$rs = $conn->execute($sql);
$username = $rs->fields['username'];
$smarty->assign('username',$username);
$smarty->assign('dsebi',$dsebi);
$smarty->assign('psebi',$psebi);
$smarty->assign('money',$money);
$smarty->assign('tsebi',$dsebi+$psebi);
$smarty->assign('option',$option);
$smarty->assign('uid',$uid);
$smarty->assign('total', $total);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);