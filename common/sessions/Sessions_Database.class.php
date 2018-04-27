<?php
defined('_VALID') or die('Restricted Access!');
class Sessions_Database
{
    private $_sess_db,$conf;
    public function __construct($conf){
        $this->conf = $conf;
    }
    
    public  function open() {
        $this->_sess_db = mysql_connect($this->conf['db_host'], $this->conf['db_user'], $this->conf['db_pass']);
        if ($this->_sess_db) {
            return mysql_select_db($this->conf['db_name'], $this->_sess_db);
        }
        return true;
    }
    
    public function close() {
        return mysql_close($this->_sess_db);
    }
    
    public function read($session_id) {
        $sql = sprintf("SELECT `session_data` FROM `sessions` WHERE `session_id` = '%s'", mysql_real_escape_string($session_id));
        $result = mysql_query($sql, $this->_sess_db);
        if ($result) {
            if (mysql_num_rows($result)) {
                $record = mysql_fetch_assoc($result);
                $session_data = $record['session_data'];
                return $session_data;
            }
        }
        return '';
    }
    
    public function write($session_id, $session_data)
    {
        $time = time();
        $sql = sprintf("SELECT `session_data` FROM `sessions` WHERE `session_id` = '%s'", mysql_real_escape_string($session_id));
        $result = mysql_query($sql, $this->_sess_db);
        if ($result) {
            $sql = sprintf("REPLACE INTO `sessions` (session_id,session_expires,session_data) VALUES('%s', '%s', '%s')", mysql_real_escape_string($session_id),
                $time, mysql_real_escape_string($session_data) );
        }else{
            $sql = sprintf("INSERT INTO `sessions` (session_id,session_expires,session_data) VALUES('%s', '%s', '%s')", mysql_real_escape_string($session_id),
                $time, mysql_real_escape_string($session_data) );
        }
        return mysql_query($sql, $this->_sess_db) ? true : false;
    }
    
    public function destroy( $session_id )
    {
        $sql = sprintf("DELETE FROM `sessions` WHERE `session_id` = '%s'", $session_id);
        return mysql_query($sql, $this->_sess_db) ? true : false;
    }
    
    public function gc($max) {
        $sql = sprintf("DELETE FROM `sessions` WHERE `session_expires` < '%s'", mysql_real_escape_string(time() - $max));
        return mysql_query($sql, $this->_sess_db) ? true : false;
    }
}
?>