<?php
defined('_VALID') or die('Restricted Access!');
set_time_limit(0);
Auth::checkAdmin();
$video  = array();
$VID    = round($_GET['VID']);
if ( $VID <= 0 ) 
    $errors[] = 'Invalid video ID. This video does not exist!';

if ( !$errors ) {
    if ( isset($_POST['edit_video']) ) {
        require $config['BASE_DIR']. '/classes/filter.class.php';
        $filter     	= new VFilter();
        $title          = $filter->get('title');
        $keyword        = $filter->get('keyword');
        $channel        = $filter->get('channel','INT');
        $type			= $filter->get('type');
        $ipod_filename  = $filter->get('ipod_filename');
        $ybPlayUrl      = $filter->get('ybPlayUrl');
        $pic            = $filter->get('pic');        
        if ( empty($title)) {
            $errors[]           = 'Please enter a video title!';
        }
        $title = mysql_real_escape_string($title);
        if ( $channel === 0 ) {
            $errors[]           = 'Please select a video category!';
        }
        $keyword	= prepare_string($keyword, false);
        $keyword   = mysql_real_escape_string($keyword);
        if (empty($pic)) {
            $errors[]  = '请填写图片地址';
        }
        $pic = mysql_real_escape_string($pic);
        if (empty($ipod_filename)) {
            $errors[] = '请填写视频地址';
        }
        $ipod_filename = mysql_real_escape_string($ipod_filename);
        $type = ($type === 'public') ? 'public' : 'private';
        
        if ( !$errors ) {
            $sql = "UPDATE video SET title = '{$title}',keyword = '{$keyword}',channel = '{$channel}',type = '{$type}',ipod_filename = '{$ipod_filename}',ybPlayUrl = '{$ybPlayUrl}',pic = '{$pic}' WHERE vid = {$VID} LIMIT 1;";
            $rs = $conn->execute($sql);
            if ($rs && $conn->Affected_Rows()> 0) {
                //修改后同步到上传网站
                $sql = 'SELECT zid FROM video WHERE vid = '.$VID;
                $rs = $conn->execute($sql);
                if ($rs && $conn->Affected_Rows()> 0) {
                    $zid = $rs->fields['zid'];
                    curlGetData('http://sczy1.com:8080/update',
                        http_build_query(
                            array(
                                'zid'=>$zid,
                                'title'=>$title,
                                'channel'=>$channel
                            )
                        )
                    );
                }
                $messages[] = 'Video information updated successfuly!';
            }else{
                $errors[] = 'Video information updated Failure!';
            }
        }
    }
    $sql    = "SELECT VID,title,keyword,channel,type,ipod_filename,ybPlayUrl,pic,duration FROM video WHERE VID = {$VID} LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
        $video                  = $rs->getrows();
    }
    else
        $errors[]    = 'Invalid Video ID. This video does not exist!';
}
$smarty->assign('video', $video);
$smarty->assign('channels', get_categories(array(6,7,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25)));
?>
