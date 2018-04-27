<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';
require $config['BASE_DIR'].'/include/config.rank.php';
if (isset($_POST['a'])) {   
    unset($_GET);
    $action = strtolower(trim($_POST['a']));
    if ($action == 'delete_multiple') {
        $dtemp = array();
        foreach ( $_POST as $key => $value ) {
            if ( $key != 'check_all_users' && substr($key, 0, 17) == 'user_id_checkbox_') {
                if ( $value == 'on' ) {
                    $dtemp[] =intval(str_replace('user_id_checkbox_', '', $key));
                }
            }
        }
        $count = count($dtemp);
        if ( $count === 0 ) {
            $errors[]   = 'Please select users to be deleted!';
        } else {
            if ($count > 0) {
                deleteUser($dtemp);
                $messages[] = 'Successfully deleted ' .$count. ' (selected) users!';
            }
        }  
    }
    if ($action == 'suspend_multiple' || $action == 'approve_multiple') {
        $satemp = array();
        if ($action == 'approve_multiple') {
            $act        = 'Active';
            $act_name   = 'activated';
        }
        if ( $action == 'suspend_multiple' ) {
            $act        = 'Inactive';
            $act_name   = 'suspended';
        }
        
        foreach ( $_POST as $key => $value ) {
            if ( $key != 'check_all_users' && substr($key, 0, 17) == 'user_id_checkbox_') {
                if ( $value == 'on' ) {
                    $satemp[] = intval(str_replace('user_id_checkbox_', '', $key));
                }
            }
        }
        $count = count($satemp);
        if ( $count === 0 ) {
            $errors[]   = 'Please select users to be ' .$act_name. '!';
        } else {
            if ($count > 0) {
                $sa_uidstr = implode(',', $satemp);
                $sql = "UPDATE signup SET account_status = '{$act}' WHERE UID in ({$sa_uidstr});";
                $rs = $conn->execute($sql);
                $messages[] = 'Successfully ' .$act_name. ' ' .$count. ' (selected) users!';
            }
        }  
    }
}
$remove = NULL;
$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;

if ( isset($_GET['a']) && $_GET['a'] != '' ) {
    unset($_POST);
    $UID    = ( isset($_GET['UID']) && is_numeric($_GET['UID']) ) ? intval(trim($_GET['UID'])) : NULL;    
    $action = trim($_GET['a']);
    if ( $action != '' && !$UID )
        $errors[] = 'Invalid User ID. User ID must be numeric!';
    switch ( $action ) {
        case 'delete':
            $uid_arr = array();
            array_push($uid_arr, $UID);
            deleteUser($uid_arr);
            $remove = '&a=delete&UID=' .$UID;
            $messages[] = 'Successfully deleted user!';
            break;
        case 'activate':
            $sql = "UPDATE signup SET account_status = 'Active' WHERE UID = '" .mysql_real_escape_string($UID). "' LIMIT 1";
            $conn->execute($sql);
            $messages[] = 'User account activated successfuly!';
            $remove = '&a=activate&UID=' .$UID;
            break;
        case 'suspend':
            $sql = "UPDATE signup SET account_status = 'Inactive' WHERE UID = '" .mysql_real_escape_string($UID). "' LIMIT 1";
            $conn->execute($sql);
            $messages[] = 'User account suspended successfuly!';
            $remove = '&a=suspend&UID=' .$UID;
            break;
        default:
            $errors[] = 'Invalid action. Allowed actions: delete, activated and suspend!';
    }
}
$query          = constructQuery($module_keep);
$sql            = $query['count'];
$rs             = $conn->execute($sql);
$total_users    = $rs->fields['total_users'];
$pagination     = new Pagination($query['page_items']);
$limit          = $pagination->getLimit($total_users);
$paging         = $pagination->getAdminPagination($remove);
//$sql          = $query['select']. " LIMIT " .$limit;
$sql            = 'SELECT p.UID,p.username,p.photo,p.gender,p.products,p.premium,p.premiumexpirytime,p.addtime,p.logintime,p.watched_video,p.video_viewed,p.account_status,s.sebi_surplus,s.sebi_tiyan,uv.`aname` FROM 
                    (SELECT UID, username,photo,gender,products,premium,premiumexpirytime,addtime,logintime,watched_video,video_viewed,account_status FROM signup INNER JOIN (SELECT UID FROM signup '.$query['select'].' LIMIT '.$limit.') AS np USING(UID)) p 
                    LEFT JOIN user_sebi s On p.UID = s.uid LEFT JOIN `user_vip` uv ON p.`username`=uv.`uname`';
$rs             = $conn->execute($sql);
if ($rs && $conn->Affected_Rows() > 0) {
    $users          = $rs->getrows();
}

