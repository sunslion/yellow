<?php
defined('_VALID') or die('Restricted Access!');
class Promotion extends Base{
    public function onIndex() {
        $uid = get_request_arg('uid');
        $ip = ip2long(GetRealIP());
        $awardConf = array(
            1=>array(20,40),
            2=>array(40,60),
            3=>array(60,80),
            4=>array(80,100)
        );
        $awardMaxTotal = 50;
        $promotionModel = $this->modelFactory->get('promotion');
        $result = $promotionModel->promotioning($uid,$ip,$awardMaxTotal,$awardConf);
        if ($result === true) {
            $this->pushAssigns(array('messages'=>$result));
        }else{
            $this->pushAssigns(array('errors'=>$result));
        }
        $this->tpls = array('header.tpl','promotion.tpl','footer.tpl');
    }
}
?>