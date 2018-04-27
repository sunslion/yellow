<?php
defined('_VALID') or die('Restricted Access!');
class Factory
{
    private $conf;
    function __construct($conf=array()){
        $this->conf = $conf;
    }
    public function get($mix){
        if (!is_string($mix) || empty($mix)) {
            die('请传字符串并且不能为空字符串');
        }
        $model = ucfirst($mix).'Model';
        return new $model($this->conf);
    }
}
?>