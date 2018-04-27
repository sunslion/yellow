<?php
defined('_VALID') or die('Restricted Access!');
//require_once 'Cache.class.php';
class Session
{
    private static $_sess_db,$_cache;

    public static function open() {
        global $config;    
        $options = array(
            'host'=>$config['mem_host'],
            'port'=>$config['mem_port'],
            'prefix'=>'ses',
            'expire'=>intval($config['session_lifetime']),
            'length'=>0
        );
        self::$_cache = Cache::getInstance('MemcacheAction',$options);
        self::$_sess_db = mysql_connect($config['db_host'], $config['db_user'], $config['db_pass']);
        if (self::$_sess_db) {
            return mysql_select_db($config['db_name'], self::$_sess_db);
        }
        return false;
    }

    public static function close() {
        self::$_cache->close();
        return mysql_close(self::$_sess_db);
    }

    public static function read($session_id) {
        $value = self::$_cache->get($session_id);
        if($value){
            return $value;
        }
        $sql = sprintf("SELECT `session_data` FROM `sessions` WHERE `session_id` = '%s'", mysql_real_escape_string($session_id));
        $result = mysql_query($sql, self::$_sess_db);
        if ($result) {
            if (mysql_num_rows($result)) {
                $record = mysql_fetch_assoc($result);
                $session_data = $record['session_data'];
                self::$_cache->set($session_id,$session_data);
                return $session_data;
            }
        }
        return '';
    }

    public static function write($session_id, $session_data)
    {
        $time = time();
        self::$_cache->set($session_id,$session_data);
        $sql = sprintf("SELECT `session_data` FROM `sessions` WHERE `session_id` = '%s'", mysql_real_escape_string($session_id));
        $result = mysql_query($sql, self::$_sess_db);
        if ($result) {
            $sql = sprintf("REPLACE INTO `sessions` (session_id,session_expires,session_data) VALUES('%s', '%s', '%s')", mysql_real_escape_string($session_id),
                $time, mysql_real_escape_string($session_data) );
        }else{
        
	       $sql = sprintf("INSERT INTO `sessions` (session_id,session_expires,session_data) VALUES('%s', '%s', '%s')", mysql_real_escape_string($session_id),
						$time, mysql_real_escape_string($session_data) );
        }
        return mysql_query($sql, self::$_sess_db);
	}

    public static function destroy( $session_id )
    {
        self::$_cache->_unset($session_id);
	    $sql = sprintf("DELETE FROM `sessions` WHERE `session_id` = '%s'", $session_id);
		return mysql_query($sql, self::$_sess_db);
	}
    
    public static function gc($max) {
	    $sql = sprintf("DELETE FROM `sessions` WHERE `session_expires` < '%s'", mysql_real_escape_string(time() - $max));
		return mysql_query($sql, self::$_sess_db);
	}
}
?>