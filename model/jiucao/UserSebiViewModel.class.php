<?php
defined('_VALID') or die('Restricted Access!');
class UserSebiViewModel extends BaseModel{
    public function insert($uid,$vid) {
        $uid = round($uid);
        $vid = round($vid);
        $last_time = strtotime(date('Y-m-d'));
        $sql = 'INSERT INTO user_sebi_view(uid,vid,last_time) VALUES ('.$uid.','.$vid.','.$last_time.')';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return true;
        }
        return false;
    }
    public function getTodayView($uid,$vid) {
        $uid = round($uid);
        $vid = round($vid);
        $time = strtotime(date('Y-m-d'));
        $sql = 'SELECT COUNT(veid) AS total FROM user_sebi_view WHERE uid = '.$uid.' AND vid = '.$vid.' AND last_time = '.$time.' LIMIT 1';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return (int)$rs->fields['total'];
        }
        return false;
    }
}
?>