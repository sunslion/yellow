<?php
class QQCToGame
{
    public static function find($guname) {
        global $conn;
        $guname = mysql_real_escape_string($guname);
        $sql = 'SELECT COUNT(id) as total FROM qqc_game WHERE gusername =\''.$guname.'\' LIMIT 1;';
        $rs = $conn->execute($sql);
        if($rs){
           return $rs->fields['total'] > 0 ? $rs->fields['total'] : false;
        }
        return false;
    }
    public static function add($uid,$gusername) {
        global $conn,$products_letter;
        $uid = intval($uid);
        $uid = mysql_real_escape_string($uid);
        $gusername = mysql_real_escape_string($gusername);
        $products_num = 0;
        $time = time();
        if (is_array($products_letter)) {
            $first_letter = substr($gusername, 0,1);
            foreach ($products_letter as $k => $v) {
                if ($first_letter === $v) {
                    $products_num = $k;
                    break;
                }
            }
        }
        $sql = 'INSERT INTO qqc_game (uid,gusername,gameid,btime) VALUES('.$uid.',\''.$gusername.'\','.$products_num.','.$time.')';
        $rs = $conn->execute($sql);
        if($rs)
            return true;
        return false;
    }
    public static function setIsgetsebi($uid,$isgetsebi) {
        global $conn;
        $uid = mysql_real_escape_string($uid);
        $uid = intval($uid);
        $isgetsebi = mysql_real_escape_string($isgetsebi);
        $sql = 'UPDATE qqc_game SET isgetsebi ='.$isgetsebi.' WHERE uid ='.$uid;
        $rs = $conn->execute($sql);
        if($rs)return true;
        return false;
    }
    public static function findObjIsGetsebi($uid,$isgetsebi) {
        global $conn;
        $uid = mysql_real_escape_string($uid);
        $uid = intval($uid);
        $sql = 'SELECT id FROM qqc_game WHERE uid='.$uid.' AND isgetsebi='.$isgetsebi.' LIMIT 1';
        $rs = $conn->execute($sql);
        if($rs)
            return $rs->fields['id'];
        return false;
    }
    public static function findObj($uid) {
        global $conn;
        $uid = mysql_real_escape_string($uid);
        $uid = intval($uid);
        $sql = 'SELECT gusername,gameid,btime,isgetsebi FROM qqc_game WHERE uid = '.$uid .' LIMIT 1';
        $rs = $conn->execute($sql);
        if($rs && $conn->Affected_Rows() > 0){
            return array(
                'gusername'=>$rs->fields['gusername'],
                'gameid'=>$rs->fields['gameid'],
                'btime'=>$rs->fields['btime'],
                'isgetsebi'=>$rs->fields['isgetsebi']
            );
        }
        return false;
    }
}