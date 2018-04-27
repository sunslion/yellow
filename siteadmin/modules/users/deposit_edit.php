<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR'].'/include/config.rank.php';
$id = intval($_GET['id']);

if (isset($_POST['edit_deposit'])) {
    require $config['BASE_DIR']. '/classes/filter.class.php';
    $reg = "/^\d+(\.\d+)?$/";
    $filter = new VFilter();
    $id = $filter->get('id');
    $money = $filter->get('money');
    if (empty($money)) {
        $errors[] = '本次存款金额不能为空';
    }
    if (!preg_match($reg,$money)){
        $errors[] = '本次存款金额需填写有效数字';
    }
    $sebi = $filter->get('sebi');
    if ( $sebi == '') {
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
        $sql = "SELECT uid,sebi,get_sebi FROM user_deposit WHERE id = {$id} LIMIT 1;";
        $rs = $conn->execute($sql);
        $deposits = $rs->getrows();
        $deposit = $deposits[0];
        $uid = $deposit['uid'];
        $old_sebi = $deposit['sebi'];
        $old_get_sebi = $deposit['get_sebi'];
       
        $utime = time();
        $sql = "UPDATE user_deposit SET money = {$money},sebi={$sebi},isget_sebi={$isget_sebi},get_sebi={$get_sebi},dtime={$dtime},utime={$utime} WHERE id={$id}";
        $rs = $conn->execute($sql);
        if ($rs) {
            $sebi = $sebi - $old_sebi;
            $get_sebi = $get_sebi - $old_get_sebi;
            if ($get_sebi < 0) {
                $get_sebi = 0;
            }
            $send_total_surplus = $sebi + $get_sebi;
            //查询剩余色币数量
            $sql = "SELECT sebi_surplus FROM user_sebi WHERE uid={$uid} LIMIT 1;";
            $irs = $conn->execute($sql);
            $rows = $irs->getrows();
            if ( count($rows)>0 ) {
                $sql = "UPDATE user_sebi set sebi_total = sebi_total + {$send_total_surplus},sebi_surplus = sebi_surplus + {$send_total_surplus},isfree = 0 where uid = {$uid}";
                $rs = $conn->execute($sql);
            }else{
                $sql = "INSERT INTO user_sebi(uid,sebi_total,sebi_surplus,isfree) VALUES ({$uid},{$send_total_surplus},{$send_total_surplus},0);";
                $rs = $conn->execute($sql);
            }
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
                //升级
                $sql = "SELECT sebi_surplus FROM user_sebi WHERE uid={$uid} LIMIT 1;";
                $irs = $conn->execute($sql);
                $sebi_surplus = $irs->fields['sebi_surplus'];
                //查找当前色币所在的等级
                $range = 0;
                foreach ($rank_range as $k => $v) {
                    list($min,$max) = $v;
                    if ($min <= $sebi_surplus && $max >= $sebi_surplus) {
                        $range = $k;
                        break;
                    }
                }
                //查找当前用户等级在哪个等级组
                $new_premium = 0;
                foreach ($user_rank_range as $key => $value) {
                    if (in_array($range, $value)) {
                        $new_premium = $key;
                        break;
                    }
                }
                //查找当前用户的等级组
                $sql = "SELECT premium FROM signup WHERE UID = {$uid} LIMIT 1;";
                $rs = $conn->execute($sql);
                $premium = $rs->fields['premium'];
                //如果当前用户的等级组与新等级组不相同，就更新到新的等级组
                if ($premium != $new_premium) {
                    $otime = strtotime(date('Y-m-d'));
                    $sql = "UPDATE signup SET premium = {$new_premium},otime={$otime} WHERE UID = {$uid} LIMIT 1;";
                    $conn->execute($sql);
                }
                $messages[] = '记录编辑成功!';
            }else{
                $errors[] = '编辑色币失败';   
            }
        }
    }
}
$sql = "SELECT uid,money,sebi,isget_sebi,get_sebi,dtime,ishongbao,isfirstdeposit FROM user_deposit WHERE id = {$id} LIMIT 1;";
$rs = $conn->execute($sql);
$deposits = $rs->getrows();
$deposit = $deposits[0];
$uid = $deposit['uid'];

$sql = "SELECT username,premium FROM signup WHERE UID = {$uid} LIMIT 1;";
$rs = $conn->execute($sql);
$username = $rs->fields['username'];
$premium = $rs ->fields['premium'];
$smarty->assign('id',$id);
$smarty->assign('uid',$uid);
$smarty->assign('username',$username);
$smarty->assign('user_range',$user_range[$premium]);
$smarty->assign('deposit',$deposit);
$smarty->assign('rank_range','['.json_encode($rank_range).']');
$smarty->assign('rank_scale','['.json_encode($rank_scale).']');