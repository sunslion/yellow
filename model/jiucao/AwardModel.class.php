<?php
defined('_VALID') or die('Restricted Access!');
class AwardModel extends BaseModel{
    public function insert($uid,$awards,$date){
        $uid = round($uid);
        $awards = round($awards);
        $date = round($date);
        $sql = 'INSERT INTO user_award(uid,awards,date) VALUES (\''.$uid.'\',\''.$awards.'\',\''.$date.'\')';
        $rs = $this->conn->Execute($sql);
        if ($rs && $this->conn->Affected_Rows()> 0) {
            return true;
        }
        return false;
    }
    public function getTotal($where='') {
        $where = strtolower($where);
        if (strpos($where, 'where') === false) {
            $where = ' WHERE '.$where;
        }
        $sql = 'SELECT SUM(awards) AS total FROM user_award'.$where.' LIMIT 1';
        $rs = $this->conn->Execute($sql);
        if ($rs && $this->conn->Affected_Rows()> 0) {
            return (int)$rs->fields['total'];
        }
        return 0;
    }
}
?>