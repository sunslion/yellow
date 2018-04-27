<?php
class Sessions_Control{
    public static function init($type,$conf = array()){
        ini_set('session.name', $conf['session_name']);
        ini_set('session.use_cookies', 1);
        ini_set('session.use_trans_sid', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.cookie_httponly', 1);
        ini_set('session.gc_maxlifetime', intval($conf['session_lifetime']));
        if (class_exists($type)) {
            $session = new $type($conf);
            ini_set('session.save_handler', 'user');
            $result = session_set_save_handler(
                array($session,"open"),
                array($session,"close"),
                array($session,"read"),
                array($session,"write"),
                array($session,"destroy"),
                array($session,"gc")
            );
            if ($result){
                register_shutdown_function('session_write_close');
                session_start();
            }
        }
    } 
}
?>