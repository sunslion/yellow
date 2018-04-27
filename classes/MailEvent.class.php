<?php
class MailEvent {
    public static function add($options=array()){
        global $conn;
        $options = array_merge(array(
            'ctime'=>1,
        	'sender' =>'',
        	'receiver'=>'',
        	'subject'=>'',
        	'body'=>'',
            'inbox'=>1,
            'outbox'=>0,
            'status'=>1
        ),$options);
        foreach ($options as $k => $v){
            if ($k == 'body') {
                $options[$k] = $v;
            }else{
                $options[$k] = urlencode($v);
            }
            
        }
        $ename = 'Mail';
        $eaddtime = time();
        $ctime = $eaddtime + $options['ctime'];
        unset($options['ctime']);
        $json = json_encode($options);
        $options = $json;
        $sql = "INSERT INTO event (ename,options,ctime,eaddtime) VALUES('{$ename}','{$options}',{$ctime},{$eaddtime})";
        $rs = $conn->execute($sql);
        return $rs;
    }
    
    public static function listen(){
        global $conn;
        $time = time();
        $sql = "SELECT eid,options FROM event WHERE estatus = 0";
        $rs = $conn->execute($sql);
        if (!empty($rs)) {
            $events = $rs->getrows();
            foreach ($events as $v){
                $options = json_decode($v['options'],true);
                foreach ($options as $k => $ov) {
                    if ($k  == 'body') {
                        $options[$k] = $ov;
                    }else{
                        $options[$k] = urldecode($ov);
                    } 
                }
                if (!empty($options)) {
                    self::compose($v['eid'],$options);
                }
            }
        }
    }
    public static function compose($eid,$options=array()){
        global $conn;
        if (isset($options['receiver'])) {
            if ($options['receiver'] == '0') {
                self::update($eid, 1);
            }else{
                $receivers = explode(',', $options['receiver']);
                $count = count($receivers);
                if ($count > 10000) {
                    self::update($eid, 1);
                }else{
                    $time = date('Y-m-d H:i:s',time());
                    $sql = "INSERT INTO mail ( sender, receiver, subject, body, inbox, outbox, send_date, status ) VALUES ";
                    foreach ($receivers as $r) {
                        $sql .= "('{$options['sender']}','{$r}','{$options['subject']}','{$options['body']}','{$options['inbox']}','{$options['outbox']}','{$time}',1),";
                    }
                    $sql = rtrim($sql,',');
                    $rs = $conn->execute($sql);
                    if (!empty($rs)) {
                        self::update($eid, 2);
                    }
                }
            }
        }
        return false;
    }
    public static function rm($eid){
        global $conn;
        $sql = "DELETE FROM event WHERE eid = {$eid} ";
        return $conn->execute($sql);
    }
    protected static  function update($eid,$status){
        $time = time();
        global $conn;
        $sql = "UPDATE event SET estatus = {$status} , esendtime = {$time} WHERE eid = {$eid}";
        return $conn->execute($sql);
    }
}