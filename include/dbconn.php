<?php
defined('_VALID') or die('Restricted Access!');

$conn = ADONewConnection($config['db_type']);
//$authDB = ADONewConnection($config['authDB_type']);
//$BBSDB = ADONewConnection($config['BBS_type']);

$conn->memCache = true;
$conn->memCacheHost = $config['mem_host'];
$conn->memCachePort = $config['mem_port'];
if ( !$conn->PConnect($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']) ) {
    echo 'Could not connect to mysql! Please check your database settings!';
    die();
}

/*
if ( !$authDB->NConnect($config['authDB_host'], $config['authDB_user'], $config['authDB_pass'], $config['authDB_name']) ) {
    echo 'Error:AuthDB';
    die();
}

if ( !$BBSDB->PConnect($config['BBS_host'], $config['BBS_user'], $config['BBS_pass'], $config['BBS_name']) ) {
    echo 'Error:BBSDB';
    die();
}
*/

$conn->execute("SET NAMES 'utf8'");
//$authDB->execute("SET NAMES 'utf8'");
//$BBSDB->execute("SET NAMES 'utf8'");
?>
