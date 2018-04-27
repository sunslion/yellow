<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
require $config['BASE_DIR']. '/classes/pagination.class.php';
$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;
$option = (isset($_SESSION['search_hd_option'])) ? $_SESSION['search_hd_option'] : array('sort'=>'id','order'=>'DESC');
$query_add = '';
$where = '';
if (isset($_POST['search_hd'])) {
    if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
        $keyword = mysql_escape_string(trim($_POST['keyword']));
        $option['where'] = $keyword;
        $where = " WHERE uid = '{$keyword}' OR uname like '%{$keyword}%' ";
    }
    $option['sort'] = mysql_escape_string(trim($_POST['sort']));
    $option['order'] = mysql_escape_string(trim($_POST['order']));
    $query_add = $option['sort']. " " .$option['order'];
    $_SESSION['search_hd_option'] = $option;
}
$pagesize = 20;
$type = intval($_GET['type']);
if ($type == 0) {
    $type = intval($_POST['type']);
}
require $config['BASE_DIR'].'/classes/HDBless.class.php';
if (isset($_GET['a']) && $_GET['a'] === 'isshow') {
    $id = intval($_GET['id']);
    if(HDBless::updateIsShow($id)){
        $messages[] = '审核成功';
    }else{
        $errors[] = '审核失败';
    }
}
if ($type == 1) {
    $module_template = 'hd/bless.tpl';
    $total = HDBless::getCount($where);
    if ($total) {
        $pageindex = ($page - 1) * $pagesize;
        $pagination     = new Pagination($pagesize);
        $limit          = $pagination->getLimit($total);
        $paging         = $pagination->getAdminPagination('');
        $rows = HDBless::get($pageindex,$pagesize,$where);
        if ($rows) {
            $smarty->assign('rows', $rows);
        }
    }
    
}else{
    if (!empty($where)) {
        $where .= ' AND gid =4 ';
    }else{
        $where = ' gid = 4 ';
    }
    if (empty($query_add)) {
        $query_add = 'id DESC';
    }
    $module_template = 'hd/yuanxiao.tpl';
    require $config['BASE_DIR'].'/include/config.rank.php';
    require $config['BASE_DIR'].'/classes/HDGames.class.php';
    $total = HDGames::getCount($where);
    if ($total) {
        $pageindex = ($page - 1) * $pagesize;
        $pagination     = new Pagination($pagesize);
        $limit          = $pagination->getLimit($total);
        $paging         = $pagination->getAdminPagination('');
        $rows = HDGames::getAll($pageindex,$pagesize,$where,$query_add);
        $str = '<font style="color:red;">%s</font> 中奖为  <font style="color:red;">%s</font>;<br/>';
        if ($rows) {
            foreach ($rows as &$v) {
                foreach ($v as $sk=>$sv) {
                    if ($sk == 'data') {
                        $data = json_decode($sv,true);
                        $v['info'] = '';
                        foreach ($data as $key => $value) {
                            $v['info'] .= sprintf($str,date('Y-m-d H:i:s',$key),$yuanxiao_jp[$value]);
                        }
                    }
                }
            }
            $smarty->assign('rows', $rows);
        }
    }
}
$smarty->assign('total', $total);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);
$smarty->assign('option', $option);