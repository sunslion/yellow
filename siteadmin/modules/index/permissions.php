<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();
$filter                 = new VFilter();
if ( isset($_POST['submit_permissions']) ) {
	$user_registration 	    = $filter->get('user_registration');
	$email_verification	    = $filter->get('email_verification');
	$video_view		        = $filter->get('video_view');
	$video_comments		    = $filter->get('video_comments');
    $photo_comments         = $filter->get('photo_comments');
    $blog_comments          = $filter->get('blog_comments');
    $wall_comments          = $filter->get('wall_comments');
	$private_msgs		    = $filter->get('private_msgs');
    $video_rate             = $filter->get('video_rate');
    $photo_rate             = $filter->get('photo_rate');
    $game_rate              = $filter->get('game_rate');
	$edit_videos			= $filter->get('edit_videos');
	$purviews                  = $filter->get('purviews');

	
    $config['user_registration']    = $user_registration;
    $config['email_verification']   = $email_verification;
    $config['video_view']           = $video_view;
    $config['video_comments']       = $video_comments;
    $config['photo_comments']       = $photo_comments;
    $config['blog_comments']        = $blog_comments;
    $config['wall_comments']        = $wall_comments;
    $config['private_msgs']         = $private_msgs;
    $config['video_rate']           = $video_rate;
    $config['photo_rate']           = $photo_rate;
    $config['game_rate']            = $game_rate;
	$config['edit_videos']			= $edit_videos;
	$config['purviews']                = $purviews;
	update_config($config);
    update_smarty();
	$messages[] = 'Permissions Updated Successfuly!';
}
if (isset($_POST['submit_menus'])) {
    $user_type              = $filter->get('user_type');
    if(empty($user_type)){
        echo '<meta http-equiv="refresh" content="3; url=/siteadmin/index.php?m=permissions" />';
        exit('请选择用户组');
    }
    $permissions   = $_POST['menus'];
    if (empty($permissions)) {
        echo '<meta http-equiv="refresh" content="3; url=/siteadmin/index.php?m=permissions" />';
        exit('请选择菜单项！');
    }
    $menus = array();
    $sub_arr_menus = array();
    foreach ($permissions as $k=>$v){
        if (is_numeric($k)) {
            $menus[] = $v;
        }else{
            $sub_arr_menus = array_merge($sub_arr_menus,$v);
        }
    }
    $config['perm_'.$user_type.'_menus'] = json_encode($menus);
    $config['perm_'.$user_type.'_submenus'] = json_encode($sub_arr_menus);
    update_config($config);
    $messages[] = 'Menus Updated Successfuly!';
}
$purviews = $config['purviews'];
if (!empty($purviews)) {
    $temp = explode('|', $purviews);
    $i = 1;
    $temp_arr = array();
    foreach ($temp as $v){
        $temp_arr[$i] = $v;
        $i++;
    }
    $smarty->assign('purview_arr', $temp_arr);
}
$smarty->assign('sub_menus', $sub_menus);
$smarty->assign('sub_menus_action', $sub_menus_action);
?>
