<?php
defined('_VALID') or die('Restricted Access!');
class UserDepositModel extends BaseModel
{
    public function get($uid) {
        
    }
    public function update($mix = array(),$where ='') {
        if (!is_array($mix)) {
            return false;
        }
        if (count($mix)<=0) {
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
        $sql = 'UPDATE user_deposit SET '.$option_str.$where;
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return true;
        }
        return false;
    }
}
?>