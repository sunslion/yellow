<?php
defined('_VALID') or die('Restricted Access!');
class Video extends Base{
    public function onIndex(){
        $chid = get_request_arg('cid');
        $page = get_request_arg('p');
        $page = $page < 1 ? 1 : $page;
        $channels = $this->getChannels();
        $channelName = '';
        foreach ($channels as $v) {
            if ($v['CHID'] == $chid) {
                $channelName = $v['name'];
                break;
            }
        }
        $key = 'video1_'.$chid.'_'.$page;
        if (is_mobile()) {
            $key = 'm_'.$key;
        }
        $output = $this->cache->get($key);
        if (!$output['videolist']) {
            $pagesize = 21;
            $pageindex = ($page -1) * $pagesize;
            $where = 'channel='.$chid;
            $videoModel = $this->modelFactory->get('video');
            $total = $videoModel->getTotal($where);
            $pagination = new Libs_Pagination($total,$page,$pagesize);
            $pageHtml = $pagination->getPagination('/video/index/cid/'.$chid);
            $videoList = $videoModel->getAll($where,$pageindex,$pagesize,'VID desc');
            $output['pages'] = $pageHtml;
            $output['videolist'] = $videoList;
            $this->cache->set($key,$output,3600);
        }
        $seo = array(
            'title'=>$this->conf['site_title'],
            'keyword'=>$this->conf['meta_keywords'],
            'description'=>$this->conf['meta_description'],
        );
        //设置虚拟的观看数、顶、踩
        if(is_array($output['videolist'])&&$output['videolist'][0]['VID']){
            //实例化推荐类
            $sugetModel = $this->modelFactory->get('GetSuget');
            foreach($output['videolist'] as $k=>&$v){
                $v['viewnumber'] = $sugetModel->getViewNum($v['viewnumber']);
                $v['likes'] = $sugetModel->getLike($v['viewnumber'],$v['likes']);
                $v['dislikes'] = $sugetModel->getDislike($v['viewnumber'],$v['dislikes']);
                $v['pic'] = str_replace($sugetModel->get_domain($v['pic']),$this->conf['img_domin'],$v['pic']);//替换域名
            }
        }
        //获取AV女优总条数
        $sql = "SELECT COUNT(*) as avNum FROM avactor";
        $avactor = $sugetModel->getAll($sql);
        $this->pushAssigns($seo);
        $this->pushAssigns(array('videolist'=>$output['videolist'],'pages'=>$output['pages'],'channelname'=>$channelName,'CHID'=>$chid,'avNum'=>$avactor[0]['avNum']));
        $this->tpls = array('header.tpl','videos.tpl','footer.tpl');
    }
    public function onShow(){
        global $seo;
        $id = get_request_arg('id');
        get_request_arg('type')==2?$type=2:$type=1;//默认type=1 ck播放 2是优播
        $key = 'video_'.$id;
        $output = $this->cache->get($key);
        if(!$output['video']){
            $videoModel = $this->modelFactory->get('video');
            $videos = $videoModel->getAll('VID='.$id,0,1);
            if ($videos && isset($videos[0])) {
                //更新观看次数
                $re = $videoModel->setInc('viewnumber',1,'VID='.$id);

                $output['video'] = $videos[0];
                $channelName = '';
                $channels = $this->getChannels();
                foreach ($channels as $v) {
                    if($v['CHID'] == $videos[0]['channel']){
                        $channelName = $v['name'];
                        break;
                    }
                }
                $output['cname'] = $channelName;
                //相关视频
                $relatedvideos = $this->getRelatedVideos($videos[0]['VID']);
                $output['relatedvideos'] = $relatedvideos['videos'];
                $output['relatecount'] = $relatedvideos['total'];
                $output['id'] = $id;
                $self_title         = $relatedvideos['videos'][0]['title'] . $seo['video_title'];
                $self_keywords      = $relatedvideos['videos'][0]['keyword'] . $seo['video_keywords'];
                $output['self_title'] = $self_title;
                $output['self_keywords'] = $self_keywords;
                $this->cache->set($key,$output,3600);
            }
        }
        $output['host'] = isset($_SERVER['HTTP_HOST']) ? 'http://'.$_SERVER['HTTP_HOST'] : '';
        $title = '';
        $keyword = '';
        $des = '';
        if(isset($output['video']) && isset($output['video']['title']) && !empty($output['video']['title'])) {
            $title = $output['video']['title'].'-'.$this->conf['site_title'];
        }else{
            $title = $this->conf['site_title'];
        }
        if (isset($output['video']) && isset($output['video']['keyword']) && !empty($output['video']['keyword'])) {
            $keyword = $this->conf['meta_keywords'].','.$output['video']['keyword'];
        }else{
            $keyword = $this->conf['meta_keywords'];
        }
        if (isset($options['video']) && isset($output['video']['des']) && !empty($output['video']['des'])) {
            $des = $output['video']['des'];
        }else{
            $des = $this->conf['meta_description'];
        }
        $seo = array(
            'title'=>$title,
            'keyword'=>$keyword,
            'description'=>$des,
            'CHID'=>isset($output['video']) ? $output['video']['channel']:0
        );
        //实例化推荐类
        $sugetModel = $this->modelFactory->get('GetSuget');
        $suggestVideo = $sugetModel->getSugetVideo(23);
        $suggestVideoA = array_slice($suggestVideo,0,20,true);//推荐20个视频
        $suggestVideoB = array_slice($suggestVideo,20,23,true);//推荐3个视频
        $suggestVideoB ? $suggestVideoB =  array_values($suggestVideoB) : $suggestVideoB =  array();
        //重新赋值顶和踩数目
        if(is_array($output['video'])&&$output['video']['VID']){
            $output['video']['viewnumber'] = $sugetModel->getViewNum($output['video']['viewnumber']);
            $output['video']['likes'] = $sugetModel->getLike($output['video']['viewnumber'],$output['video']['likes']);
            $output['video']['dislikes'] = $sugetModel->getDislike($output['video']['viewnumber'],$output['video']['dislikes']);
        }
        $output['type'] =  $type;
        $this->pushAssigns(array('suggestVideo'=>$suggestVideoA,'videocount'=>20));
        $this->pushAssigns(array('suggestVideoB'=>$suggestVideoB));
        $this->pushAssigns($seo);
        $this->pushAssigns($output);
        $this->tpls = array('video.tpl');
    }
    
