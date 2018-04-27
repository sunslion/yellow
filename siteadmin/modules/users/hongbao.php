<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';
Auth::checkAdmin();
require $config['BASE_DIR'].'/classes/Member.class.php';
$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;
$order = 'id desc';
$page_items = 10;
$where = '';
if (isset($_POST['username'])) {
    $username = strip_tags($_POST['username']);
    $uid = Member::getNameUser($username);
    $where = ' WHERE uid = '.$uid;
}
$query_count = 'SELECT COUNT(id) as total FROM hongbao LIMIT 1;';
$rs = $conn->execute($query_count);
$total = 0;
if ($rs) {
    $total = $rs->fields['total'];
}
$remove = '';
$pagination     = new Pagination($page_items);
$limit          = $pagination->getLimit($total);
$paging         = $pagination->getAdminPagination($remove);
$query = "SELECT id,uid,amount,ip,isreceive,rtime,rectime,total,detotal FROM hongbao {$where} ORDER BY {$order} LIMIT {$limit}";
$rs = $conn->execute($query);
if ($rs) {
    $hongbaos = $rs->getrows();
    $uids = array();
    foreach ($hongbaos as $k => $v) {
        $uids[] = $v['uid'];
    }
    $users = Member::getUsers($uids);
    foreach ($hongbaos as $k => $v) {
        foreach ($users as $sk => $sv) {
            if ($sv['UID'] == $v['uid']) {
                $hongbaos[$k]['username'] = $sv['username'];
                $hongbaos[$k]['ip'] = long2ip($v['ip']);
            }
        }
    }
    unset($users);
    $smarty->assign('hongbaos',$hongbaos);
}
$smarty->assign('total', $total);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);