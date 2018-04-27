<?php
class HDBless
{
    public static function add($uid,$uname,$ip,$qq,$context){
        global $conn;
        $qq = mysql_real_escape_string($qq);
        $context = mysql_real_escape_string($context);
        $atime = time();
        $sql = 'INSERT INTO bless(uid,uname,ip,qq,context,atime) VALUES ('.$uid.',\''.$uname.'\','.$ip.',\''.$qq.'\',\''.$context.'\','.$atime.')';
        $rs = $conn->execute($sql);
        if($rs){
            return true;
        }
        return false;
    }
    public static function updateIsShow($id){
        global $conn;
        $utime = time();
        $sql = 'UPDATE bless SET isshow = 1,utime = '.$utime.' WHERE id='.$id;
        $rs = $conn->execute($sql);
        if($rs)
            return true;
        return false;
    }
    public static function getCount($where='isshow = 1'){
        global $conn;
        $where  = strtolower($where);
        if(!empty($where) && strpos($where, 'where') === false){
            $where = ' WHERE '.$where;
        }
        $sql = 'SELECT COUNT(id) AS total FROM bless '.$where.' LIMIT 1';
        $rs = $conn->execute($sql);
        if ($rs && $conn->Affected_Rows() > 0) {
            return $rs->fields['total'];
        }
        return 0;
    }
    public static function get($pageindex,$pagesize=20,$where='isshow = 1',$order='id desc') {
        global $conn;
        $where  = strtolower($where);
        if(!empty($where) && strpos($where, 'where') === false){
            $where = ' WHERE '.$where;
        }
        $sql = 'SELECT id,uid,uname,qq,context,isshow,atime,utime,ip FROM bless '.$where.' ORDER BY '.$order.' LIMIT '.$pageindex.','.$pagesize;
        $rs = $conn->execute($sql);
        if ($rs && $conn->Affected_Rows() > 0) {
            $result = array();
            $rows = $rs->getrows();
            foreach ($rows as $k => $v) {
                $result[$k]['id'] = $v['id'];
                $result[$k]['uid'] = $v['uid'];
                $result[$k]['uname'] = $v['uname'];
                $result[$k]['qq'] = $v['qq'];
                $result[$k]['context'] = $v['context'];
                $result[$k]['isshow'] = $v['isshow'];
                $result[$k]['atime'] = $v['atime'];
                $result[$k]['utime'] = $v['utime'];
                $result[$k]['ip'] = long2ip($v['ip']);
            }
            return $result;
        }
        return false;
    }
    
}