<?php
defined('_VALID') or die('Restricted Access!');
class UserSebiModel extends BaseModel
{
    public function get($uid){
        $uid = round($uid);
        $sql = 'SELECT sebi,sebi_total,sebi_consume,sebi_surplus,jiangli_time,ip,isfree,sebi_tiyan FROM user_sebi WHERE uid ='.$uid.' LIMIT 1';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return array(
                'sebi' => $rs->fields['sebi'],
                'sebi_total' => $rs->fields['sebi_total'],
                'sebi_consume' => $rs->fields['sebi_consume'],
                'sebi_surplus' => $rs->fields['sebi_surplus'],
                'jiangli_time' => $rs->fields['jiangli_time'],
                'ip' => $rs->fields['ip'],
                'isfree' => $rs->fields['isfree'],
                'sebi_tiyan' => $rs->fields['sebi_tiyan'],
            );
        }
        return false;
    }
    public function setInc($field,$step=1,$where=''){
        $where = strtolower($where);
        if (!empty($where) && strpos($where, 'where') === false) {
            $where = ' WHERE '.$where;
        }
        $sql = 'UPDATE user_sebi SET '.$field.'='.$field.'+'.$step.$where;
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return true;
        }
        return false;
    }
    public function setDec($field,$step=1,$where=''){
        $where = strtolower($where);
        if (!empty($where) && strpos($where, 'where') === false) {
            $where = ' WHERE '.$where;
        }
        $sql = 'UPDATE user_sebi SET '.$field.'='.$field.'-'.$step.$where;
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return true;
        }
        return false;
    }
    public function update($mix = array(),$where=''){
        if (!is_array($mix)) {
            return false;
        }
        if (count($mix) <= 0) {
            return false;
        }
        $where = strtolower($where);
        if (!empty($where) && strpos($where, 'where') === false) {
            $where = ' WHERE '.$where;
        }
        $option_str = '';
        foreach ($mix as $key => $value) {
            $value = mysql_real_escape_string($value);
            $option_str .= $key.'='."'{$value}',";
        }
        $option_str = rtrim($option_str,',');
        $sql = 'UPDATE user_sebi SET '.$option_str.$where;
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return true;
        }
        return false;
    }
}
?>