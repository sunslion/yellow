<?php
class Hongbao
{
    public static function add($uid,$amount,$ip) {
       global $conn;
       $uid= round($uid);
       $amount = round($amount);
       $ip = round($ip);
       $sql = 'INSERT INTO hongbao (uid,amount,total,ip,isreceive,rtime) VALUES ('.$uid.','.$amount.','.$amount.','.$ip.',1,'.time().')';
       $rs = $conn->execute($sql);
       if($rs){
           return true;
       }
       return false;
    }
    public static function getUid($uid){
        global $conn;
        $uid = round($uid);
        $sql = 'SELECT amount,total,ip,isreceive,rtime,rectime,detotal FROM hongbao WHERE uid ='.$uid.' LIMIT 1';
        $rs = $conn->execute($sql);
        if ($rs && $conn->Affected_Rows() > 0) {
            $hongbao = array();
            $hongbao['amount'] = $rs->fields['amount'];
            $hongbao['total'] = $rs->fields['total'];
            $hongbao['ip'] = $rs->fields['ip'];
            $hongbao['isreceive'] = $rs->fields['isreceive'];
            $hongbao['rtime'] = $rs->fields['rtime'];
            $hongbao['rectime'] = $rs->fields['rectime'];
            $hongbao['detotal'] = $rs->fields['detotal'];
            return $hongbao;
        }
        return false;
    }
    public static function getIp($ip){
        global $conn;
        $ip = round($ip);
        $sql = 'SELECT uid,amount,total,isreceive,rtime,rectime,detotal FROM  hongbao WHERE ip ='.$ip.' LIMIT 1';
        $rs = $conn->execute($sql);
        if ($rs && $conn->Affected_Rows() > 0) {
            $hongbao = array();
            $hongbao['amount'] = $rs->fields['amount'];
            $hongbao['total'] = $rs->fields['total'];
            $hongbao['uid'] = $rs->fields['uid'];
            $hongbao['isreceive'] = $rs->fields['isreceive'];
            $hongbao['rtime'] = $rs->fields['rtime'];
            $hongbao['rectime'] = $rs->fields['rectime'];
            $hongbao['detotal'] = $rs->fields['detotal'];
            return $hongbao;
        }
        return false;
    }
    public static function updateAmount($uid,$amount){
        global $conn;
        $uid = round($uid);
        $amount = round($amount);
        $sql = 'UPDATE hongbao SET total ='.$amount.',rectime = '.time().' WHERE uid ='.$uid;
        $rs = $conn->execute($sql);
        if($rs && $conn->Affected_Rows() > 0)
            return true;
        return false;
    }
    public static function updateDetotal($uid,$amount){
        global $conn;
        $uid = round($uid);
        $amount = round($amount);
        $sql = 'UPDATE hongbao SET detotal ='.$amount.',rectime = '.time().' WHERE uid ='.$uid;
        $rs = $conn->execute($sql);
        if($rs && $conn->Affected_Rows() > 0)
            return true;
        return false;
    }
    public static function getHongbaos($uids){
        global $conn;
        $where = '';
        if (is_array($uids)) {
            $where = ' WHERE uid in ('.implode(',', $uids).')';
        }else{
            $uids = round($uids);
            $where = ' WHERE uid = '.$uids;
        }
        $sql = 'SELECT uid,total FROM hongbao '.$where;
        $rs = $conn->execute($sql);
        if ($rs && $conn->Affected_Rows() > 0) {
            $result = array();
            $rows = $rs->getrows();
            foreach ($rows as $k => $v) {
                $result[$k]['uid'] = $v['uid'];
                $result[$k]['total'] = $v['total'];
            }
            return $result;
        }
        return false;
    }
}