<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
require $config['BASE_DIR']. '/include/function_video.php';
require $config['BASE_DIR']. '/classes/pagination.class.php';

$thumb_dir      = $config['TMB_DIR'];
$video_dir      = $config['VDO_DIR'];
$flvideo_dir    = $config['FLVDO_DIR'];
$tmp_dir        = $config['TMP_DIR']. '/thumbs';
if ( !file_exists($thumb_dir) or !is_dir($thumb_dir) or !is_writable($thumb_dir) ) {
    $errors[] = 'Thumb directory ' .$thumb_dir. ' does not exist or not writable!';
}
if ( !file_exists($video_dir) or !is_dir($video_dir) or !is_writable($video_dir) ) {
    $errrors[] = 'Video directory ' .$video_dir. ' does not exist or not writable!';
}
if ( !file_exists($flvideo_dir) or !is_dir($flvideo_dir) or !is_writable($flvideo_dir) ) {
    $errors[] = 'FLVideo directory ' .$flvideo_dir. ' does not exist or not writable!';
}
if ( !file_exists($tmp_dir) or !is_dir($tmp_dir) or !is_writable($tmp_dir) ) {
    $errors[] = 'Temporary directory ' .$tmp_dir. ' does not exist or not writable!';
}
$post_action = strtolower(trim($_POST['a']));
if ($post_action == 'delete_multiple') {
    $del_vids = array();
    foreach ( $_POST as $key => $value ) {
        if ( $key != 'check_all_videos' && substr($key, 0, 18) == 'video_id_checkbox_') {        
            if ( $value == 'on' ) {
                $del_vids[] = intval(str_replace('video_id_checkbox_', '', $key));
            }
        }
    }
    $count = count($del_vids);
    if ( $count === 0 ) {
        $errors[]   = 'Please select videos to be deleted!';
    } else {
        if ($count > 0) {
            if (deleteVideo($del_vids)) {
                $messages[] = 'Successfully deleted ' .$count. ' (selected) videos!';
            }else{
                $errors[] = 'Fail deleted ' .$count. ' (selected) videos!';;
            }
        }
    }
}

if ($post_action == 'suspend_multiple' || $post_action == 'approve_multiple' ) {
    $index      = 0;
    if ($post_action == 'approve_multiple') {
        $act        = 1;
        $act_name   = 'activated';
    }
    if ( $post_action == 'suspend_multiple' ) {
        $act        = 0;
        $act_name   = 'suspended';
    }
    
    foreach ( $_POST as $key => $value ) {
        if ( $key != 'check_all_videos' && substr($key, 0, 18) == 'video_id_checkbox_') {        
            if ( $value == 'on' ) {
                $vid = intval(str_replace('video_id_checkbox_', '', $key));
                $sql = "UPDATE video SET active = '" .$act. "' WHERE VID = " .$vid. " LIMIT 1";
                $conn->execute($sql);
                if ( $act_name == 'activated' ) {
                    send_video_approve_email($vid);
                }
                ++$index;
            }
        }
    }
    
    if ( $index === 0 ) {
        $errors[]   = 'Please select videos to be ' .$act_name. '!';
    } else {    
        $messages[] = 'Successfully ' .$act_name. ' ' .$index. ' (selected) videos!';
    }
}

$remove = NULL;
$page   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;

if ( isset($_GET['a']) && $_GET['a'] != '' ) {
    $action = trim($_GET['a']);
    $VID    = ( isset($_GET['VID']) && is_numeric($_GET['VID']) && videoExists($_GET['VID']) ) ? trim($_GET['VID']) : NULL;
    if ( $VID ) {
        switch ( $action ) {
            case 'delete':
                $sql = 'SELECT zid FROM video WHERE vid = '.$VID;
                $rs = $conn->execute($sql);
                if(deleteVideo($VID)){
                    if ($rs && $conn->Affected_Rows()> 0) {
                        $zid = $rs->fields['zid'];
                        curlGetData('http://sczy1.com:8080/del',
                            http_build_query(
                                array(
                                    'zid'=>$zid
                                )
                            )
                        );
                    }
                    $messages[] = 'Video deleted successfuly!';
                }else{
                    $errors[] = 'Video deleted Failure';
                }
                $remove = '&a=delete&VID=' .$VID;
                break;
            case 'suspend':
                $sql = "UPDATE video SET active = '0' WHERE VID = '" .mysql_real_escape_string($VID). "' LIMIT 1";
                $conn->execute($sql);
                $messages[] = 'Video suspended successfuly!';
                $remove = '&a=suspend&VID=' .$VID;
                break;
            case 'activate':
                $sql = "UPDATE video SET active = '1' WHERE VID = '" .mysql_real_escape_string($VID). "' LIMIT 1";
                $conn->execute($sql);
                send_video_approve_email($VID);
                $messages[] = 'Video activated successfuly!';
                $remove = '&a=activate&VID=' .$VID;
                break;
            case 'regenthumbs':
				if (file_exists($config['HD_DIR'].'/'.$VID. '.mp4')) {
					extract_video_thumbs($config['HD_DIR'].'/'.$VID. '.mp4', $VID);
				} elseif (file_exists($config['FLV_DIR'].'/'.$VID. '.flv')) {
					extract_video_thumbs($config['FLV_DIR'].'/'.$VID. '.flv', $VID);
				} elseif (file_exists($config['FLV_DIR'].'/'.$VID. '.mp4')) {
					extract_video_thumbs($config['FLV_DIR'].'/'.$VID. '.mp4', $VID);
				} else {
					extract_video_thumbs($config['IPHONE_DIR'].'/'.$VID. '.mp4', $VID);
				}
				$_SESSION['message'] = 'Thumbs regenerated successfuly!';
				$remove = '&=regenthumbs&VID='.$VID;
				VRedirect::go('videos.php?m='.$module_keep.'&page='.$page);
                break;
			case 'duration':
				if (file_exists($config['HD_DIR'].'/'.$VID. '.mp4')) {
					$duration = get_video_duration($config['HD_DIR'].'/'.$VID. '.mp4', $VID);					
				} elseif (file_exists($config['FLV_DIR'].'/'.$VID. '.flv')) {
					$duration = get_video_duration($config['FLV_DIR'].'/'.$VID. '.flv', $VID);						
				} elseif (file_exists($config['FLV_DIR'].'/'.$VID. '.mp4')) {
					$duration = get_video_duration($config['FLV_DIR'].'/'.$VID. '.mp4', $VID);											
				} else {
					$duration = get_video_duration($config['IPHONE_DIR'].'/'.$VID. '.mp4', $VID);											
				}				
				$sql = "UPDATE video SET duration = ".$duration." WHERE VID = ".$VID." LIMIT 1";
				$conn->execute($sql);
				$_SESSION['message'] = 'Duration regenerated successfuly!';
				$remove = '&=duration&VID='.$VID;
				VRedirect::go('videos.php?m='.$module_keep.'&page='.$page);
				break;
        }
    } else {
        $err = 'Invalid video id. Video does not exist!?';
    }
}

