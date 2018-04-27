<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
require $config['BASE_DIR']. '/classes/pagination.class.php';
$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;

require $config['BASE_DIR'].'/include/config.rank.php';
require $config['BASE_DIR'].'/classes/Games_task.class.php';
if (isset($_GET['a']) && $_GET['a'] === 'del') {
    $filter = new VFilter();
    $id = $filter->get('id','INTEGER','GET');
    if(Games_task::del($id)){
         $messages[] = '删除成功';
    }else{
        $errors[] = '删除失败';
    }
}
$pagesize = 20;
$total = Games_task::getTotal();
$pagination     = new Pagination($pagesize);
$limit          = $pagination->getLimit($total);
$paging         = $pagination->getAdminPagination('');
$pageindex = 0;
if (strpos($limit, ',') !== false) {
    list($pageindex,$pagesize) = explode(',', $limit);
}
$rows = Games_task::getAll($pageindex,$pagesize);
$smarty->assign('rows', $rows);
$smarty->assign('total', $total);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);