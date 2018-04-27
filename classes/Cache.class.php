<?php 
class Cache{
    
    public  $handler;
    
    public $options = array();
    
    function connect($type = '',$options=array()){
        if (empty($type))
            die('没有指定缓存类型方式');
        require_once $type.'.class.php';
        if (class_exists($type)) {
            $cache = new $type($options);
        }else{
            die('缓存类型方式不存在');
        }
        return $cache;
    }
    
    static function getInstance($type='',$options=array()){
        static $_instance = array();
        $guid = $type.to_guid_string($options);
        if (!isset($_instance[$guid])) {
            $obj = new Cache();
            $_instance[$guid] = $obj->connect($type,$options);
        }
        return $_instance[$guid];
    }
    
    public function get($name){
      return $this->get($name);
    }
    
    public function set($name,$value){
        $this->set($name,$value);
    }
    
    public function _unset($name){
        $this->rm($name);
    }
    public function getOptions($name){
        $this->options[$name];
    }
    public function clear(){
        $this->clear();
    }
    public function close(){
        $this->close();
    }
}