<?php
defined('_VALID') or die('Restricted Access!');
class DB_AdoDB
{
    public  $db;
    function __construct($conf = array()){
        if (empty($conf)) {
           die('数据库选项不能为空');
        }
        $options = array('db_type','db_host','db_user','db_pass','db_name');
        foreach ($options as $v) {
            if (!isset($conf[$v]) || empty($conf[$v])) {
                die('数据库项'.$v.'没有设置或为空!');
            }
        }
        include BASE_PATH.'/include/adodb/adodb.inc.php';
        $this->db = ADONewConnection($conf['db_type']);
        $this->db->memCache = true;
        $this->db->memCacheHost = $conf['mem_host'];
        $this->db->memCachePort = $conf['mem_port'];
        if ( !$this->db->PConnect($conf['db_host'], $conf['db_user'], $conf['db_pass'], $conf['db_name']) ) {
            die('Could not connect to mysql! Please check your database settings!');
        }
        $this->db->execute("SET NAMES 'utf8'");
    }
}
?>