    public function onYbGuide(){
        $this->tpls = array('ybGuide.tpl');
    }
    public function onYbGuide_Ios(){
        $this->tpls = array('ybGuide_Ios.tpl');
    }

    protected function getRelatedVideos($id,$page=1){
        //获取当前数据
        $videoModel = $this->modelFactory->get('video');
        $videos = $videoModel->getAll('VID = '.$id,0,1);
        if ($videos && isset($videos[0])) {
            $page = round($page);
            $page = $page <= 0 ? 1 :$page;
            if ($page >= 5) {
                return false;
            }
            $pagesize = 4;
            $pageindex = ($page - 1) * $pagesize;

            $channel = $videos[0]['channel'];
            $title = $videos[0]['title'];
            $where = 'channel = \''.$channel.'\' AND (locate(\''.$title.'\',title) > 0 OR locate(\''.$title.'\',keyword)) AND VID !='.$id;
            $result = array();
            $result['total'] = $videoModel->getTotal($where);
            $result['videos'] = $videoModel->getAll($where,$pageindex,$pagesize,'addtime DESC');
            return $result;
        }
        return false;
    }
    public function onAjax_related_videos(){
        $filter = new Libs_Filter();
        $id = $filter->get('id','INTEGER');
        $page = $filter->get('p','INTEGER');
        $relatedVideos = $this->getRelatedVideos($id,$page);
        if ($relatedVideos) {
            $output['relatedvideos'] = $relatedVideos['videos'];
        }else{
            $output['relatedvideos'] = array();
        }
        $this->pushAssigns($output);
        $this->tpls = array('related_videos.tpl');
    }
    public function onAjax_play(){
        //ajax模式
        $this->isajax = 1;
        //每部影片不同时间需要的色币也不一样
        $timeToSebi = array(
            0=>array(0,60),
            1=>array(60,1800),
            2=>array(1800,3600),
            3=>array(3600,5400),
            4=>array(5400,7200),
            5=>array(7200,9000),
            6=>array(9000,10800),
            7=>array(10800,12600),
            8=>array(12600,14400)
        );
        $filter = new Libs_Filter();
        $t = $filter->get('t','INTEGER');
        $vid = $filter->get('vid','INTEGER');
        $totalTime = $filter->get('totalTime','INTEGER');
        $ip = ip2long(GetRealIP());
        $uid = isset($_SESSION['uid']) ? (int)$_SESSION['uid'] : 0;
        $signupModel = $this->modelFactory->get('signup');
        $result = $signupModel->validUserPlay($uid,$t,$vid,$ip,$totalTime,$this->cache,$timeToSebi);
        echo json_encode($result);
        exit;
    }
    public function onAjax_likes(){
        $result = array('code'=>0,'msg'=>'');
        /*
        if (!$this->isLogin()) {
            $result['code'] = 1;
            $result['msg'] = '请登陆评论';
            echo json_encode($result);
            exit;
        }*/
        $ip = ip2long(GetRealIP());
        $uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : 0;
        $vtime = strtotime(date('Y-m-d'));
        $filter = new Libs_Filter();
        $vid = $filter->get('vid','INTEGER');

        $likesModel = $this->modelFactory->get('likes');
        $likes = $likesModel->getTodayVoteIp($ip,$vid,$vtime);
        if($likes){
            $result['code'] = 1;
            $result['msg'] = '今天已投过票了';
            echo json_encode($result);
            exit;
        }
        $type = $filter->get('t','INTEGER');
        $types = array(1=>'likes',2=>'dislikes');

        if (!array_key_exists($type, $types)) {
            $result['code'] = 1;
            $result['msg'] = '操作类型无效';
            echo json_encode($result);
            exit;
        }
        $str = $types[$type];

        $videoModel = $this->modelFactory->get('video');
        if($videoModel->setInc($str,1,'VID='.$vid)){
            $likes = $likesModel->getIp($ip,$vid);
            if(!$likes){
                $likesModel->insert($uid,$vid,$str,$ip);
            }else{
                $likesModel->setIncIp($ip,$vid,$str,1);
            }
            $result['msg'] = '投票成功！';
        }else {
            $result['code'] = 1;
            $result['msg'] = '投票失败！';
        }
        echo json_encode($result);
        exit;
    }

}
