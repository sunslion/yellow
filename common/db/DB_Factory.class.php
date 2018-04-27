<?php
defined('_VALID') or die('Restricted Access!');
class DB_Factory
{
    public function createObj($type,$conf){
        switch ($type) {
            case 'AdoDB':
                $db = new DB_AdoDB($conf);
                return $db->db;
            default:
                die('没有可用的数据库操作类');
                break;
        }
    }
}
?>