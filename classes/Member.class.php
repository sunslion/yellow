<?php
class Member
{
    /*
     * return 添加存款信息，添加色币，升级并且如果成功，返回最新的级别，否则flase
     * */
    public static function deposit($uid,$money,$dtime){
        $re = Deposit::addDepositRecord($uid, $money, $money, $dtime);
        if ($re) {
            $nre = NSebi::findSebiRecord($uid);
            if (!$nre) {
                NSebi::addSebiRecord($uid);
            }
            if(NSebi::updateSebi($uid, $money)){
                $record = NSebi::findSebiRecord($uid);
                if ($record) {
                   return self::updateMemberRank($uid, $record['sebi_surplus']);
                }
            }
        }
        return false;
    }
    /*
     * 更新用户级别
     * return 成功返回级别，失败返回false
     * */
    public static function updateMemberRank($uid,$sebi_surplus) {
        global $conn;
        $uid = mysql_real_escape_string($uid);
        $rang = self::getRange($sebi_surplus);
        $new_premium = self::getPremium($rang);
        $premium = self::getMemberCurrPremium($uid);
        if ($new_premium != $premium) {
            $otime = strtotime(date('Y-m-d'));
            $sql = 'UPDATE signup SET premium ='.$new_premium.',otime='.$otime.' WHERE UID ='.$uid.' LIMIT 1;';
            $rs = $conn->execute($sql);
            if ($rs) 
                return $new_premium;
        }
        return false;
    }
    //随机产生红包
    //返回值  -1表示当前用户已经领取过红包,-2表示同一个IP下已经领取过红包了,true表示添加成功
    public static function payHongbao($uid,$ip){
        //检查当前是否已经领取红包了
        if (Hongbao::getUid($uid)) {
            return -1;
        }
        //检查当前用户所在的IP是否领取过红包,保证同一个IP只能领取一次
        //if (Hongbao::getIp($ip)) {
        //    return -2;
        //}
        //产生随机金额
        $amount = rand(1, 5);
        return Hongbao::add($uid, $amount, $ip);
    }
    //帮推荐者加入红包
    //ruid是推荐者，uid是被推荐者
    //返回值  -1表示当前用户已经领取过红包,-2表示同一个IP下已经帮别人加大过红包了,true表示添加成功
    public static function payReHongbao($uid,$ruid,$rip){
        //检查当前登陆用户是否帮分享者加大过红包
        if (Hbrecommend::getUid($uid, $ruid)) {
            return -1;
        }
        //检查当前登陆用户的IP是否已经帮别人加大过红包
        if (Hbrecommend::getIp($rip)) {
            return -2;
        }
        //检查被推荐者是否成功领取过红包
        if (!Hongbao::getUid($uid)) {
            return -3;
        }
        //产生随机金额
        $bamount = rand(1, 3);
        //添加"帮推荐者加大红包"的记录
        if (Hbrecommend::add($uid, $ruid, $rip, $bamount)) {
            //获取被推荐者的记录
            $user = Hongbao::getUid($uid);
            //把产生的金额累加到被推荐者的红包额度上
            $amount = $bamount + $user['amount'];
            return Hongbao::updateAmount($uid, $amount);
        }
        return false;
    }
    public static function getUsers($uids){
        global $conn;
        $where = '';
        if (is_array($uids)) {
            $where = ' UID IN ('.implode(',', $uids).')';
        }else{
            $uid = round($uids);
            $where = ' UID = '.$uid.' LIMIT 1;';
        }
        if (!empty($where)) {
            $where = ' WHERE '.$where;
        }
        $sql = 'SELECT UID,username FROM signup '.$where;
        $rs = $conn->execute($sql);
        if($rs && $conn->Affected_Rows() > 0){
            return $rs->getrows();
        }
        return false;
    }
    public static function getRange($sebi_surplus){
        global $rank_range;
        foreach ($rank_range as $k => $v) {
            list($min,$max) = $v;
            if ($min <= $sebi_surplus && $max >= $sebi_surplus) {
                return  $k;
            }
        }
        return 0;
    }
    public static function getPremium($range){
        global $user_rank_range;
        foreach ($user_rank_range as $k => $v) {
            if (in_array($range, $v)) {
                return  $k;
            }
        }
        return 0;
    }
    public static function getMemberCurrPremium($uid) {
        global $conn;
        $uid = mysql_real_escape_string($uid);
        $sql = 'SELECT premium FROM signup WHERE UID = '.$uid.' LIMIT 1';
        $rs = $conn->execute($sql);
        if($rs && $conn->Affected_Rows() > 0)
            return $rs->fields['premium'];
        return 0;
    }
    public static function updateUserProducts($uid,$pname){
        global $conn,$products_letter;
        if (is_array($products_letter)) {
            $uid = mysql_real_escape_string($uid);
            $first_letter = substr($pname, 0,1);
            $products_num = 0;
            foreach ($products_letter as $k => $v) {
                if ($first_letter === $v) {
                    $products_num = $k;
                    break;
                }
            }
            if ($products_num === 0) {
                return false;
            }
            $sql = 'SELECT products FROM signup WHERE UID ='.$uid.' LIMIT 1';
            $rs = $conn->execute($sql);
            if ($rs) {
                $oproducts = $rs->fields['products'];
                $nproducts = empty($oproducts) || strpos($oproducts, $products_num) !== false ? $products_num : $oproducts.','.$products_num;
                $sql = 'UPDATE signup SET products = '.$nproducts.' WHERE UID='.$uid;
                $rs = $conn->execute($sql);
                return $rs;
            }
        }
        return false;
    }
    public static function updateUserYearTime($uid,$days){
        global $conn;
        $uid = mysql_real_escape_string($uid);
        $uid = intval($uid);
        $days = intval($days);
        $time = $days * 86400;
        $sql = 'UPDATE signup SET otime = otime +'.$time.' WHERE UID = '.$uid;
        $rs = $conn->execute($sql);
        if($rs){
            return true;
        }
        return false;
    }
    public static function getNameUser($username =''){
        global $conn;
        $username = mysql_real_escape_string($username);
        $sql = 'SELECT UID FROM signup WHERE username = \''.$username.'\' LIMIT 1';
        $rs = $conn->execute($sql);
        if($rs && $conn->Affected_Rows() > 0){
            return $rs->fields['UID'];
        }
        return 0;
    }
}