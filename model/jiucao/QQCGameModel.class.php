<?php
defined('_VALID') or die('Restricted Access!');
class QQCGameModel extends BaseModel
{
    public function find($guname) {
        $guname = mysql_real_escape_string($guname);
        $sql = 'SELECT COUNT(id) as total FROM qqc_game WHERE gusername =\''.$guname.'\' LIMIT 1;';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return $rs->fields['total'] > 0 ? $rs->fields['total'] : false;
        }
        return false;
    }
    public function add($uid,$gusername) {
        $uid = round($uid);
        $gusername = mysql_real_escape_string($gusername);
        $products_num = 0;
        $time = time();
        include  BASE_PATH.'/include/config.products.php';
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
        $rs = $this->conn->execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0)
            return true;
        return false;
    }
    public function insert($uid,$gusername,$gameid){
        $uid = round($uid);
        $gusername = mysql_real_escape_string($gusername);
        $gameid = round($gameid);
        $btime = time();
        $sql = 'INSER INTO qqc_game(uid,gusername,gameid,btime) VALUES('.$uid.',\''.$gusername.'\','.$gameid.','.$btime.')';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return true;
        }
        return true;
    }
    
    public function updateIsgetsebi($uid,$isgetsebi=0) {
        $uid = round($uid);
        $isgetsebi = round($isgetsebi);
        $sql = 'UPDATE qqc_game SET isgetsebi = '.$isgetsebi.' WHERE uid = '.$uid.' LIMIT 1';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return true;
        }
        return false;
    }
    
    public function getList($names = array()) {
        if (!is_array($names)) {
            return false;
        }
        $str = '';
        foreach ($names as &$v) {
            $v = mysql_real_escape_string($v);
            $str .= '\''.$v.'\',';
        }
        $str = rtrim($str,',');
        $sql = 'SELECT uid,gusername,gameid,btime FROM qqc_game WHERE gusername in ('.$str.')';
        $rs = $this->conn->Execute($sql);
        if ($rs && $this->conn->Affected_Rows() > 0) {
            $arr = array();
            $rows = $rs->getrows();
            foreach ($rows as $k => $v) {
                $arr[$k]['uid'] = $v['uid'];
                $arr[$k]['gusername'] = $v['gusername'];
                $arr[$k]['gameid'] = $v['gameid'];
                $arr[$k]['btime'] = $v['btime'];
            }
            return $arr;
        }
        return false;
    }
}
?>