<?php
defined('_VALID') or die('Restricted Access!');

$sql = "SELECT * from adv_group ORDER BY advgrp_id DESC LIMIT 1";
$rs=$conn->execute($sql);
$last_index=$rs->fields['advgrp_id'];

//echo $last_index; die();


$sql = "SELECT advgrp_name FROM adv_group WHERE advgrp_name = 'mobile_footer' LIMIT 1";
$conn->execute($sql);
if(mysql_affected_rows() !=1) {
  $last_index++;
  $sql="INSERT INTO adv_group SET advgrp_id = '".$last_index."', advgrp_name = 'mobile_footer'";
  $conn->execute($sql);
}

$sql = "SELECT advgrp_name FROM adv_group WHERE advgrp_name = 'mobile_video' LIMIT 1";
$conn->execute($sql);
if(mysql_affected_rows()<1) {
  $last_index++;
  $sql="INSERT INTO adv_group SET advgrp_id = '".$last_index."', advgrp_name = 'mobile_video'";
  $conn->execute($sql);
}

$sql = "SELECT advgrp_name FROM adv_group WHERE advgrp_name = 'mobile_photo' LIMIT 1";
$conn->execute($sql);
if(mysql_affected_rows()<1) {
  $last_index++;
  $sql="INSERT INTO adv_group SET advgrp_id = '".$last_index."', advgrp_name = 'mobile_photo'";
  $conn->execute($sql);
}

$sql = "SELECT advgrp_name FROM adv_group WHERE advgrp_name = 'mobile_browse_videos' LIMIT 1";
$conn->execute($sql);
if(mysql_affected_rows()<1) {
  $last_index++;
  $sql="INSERT INTO adv_group SET advgrp_id = '".$last_index."', advgrp_name = 'mobile_browse_videos'";
  $conn->execute($sql);
}

?>