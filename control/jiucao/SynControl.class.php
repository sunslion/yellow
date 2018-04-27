<?php
defined('_VALID') or die('Restricted Access!');
class Syn extends Base{
    public function onResponse(){
       header("Content-type: text/json;charset=gbk");
       $t = intval($_REQUEST['t']);
       $path = $this->getPath($t);
       $rs = $this->getData($path);
       echo $rs;exit;
    }
    public function onReturn(){
        $t = intval($_REQUEST['t']);
        $path = $this->getPath($t);
        $filestr = '';
        if (isset($_REQUEST['f']) && !empty($_REQUEST['f'])) {
            $files = explode(',', $_REQUEST['f']);
            foreach ($files as $f){
                $file = $path.'/'.$f;
                if(file_exists($file)){
                    unlink($file);
                }
            }
            echo 1;
        }else{
            echo 0;
        }
        exit;
    }
    private function getPath($t){
        $path = '';
        switch ($t) {
            case 1:
                $path = BASE_PATH . '/cache/syn/add';
                break;
            case 2:
                $path = BASE_PATH . '/cache/syn/update';
                break;
            case 3:
                $path = BASE_PATH . '/cache/syn/del';
                break;
            default:
                break;
        }
        return $path;
    }
    private function getData($path){
        if (file_exists($path)) {
            $fileList = glob($path.'/*');
            $data = array();
            foreach ($fileList as $v) {
                $content = file_get_contents($v);
                if (empty($content)) {
                    continue;
                }
                $arr = json_decode($content,true);
                if (!$arr) {
                    continue;
                }
                $infos = pathinfo($v);
                $data[$infos['basename']] = $arr;
            }
            return json_encode($data);
        }
        return '';
    }
}
?>