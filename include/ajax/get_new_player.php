<?php
defined('_VALID') or die('Restricted Access!');
header("Content-type: text/json; charset=utf-8");
require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR'].'/classes/auth.class.php';
Auth::checkAdmin();
disableRegisterGlobals();

if (isset($_POST['type'])) {
    $type = intval($_POST['type']);
    $sql = 'SELECT * FROM new_player WHERE type ='.$type.' LIMIT 1;';
    $rs    = $conn->execute($sql);
    $result = array(
        'front_ads_guest'=>'',
        'front_ads_uri_guest'=>'',
        'front_ads_time_guest'=>'',
        'front_ads_free'=>'',
        'front_ads_uri_free'=>'',
        'front_ads_time_free'=>'',
        'front_ads_premium'=>'',
        'front_ads_uri_premium'=>'',
        'front_ads_time_premium'=>'',
        'front_ads_view'=>'',
        'stop_ads'=>'',
        'stop_ads_uri'=>'',
    );
    if($rs && $conn->Affected_Rows()>0){
        $result['front_ads_guest'] = $rs->fields['front_ads_guest'];
        $result['front_ads_uri_guest'] = $rs->fields['front_ads_uri_guest'];
        $result['front_ads_time_guest'] = $rs->fields['front_ads_time_guest'];
        $result['front_ads_free'] = $rs->fields['front_ads_free'];
        $result['front_ads_uri_free'] = $rs->fields['front_ads_uri_free'];
        $result['front_ads_time_free'] = $rs->fields['front_ads_time_free'];
        $result['front_ads_premium'] = $rs->fields['front_ads_premium'];
        $result['front_ads_uri_premium'] = $rs->fields['front_ads_uri_premium'];
        $result['front_ads_time_premium'] = $rs->fields['front_ads_time_premium'];
        $result['front_ads_view'] = $rs->fields['front_ads_view'];
        $result['stop_ads'] = $rs->fields['stop_ads'];
        $result['stop_ads_uri'] = $rs->fields['stop_ads_uri'];
    }
    echo json_encode($result);exit;
}