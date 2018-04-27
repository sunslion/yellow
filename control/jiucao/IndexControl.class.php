<?php
defined('_VALID') or die('Restricted Access!');
class Index extends Base{
    public function onIndex() {
        $videoMode = $this->modelFactory->get('video');
        $channelMode = $this->modelFactory->get('channel');
        //实例化推荐类
        $sugetModel = $this->modelFactory->get('GetSuget');
        //获取AV女优总条数
        $sql = "SELECT COUNT(*) as avNum FROM avactor";
        $avactor = $sugetModel->getAll($sql);
        //最新更新
        $key = 'index_newVideoList1';
        $newVideoList = $this->cache->get($key);
        if (!$newVideoList) {
            $newVideoList = $videoMode->getAll('',0,6,'vid desc');
            $this->cache->set($key,$newVideoList,3600);
        }
        //设置虚拟的观看数-踩、赞的数量
        if(is_array($newVideoList)&&$newVideoList[0]['VID']){
            foreach ($newVideoList as $k=>&$v){
                $v['viewnumber'] =  $sugetModel->getViewNum($v['viewnumber']);
                $v['likes'] = $sugetModel->getLike($v['viewnumber'],$v['likes']);
                $v['dislikes'] = $sugetModel->getDislike($v['viewnumber'],$v['dislikes']);
                $v['pic'] = str_replace($sugetModel->get_domain($v['pic']),$this->conf['img_domin'],$v['pic']);//替换域名
            }
        }
        $this->pushAssigns(array('newvideolist'=>$newVideoList));
        //其他大娄的最新视频
        $key = 'index_videos1';
        $videoList = $this->cache->get($key);
        if(!$videoList){
            $channelList = $channelMode->getAll();
            $i = 0;
            foreach ($channelList as $k=>$v) {
               // if (!in_array($v['CHID'], array(6,7))) {
                    $videoList[$i]['CHID'] = $v['CHID'];
                    $videoList[$i]['name'] = $v['name'];
                    $videos = $videoMode->getAll("channel={$v['CHID']}",0,6,'VID desc');
                    $videoList[$i]['videos'] = $videos;
                    $i++;
               // }
            }
            unset($channelList);
            $this->cache->set($key,$videoList,3600);
        }
        $seo = array(
            'title'=>$this->conf['site_title'],
            'keyword'=>$this->conf['meta_keywords'],
            'description'=>$this->conf['meta_description'],
        );
        //设置虚拟的观看数、顶、踩
        if(is_array($videoList)&&$videoList[0]['videos'][0]['VID']){
            foreach($videoList as $k=>&$v){
                foreach ($v['videos'] as $k2=>&$v2){
                    $v2['viewnumber'] = $sugetModel->getViewNum($v2['viewnumber']);
                    $v2['likes'] = $sugetModel->getLike($v2['viewnumber'],$v2['likes']);
                    $v2['dislikes'] = $sugetModel->getDislike($v2['viewnumber'],$v2['dislikes']);
                    $v2['pic'] = str_replace($sugetModel->get_domain($v2['pic']),$this->conf['img_domin'],$v2['pic']);//替换域名
                }
            }
        }
        $this->pushAssigns($seo);
        $this->pushAssigns(array('indexvideolist'=>$videoList,'avNum'=>$avactor[0]['avNum']));
        $this->tpls = array('v.tpl');
    }


}