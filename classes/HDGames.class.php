<?php
class HDGames{
    public static function add($gid,$uid,$uname,$ip,$data=array()) {
        global $conn;
        $atime = time();
        $data = json_encode($data);
        $sql = 'INSERT INTO hdgames(gid,uid,uname,ip,data,atime) VALUES ('.$gid.','.$uid.',\''.$uname.'\','.$ip.',\''.$data.'\','.$atime.')';
        $rs = $conn->execute($sql);
        if($rs){
            return true;
        }
        return false;
    }
    public static function updateData($gid,$uid,$data=array()) {
        global $conn;
        $utime = time();
        $data = json_encode($data);
        $sql = 'UPDATE hdgames SET utime = '.$utime.',data =\''.$data.'\' WHERE gid ='.$gid.' AND uid = '.$uid;
        $rs = $conn->execute($sql);
        if($rs && $conn->Affected_Rows() > 0)
            return true;
        return false;
    }
    public static function updateResult($gid,$uid,$result){
        global $conn;
        $sql = 'UPDATE hdgames SET result = \''.$result.'\' WHERE gid ='.$gid.' AND uid='.$uid;
        $rs = $conn->execute($sql);
        if($rs && $conn->Affected_Rows() > 0)
            return true;
        return false;
    }
    public static function get($gid,$uid){
        global $conn;
        $sql = 'SELECT ip,data,result,atime,utime FROM hdgames  WHERE gid ='.$gid.' AND uid ='.$uid.' LIMIT 1';
        $rs = $conn->execute($sql);
        if($rs && $conn->Affected_Rows() > 0){
            $result = array();
            $result['ip'] = $rs->fields['ip'];
            $result['data'] = $rs->fields['data'];
            $result['result'] = $rs->fields['result'];
            $result['atime'] = $rs->fields['atime'];
            $result['utime'] = $rs->fields['utime'];
            return $result;
        }
        return false;
    }
    public static function getIpRecord($gid,$ip){
        global $conn;
        $sql = 'SELECT uid,data,result,atime,utime FROM hdgames  WHERE gid ='.$gid.' AND ip ='.$ip.' LIMIT 1';
        $rs = $conn->execute($sql);
        if($rs && $conn->Affected_Rows() > 0){
            $result = array();
            $result['uid'] = $rs->fields['uid'];
            $result['data'] = $rs->fields['data'];
            $result['result'] = $rs->fields['result'];
            $result['atime'] = $rs->fields['atime'];
            $result['utime'] = $rs->fields['utime'];
            return $result;
        }
        return false;
    }
    public static function getCount($where = ''){
        global $conn;
        $where = strtolower($where);
        if (!empty($where) && strpos($where, 'where') === false) {
            $where = ' WHERE '.$where;
        }
        $sql = 'SELECT COUNT(gid) AS total FROM hdgames '.$where.' LIMIT 1';
        $rs = $conn->execute($sql);
        if ($rs && $conn->Affected_Rows() > 0) {
            return $rs->fields['total'];
        }
        return 0;
    }
    public static function getAll($pageindex,$pagesize=20,$where='',$order='id ASC'){
        global $conn;
        $where = strtolower($where);
        if (!empty($where) && strpos($where, 'where') === false) {
            $where = ' WHERE '.$where;
        }
        $sql = 'SELECT id,gid,uid,uname,data,result,atime,utime,ip FROM hdgames '.$where.' ORDER BY '.$order.' LIMIT '.$pageindex.','.$pagesize;
        $rs = $conn->execute($sql);
        if ($rs && $conn->Affected_Rows() > 0) {
            $result = array();
            $rows = $rs->getrows();
            foreach ($rows as $key => $value) {
                $result[$key]['id'] = $value['id'];
                $result[$key]['gid'] = $value['gid'];
                $result[$key]['uid'] = $value['uid'];
                $result[$key]['uname'] = $value['uname'];
                $result[$key]['data'] = $value['data'];
                $result[$key]['result'] = $value['result'];
                $result[$key]['atime'] = $value['atime'];
                $result[$key]['utime'] = $value['utime'];
                $result[$key]['ip'] = long2ip($value['ip']);
            }
            return $result;
        }
        return false;
    }
}