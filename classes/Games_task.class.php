<?php
class Games_task
{
    public static function add($title,$condition,$prize,$isshow,$order){
        global $conn;
        $title = mysql_real_escape_string($title);
        $condition = mysql_real_escape_string($condition);
        $prize = mysql_real_escape_string($prize);
        $atime = time();
        $isshow = round($isshow);
        $order = round($order);
        $sql = 'INSERT INTO games_task(`tname`,`conditions`,`prize`,`atime`,`isshow`,`orders`) VALUES(\''.$title.'\',\''.$condition.'\',\''.$prize.'\','.$atime.','.$isshow.','.$order.')';
        $rs = $conn->execute($sql);
        if($rs){
            return true;
        }
        return false;
    }
    public static function update($wid,$title,$condition,$prize,$isshow,$order) {
        global $conn;
        $wid = round($wid);
        $title = mysql_real_escape_string($title);
        $condition = mysql_real_escape_string($condition);
        $prize = mysql_real_escape_string($prize);
        $utime = time();
        $isshow = round($isshow);
        $order = round($order);
        $sql = 'UPDATE games_task SET `tname`=\''.$title.'\',`conditions`=\''.$condition.'\',`prize`=\''.$prize.'\',`utime`='.$utime.',`isshow` = '.$isshow.',`orders` = '.$order.' WHERE id='.$wid;
        $rs = $conn->execute($sql);
        if ($rs) {
            return true;
        }
        return false;
    }
    public static function get($wid){
        global $conn;
        $wid = round($wid);
        $sql = 'SELECT `tname`,`conditions`,`prize`,`atime`,`utime`,`isshow`,`orders` FROM games_task WHERE id ='.$wid.' LIMIT 1';
        $rs = $conn->execute($sql);
        if ($rs && $conn->Affected_Rows() > 0) {
            $result = array();
            $result['tname'] = $rs->fields['tname'];
            $result['condition'] = $rs->fields['conditions'];
            $result['prize'] = $rs->fields['prize'];
            $result['atime'] = $rs->fields['atime'];
            $result['utime'] = $rs->fields['utime'];
            $result['isshow'] = $rs->fields['isshow'];
            $result['order'] = $rs->fields['orders'];
            return $result;
        }
        return false;
    }
    public static function del($wid){
        global $conn;
        $wid = round($wid);
        $sql = 'DELETE FROM games_task WHERE id='.$wid;
        $rs = $conn->execute($sql);
        if ($rs && $conn->Affected_Rows() > 0) {
            return true;
        }
        return false;
    }
    public static function getTotal($where=''){
        global $conn;
        $where = strtolower($where);
        if (!empty($where) && strpos($where, 'where') === false) {
            $where = ' WHERE '.$where;
        }
        $sql = 'SELECT COUNT(id) AS total FROM games_task '.$where;
        $rs = $conn->execute($sql);
        if ($rs && $conn->Affected_Rows() > 0) {
            return $rs->fields['total'];
        }
        return 0;
    }
    public static function getAll($pageindex,$pagesize=20,$where='',$order='id ASC') {
        global $conn,$task_type,$task_sign,$task_join;
        $where = strtolower($where);
        if (!empty($where) && strpos($where, 'where') === false) {
            $where = ' WHERE '.$where;
        }
        $sql = 'SELECT `id`,`tname`,`conditions`,`prize`,`atime`,`utime`,`isshow`,`orders` FROM games_task '.$where.' ORDER BY '.$order.' LIMIT '.$pageindex.','.$pagesize;
        $rs = $conn->execute($sql);
        if ($rs && $conn->Affected_Rows() > 0) {
            $rows = $rs->getrows();
            $result = array();
            foreach ($rows as $k => $v) {
                $result[$k]['id'] = $v['id'];
                $result[$k]['tname'] = $v['tname'];
                $result[$k]['condition'] = $v['conditions'];
                $condition = json_decode($v['conditions'],true);
                $result[$k]['condition_arr'] = $condition;
                $count = count($condition);
                if ($count > 0) {
                    $str = '';
                    foreach ($condition as $sk=>$sv) {
                        foreach ($sv as $key => $value) {
                            if ($key === 'task_type') {
                                $str .= $task_type[$value];
                            }
                            if ($key === 'task_sign') {
                                $str .= $task_sign[$value];
                            }
                            if($key === 'credit'){
                                $str .= $value;
                            }
                            if ($key === 'task_join' ) {
                                $str .= ' '.$task_join[$value].' ';
                            }
                        }
                    } 
                    $result[$k]['condition_str'] = $str;
                }
                $result[$k]['prize'] = $v['prize'];
                $result[$k]['atime'] = $v['atime'];
                $result[$k]['utime'] = $v['utime'];
                $result[$k]['isshow'] = $v['isshow'];
                $result[$k]['order'] = $v['orders'];
            }
            return $result;
        }
        return false;
    }
}