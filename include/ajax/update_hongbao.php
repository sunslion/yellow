<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
disableRegisterGlobals();
require $config['BASE_DIR'].'/classes/Hongbao.class.php';
$uid = round($_POST['uid']);
$hongbao = Hongbao::getUid($uid);
$amount = round($_POST['amount']);
if ($amount > $hongbao['total']) {
    echo json_encode(array('flag'=>-1));
    exit;
}
//$result = $hongbao['total'] - $amount;
if(Hongbao::updateDetotal($uid, $amount)){
    echo json_encode(array('flag'=>1));
    exit;
}
echo json_encode(array('flag'=>2));
exit;