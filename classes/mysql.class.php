<?php
class mysql{
    static $_instance = false;
    public static function getLink($fun,$argHostname, $argUsername, $argPassword,$newLink = fase,$clientFlags = 0) {
        if (self::$_instance === false) {
            switch ($fun) {
                case 'mysql_connect':
                    self::$_instance = mysql_connect($argHostname,$argUsername,$argPassword,$newLink,$clientFlags);
                    break;
                case 'mysql_pconnect':
                    self::$_instance = mysql_pconnect($argHostname,$argUsername,$argPassword,$clientFlags);
		    if( !self::$_instance )
			var_dump(mysql_error());		
                    break;
            }
        }
        return self::$_instance;
    }
}
