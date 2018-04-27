<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';
Auth::checkAdmin();

$all = isset($_GET['all']) ? intval($_GET['all']) : 0;
if ($all == 1) {
    unset($_SESSION['search_admin_option']);
}
$act = array(1 => 'activate',2 =>'suspend');
if (isset($_GET['a'])) {
    $action = $filter->get('a','STRING','GET');
    if($action == 'delete'){
        $id = $filter->get('id','INT','GET');
        $sql = "DELETE FROM admin WHERE id = {$id}";
        if($conn->execute($sql)){
            $messages[] = '删除成功!';
        }else{
            $errors[] = '删除失败!';
        }
    }
    
    if ($action == 'suspend' || $action == 'activate') {
        $id = $filter->get('id','INT','GET');
        $key = array_search($action, $act);
        $sql = "UPDATE admin SET status = {$key} WHERE id = {$id}";
        if($conn->execute($sql)){
            $messages[] = '更新状态成功!';
        }else{
            $errors[] = '更新状态失败!';
        }
    }
}

$option = isset($_SESSION['search_admin_option']) ? $_SESSION['search_admin_option'] : array();
if (isset($_POST['search_admin'])) {
    $option['name'] = $filter->get('name');
    $option['email'] = $filter->get('email');
    $option['mobile'] = $filter->get('mobile');
    $option['type'] = $filter->get('type');
    $option['order'] = $filter->get('order');
    $option['display'] = $filter->get('display');
    
    $_SESSION['search_admin_option'] = $option;
}

$where = '';
$whereAnd = ' WHERE ';
if ($option['name'] != '') {
    $where  = $whereAnd . "  name LIKE '%{$option['name']}%' "; 
    $whereAnd = ' AND ';
}
if ($option['email'] !='') {
    $where .= $whereAnd . " email = '{$option['email']}'";
    $whereAnd = ' AND ';
}
if ($option['mobile'] !='') {
    $where .= $whereAnd . " mobile = '{$option['mobile']}'";
    $whereAnd = ' AND ';
}
if (isset($option['type']) && $option['type'] > 0) {
    $where .= $whereAnd . " type = {$option['type']}";
    $whereAnd = ' AND ';
}

$option['order'] = isset($option['order']) ? $option['order'] :'DESC';
$option['display'] = isset($option['display']) ? intval($option['display']) : 10;
$total_sql = "SELECT count(id) as total FROM admin ".$where;
$rs = $conn->execute($total_sql);
$total = 0;
if ($rs)
    $total = $rs->fields['total'];
$pagination     = new Pagination($option['display']);
$limit          = $pagination->getLimit($total);
$paging         = $pagination->getAdminPagination();
$sql = "SELECT * FROM admin ".$where.' ORDER BY id '.$option['order'].' LIMIT '.$limit;
$rs = $conn->execute($sql);
if($rs)
    $users = $rs->getrows();

$smarty->assign('act',$act);
$smarty->assign('users', $users);
$smarty->assign('total_users', $total);
$smarty->assign('users', $users);
$smarty->assign('paging', $paging);
$smarty->assign('option', $option);