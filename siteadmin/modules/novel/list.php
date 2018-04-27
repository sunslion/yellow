<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

require $config['BASE_DIR']. '/classes/pagination.class.php';

$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;
$option = (isset($_SESSION['search_novel_option'])) ? $_SESSION['search_novel_option'] : array('sort'=>'VID','order'=>'DESC');
$query_add = '';
if (isset($_POST['search_novel'])) {
	$option['sort'] = mysql_escape_string(trim($_POST['sort']));
	$option['order'] = mysql_escape_string(trim($_POST['order']));
	$query_add = " ORDER BY " .$option['sort']. " " .$option['order'];
	$_SESSION['search_novel_option'] = $option;
}

$sql_count = "SELECT count(VID) as total FROM novel".$query_add;

$crs = $conn->execute($sql_count);
$total  = $crs->fields['total'];
$pagination     = new Pagination(10);
$limit          = $pagination->getLimit($total);
$paging         = $pagination->getAdminPagination('');
$sql_select = "SELECT n.*,c.name FROM novel n inner join channel c on n.category_id = c.CHID WHERE 1=1".$query_add." LIMIT ".$limit;
$rs = $conn->execute($sql_select);
$novels = $rs->getrows();

$smarty->assign('novels', $novels);
$smarty->assign('total', $total);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);