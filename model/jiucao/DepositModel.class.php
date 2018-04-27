<?php
defined('_VALID') or die('Restricted Access!');
class DepositModel extends BaseModel{
    public function isRepeatRecord($uid,$dtime){
        $uid = round($uid);
        $dtime = round($dtime);
        $sql = 'SELECT COUNT(id) AS total FROM user_deposit WHERE uid ='.$uid.' AND dtime='.$dtime.' LIMIT 1;';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return $rs->fields['total'] > 0 ? $rs->fields['total'] : false;
        }
        return false;
    }
    public function addDepositRecord($uid,$money,$sebi,$dtime){
        $uid = round($uid);
        $money = round($money);
        $dtime = round($dtime);
        $atime = time();
        $sql = 'INSERT INTO user_deposit(uid,money,sebi,dtime,atime) VALUES ('.$uid.','.$money.','.$sebi.','.$dtime.','.$atime.')';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return true;
        }
        return false;
    }
}
?>