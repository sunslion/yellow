<?php
defined('_VALID') or die('Restricted Access!');
class VideoModel extends BaseModel
{
    public function search($title,$kd,$pageindex,$pagesize=20,$order='vid desc'){
        //如存在-把关键词分割成数组
        if(stristr($kd,'-')){
            $kd = explode('-',$kd);
        }
        if(is_array($kd)&&!empty($kd)){
            $where = '';
            foreach ($kd as $k=>$v){
                $v = trim($v);
                $v = mysql_real_escape_string($v);
                if($k==0) {
                    $where.= " LOCATE('{$v}',title) > 0 OR LOCATE('{$v}',keyword) > 0 " ;
                    continue;
                }
                $where.=" OR LOCATE('{$v}',title) > 0 OR LOCATE('{$v}',keyword) > 0 ";
             }
        }else{
            $title = mysql_real_escape_string($title);
            $kd = mysql_real_escape_string($kd);
            $where = " LOCATE('{$title}',title) > 0 OR LOCATE('{$kd}',keyword) > 0 ";
        }
        $total = $this->getTotal($where);
        $videos = $this->getAll($where,$pageindex,$pagesize,$order);
        return array('total'=>$total,'videos'=>$videos);
    }
    public function getAll($where='',$pageindex,$pagesize=20,$order='vid desc') {
        if (is_array($where)) {
            $where = $this->getArrayToStr($where);
        }
        
        $where = strtolower($where);
        if (!empty($where) && strpos($where, 'where') === false) {
            $where = ' WHERE '.$where;
        }
        
        $order = strtolower($order);
        if (!empty($order) && strpos($order, 'order by') === false) {
            $order = ' ORDER BY '.$order;
        }
        $limit = '';
        if (intval($pagesize) === 0) {
            $limit = ' LIMIT '.$pageindex;
        }else{
            $limit = ' LIMIT '.$pageindex.','.$pagesize;
        }
        $sql = 'SELECT VID,title,channel,description,keyword,addtime,viewnumber,pic,rate,likes,dislikes,ipod_filename,ybPlayUrl FROM video '.$where.$order.$limit;
        $rs = $this->conn->Execute($sql);
        if ($rs && $this->conn->Affected_Rows() > 0) {
            $rows = $rs->getrows();
            $result = array();
            foreach ($rows as $key => $v) {
                $result[$key]['VID'] = $v['VID'];
                $result[$key]['title'] = $v['title'];
                $result[$key]['channel'] = $v['channel'];
                $result[$key]['description'] = $v['description'];
                $result[$key]['keyword'] = $v['keyword'];
                $result[$key]['addtime'] = date('Y-m-d',$v['addtime']);
                $result[$key]['viewnumber'] = $v['viewnumber'];
                $result[$key]['pic'] = $v['pic'];
                $result[$key]['rate'] = round($v['likes'] / ($v['dislikes'] == 0 ? 1 : $v['dislikes']));
                $result[$key]['likes'] = $v['likes'];
                $result[$key]['dislikes'] = $v['dislikes'];
                $result[$key]['ipod_filename'] = $v['ipod_filename'];
                $result[$key]['ybPlayUrl'] = $v['ybPlayUrl'];
            }
            return $result;
        }
        return false;
    }
    private function getArrayToStr($mix=array()){
        if (!is_array($mix) || count($mix) <= 0) {
            return '';
        }
        $where = array();
        $count = count($mix);
        $i=1;
        foreach ($mix as $key => $value) {
            if (is_array($value)) {
                list($v,$o,$l) = $value;
                $v = mysql_real_escape_string($v);
                $l = strtolower($l);
                $l = $l === 'or' ? ' OR ' : ' AND ';   
                switch ($o){
                    case 'like':
                        $where[] = "{$key} like '%{$v}%'";
                        break;
                    case 'in':
                        $where[] = "{$key} in ({$v})";
                        break;
                    default:
                        $where[] = "{$key} = '{$v}'";
                        break;
                }
                
            }else{
                $where[] = $value;
            }
            if($count > $i){
                $where[] = $l;
            }
            $i++;
        }
        return implode(' ', $where);
    }
    
    public function getTotal($where = '') {
        if (is_array($where)) {
            $where = $this->getArrayToStr($where);
        }
        if(!empty($where)){
            $where = strtolower($where);
            if (strpos($where, 'where') === false) {
                $where = ' WHERE '.$where;
            }
        }
        $sql = 'SELECT COUNT(VID) AS total FROM video '.$where.' LIMIT 1';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return (int)$rs->fields['total'];
        }
        return 0;
    }
    public function setInc($field,$step=1,$where=''){
        $where = strtolower($where);
        if (!empty($where) && strpos($where, 'where') === false) {
            $where = ' WHERE '.$where;
        }
        $sql = 'UPDATE video SET '.$field.'='.$field.'+'.$step.$where;
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
        $sql = 'UPDATE video SET '.$field.'='.$field.'-'.$step.$where;
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
        $sql = 'UPDATE video SET '.$option_str.$where;
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return true;
        }
        return false;
    }
    public function getMaxId(){
        $sql = 'SELECT MAX(vid) AS max FROM video limit 1;';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return $rs->fields['max'];
        }
        return 0;
    }
    public function insert($mix = array()) {
        if (!is_array($mix)) {
            return false;
        }
        if(count($mix) <= 0){
            return false;
        }
        $keys = array();
        $values = array();
        foreach ($mix as $key => $value) {
            $value = mysql_real_escape_string(StripStr($value));
            $keys[] = $key;
            $values[] = "'{$value}'";
        }
        $sql = 'INSERT INTO video('.implode(',', $keys).') VALUES ('.implode(',', $values).');';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return true;
        }
        return false;
    }
    public function delete($mix = array(),$join=' AND ') {
        if (!is_array($mix)) {
            return false;
        }
        if(count($mix) <= 0){
            return false;
        }
        $where = array();
        foreach ($mix as $k => $v) {
            if (is_array($v)) {
                $where[$k] = "{$k} in (";
                $temp = array();
                foreach ($v as $sv) {
                    $sv = mysql_real_escape_string(StripStr($sv));
                    $temp[] = "'{$sv}'";
                }
                $where[$k] .= implode(',', $temp).')';
            }else{
                $sv = mysql_real_escape_string(StripStr($v));
                $where[] = "{$k} = '{$v}'";
            }
        }
        $sql = 'DELETE FROM video WHERE '.implode($join, $where);
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return true;
        }
        return false;
    }
}
?>