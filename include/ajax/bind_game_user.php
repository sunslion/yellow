<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR'].'/classes/QQCToGame.class.php';
disableRegisterGlobals();
$response = array('flag'=>1,'msg'=>'');
if (isset($_POST['guname'])) {
    $filter     = new VFilter();
    $guname   = $filter->get('guname');
    if(empty($guname)){
        $response['flag'] = false;
        $response['msg'] = '游戏账户名不能为空';
        echo json_encode($response);
        exit;
    }
    //判断是否是乐橙用户
    $firstLetter = substr($guname, 0,1);
    if ($firstLetter !== 'c') {
        $response['flag'] = false;
        $response['msg'] = '游戏账户不属于凯时平台用户';
        echo json_encode($response);
        exit;
    }
    if(QQCToGame::find($guname)){
        $response['flag'] = false;
        $response['msg'] = '该账户已被绑定使用';
        echo json_encode($response);
        exit;
    }
    $result = getRemoteData($guname);
    if (!$result) {
        $response['flag'] = false;
        $response['msg'] = '该账户在游戏平台没有找到';
        echo json_encode($response);
        exit;
    }
    $nr = json_decode($result,true);
    if ($nr['status'] == 0) {
        $response['flag'] = false;
        $response['msg'] = '该账户在游戏平台没有找到';
        echo json_encode($response);
        exit;
    }
    $uid = isset($_SESSION['uid']) ? intval($_SESSION['uid']) : 0;
    if($uid <= 0){
        $response['flag'] = false;
        $response['msg'] = '您没登陆，请登陆!';
        echo json_encode($response);
        exit;
    }
    require 'include/config.products.php';
    require 'include/config.rank.php';
    $r = QQCToGame::add($uid, $guname);
    //获取用户存款信息,如果有就得将用户存款信息添加，并且添加相关数据的色币及升级
    if($r){
        require 'classes/Deposit.class.php';
        require 'classes/NSebi.class.php';
        require 'classes/Member.class.php';
        foreach ($nr['msg'] as $sk => $sval){
            if ($sk === 'balance_record') {
                break;
            }
            if (strpos($sk, 'deposit') === false) {
                break;
            }
            list($key,$time) = explode('_', $sk);
            $re = Deposit::isRepeatRecord($uid, $time);
            if (!$re) {
                $r = Member::deposit($uid, $sval, $time);
                if ($r !== false) {
                    Member::updateUserProducts($uid, $guname);
                    set_session_vals(array('uid_premium'=>$r));
                }
            }
        }
        $response['flag'] = true;
        $response['msg'] = '游戏账号绑定成功';
        echo json_encode($response);
        exit;
    }
}
$response['flag'] = false;
$response['msg'] = '游戏账号绑定失败';
echo json_encode($response);
exit;
