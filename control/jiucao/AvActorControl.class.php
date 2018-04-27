<?php
defined('_VALID') or die('Restricted Access!');
class AvActor extends Base{
    public function onIndex(){
        $where .=" ORDER BY `orderby` ASC , `addtime` DESC";
        $sql = "SELECT *  FROM avactor ".$where;
        $sugetModel = $this->modelFactory->get('GetSuget');
        $avactor = $sugetModel->getAll($sql);
        foreach ($avactor as $k=>&$v){
            if(is_array($v)&&$v){
                    $url = $this->codeUrl($v['name'],$v['japan_name']);
                    $v['url'] = '/search?kd='.$url;
            }
        }
        $this->pushAssigns(array('avactor' => $avactor, 'CHID' => '8080'));
        $this->tpls = array('av/index.tpl');
    }
    public function codeUrl($name,$japan_name){
        $name = trim($name);
        $japan_name = trim($japan_name);
        $name = str_replace(['(',')','（','）'],'',$name);
        $name = str_replace('/','-',$name);
        $japan_name = str_replace(['(',')','（','）'],'',$japan_name);
        $japan_name = str_replace('/','-',$japan_name);
        if($name&&$japan_name){
            return $name.'-'.$japan_name;
        }else if($name){
            return $name;
        }else{
            return $japan_name;
        }
    }
}
?>