$temp = array();
foreach ($users as &$u){
    if (!empty($u['products'])) {
        $u_p_arr = explode(',', $u['products']);
        foreach ($u_p_arr as $v){
            $temp[] = $products[$v];
        }
        $u['products'] = implode(',', $temp);
        $temp = array();
    }
}
$send_users = array();
foreach ($users as $su){
    $send_users[] = $su['username'];
}
function constructQuery($module)
{
    global $smarty;

    $query_module = '';
    if ( $module == 'active' or $module == 'inactive' )
            $query_module = " WHERE account_status = '" .$module. "'";

    $query              = array();
    //$query_select       = "SELECT p.UID,p.username,p.photo,p.gender,p.products,p.premium,p.premiumexpirytime,p.addtime,p.logintime,p.watched_video,p.video_viewed,p.account_status,s.sebi_surplus,s.sebi_tiyan,uv.`aname` FROM signup p LEFT JOIN user_sebi s On p.UID = s.uid LEFT JOIN `user_vip` uv ON p.`username`=uv.`uname`" .$query_module;
    $query_select       = $query_module;
    $query_count        = "SELECT count(UID) AS total_users FROM signup ".$query_module;
    $query_add          = ( $query_module != '' ) ? " AND" : " WHERE";
    $query_option       = array();
    $option_orig        = array('username' => '', 'email' => '', 'country' => '', 'name' => '', 'gender' => '', 'relation' => '',
                                'sort' => 'UID', 'order' => 'DESC', 'display' => 10);

	$all   = (isset($_GET['all'])) ? intval($_GET['all']) : 0;
	if ($all == 1) {
		unset ($_SESSION['search_users_option']);
	}
	
    $option             = ( isset($_SESSION['search_users_option']) ) ? $_SESSION['search_users_option'] : $option_orig;
    
    if ( isset($_POST['search_videos']) ) {
        $option['username']     = trim($_POST['username']);
        $option['email']        = trim($_POST['email']);
        $option['country']      = trim($_POST['country']);
        $option['name']         = trim($_POST['name']);
        $option['gender']       = trim($_POST['gender']);
        $option['relation']     = trim($_POST['relation']);
        $option['sort']         = trim($_POST['sort']);
        $option['order']        = trim($_POST['order']);
        $option['display']      = trim($_POST['display']);
        $option['products']      = trim($_POST['products']);
        $option['premium']      = trim($_POST['premium']);
        $option['sdate']        = trim($_POST['sdate']);
        $option['edate']        = trim($_POST['edate']);
        $option['aname']        = trim($_POST['aname']);
      
        $_SESSION['search_users_option'] = $option;
    }
    
    if ( $option['username'] != '' ) {
        $query_option[] = $query_add. " username LIKE '" .mysql_real_escape_string($option['username']). "%'";
        $query_add      = " AND";
    }
    
    if ( $option['email'] != '' ) {
        $query_option[] = $query_add. " email LIKE '" .mysql_real_escape_string($option['email']). "%'";
        $query_add      = " AND";
    }
    
    if ( $option['country'] != '' ) {
        $query_option[] = $query_add. " country LIKE '" .mysql_real_escape_string($option['country']). "%'";
        $query_add      = " AND";
    }
   /* 
    if ( $option['name'] != '' ) {
        $query_option[] = $query_add. " ( fname LIKE '" .mysql_real_escape_string($option['name']). "%' OR lname LIKE '" .mysql_real_escape_string($option['name']). "%'";
        $query_add      = " AND";
    }
   */ 
    if ( $option['gender'] != '' ) {
        $query_option[] = $query_add. " gender = '" .mysql_real_escape_string($option['gender']). "'";
        $query_add      = " AND";
    }
    
    if ( $option['relation'] != '' ) {
        $query_option[] = $query_add. " relation = '" .mysql_real_escape_string($option['relation']). "'";
        $query_add      = " AND";
    }
    if ( $option['products'] != '' ){
        $products = mysql_real_escape_string($option['products']);
        $query_option[] = $query_add. "  locate('{$products}',products) > 0 ";
        $query_add      = " AND";
    }
    if ( $option['premium'] != '' ){
        $query_option[] = $query_add. " premium >= " .intval($option['premium']);
        $query_add      = " AND";
    }
    if ($option['sdate'] != '') {
        $sdate = strtotime($option['sdate']);
        $query_option[] = $query_add. " addtime >= {$sdate} ";
        $query_add      = " AND";
    }
    if ($option['edate'] != '') {
        $edate = strtotime($option['edate']);
        $query_option[] = $query_add. " addtime <= {$edate} ";
        $query_add      = " AND";
    }/*
    if ( $option['aname'] !='' ) {
        $aname = mysql_real_escape_string($option['aname']);
        $query_option[] = $query_add. " aname = '{$aname}'";
        $query_add      = " AND";
    }*/
    $query_option[]         = " ORDER BY " .$option['sort']. " " .$option['order'];
    $where = implode(' ', $query_option);

    $query['select']        = $query_select . $where;
    $query['count']         = $query_count . $where;
    $query['page_items']    = $option['display'];
    
    $smarty->assign('option', $option);  
    return $query;
}
$sql = "SELECT id,name FROM admin";
$rs             = $conn->execute($sql);
if ($rs) {
    $admins = $rs->getrows();
    $smarty->assign('admins', $admins);
}
$smarty->assign('send_users',implode(',', $send_users));
$smarty->assign('products', $products);
$smarty->assign('user_range', $user_range);
$smarty->assign('users', $users);
$smarty->assign('total_users', $total_users);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);
unset($send_users);