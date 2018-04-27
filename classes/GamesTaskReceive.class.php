<?php
class GamesTaskReceive
{
    public static function add($uid,$taskid){
        global $conn;
        $uid = round($uid);
        $taskid = round($taskid);
        $atime = time();
        $sql = 'INSERT INTO games_task_receive(uid,taskid,atime) VALUES ('.$uid.','.$taskid.','.$atime.')';
        $rs = $conn->execute($sql);
        if($rs)
            return true;
        return false;
    }
    public static function isExists($uid,$taskid){
        global $conn;
        $uid = round($uid);
        $taskid = round($taskid);
        $sql = 'SELECT COUNT(id) AS total FROM games_task_receive WHERE uid ='.$uid.' AND taskid = '.$taskid.' LIMIT 1;';
        $rs = $conn->execute($sql);
        if($rs)
            return $rs->fields['total'] > 0 ? $rs->fields['total'] : false;
        return false;
    }
    public static function getUserTask($uid) {
        global $conn;
        $uid = round($uid);
        $sql = 'SELECT taskid FROM games_task_receive WHERE uid = '.$uid;
        $rs = $conn->execute($sql);
        if($rs && $conn->Affected_Rows() > 0){
            $result = array();
            $rows = $rs->getrows();
            foreach ($rows as $value) {
                $result[] = $value['taskid'];
            }
            return $result;
        }
        return false;
    }
    public static function getTotal($where = '') {
        global $conn;
        $where = strtolower($where);
        if (!empty($where) && strpos($where, 'where') === false) {
            $where = ' WHERE '.$where;
        }
        $sql = 'SELECT COUNT(id) AS total FROM games_task_receive '.$where.' limit 1';
        $rs = $conn->execute($sql);
        if ($rs && $conn->Affected_Rows() > 0) {
            return $rs->fields['total'];
        }
        return 0;
    }
    public static function updateIsPost($id){
        global $conn;
        $id = round($id);
        $sql = 'UPDATE games_task_receive SET ispost = 1 WHERE id='.$id;
        $rs = $conn->execute($sql);
        if ($rs) {
            return true;
        }
        return false;
    }
}