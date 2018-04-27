<?php
defined('_VALID') or die('Restricted Access!');
class NovelModel extends BaseModel
{
    public function getAll($where='',$pageindex=0,$pagesize=20,$order='vid desc') {
        $where = strtolower($where);
        if (!empty($where) && strpos($where, 'where') === false) {
            $where = ' WHERE '.$where;
        }
        $order = strtolower($order);
        if (!empty($order) && strpos($order, 'order by') === false) {
            $order = ' ORDER BY '.$order;
        }
        $sql = 'SELECT VID,title,content,category_id,addtime,viewnumber FROM novel '.$where.$order.' LIMIT '.$pageindex.','.$pagesize;
        $rs = $this->conn->Execute($sql);
        if ($rs && $this->conn->Affected_Rows() > 0) {
            $rows = $rs->getrows();
            $result = array();
            foreach ($rows as $key => $v) {
                $result[$key]['VID'] = $v['VID'];
                $result[$key]['title'] = $v['title'];
                $result[$key]['content'] = $v['content'];
                $result[$key]['category_id'] = $v['category_id'];
                $result[$key]['time'] = $v['addtime'];
                $result[$key]['addtime'] = date('Y-m-d',$v['addtime']);
                $result[$key]['viewnumber'] = $v['viewnumber'];
            }
            return $result;
        }
        return false;
    }
    public function getTotal($where = '') {
        $where = strtolower($where);
        if (strpos($where, 'where') === false) {
            $where = ' WHERE '.$where;
        }
        $sql = 'SELECT COUNT(VID) AS total FROM novel '.$where.' LIMIT 1';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return $rs->fields['total'];
        }
        return 0;
    }
    public function updateViewNumber($id){
        $id = round($id);
        $sql = 'UPDATE novel SET viewnumber = viewnumber + 1 WHERE VID = '.$id.' LIMIT 1';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return true;
        }
        return false;
    }
    public function getMaxId(){
        $sql = 'SELECT MAX(VID) AS max FROM novel limit 1;';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return $rs->fields['max'];
        }
        return 0;
    }
}
?>