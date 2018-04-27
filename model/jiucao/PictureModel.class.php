<?php
defined('_VALID') or die('Restricted Access!');
class PictureModel extends BaseModel
{
    public function getAll($where = '',$pageindex=0,$pagesize = 20,$order='VID desc'){
        $where = strtolower($where);
        if (!empty($where) && strpos($where, 'where') === false) {
            $where = ' WHERE '.$where;
        }
        $order = strtolower($order);
        if (!empty($order) && strpos($order, 'order by') === false) {
            $order = ' ORDER BY '.$order;
        }
        $sql = 'SELECT VID,title,description,category_id,addtime,total_imgs,viewnumber FROM picture '.$where.$order.' LIMIT '.$pageindex.','.$pagesize;
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            $rows = $rs->getrows();
            $result = array();
            foreach ($rows as $key => $row) {
                $result[$key]['VID'] = $row['VID'];
                $result[$key]['title'] = $row['title'];
                $result[$key]['description'] = $row['description'];
                $temp = $this->getImgs($row['description']);
                if ($temp) {
                    $result[$key]['count'] = $temp['count'];
                    $result[$key]['default'] = $temp['default'];
                    $result[$key]['imgs'] = $temp['imgs'];
                }
                $result[$key]['description'] = $row['description'];
                $result[$key]['category_id'] = $row['category_id'];
                $result[$key]['addtime'] = $row['addtime'];
                $result[$key]['total_imgs'] = $row['total_imgs'];
                $result[$key]['viewnumber'] = $row['viewnumber'];
            }
            return $result;
        }
        return false;
    }
    protected function getImgs($str=''){
        if (!is_string($str)) {
            return false;
        }
        $str = strip_tags($str,'<img>');
        if(preg_match_all('/<img.*?src="(.*?)".*?>/is', $str,$matches)){
            if (isset($matches[1])) {
                $count = count($matches[1]);
                $defaultImg = '';
                if($count > 0)
                    $defaultImg = $matches[1][0];
                return array('count'=>$count,'default'=>$defaultImg,'imgs'=>$matches[1]);
            }
        }
        return false;
    }
    public function getTotal($where = '') {
        $where = strtolower($where);
        if (!empty($where) && strpos($where, 'where') === false) {
            $where = ' WHERE '.$where;
        }
        $sql = 'SELECT COUNT(VID) AS total FROM picture '.$where;
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return $rs->fields['total']; 
        }
        return 0;
    }
    public function updateviewNumber($id){
        $id = round($id);
        $sql = 'UPDATE picture SET viewnumber = viewnumber+1 WHERE VID = '.$id.' LIMIT 1';
        $rs = $this->conn->Execute($sql);
        if ($rs && $this->conn->Affected_Rows() > 0) {
            return true;
        }
        return false;
    }
    public function getMaxId(){
        $sql = 'SELECT MAX(VID) AS max FROM picture limit 1;';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return $rs->fields['max'];
        }
        return 0;
    }
}
?>