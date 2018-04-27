<?php 
defined('_VALID') or die('Restricted Access!');
class AutoLoader{
    private static $config = array();
    public static function run($conf){
        self::$config = $conf;
        spl_autoload_register(array('AutoLoader','loadFile'));

        $query      = ( isset($_SERVER['QUERY_STRING']) ) ? $_SERVER['QUERY_STRING'] : '';
        $request    = str_replace(isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '', '', isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '');
        $request    = str_replace('?' .$query, '', $request);
        $request    = explode('/', trim($request, '/'));
        $control = isset($request[0]) && !empty($request[0]) ? $request[0] : 'index';
        $action = isset($request[1]) && !empty($request[1]) ? $request[1] : 'index';
        $control = ucfirst($control);
        $action = 'on'.ucfirst($action);
        if (class_exists($control) && self::classMethodExists($control, $action)) {
            $obj = new $control(self::$config);
            $obj->$action();
        }else{
            header('HTTP/1.1 404 Not Found');
            die('404');
        }
    }
    protected static function classMethodExists($class_name,$method_name){
        $methods = get_class_methods($class_name);
        foreach ($methods as $val){
            if($val === $method_name){
                return true;
            }
        }
        return false;
    }
    protected static function loadFile($className){
        $project_control = isset(self::$config['project_control']) && $className !== 'Base' ? self::$config['project_control'] .'/': '';
        $path_control = BASE_PATH.'/control/'.$project_control.$className.'Control.class.php';
        if (is_file($path_control)) {
            include $path_control;
            return true;
        }
        $project_model = isset(self::$config['project_model']) && !in_array($className, array('BaseModel','Factory')) ? self::$config['project_model'].'/' : '';
        $classNameModel = strpos($className, 'Model') !== false ? $className.'.class.php' : $className.'Model.class.php';
        $path_model = BASE_PATH.'/model/' . $project_model . $classNameModel;
        if (is_file($path_model)) {
            include $path_model;
            return true;
        }
        $path_smarty = BASE_PATH.'/include/smarty/libs/'.$className.'.class.php';
        if (is_file($path_smarty)) {
            include $path_smarty;
            return true;
        }
        if (strpos($className, '_') !== false) {
            $classNameArr = explode('_', $className);
            $path_common = BASE_PATH.'/common/'.strtolower($classNameArr[0]).'/'.$className.'.class.php';
            if (is_file($path_common)) {
                include $path_common;
                return true;
            }
        }
    }

}
