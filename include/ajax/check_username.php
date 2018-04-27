<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';

disableRegisterGlobals();
$response = array();
if ( isset($_POST['username']) ) {
    $filter     = new VFilter();
    $username   = $filter->get('username');
    $response['flag'] = '';
    //$response   = '<span class="text-danger">'.$lang['ajax.username_empty'].'</span>';
    if ( $username != '' ) {
        $sql = "SELECT UID FROM signup WHERE username = '" .mysql_real_escape_string($username). "' LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
            $response['flag'] = false;
            //$response = '<span class="text-danger">'.$lang['ajax.username_used'].'</span>';
        } else {
            $response['flag'] = true;
            //$response = '<span class="text-success">'.$lang['ajax.username_available'].'</span>';
        }
    }
    echo json_encode($response) ;
}
if ( isset($_POST['email']) ) {
    $filter     = new VFilter();
    $email   = $filter->get('email');
    $response['flag'] = '';
    if ( $email != '' ) {
        $sql = "SELECT UID FROM signup WHERE email = '" .mysql_real_escape_string($email). "' LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
            $response['flag'] = false;
        } else {
            $response['flag'] = true;
        }
    }
    echo json_encode($response) ;
}
?>