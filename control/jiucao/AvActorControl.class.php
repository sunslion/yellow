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
    //图库列表
    public function onAvlist(){
        $find = array('，',',');
        $sugetModel = $this->modelFactory->get('GetSuget');
        $where  =" WHERE push=1  ORDER BY `orderNum` ASC , `addtime` DESC";
        $sql = "SELECT * FROM av_actor ".$where;
        $avactorPush = $sugetModel->getAll($sql);
        //all
        $where  =" ORDER BY `orderNum` ASC , `addtime` DESC";
        $sql = "SELECT t1.*,t2.name,t2.japan_name,t2.id actor_id FROM av_actor_fpic t1 LEFT JOIN av_actor t2 ON t1.aid=t2.id ".$where;
        $sugetModel = $this->modelFactory->get('GetSuget');
        $avactor = $sugetModel->getAll($sql);
        foreach ($avactor as $k=>&$v){
            $v['tag'] = str_replace($find,',',$v['tag']);
            $v['tag'] = explode(',',$v['tag']);
            $sqlCount = "SELECT count(*) imgCount FROM av_actor_pic WHERE aid = '{$v['id']}' ";
            $imgCount = $sugetModel->getAll($sqlCount);
            $imgCount[0]['imgCount']?$v['imgCount'] = $imgCount[0]['imgCount']:$v['imgCount'] = 0;
        }
        $this->pushAssigns(array('avactorPush' => $avactorPush));
        $this->pushAssigns(array('avactor' => $avactor));
        $this->tpls = array('av/avAcotr/index.tpl');
    }
    //图库介绍
    public function onAvintro(){
        $actor_id= get_request_arg('actor_id');
        $actor_id = intval($actor_id);
        $sugetModel = $this->modelFactory->get('GetSuget');
        $find = array('，',',');
        $where = " WHERE t1.aid = $actor_id ORDER BY `orderNum` ASC , `addtime` DESC ";//排序 第一优序列号排序 第二优先时间倒序 ";
        $sql = "SELECT
                    t1.*, t2.`name`,
                    t2.`japan_name`,
                    t2.`id` actor_id,
                    (
                        SELECT
                            count(*)
                        FROM
                            av_actor_pic t3
                        WHERE
                            t3.aid = t1.id
                    ) imgCount
                FROM
                    av_actor_fpic t1
                LEFT JOIN av_actor t2 ON t2.id = $actor_id ".$where;
        $list = $sugetModel->getAll($sql);
        foreach ($list as $k=>&$v){
            $v['tag'] = str_replace($find,',',$v['tag']);
            $v['tag'] = explode(',',$v['tag']);
        }
        $sql = "SELECT * FROM av_actor WHERE id='{$actor_id}' LIMIT 1 ";
        $avactor = $sugetModel->getAll($sql);
        $this->pushAssigns(array('avactor' => $avactor[0], 'list' => $list));
        $this->tpls = array('av/avAcotr/intro.tpl');
    }
    //图库详情
    public function onAvdesc(){
        $id = get_request_arg('id');//专辑id
        $actor_id= get_request_arg('actor_id');//女优id
        $id = intval($id);
        $actor_id = intval($actor_id);
        $sugetModel = $this->modelFactory->get('GetSuget');
        $sql = "SELECT
                    t1.*, t2.`japan_name`,
                    t2.`name`,
                    (
                        SELECT
                            COUNT(*)
                        FROM
                            av_actor_pic t3 
                        WHERE t3.aid = $id
                    ) imgCount
                FROM
                    av_actor_fpic t1
                LEFT JOIN av_actor t2 ON t2.id = $actor_id
                WHERE
                    t1.id = $id LIMIT 1";
        $list = $sugetModel->getAll($sql);
        $where = "ORDER BY id ASC";
        $sql = "SELECT * FROM av_actor_pic  WHERE `aid` = $id ".$where;
        $imgArr = $sugetModel->getAll($sql);
        $this->pushAssigns(array('list' => $list[0], 'imgArr' => $imgArr));
        $this->tpls = array('av/avAcotr/desc.tpl');
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
