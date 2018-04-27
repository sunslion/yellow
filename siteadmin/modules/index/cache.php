<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$allowed_acts  = array('frontend', 'backend');
$act           = ( isset($_GET['act']) ) ? $_GET['act'] : '';
if ($act!='' && !in_array($act, $allowed_acts) ) {
    $act   = NULL;
    $err    = 'Invalid page name!';
}
$num = 0;
$msg ='';
$sact = '';
if (isset($_GET['sact']) && !empty($_GET['sact']) ) {
    $sact = '/'.trim($_GET['sact']);
}
if ( $act!='' ) {
    //前后台缓存
    $file_path  = $config['BASE_DIR'] . '/cache/' . $act;
    if($act === 'frontend'){
        $file_path  .= '/'.$config['template'].$sact;
    }
    if ( file_exists($file_path) ) {
        $filesnames = scandir($file_path);
        if( count($filesnames) > 0 ) {
            foreach ($filesnames as $name) {
               $file =  $file_path . '/' . $name;
               if( file_exists($file) && is_file($file) ) {
                    @unlink($file);
                    $num++;
               }
            }
        } else {
            $msg = '缓存已经清空!';
        }
    } else {
        $msg = '文件夹不存在(' .$file_path. ')!';
    }
}

if($num == 0) {
    $msg = '文件已经清空';
}

$smarty->assign('num', $num);
$smarty->assign('msg', $msg);

?>
