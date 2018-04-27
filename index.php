<?php
define('_VALID','AUTO_LOADER_RUN');
define('BASE_PATH', dirname(__FILE__));
include BASE_PATH.'/include/debug.php';
include BASE_PATH.'/include/config.db.php';
include BASE_PATH.'/include/config.local.php';
require BASE_PATH.'/include/security.php';
include BASE_PATH.'/include/function_global.php';
include 'AutoLoader.php';
//print_r($config);
//$arr = array('mem_host','mem_port','authDB_type','authDB_host','authDB_user','authDB_name','BBS_type','BBS_host','BBS_user','BBS_pass','BBS_name','authDB_pass','session_name','session_lifetime','session_driver');
if(isset($arr) && implode('',$arr)){
    foreach ($arr as $k=>$v){
        unset($config[$v]);    
    }
}
//print_r($config);exit; 
AutoLoader::run($config);