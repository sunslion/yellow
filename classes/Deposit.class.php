<?php
class Deposit
{
    public static  function addDepositRecord($uid,$money,$sebi,$dtime){
        global $conn;
        $uid = mysql_real_escape_string($uid);
        $money = mysql_real_escape_string($money);
        $dtime = mysql_real_escape_string($dtime);
        $atime = time();
        $sql = 'INSERT INTO user_deposit(uid,money,sebi,dtime,atime) VALUES ('.$uid.','.$money.','.$sebi.','.$dtime.','.$atime.')';
        $rs = $conn->execute($sql);
        if($rs){
            return true;
        }
        return false;
    }
    public static function isRepeatRecord($uid,$dtime){
        global $conn;
        $uid = mysql_real_escape_string($uid);
        $dtime = mysql_real_escape_string($dtime);
        $sql = 'SELECT COUNT(id) AS total FROM user_deposit WHERE uid ='.$uid.' AND dtime='.$dtime.' LIMIT 1;';
        $rs = $conn->execute($sql);
        if($rs){
            return $rs->fields['total'] > 0 ? $rs->fields['total'] : false;
        }
        return false;
    }
    public static  function updatePlayGameSebi($uid,$isget,$get_sebi){
        $isget = intval($isget);
        if ($isget == 0) {
            return false;
        }
        global $conn;
        $uid = mysql_real_escape_string($uid);
        $get_sebi = mysql_real_escape_string($get_sebi);
        $sql = 'UPDATE user_deposit SET isget_sebi='.$isget.',get_sebi='.$get_sebi.' WHERE uid ='.$uid;
        $rs = $conn->execute($sql);
        if ($rs) {
            return true;
        }
        return false;
    }
    public static function getDepositHongbag($pageindex = 0,$limit = 10,$order = 'id DESC'){
        global $conn;
        $pageindex = round($pageindex);
        $sql = 'SELECT uid,money FROM user_deposit WHERE ishongbao = 1 ORDER BY '.$order.' LIMIT '.$pageindex.','.$limit;
        $rs = $conn->execute($sql);
        if ($rs && $conn->Affected_Rows() > 0) {
            $result = array();
            $rows = $rs->getrows();
            foreach ($rows as $k => $v) {
                $result[$k]['uid'] = $v['uid'];
                $result[$k]['money'] = $v['money'];
            }
            return $result;
        }
        return false;
    }
    public static function getTimeDepositMoney($uid,$sTime,$eTime){
        global $conn;
        $sql = 'SELECT money FROM user_deposit WHERE uid ='.$uid.' AND dtime > '.$sTime.' AND dtime < '.$eTime;
        $rs = $conn->execute($sql);
        if ($rs && $conn->Affected_Rows() > 0) {
            $result = array();
            $rows = $rs->getrows();
            foreach ($rows as $k => $v) {
                $result[] = $v['money'];
            }
            return $result;
        }
        return false;
    }
    public static function getDepositMoneyTotal($uid){
        global $conn;
        $sql = 'SELECT money FROM user_deposit WHERE uid ='.$uid;
        $rs = $conn->execute($sql);
        $moneyTotal = 0;
        if($rs && $conn->Affected_Rows() > 0){
            $result = array();
            $rows = $rs->getrows();
            foreach ($rows as $k=>$v){
                $moneyTotal += $v['money'];
            }
            $result['moneyTotal'] = $moneyTotal;
            $result['count'] = count($rows);
            return $result;
        }
        return false;
    }
}