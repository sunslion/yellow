<?php
class Hbrecommend
{
    public static function add($uid,$ruid,$rip,$bamount){
        global $conn;
        $uid = round($uid);
        $ruid = round($ruid);
        $rip = round($rip);
        $bamount = round($bamount);
        $rtime = time();
        $sql = 'INSERT INTO hbrecommend(uid,ruid,rip,bamount,rtime) VALUES ('.$uid.','.$ruid.','.$rip.','.$bamount.','.$rtime.')';
        $rs = $conn->execute($sql);
        if($rs){
            return true;
        }
        return false;
    }
    public static function getUid($uid,$ruid) {
        global $conn;
        $uid = round($uid);
        $ruid = round($ruid);
        $sql = 'SELECT rip,bamount,rtime FROM hbrecommend WHERE uid = '.$uid.' AND ruid = '.$ruid.' LIMIT 1';
        $rs = $conn->execute($sql);
        if($rs && $conn->Affected_Rows() > 0){
            $hbrecommend = array();
            $hbrecommend['rip'] = $rs->fields['rip'];
            $hbrecommend['bamount'] = $rs->fields['rip'];
            $hbrecommend['rtime'] = $rs->fields['rtime'];
            return $hbrecommend;
        }
        return false;
    }
    public static function getHBUsers($uid){
        global $conn;
        $uid = round($uid);
        $sql = 'SELECT id,ruid,rip,bamount,rtime FROM hbrecommend WHERE uid = '.$uid.' ORDER BY rtime DESC LIMIT 4';
        $rs = $conn->execute($sql);
        if($rs){
            return $rs->getrows();
        }
        return false;
    }
    public static function getIp($ip){
        global $conn;
        $ip = round($ip);
        $sql = 'SELECT uid,ruid,bamount,rtime FROM hbrecommend WHERE rip = '.$ip.' LIMIT 1';
        $rs = $conn->execute($sql);
        if($rs && $conn->Affected_Rows() > 0){
            $hbrecommend = array();
            $hbrecommend['uid'] = $rs->fields['uid'];
            $hbrecommend['ruid'] = $rs->fields['ruid'];
            $hbrecommend['bamount'] = $rs->fields['rip'];
            $hbrecommend['rtime'] = $rs->fields['rtime'];
            return $hbrecommend;
        }
        return false;
    } 
    public static function getAll($pageindex=0,$limit=10,$order='id DESC'){
        global $conn;
        $pageindex = round($pageindex);
        $sql = 'SELECT ruid,uid,rip,rtime,bamount FROM hbrecommend ORDER BY '.$order.' LIMIT '.$pageindex.','.$limit;
        $rs = $conn->execute($sql);
        if($rs && $conn->Affected_Rows() > 0){
            $rows = $rs->getrows();
            $hbrecommend = array();
            foreach ($rows as $k => $v) {
                $hbrecommend[$k]['ruid'] = $v['ruid'];
                $hbrecommend[$k]['uid'] = $v['uid'];
                $hbrecommend[$k]['rip'] = $v['rip'];
                $hbrecommend[$k]['rtime'] = $v['rtime'];
                $hbrecommend[$k]['bamount'] = $v['bamount'];
            }
            return $hbrecommend; 
        }
        return false;
    }
}