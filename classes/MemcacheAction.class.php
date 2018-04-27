<?php
class MemcacheAction extends Cache
{
    protected static $_instance = null;
    function __construct($options=array()){
        if (!extension_loaded('memcache')){
            die('Memcache模块不存在');
        }
        $options = array_merge(array(
            'host' => '127.0.0.1',
            'port' => '11211',
            'timeout' => 1,
            'persistent' => true
        ),$options);
        $this->options = $options;
        $this->options['prefix'] = $options['prefix'];
        $this->options['expire'] = $options['expire'];
        $this->options['length'] = $options['length'];
        $this->handler = self::getMenInstance($this->options);
    }
    
    private static function getMenInstance ($options){
        if (null === self::$_instance){
            $func = $options['persistent'] ? 'pconnect' : 'connect';
            self::$_instance = new Memcache();
            $options['timeout'] === false ?
            self::$_instance->$func($options['host'],$options['port']) :
            self::$_instance->$func($options['host'],$options['port'],$options['timeout']);
        }
        return self::$_instance;
    }
    public function get($name){
        return $this->handler->get($this->options['prefix'].$name);
    }
    
    public function set($name,$value,$expire=null) {
        if (is_null($expire)){
            $expire = $this->options['expire'];
        }
        $name = $this->options['prefix'].$name;
        if ($this->handler->set($name, $value,0,$expire)) {
            return true;
        }
        return false;
    }
    public function rm($name,$ttl = false){
        $name = $this->options['prefix'].$name;
        return $ttl === false ?$this->handler->delete($name):$this->handler->delete($name,$ttl);
    }
    public function clear(){
        return $this->handler->flush();
    }
    public function close(){
        return $this->handler->close();
    }
}

?>