$query          = constructQuery($module_keep);
$sql            = $query['count'];
$rs             = $conn->execute($sql);
$total_videos   = $rs->fields['total_videos'];
$pagination     = new Pagination($query['page_items']);
$limit          = $pagination->getLimit($total_videos);
$paging         = $pagination->getAdminPagination($remove);
$sql            = $query['select']. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
if($rs && $conn->Affected_Rows() > 0)
    $videos         = $rs->getrows();

function constructQuery($module)
{
    global $smarty;

    $query_module = '';
    if ( $module == 'private' or $module == 'public' )
            $query_module = " AND v.type = '" .$module. "'";

    $query              = array();
    $query_select       = "SELECT * FROM video  WHERE 1=1 " .$query_module;
    $query_count        = "SELECT count(v.VID) AS total_videos FROM video AS v WHERE v.VID != ''" .$query_module;
    $query_add          = ( $query_module != '' ) ? " AND" : " WHERE";
    $query_option       = array();
    $channel            = ( isset($_GET['CID']) && is_numeric($_GET['CID']) && channelExists($_GET['CID']) ) ? trim($_GET['CID']) : NULL;
    $option_orig        = array('username' => '', 'title' => '', 'description' => '', 'keyword' => '', 'channel' => $channel, 'active' => '',
                                'sort' => 'VID', 'order' => 'DESC', 'display' => 100);

	$all   = (isset($_GET['all'])) ? intval($_GET['all']) : 0;
	if ($all == 1) {
		unset ($_SESSION['search_videos_option']);
	}
	
	$option             = ( isset($_SESSION['search_videos_option']) ) ? $_SESSION['search_videos_option'] : $option_orig;
	
    if ( isset($_POST['search_videos']) ) {
        $option['username']     = trim($_POST['username']);
        $option['title']        = trim($_POST['title']);
        $option['description']  = trim($_POST['description']);
        $option['keyword']      = trim($_POST['keyword']);
        $option['channel']      = intval(trim($_POST['channel']));
        $option['active']       = trim($_POST['active']);
		$option['sort']         = trim($_POST['sort']);
        $option['order']        = trim($_POST['order']);
        $option['display']      = trim($_POST['display']);
	
		$_SESSION['search_videos_option'] = $option;
	}
	
	if ( $option['title'] != '' ) {
	    $query_option[] = " AND title LIKE '%" .mysql_real_escape_string($option['title']). "%'";
	}
	
	if ( $option['description'] != '' ) {
	    $query_option[] = " AND description LIKE '%" .mysql_real_escape_string($option['description']). "%'";
	}
		
	if ( $option['keyword'] != '' ) {
	    $query_option[] = " AND keyword LIKE '%" .mysql_real_escape_string($option['keyword']). "%'";
	}
	
	if ( $option['channel'] != '' ) {
	    $query_option[] = " AND channel = " .intval($option['channel']);
	}
	
	if ( $option['active'] == '0' || $option['active'] == '1' ) {
	    $query_option[] = " AND active = '" .$option['active']. "'";
	}
	
    $query_option[]         = " ORDER BY " .$option['sort']. " " .$option['order'];    
    $query['select']        = $query_select .implode(' ', $query_option);
    $query['count']         = $query_count .implode(' ', $query_option);
    $query['page_items']    = $option['display'];
   
    $smarty->assign('option', $option);
    
    return $query;
}

function getUserID( $username )
{
    global $conn;
    
    $sql = "SELECT UID FROM signup WHERE username = '" .mysql_real_escape_string($username). "' LIMIT 1";
    $rs  = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 )
        return $rs->fields['UID'];
    
    return false;
}

$smarty->assign('videos', $videos);
$smarty->assign('total_videos', $total_videos);
$smarty->assign('paging', $paging);
$smarty->assign('page', $page);
$smarty->assign('channels', get_categories());
?>
