<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

if ( isset($_POST['add_adv_group']) && !$errors ) {
    $name = mysql_real_escape_string(trim($_POST['name']));
    $width      = mysql_real_escape_string(trim($_POST['width']));
    $height     = mysql_real_escape_string(trim($_POST['height']));
    $position  = mysql_real_escape_string(trim($_POST['position']));
    $position_top = mysql_real_escape_string(trim($_POST['position_top']));
    $position_bottom = mysql_real_escape_string(trim($_POST['position_bottom']));
    $position_left_right = mysql_real_escape_string(trim($_POST['position_left_right']));
    $ismobile = mysql_real_escape_string(trim($_POST['ismobile']));
    intval($ismobile)?$ismobile=intval($ismobile):$ismobile=0;//是否为手机端
    $currtime = time();
    $sql  = "INSERT INTO adv_zone(name,width,height,position,position_top,position_bottom,position_left_right,addtime,ismobile) VALUES 
	           ('{$name}','{$width}','{$height}','{$position}','{$position_top}','{$position_bottom}','{$position_left_right}',{$currtime},$ismobile)";
    $rs = $conn->execute($sql);
    if ($rs) {
        write_ads_cache();
        $msg = '广告位置添加成功!';
        VRedirect::go('index.php?msg=' . $msg . '&m=advzone');
    }else{
        $msg = '广告位置添加失败!';
        VRedirect::go('index.php?err=' . $msg . '&m=advzone');
    }
}
