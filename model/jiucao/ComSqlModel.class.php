<?php
defined('_VALID') or die('Restricted Access!');
class ComSqlModel extends BaseModel
{
    public function getAll($sql) {
        if(empty($sql)) return false;
        $rs = $this->conn->Execute($sql);
        if ($rs && $this->conn->Affected_Rows() > 0){ 
           $rows = $rs->getrows();
        }else{
           $rows = array();
        }    
        return $rows;
    }
    
    public function getNumInfo($sql,$n=1) {
        if(empty($sql)) return false;
        $rs = $this->conn->Execute($sql);
        if ($rs && $this->conn->Affected_Rows() > 0){
            $rows = $rs->getrows($n);
        }else{
            $rows = array();
        }
        return $rows;
    }
}
?>