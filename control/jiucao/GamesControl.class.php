<?php
defined('_VALID') or die('Restricted Access!');
class Games extends Base
{
    public function onReturn() {
        $d = get_request_arg('return','string');
        if (empty($d)) {
            exit;
        }
        $unameArr = explode(',', $d);
        $qqcgamesModel = $this->modelFactory->get('qQCGame');
        $QQCGameList = $qqcgamesModel->getList($unameArr);
        $signupModel = $this->modelFactory->get('signup');
        $existArr = array();
        if ($QQCGameList) {
            foreach ($QQCGameList as $k => $v) {
                $existArr[$v['gusername']] = $v['uid'];
                $signupModel->updateUserProducts($v['uid'],$v['gusername']);
            }
        }
        if (count($existArr) > 0) {
            $remoteArr = array();
            foreach ($existArr as $k => $vuid) {
                $return = getRemoteData($k);
                //如果后面有多个平台就要注意了
                $remoteArr[$vuid] = $return;
            }
            unset($unameArr);
            unset($existArr);
            $depositModel = $this->modelFactory->get('deposit');
            
            foreach ($remoteArr as $kvuid => $v) {
                //查找存款记录，添加记录，追加色币
                $result = json_decode($v,true);
                if ($result['status'] == 0) {
                    break;
                }
                foreach ($result['msg'] as $sk =>$sv) {
                    if (strpos($sk, 'deposit_') !== false) {
                        list($key,$time) = explode('_', $sk);
                        $re = $depositModel->isRepeatRecord($kvuid, $time);
                        if (!$re) {
                            $r = $signupModel->deposit($kvuid, $sv, $time);
                        }
                    }
                    unset($result['msg'][$sk]);
                }
            }
            unset($remoteArr);
        }
    }
    
    public function onAjaxbindgameuser(){
        $this->isajax = 1;
        $response = array('flag'=>1,'msg'=>'');
        $filter = new Libs_Filter();
        $guname = $filter->get('guname');
        if(empty($guname)){
            $response['flag'] = 0;
            $response['msg'] = '游戏账户名不能为空';
            echo json_encode($response);
            exit;
        }
        //判断是否是乐橙用户
        $firstLetterArr = array('r');
        $firstLetter = substr($guname, 0,1);
        if (!in_array($firstLetter, $firstLetterArr)) {
            $response['flag'] = 0;
            $response['msg'] = '游戏账户不属于该游戏指定平台';
            echo json_encode($response);
            exit;
        }
        $qqcGameModel = $this->modelFactory->get('qQCGame');
        if($qqcGameModel->find($guname)){
            $response['flag'] = 0;
            $response['msg'] = '该账户已被绑定使用';
            echo json_encode($response);
            exit;
        }
        $result = getRemoteData($guname);
        if (!$result) {
            $response['flag'] = 0;
            $response['msg'] = '该账户在游戏平台没有找到';
            echo json_encode($response);
            exit;
        }
        $nr = json_decode($result,true);
        if ($nr['status'] == 0) {
            $response['flag'] = 0;
            $response['msg'] = '该账户在游戏平台没有找到';
            echo json_encode($response);
            exit;
        }
        if(!$this->isLogin()){
            $response['flag'] = 0;
            $response['msg'] = '您没登陆，请登陆!';
            echo json_encode($response);
            exit;
        }
        $uid = $_SESSION['uid'];
        $r = $qqcGameModel->add($uid, $guname);
        //获取用户存款信息,如果有就得将用户存款信息添加，并且添加相关数据的色币及升级
        if($r){
            $depositModel = $this->modelFactory->get('deposit');
            $signupModel = $this->modelFactory->get('signup');
            foreach ($nr['msg'] as $sk => $sval){
                if (strpos($sk, 'deposit') === false) {
                    continue;
                }
                list($key,$time) = explode('_', $sk);
                $re = $depositModel->isRepeatRecord($uid, $time);
                if (!$re) {
                    $r = $signupModel->deposit($uid, $sval, $time);
                    if ($r !== false) {
                        $signupModel->updateUserProducts($uid, $guname);
                        set_session_vals(array('uid_premium'=>$r));
                    }
                }
            }
            $response['flag'] = 1;
            $response['msg'] = '游戏账号绑定成功';
        }else{
            $response['flag'] = 0;
            $response['msg'] = '游戏账号绑定失败';
        }
        echo json_encode($response);
        exit;
    }
    public function onAjaxcheckguname() {
        $this->isajax = 1;
        $response = array('flag'=>1,'msg'=>'');
        $filter = new Libs_Filter();
        $guname = $filter->get('guname');
        if(empty($guname)){
            $response['flag'] = 0;
            $response['msg'] = '游戏账户名不能为空';
            echo json_encode($response);
            exit;
        }
        //判断是否是乐橙用户
        $firstLetterArr = array('r');
        $firstLetter = substr($guname, 0,1);
        if (!in_array($firstLetter, $firstLetterArr)) {
            $response['flag'] = 0;
            $response['msg'] = '游戏账户不属于该游戏指定平台';
            echo json_encode($response);
            exit;
        }
        $qqcGameModel = $this->modelFactory->get('qQCGame');
        if($qqcGameModel->find($guname)){
            $response['flag'] = 0;
            $response['msg'] = '该账户已被绑定使用';
            echo json_encode($response);
            exit;
        }
        $result = getRemoteData($guname);
        if (!$result) {
            $response['flag'] = 0;
            $response['msg'] = '该账户在游戏平台没有找到';
            echo json_encode($response);
            exit;
        }
        $nr = json_decode($result,true);
        if ($nr['status'] == 0) {
            $response['flag'] = 0;
            $response['msg'] = '该账户在游戏平台没有找到';
            echo json_encode($response);
            exit;
        }
        echo json_encode($response);
        exit;
    }
}
?>