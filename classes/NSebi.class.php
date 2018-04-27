<?php
class NSebi
{
    public static  function addSebiRecord($uid){
        global $conn;
        $uid = mysql_real_escape_string($uid);
        $sql = 'INSERT INTO user_sebi(uid) VALUES ('.$uid.')';
        $rs = $conn->execute($sql);
        if($rs){
            return true;
        }
        return false;
    }
    public static function updateSebi($uid,$sebi){
        global $conn;
        $uid = mysql_real_escape_string($uid);
        $sebi = mysql_real_escape_string($sebi);
        $sql = 'UPDATE user_sebi SET isfree = 0, sebi_total = sebi_total+'.$sebi.',sebi_surplus=sebi_surplus+'.$sebi.' WHERE uid = '.$uid;
        $rs = $conn->execute($sql);
        if($rs)
            return true;
        return false;
    }
    public static function updateTiYanbi($uid,$tiyanbi){
        global $conn;
        $uid = mysql_real_escape_string($uid);
        $tiyanbi = mysql_real_escape_string($tiyanbi);
        $sql = 'UPDATE user_sebi SET isfree = 1,sebi_tiyan=sebi_tiyan+'.$tiyanbi.' WHERE uid ='.$uid;
        $rs = $conn->execute($sql);
        if($rs)
            return true;
        return false;
    }
    public static function findSebiRecord($uid){
        global $conn;
        $uid = mysql_real_escape_string($uid);
        $sql = 'SELECT sebi,sebi_total,sebi_consume,sebi_surplus,jiangli_time,ip,isfree,sebi_tiyan FROM user_sebi WHERE uid = '.$uid.' LIMIT 1';
        $rs = $conn->execute($sql);
        if ($rs && $conn->Affected_Rows() > 0) {
            $sebiInfo = array();
            $sebiInfo['sebi'] = $rs->fields['sebi'];
            $sebiInfo['sebi_total'] = $rs->fields['sebi_total'];
            $sebiInfo['sebi_consume'] = $rs->fields['sebi_consume'];
            $sebiInfo['sebi_surplus'] = $rs->fields['sebi_surplus'];
            $sebiInfo['jiangli_time'] = $rs->fields['jiangli_time'];
            $sebiInfo['ip'] = $rs->fields['ip'];
            $sebiInfo['isfree'] = $rs->fields['isfree'];
            $sebiInfo['sebi_tiyan'] = $rs->fields['sebi_tiyan'];
            return $sebiInfo;
        }
        return false;
    }
}