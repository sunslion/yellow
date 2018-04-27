<?php
defined('_VALID') or die('Restricted Access!');
class ChannelModel extends BaseModel
{
    public function getAll($parentid = 0) {
        $parentid = round($parentid);
        $sql = 'SELECT CHID,parentid,name,total_videos FROM channel WHERE parentid = '.$parentid.' AND isshow = 1 ORDER BY sort ASC';
        $rs = $this->conn->Execute($sql);
        if ($rs && $this->conn->Affected_Rows()> 0) {
            $result = array();
            $rows = $rs->getrows();
            foreach ($rows as $key => $value) {
                $result[$key]['CHID'] = $value['CHID'];
                $result[$key]['parentid'] = $value['parentid'];
                $result[$key]['name'] = $value['name'];
                $result[$key]['total_videos'] = $value['total_videos'];
            }
            return $result;
        }
        return false;
    }
    public function get($id) {
        $id = round($id);
        $sql = 'SELECT CHID,parentid,name,total_videos FROM channel WHERE CHID ='.$id.' LIMIT 1;';
        $rs = $this->conn->Execute($sql);
        if ($rs && $this->conn->Affected_Rows()> 0) {
            return array(
                'CHID'=>$rs->fields['CHID'],
                'parentid'=>$rs->fields['parentid'],
                'name'=>$rs->fields['name'],
                'total_videos'=>$rs->fields['total_videos'],
            );
        }
        return false;
    }
    
    public function update($mix=array(),$where=''){
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
        $options = array();
        foreach ($mix as $key => $value) {
            $value = mysql_real_escape_string($value);
            $options[] = $key.'='."'{$value}'";
        }
        $option_str = implode(',', $options);
        $sql = 'UPDATE channel SET '.$option_str.$where;
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return true;
        }
        return false;
    }
}
?>