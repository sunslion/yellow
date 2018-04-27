<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

require $config['BASE_DIR']. '/include/config.template.php';
if ( isset($_POST['submit_settings']) ) {
require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/classes/validation.class.php';

    $filter                 = new VFilter();
    $synctime         = $filter->get('synctime', 'INTEGER');
	   
    if ( $synctime == '' ) {
        $errors[]   = '你必须设置同步时间，并且必须大于0';
    }
	
    if ( !$errors ) {
        $config['synctime']            = $synctime;
        update_config($config);
        update_smarty();    
        $messages[] = '修改完成';
    }
  
}
$smarty->assign('templates', $templates);
?>
