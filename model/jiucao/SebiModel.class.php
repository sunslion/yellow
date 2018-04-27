<?php
defined('_VALID') or die('Restricted Access!');
class SebiModel extends BaseModel
{
    public function findSebiRecord($uid){
        $uid = round($uid);
        $sql = 'SELECT sebi,sebi_total,sebi_consume,sebi_surplus,jiangli_time,ip,isfree,sebi_tiyan FROM user_sebi WHERE uid = '.$uid.' LIMIT 1';
        $rs = $this->conn->Execute($sql);
        if ($rs && $this->conn->Affected_Rows() > 0) {
            $sebiInfo = array();
            $sebiInfo['sebi'] = $rs->fields['sebi'];
            $sebiInfo['sebi_total'] = $rs->fields['sebi_total'];
            $sebiInfo['sebi_consume'] = $rs->fields['sebi_consume'];
            $sebiInfo['sebi_surplus'] = $rs->fields['sebi_surplus'];
            $sebiInfo['jiangli_time'] = $rs->fields['jiangli_time'];
            $sebiInfo['ip'] = $rs->fields['ip'];
            $sebiInfo['isfree'] = $rs->fields['isfree'];
            $sebiInfo['sebi_tiyan'] = $rs->fields['sebi_tiyan'];
            return $sebiInfo;
        }
        return false;
    }
    public function addSebiRecord($uid){
        $uid = round($uid);
        $sql = 'INSERT INTO user_sebi(uid) VALUES ('.$uid.')';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return true;
        }
        return false;
    }
    public function updateSebi($uid,$sebi){
        $uid = round($uid);
        $sebi = round($sebi);
        $sql = 'UPDATE user_sebi SET isfree = 0, sebi_total = sebi_total+'.$sebi.',sebi_surplus=sebi_surplus+'.$sebi.' WHERE uid = '.$uid;
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0)
            return true;
        return false;
    }
}
?>