<?php
defined('_VALID') or die('Restricted Access!');
class PromotionModel extends BaseModel{
    public function promotioning($uid,$ip,$awardMaxTotal=50,$awardConf=array()){
        $errors = array();
        $message = array();
        $uid = round($uid);
        if ($uid <= 0) {
            $errors[] = '参数出现异常';
        }
        $signupModel = new SignupModel($this->conf);
        if (!$signupModel->getUid($uid)) {
            $errors[] = '不存在的用户';
        }
        $ip = round($ip);
        //删除当天之前的推广记录
        $today = strtotime(date('Y-m-d'));
        $where = ' dateline < '.$today;
        $this->del($where);
        //查找当前访问IP是否被记录
        $where = ' uid = '.$uid.' AND ip = '.$ip.' AND dateline = '.$today;
        $total = $this->getTotal($where);
        if ($total === 0) {
            $this->insert($uid, $ip, $today);
        }else {
            $message[] = '推广链接今天已经使用过';
        }
        //检查当日奖励数是否达到上限
        $awardModel = new AwardModel($this->conf);
        $where = ' uid = '.$uid.' AND date = '.$today;
        $awardTotal =  $awardModel->getTotal($where);
        if ($awardTotal > $awardMaxTotal) {
            $errors[] = '本链接推广奖励数达到每日上限';
        }
        if (empty($errors)) {
            $currTotal = $this->getTotal(' uid = '.$uid);
            $currAwardNum = 0;
            foreach ($awardConf as $k => $v) {
                list($min,$max) = $v;
                if ($min <= $currTotal && $max > $currTotal) {
                    $currAwardNum = $k;
                    break;
                }
            }
            if ($currAwardNum > 0) {                    
                if($awardModel->insert($uid, $currAwardNum, $today)){
                    $message[] = '被推广用户已经送往奖励记录';
                }
                //添加色币和提升等级
                $usersebiModel = new UserSebiModel($this->conf);
                if ($usersebiModel->setInc('sebi_total',$currAwardNum,'uid='.$uid)) {
                    $usersebiModel->setInc('sebi_surplus',$currAwardNum,'uid='.$uid);
                    
                    $sebi = $usersebiModel->get($uid); 
                    $rankModel = new RankModel($this->conf);
                    $rang = $rankModel->getRange($sebi['sebi_surplus']);
                    $premium = $rankModel->getPremium($rang);
                    $signupModel->updatePremium($uid,$premium);
                    $message[] = '被推广用户已经成功奖励';
                }
            }
            return $message;
        }
        return $errors;
    }
    public function insert($uid,$ip,$dateline){
        $uid = round($uid);
        $ip = round($ip);
        $dateline = round($dateline);
        $sql = 'INSERT INTO user_promotion (uid,ip,dateline) VALUES ('.$uid.','.$ip.','.$dateline.')';
        $rs = $this->conn->Execute($sql);
        if ($rs && $this->conn->Affected_Rows()> 0) {
            return true;
        }
        return false;
    }
    public function del($where){
        $where = strtolower($where);
        if (strpos($where, 'where') === false) {
            $where = 'WHERE '.$where;
        }
        $sql = 'DELETE FROM user_promotion '.$where;
        $rs = $this->conn->Execute($sql);
        if ($rs && $this->conn->Affected_Rows()> 0) {
            return true;
        }
        return false;
    }
    public function getTotal($where=''){
        $where = strtolower($where);
        if (strpos($where, 'where') === false) {
            $where = 'WHERE '.$where;
        }
        $sql = 'SELECT COUNT(id) AS total FROM user_promotion '.$where.' LIMIT 1';
        $rs = $this->conn->Execute($sql);
        if ($rs && $this->conn->Affected_Rows()> 0) {
            return (int)$rs->fields['total'];
        }
        return 0;
    }
}
?>