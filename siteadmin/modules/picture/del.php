<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
$vid = intval($_GET['vid']);
$sql = 'SELECT description FROM picture WHERE VID = '.$vid.' LIMIT 1';
$rs = $conn->execute($sql);
if ($rs && $conn->Affected_Rows() > 0) {
    $des = $rs->fields['description'];
    $des = strip_tags($des,'<img>');
    if (preg_match_all('/<img.*?src="(.*?)".*?>/is', $des,$matches)) {
      if (isset($matches[1])) {
          foreach ($matches[1] as $v) {
              $v = $config['BASE_DIR'].$v;
              if(file_exists($v)){
                  unlink($v);
              }
          }
      }  
    }
}
$sql = "DELETE FROM picture WHERE VID = {$vid};";
$rs = $conn->execute($sql);
if ($rs && $conn->Affected_Rows() > 0) {
    $msg = '删除改成功!';
    VRedirect::go('picture.php?msg=' . $msg . '&m=list');
}else {
    $msg = '删除改失败!';
    VRedirect::go('picture.php?msg=' . $msg . '&m=list');
}