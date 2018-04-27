<?php
defined('_VALID') or die('Restricted Access!');
class Sessions_File
{
    public static function session_set_save_handler($conf){
        ini_set('session.save_handler', 'files');
        ini_set('session.save_path', $conf['BASE_DIR']. '/tmp/sessions');
    }
}
?>