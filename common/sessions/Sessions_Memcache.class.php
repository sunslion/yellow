<?php
defined('_VALID') or die('Restricted Access!');
class Sessions_Memcache{
    private  $_cache,$conf;
    public function __construct($conf){
        $this->conf = $conf;
    }
    public function open(){
        $options = array(
            'host'=>$this->conf['mem_host'],
            'port'=>$this->conf['mem_port'],
            'prefix'=>'',
            'expire'=>intval($this->conf['session_lifetime']),
            'length'=>0
        );
        $this->_cache = Cache_Base::getInstance('Cache_Memcache',$options);
        if($this->_cache){
            return true;
        }
        return false;
    }
    public function close() {
        $this->_cache->close();
    }
    public function read($session_id) {
       return $this->_cache->get($session_id);
    }
    public function write($session_id, $session_data) {
       return $this->_cache->set($session_id,$session_data);
    }
    public function destroy($session_id){
       return $this->_cache->rm($session_id);
    }
    public function gc($max){
    }
}
?>