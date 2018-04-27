<?php
defined('_VALID') or die('Restricted Access!');
header("Content-type: text/json; charset=utf-8");
require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/classes/MailEvent.class.php';
require $config['BASE_DIR'].'/classes/auth.class.php';
Auth::checkAdmin();
disableRegisterGlobals();
if (isset($_POST['receiver'])) {
    $filter     = new VFilter();
    $receiver = $filter->get('receiver');
    $subject = $filter->get('subject');
    $body = $filter->get('body');
    $options = array(
        'sender' =>'管理员',
        'receiver'=>$receiver,
        'subject'=>$subject,
        'body'=>$body
    );
    if(MailEvent::add($options)){
        MailEvent::listen();
        $response['flag'] = 1;
    }else{
        $response['flag'] = 0;
    }
    echo json_encode($response);
    exit;
}