<?php
defined('_VALID') or die('Restricted Access!');
ini_set('session.name', 'AVS');
ini_set('session.use_cookies', 1);
ini_set('session.use_trans_sid', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.gc_maxlifetime', intval($config['session_lifetime']));


if ( $config['session_driver'] == 'Sessions_Database' ) {
    require $config['BASE_DIR']. '/classes/session.class.php';
    ini_set('session.save_handler', 'user');
    session_set_save_handler(array('Session', 'open'),
                             array('Session', 'close'),
                             array('Session', 'read'),
                             array('Session', 'write'),
                             array('Session', 'destroy'),
                             array('Session', 'gc'));
}elseif ( $config['session_driver'] == 'Sessions_Memcache' ) {
    require $config['BASE_DIR']. '/classes/memcache_sessions.class.php';
    ini_set('session.save_handler', 'user');
    session_set_save_handler(array('memcache_sessions', 'open'),
                             array('memcache_sessions', 'close'),
                             array('memcache_sessions', 'read'),
                             array('memcache_sessions', 'write'),
                             array('memcache_sessions', 'destroy'),
                             array('memcache_sessions', 'gc'));
}else {
    ini_set('session.save_handler', 'files');
    ini_set('session.save_path', $config['BASE_DIR']. '/tmp/sessions');
}

register_shutdown_function('session_write_close');
session_start();
?>
