<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
$video = array('pic' => '', 'title' => '', 'category' => 0, 'tags' => '',
               'type' => 'public', 'duration' => '', 'ipod_filename','ybPlayUrl');
if (isset($_POST['embed_video'])) {
    require $config['BASE_DIR']. '/classes/filter.class.php';
    $filter     	= new VFilter();
	$title			= $filter->get('title');
	$tags			= $filter->get('tags');
	$type			= $filter->get('type');
	$category		= $filter->get('category', 'INT');
    $ipod_filename  = $filter->get('ipod_filename');
    $ybPlayUrl      = $filter->get('ybPlayUrl');
    $pic            = $filter->get('pic');
	
    if ( empty($title)) {
        $errors[]           = 'Please enter a video title!';
    }
    $title = mysql_real_escape_string($title);
    if ( $category === 0 ) {
        $errors[]           = 'Please select a video category!';
    } 

	$tags	= prepare_string($tags, false);
	$tags   = mysql_real_escape_string($tags);
	if (empty($pic)) {
	    $errors[]  = '请填写图片地址';
	}
	$pic = mysql_real_escape_string($pic);
	if (empty($ipod_filename)) {
	    $errors[] = '请填写视频地址';
	}
	$ipod_filename = mysql_real_escape_string($ipod_filename);

	$type = ($type === 'public') ? 'public' : 'private';
	if (!$errors) {
	    $vkey = mt_rand();
	    $addtime = time();
	    $rad = mt_rand(1,800000000);
	    $zid = strval($addtime.'_'.$rad);
	    $sql = "INSERT INTO video (title,keyword,channel,ipod_filename,ybPlayUrl,pic,type,vkey,addtime,active,zid) VALUES (
	                               '{$title}','{$tags}','{$category}','{$ipod_filename}','{$ybPlayUrl}','{$pic}','{$type}','{$vkey}','{$addtime}',0,'{$zid}')";
		$rs = $conn->execute($sql);
		$vid = mysql_insert_id();
		if($rs && $conn->Affected_Rows()> 0){
		    $sql = 'SELECT COUNT(VID) AS total FROM video WHERE channel = '.$category.' LIMIT 1;';
		    $rs = $conn->execute($sql);
		    $count = 0;
		    if($rs && $conn->Affected_Rows()> 0){
		        $count = (int)$rs->fields['total'];
		    }
		    $sql = 'UPDATE channel SET total_videos = '.$count.' WHERE CHID = '.$category.' LIMIT 1';
		    $rs = $conn->execute($sql);
		    
		    $path = $config['BASE_DIR'] . '/cache/syn/add';
		    if (!file_exists($path)) {
		        mkdir($path,0777,true);
		    }
		    $fileName = $path.'/add_'.time().'.txt';
		    $data = array(
		        'm_id'=>$vid,
		        'm_name'=>$title,
		        'm_type'=>$category,
		        'm_pic'=>$pic,
		        'm_playdata'=>$ipod_filename,
		        'm_keyword'=>$tags
		    );
		    if (file_exists($path)) {
		        file_put_contents($fileName,json_encode($data));
		    }
            $messages[] = 'Successfuly embeded video!';
		}else{
		    $errors[] = 'Failure embeded video!';
		}
	}
}

function duration_to_seconds($duration)
{
    $dur_arr  = explode(':', $duration);
    if (!isset($dur_arr['1'])) {
        return FALSE;
    }
                    
    $duration = 0;
    if (isset($dur_arr['2'])) {
        $duration = ((int) $dur_arr['2']*3600);
    }

    $duration = $duration + ((int)$dur_arr['0']*60);

    return ($duration + (int)$dur_arr['1']);
}

$smarty->assign('video', $video);
$smarty->assign('categories', get_categories(array(6,7,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25)));
?>
