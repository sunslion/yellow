<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

require $config['BASE_DIR']. '/classes/pagination.class.php';
require $config['BASE_DIR'].'/classes/GamesTaskReceive.class.php';

if (isset($_GET['a']) && $_GET['a'] === 'task_prize_post') {
    $filter = new VFilter();
    $id = $filter->get('id','INTEGER','GET');
    if(GamesTaskReceive::updateIsPost($id)){
        $messages[] = '记录标为赠送成功';
    }else{
        $errors[] = '记录标为赠送失败';
    }
}
$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;

$pagesize = 20;
$total = GamesTaskReceive::getTotal();
$pagination     = new Pagination($pagesize);
$limit          = $pagination->getLimit($total);
$paging         = $pagination->getAdminPagination('');

$sql = 'SELECT g.id,g.uid,g.taskid,g.atime,g.utime,g.ispost,t.tname,t.prize,s.username FROM games_task_receive g LEFT JOIN games_task t ON g.taskid = t.id LEFT JOIN signup s ON g.uid = s.UID LIMIT '.$limit;
$rs = $conn->execute($sql);
if ($rs && $conn->Affected_Rows() > 0) {
    $rows = $rs->getrows();
    $smarty->assign('rows', $rows);
}
$smarty->assign('total', $total);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);