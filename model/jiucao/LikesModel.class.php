<?php
defined('_VALID') or die('Restricted Access!');
class LikesModel extends BaseModel
{
    public function insert($uid,$vid,$type,$ip=0) {
        $uid = round($uid);
        $vid = round($vid);
        $type = mysql_real_escape_string($type);
        $vtime = strtotime(date('Y-m-d'));
        $ip = mysql_real_escape_string($ip);
        
        $sql = 'INSERT INTO video_likes(uid,vid,'.$type.',vtime,ip) VALUES('.$uid.','.$vid.',1,'.$vtime.','.$ip.')';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return true;
        }
        return false;
    }
    public function setInc($uid,$type,$step=1){
        $uid = round($uid);
        $type = mysql_real_escape_string($type);
        $vtime = strtotime(date('Y-m-d'));
        $sql = 'UPDATE video_likes SET '.$type.' = '.$type.'+1,vtime = '.$vtime.' WHERE uid ='.$uid.' LIMIT 1';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return true;
        }
        return false;
    }
    public function setIncIp($ip,$vid,$type,$step=1){
        $ip = mysql_real_escape_string($ip);
        $type = mysql_real_escape_string($type);
        $vtime = strtotime(date('Y-m-d'));
        $vid = round($vid);
        $sql = 'UPDATE video_likes SET '.$type.' = '.$type.'+1,vtime = '.$vtime.' WHERE vid = '.$vid.' AND ip ='.$ip.' LIMIT 1';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return true;
        }
        return false;
    }
    public function get($uid) {
        $uid = round($uid);
        $sql = 'SELECT vid,likes,dislikes,vtime FROM video_likes WHERE uid ='.$uid.' LIMIT 1';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return array(
                'vid' => $rs->fields['vid'],
                'likes' => $rs->fields['likes'],
                'dislikes' => $rs->fields['dislikes'],
                'vtime' => $rs->fields['vtime']
            );
        }
        return false;
    }
    public function getIp($ip,$vid=0) {
        $ip = mysql_real_escape_string($ip);
        $vid = round($vid);
        
        $sql = 'SELECT vid,likes,dislikes,vtime FROM video_likes WHERE vid = '.$vid.' AND ip ='.$ip.' LIMIT 1';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return array(
                'vid' => $rs->fields['vid'],
                'likes' => $rs->fields['likes'],
                'dislikes' => $rs->fields['dislikes'],
                'vtime' => $rs->fields['vtime']
            );
        }
        return false;
    }
    public function getTodayVote($uid,$vtime){
        $uid = round($uid);
        $vtime = round($vtime);
        $sql = 'SELECT vid,likes,dislikes FROM video_likes WHERE uid ='.$uid.' AND vtime = '.$vtime.' LIMIT 1';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return array(
                'vid' => $rs->fields['vid'],
                'likes' => $rs->fields['likes'],
                'dislikes' => $rs->fields['dislikes']
            );
        }
        return false;
    }
    public function getTodayVoteIp($ip,$vid=0,$vtime=0){
        $ip = mysql_real_escape_string($ip);
        $vtime = round($vtime);
        $vid = round($vid);
        $sql = 'SELECT vid,likes,dislikes FROM video_likes WHERE vid = '.$vid.' AND ip ='.$ip.' AND vtime = '.$vtime.' LIMIT 1';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return array(
                'vid' => $rs->fields['vid'],
                'likes' => $rs->fields['likes'],
                'dislikes' => $rs->fields['dislikes']
            );
        }
        return false;
    }
}
?>