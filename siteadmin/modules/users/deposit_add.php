<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR'].'/include/config.rank.php';
if (isset($_POST['add_deposit'])) {
    require $config['BASE_DIR']. '/classes/filter.class.php';
    $reg = "/^\d+(\.\d+)?$/";
    $filter = new VFilter();
    $uid = $filter->get('uid');
    $money = $filter->get('money');
    if (empty($money)) {
        $errors[] = '本次存款金额不能为空';
    }
    if (!preg_match($reg,$money)){
        $errors[] = '本次存款金额需填写有效数字';
    }
    $sebi = $filter->get('sebi');
    if ($sebi == '') {
        $errors[] = '本次存款所得色币不能为空';
    }
    if (!preg_match($reg, $sebi)) {
        $errors[] = '本次存款所得色币需填写有效数字';
    }
    $sebi = intval($sebi);
    $isget_sebi = $filter->get('isget_sebi');
    $isget_sebi = intval($isget_sebi);
    if ($isget_sebi == 1) {
        $get_sebi = $filter->get('get_sebi');
        if ( $get_sebi == '') {
            $errors[] = '玩游戏所得色币不能为空';
        }
        if (!preg_match($reg, $get_sebi)) {
            $errors[] = '玩游戏所得色币需填写有效数字';
        }
    }
    $get_sebi = intval($get_sebi);
    $dtime = $filter->get('dtime');
    if (empty($dtime)) {
        $errors[] = '存款时间不能为空';
    }
    $dtime = strtotime($dtime);
    if (!$errors) {
        $atime = time();
        $sql = 'INSERT INTO user_deposit(uid,money,sebi,isget_sebi,get_sebi,dtime,atime) VALUES('
            .mysql_real_escape_string($uid).','
            .mysql_real_escape_string($money).','
            .mysql_real_escape_string($sebi).','
            .mysql_real_escape_string($isget_sebi).','
            .mysql_real_escape_string($get_sebi).','
            .mysql_real_escape_string($dtime).','
            .$atime.');';
        $rs = $conn->execute($sql);
        if (!$rs)
            $errors[] = '添加失败';
        if (!$errors) {
            $sql = "SELECT sebi_surplus FROM user_sebi WHERE UID = {$uid} LIMIT 1;";
            $rs = $conn->execute($sql);
            if ( $conn->Affected_Rows() == 0){
                $sql = "INSERT INTO user_sebi (uid) VALUES ({$uid});";
                $rs = $conn->execute($sql);
                if (!$rs) {
                    $errors[] = '添加色币用户失败';
                }
            }
            if (!$errors) {
                $send_total_surplus = $sebi + $get_sebi;
                $sql = "UPDATE user_sebi set sebi_total = sebi_total + {$send_total_surplus},sebi_surplus = sebi_surplus + {$send_total_surplus},isfree=0 where uid = {$uid} LIMIT 1;";
                $rs = $conn->execute($sql);
                if ($rs) {
                    $time = strtotime(date('Y-m-d'));
                    $options = array(
                        'host'=>$config['mem_host'],
                        'port'=>$config['mem_port'],
                        'prefix'=>'sebiv',
                        'expire'=>0,
                        'length'=>0
                    );
                    $cache = Cache::getInstance('MemcacheAction',$options);
                    $nkey = $uid.$time;
                    $cache->_unset($nkey);
                    
                    $sql = "SELECT sebi_surplus FROM user_sebi WHERE uid={$uid} LIMIT 1;";
                    $rs = $conn->execute($sql);
                    $sebi_surplus = $rs->fields['sebi_surplus'];
                    $range = 0;
                    foreach ($rank_range as $k => $v) {
                        list($min,$max) = $v;
                        if ($min <= $sebi_surplus && $max >= $sebi_surplus) {
                            $range = $k;
                            break;
                        }
                    }
                    $new_premium = 0;
                    foreach ($user_rank_range as $key => $value) {
                        if (in_array($range, $value)) {
                            $new_premium = $key;
                            break;
                        }
                    }
                    $sql = "SELECT premium FROM signup WHERE UID = {$uid} LIMIT 1;";
                    $rs = $conn->execute($sql);
                    $premium = $rs->fields['premium'];
                    if ($premium != $new_premium) {
                        $otime = strtotime(date('Y-m-d'));
                        $sql = "UPDATE signup SET premium = {$new_premium},otime={$otime} WHERE UID = {$uid} LIMIT 1;";
                        $conn->execute($sql);
                    }
                    $messages[] = '记录添加成功!';
                }else{
                    $errors[] = '添加色币失败';   
                }
            }
        }
    }
}
$uid = intval($_GET['uid']);
$sql = "SELECT username,premium FROM signup WHERE UID = {$uid} LIMIT 1;";
$rs = $conn->execute($sql);
$username = $rs->fields['username'];
$premium = $rs->fields['premium'];
$smarty->assign('uid',$uid);
$smarty->assign('username',$username);
$smarty->assign('user_range',$user_range[$premium]);
$smarty->assign('rank_range','['.json_encode($rank_range).']');
$smarty->assign('rank_scale','['.json_encode($rank_scale).']');