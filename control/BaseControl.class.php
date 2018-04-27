<?php
defined('_VALID') or die('Restricted Access!');
class Base
{
    protected $conf = array();
    protected $assigns = array();
    protected $tpls = array();
    protected  $smarty = null;
    protected $cache = null;
    protected $modelFactory = null;
    protected $isajax = 0;
    function __construct($conf = array()){
        $this->conf = $conf;
        Sessions_Control::init($this->conf['session_driver'],$this->conf);
        $this->smarty = new Smarty();
        $options = array(
            'host' => $this->conf['mem_host'],
            'port' => $this->conf['mem_port'],
        );
        $this->cache = Cache_Base::getInstance('Cache_Memcache',$options);
        $this->modelFactory = new Factory($this->conf);
        if (!$this->isLogin()) {
            $this->pushAssigns(array('uid'=>0));
            Libs_Remember::check($this->cache,$this->conf);
        }else {
            $uid = round($_SESSION['uid']);
            $signupModel = $this->modelFactory->get('signup');
            $sebiModel = $this->modelFactory->get('sebi');
            $rankMode = $this->modelFactory->get('rank');
            $user = $signupModel->getUid($uid);
            $premiumName = $rankMode->getPreminumName($user['premium']);
            if ($user['premium'] == 1 || $user['premium'] == 2) {
                if($sebiModel){
                    $sebi = $sebiModel->findSebiRecord($uid);
                    if (isset($sebi['sebi_surplus'])) {
                        $this->pushAssigns(array('sebi_surplus'=>$sebi['sebi_surplus']));
                    }                    
                }
                $this->pushAssigns(array('over_time'=>date('Y-m-d',strtotime('+'.$user['years'].' years',$user['otime']))));
            }

            $this->pushAssigns(array('islogin'=>1,'uid'=>$uid,'username'=>$_SESSION['username'],'premiumName'=>$premiumName,'premium'=>$user['premium']));
        }
        //类别
        $channels = $this->getChannels();
        if($channels){
            $this->pushAssigns(array('channels'=>$channels));
        }
        //背景广告
        $this->pushAssigns(array(
            'back_img'=>(empty($this->conf['set_l_vip']) || empty($this->conf['set_r_vip'])) ? '' : '/templates/frontend/'.$this->conf['template'].'/img/'.$this->conf['set_l_vip'].'_'.$this->conf['set_r_vip'],
            'set_left_btn_top'=>$this->conf['set_left_btn_top'],
            'set_left_btn_url'=>$this->conf['set_left_btn_url'],
            'set_right_btn_top'=>$this->conf['set_right_btn_top'],
            'set_right_btn_url'=>$this->conf['set_right_btn_url'],
            'qq'=>$this->conf['lqq1'],
            'set_notice'=>$this->conf['set_notice']
        ));
        //注册模板中应用的方法
        $this->smarty->register_function('surl', 'getStaticUrl');
        $this->smarty->register_function('rate', 'getRate');
        //指定模板和缓存文件位置
        $tplPath = BASE_PATH . '/templates/frontend/' .$this->conf['template'];
        $compilePath = BASE_PATH . '/cache/frontend/'.$this->conf['template'];
        if (is_mobile()) {
            $tplPath .= '/m';
            $compilePath .= '/m';
        }
        $this->smarty->template_dir = $tplPath;
        $this->smarty->compile_dir = $compilePath;
        $this->smarty->compile_check = false;
    }
    protected function isLogin(){
        if (isset($_SESSION['uid']) && !empty($_SESSION['uid']) && isset($_SESSION['username']) && !empty($_SESSION['username'])) {
            return true;
        }
        return false;
    }
    protected function getAjaxValidCode(){
        $browser    = (isset($_SERVER['HTTP_USER_AGENT'])) ? sha1($_SERVER['HTTP_USER_AGENT']) : NULL;
        $ip         = ip2long(GetRealIP());
        return strtolower(crypt($browser . $ip,$ip));
    }
    protected function pushAssigns($item){
        if (is_array($item)) {
            $this->assigns = array_merge($this->assigns, $item);
        }
    }
    protected function getChannels($parent=0){
        $key = 'channel_'.$parent;
        $channels =  $this->cache->get($key);
        if (!$channels) {
            $channelModel = $this->modelFactory->get('channel');
            $channels = $channelModel->getAll($parent);
            $this->cache->set($key,$channels,3600);
        }
        //var_dump($parent);
        return $channels;
    }
    protected function display(){
        header("Content-type: text/html; charset=utf-8");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control:must-revalidate, max-age=3600");
        header("Pragma: no-cache");
        if(is_array($this->assigns) && count($this->assigns) > 0)
            $this->smarty->assign($this->assigns);
        foreach ($this->tpls as $key => $value) {
            $this->smarty->display($value);
        }
        if (count($this->tpls) > 0) {
          $this->smarty->gzip_encode();
        }
    }
    function __destruct(){
       if (!$this->isajax) {
           $this->display();
       }
    }
}
