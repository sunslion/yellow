<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
$type = 1;

if ( isset($_POST['submit_player']) && !$errors ) {
	$filter				= new VFilter();
	
	$front_ads_guest	=	$filter->process($_POST['front_ads_guest']);
	$front_ads_uri_guest	=	$filter->process($_POST['front_ads_uri_guest']);
	$front_ads_time_guest	=	$filter->process($_POST['front_ads_time_guest']);
	
	$front_ads_free	=	$filter->process($_POST['front_ads_free']);
	$front_ads_uri_free	=	$filter->process($_POST['front_ads_uri_free']);
	$front_ads_time_free	=	$filter->process($_POST['front_ads_time_free']);
	
	$front_ads_premium	=	$filter->process($_POST['front_ads_premium']);
	$front_ads_uri_premium	=	$filter->process($_POST['front_ads_uri_premium']);
	$front_ads_time_premium	=	$filter->process($_POST['front_ads_time_premium']);
	
	$front_ads_view	=	$filter->process($_POST['front_ads_view']);
	$stop_ads	=	$filter->process($_POST['stop_ads']);
	$stop_ads_uri	=	$filter->process($_POST['stop_ads_uri']);
	$type           =   $filter->process($_POST['type']);
if ( $front_ads_guest == '' ) {
    $errors[] = '游客广告图不能是空白!';
}
if ( $front_ads_uri_guest == '' ) {
    $errors[] = '游客广告链接不能是空白!';
}
if ( $front_ads_time_guest == '' ) {
    $errors[] = '游客广告时间不能是空白!';
}
if ( $front_ads_free == '' ) {
    $errors[] = '免费用户广告图不能是空白!';
}
if ( $front_ads_uri_free == '' ) {
    $errors[] = '免费用户广告链接不能是空白!';
}
if ( $front_ads_time_free == '' ) {
    $errors[] = '免费用户广告时间不能是空白!';
}
if ( $front_ads_premium == '' ) {
    $errors[] = '收费用户广告图不能是空白!';
}
if ( $front_ads_uri_premium == '' ) {
    $errors[] = '收费用户广告链接不能是空白!';
}
if ( $front_ads_time_premium == '' ) {
    $errors[] = '收费用户广告时间不能是空白!';
}
if ( $front_ads_view == '' ) {
    $errors[] = '显示权限不能是空白!';
}
if ( $stop_ads == '' ) {
    $errors[] = '暂停广告图不能是空白!';
}
if ( $stop_ads_uri == '' ) {
    $errors[] = '暂停广告链接不能是空白!';
}
$type = round($type);

    if ( !$errors ) {
        $sql = 'SELECT PID FROM new_player WHERE type = '.$type.' LIMIT 1';
        $conn->execute($sql);
        $front_ads_guest = mysql_real_escape_string($front_ads_guest);
        $front_ads_uri_guest = mysql_real_escape_string($front_ads_uri_guest);
        $front_ads_time_guest = mysql_real_escape_string($front_ads_time_guest);
        $front_ads_free = mysql_real_escape_string($front_ads_free);
        $front_ads_uri_free = mysql_real_escape_string($front_ads_uri_free);
        $front_ads_time_free = mysql_real_escape_string($front_ads_time_free);
        $front_ads_premium = mysql_real_escape_string($front_ads_premium);
        $front_ads_uri_premium = mysql_real_escape_string($front_ads_uri_premium);
        $front_ads_time_premium = mysql_real_escape_string($front_ads_time_premium);
        $front_ads_view = mysql_real_escape_string($front_ads_view);
        $stop_ads = mysql_real_escape_string($stop_ads);
        $stop_ads_uri = mysql_real_escape_string($stop_ads_uri);
        
        if ($conn->Affected_Rows() > 0) {
            $sql    = "UPDATE new_player SET front_ads_guest = '{$front_ads_guest}', front_ads_uri_guest = '{$front_ads_uri_guest}', front_ads_time_guest = '{$front_ads_time_guest}',
                                              front_ads_free = '{$front_ads_free}', front_ads_uri_free = '{$front_ads_uri_free}', front_ads_time_free = '{$front_ads_time_free}', front_ads_premium = '{$front_ads_premium}',
                                              front_ads_uri_premium = '{$front_ads_uri_premium}', front_ads_time_premium = '{$front_ads_time_premium}', front_ads_view = '{$front_ads_view}',
                                              stop_ads = '{$stop_ads}', stop_ads_uri = '{$stop_ads_uri}' WHERE `type` = {$type} LIMIT 1";
        }else{
            $sql = "INSERT INTO new_player(front_ads_guest,front_ads_uri_guest,front_ads_time_guest,front_ads_free,front_ads_uri_free,front_ads_time_free,front_ads_premium,front_ads_uri_premium,front_ads_time_premium,front_ads_view,stop_ads,stop_ads_uri,type) 
                    VALUES ('{$front_ads_guest}','{$front_ads_uri_guest}','{$front_ads_time_guest}','{$front_ads_free}','{$front_ads_uri_free}','{$front_ads_time_free}','{$front_ads_premium}',
                    '{$front_ads_uri_premium}','{$front_ads_time_premium}','{$front_ads_view}','{$stop_ads}','{$stop_ads_uri}','{$type}'
            )";
        }
        $rs = $conn->execute($sql);
        if($rs)
            $messages[] = '播放器广告位设置完毕！!';
    }
}

$player = array();
$sql    = "SELECT * FROM new_player WHERE type = {$type} LIMIT 1";
$rs     = $conn->execute($sql);
if ( $conn->Affected_Rows() > 0 ) {
    $player = $rs->getrows();
    $player = $player['0'];
} else {
    $errors[]    = 'Failed to load default player profile!';
}

$smarty->assign('player', $player);
?>