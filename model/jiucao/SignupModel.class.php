<?php
defined('_VALID') or die('Restricted Access!');
class SignupModel extends BaseModel
{
    public function validUserPlay($uid,$t,$vid,$ip,$totalTime,$cache,$timeToSebi){
        $result = array('premium'=>0,'code'=>0,'msg'=>'');
        $uid = round($uid);
        $t = round($t);
        $vid = round($vid);
        $user = null;
        if ($uid > 0) {
            $user = $this->getUid($uid);
        }
        $premium = 0;
        if ($user) {
            $premium = (int)$user['premium'];
        }
        $result['premium'] = $premium;
        if ($premium > 0) {
            $sebiNum = 0;
            foreach ($timeToSebi as $k => $v) {
                list($min,$max) = $v;
                if ($min < $totalTime && $totalTime <= $max) {
                    $sebiNum = $k;
                    break;
                }
            }
            if ($premium === 1) {
                $userSebiModel = new UserSebiModel($this->conf);
                $userSebi = $userSebiModel->get($uid);
                if (!$userSebi) {
                    $result['code'] = 3;
                    $result['msg'] = '系统未找到您的金币记录';
                    return $result;
                }
                if ($sebiNum > $userSebi['sebi_surplus']) {
                    $result['code'] = 3;
                    $result['msg'] = '您的金币余额不够支付当前视频需要的金币数';
                    return $result;
                }
                $userSebiView = new UserSebiViewModel($this->conf);
                $viewCount = $userSebiView->getTodayView($uid, $vid);
                if ($viewCount > 0) {
                    $result['code'] = 13;
                    $result['msg'] = '今天你可以放心看了';
                    return $result;
                }
                if($userSebiModel->setDec('sebi_surplus',$sebiNum,'uid='.$uid)){
                    $userSebiModel->setInc('sebi_consume',$sebiNum,'uid='.$uid);
                    $userSebiView->insert($uid, $vid);
                    $sebiSurplus = $userSebi['sebi_surplus'] - $sebiNum;
                    $rankModel = new RankModel($this->conf);
                    $range = $rankModel->getRange($sebiSurplus);
                    $premium = $rankModel->getPremium($range);
                    $this->updatePremium($uid,$premium);
                    $result['code'] = 11;
                    $result['msg'] = '已扣金币';
                    return $result;
                }
            }elseif ($premium === 2){
                $expireDate = strtotime('+'.$user['years'].' years',$user['otime']);
                if ($expireDate < time()) {
                    $this->updatePremium($uid,0);
                    $result['code'] = 4;
                    $result['msg'] = '年VIP用户已到期';
                    return $result;
                }
                $result['code'] = 22;
                $result['msg'] = '年VIP还未到期';
                return $result;
            }
        }else{
            $key = 'g_'.$ip;
            if ($uid > 0) {
                $key = 'u_'.$uid;
            }
            $data = $cache->get($key);
            //游客和普通 用户只能观看6部，并且每部只能是5分钟,可在当天观看多次
            $viewNums = 0;
            if ($data) {
                $viewNums = count($data);
            }
            if ($viewNums >= 6 && !in_array($vid, $data)) {
                $result['code'] = 1;
                $result['msg'] = '奴家已经陪伴您<b>30</b>分钟了.';
                return $result;
            }
            if ($t >= 300) {
                $result['code'] = 2;
                $result['msg'] = '奴家只给您5分钟时间来欣赏该视频哦！';
                return $result;
            }
            if ($data && !in_array($vid, $data)) {
                $data[] = $vid;
            }
            $expireTime = strtotime('+1 days',strtotime(date('Y-m-d'))) - time();
            $cache->set($key,$data,$expireTime);
            $result['msg'] = '已经记录观看该片的时间';
        }
        return $result;
    }
    public function reg($username,$pwd,$repwd,$email,$gender,$age,$terms,$reg_ip){
        $errors = array();
        if (empty($username)) {
            $errors[] = '请填写用户名';
        }elseif (mbstrlen($username) > 15){
            $errors[] = '用户名太长了';
        }elseif ($this->get($username)){
            $errors[] = '用户名已存在';
        }
        
        if (empty($pwd)) {
            $errors[] = '请填写密码';
        }elseif ($pwd != $repwd){
            $errors[] = '密码输入不一致';
        }
        
        if (empty($email)) {
            $errors[] = '请填写邮箱';
        }elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $errors[] = '邮箱格式不正确';
        }elseif ($this->getEmail($email)){
            $errors[] = '邮箱地址已被使用';
        }
        
        if (empty($gender)) {
            $errors[] = '请选择性别';
        }
        if (empty($age)) {
            $errors[] = '您未满18岁?';
        }
        if (empty($terms)) {
            $errors[] = '您不同意相关条款和隐私政策?';
        }
        
        if (empty($errors)) {
            return $this->insert($username, $pwd, $email, $gender,$reg_ip);
        }
        return $errors;
    }
    public function authenticate($username,$pwd){
        $result = array('errors'=>array(),'user'=>array());
        if (empty($username) || empty($pwd)) {
            $result['errors'][] = '用户名或密码不能为空';
        }
        if (!empty($result['errors'])) {
            return $result;
        }
        $user = $this->get($username);
        if($user){
            $pwd = md5($pwd);
            if($pwd === $user['pwd']){
                $this->updateLoginTime($user['UID'], time());
                $premium = 0;
                //色币的相关操作
                $sebiModel = new UserSebiModel($this->conf);
                if ($user['premium'] == 1) {//积分VIP用户
                    //获取当前用户的色币情况
                    $sebi = $sebiModel->get($user['UID']);
                    if(isset($sebi['sebi_surplus']) && $sebi['sebi_surplus'] <= 0){
                        //用户等级设置为0
                        $this->updatePremium($user['UID']);
                        //更新用户相关的色币数
                        $this->authenticateUpdateSebi($user['UID'],$sebiModel);
                        //更新存款记录中关于色币的数据
                        $this->authenticateUpdateDeposit($user['UID']);
                    }else{
                        $premium = $user['premium'];
                    }
                }elseif ($user['premium'] == 2){//年VIP用户
                    $today = strtotime(date('Y-m-d'));
                    $endTime = strtotime('+1 year',$user['otime']);
                    if ($today > $endTime) {
                        //用户等级设置为0
                       $this->updatePremium($user['UID']);
                       //更新用户相关的色币数
                       $this->authenticateUpdateSebi($user['UID'],$sebiModel);
                       //更新存款记录中关于色币的数据
                       $this->authenticateUpdateDeposit($user['UID']);
                    }else{
                        $premium = $user['premium'];
                    }
                }else{
                    $premium = $user['premium'];
                }
                $user['premium'] = $premium;
                $result['user'] = $user;
            }else{
                $result['errors'][] = '密码错误';
            }
        }else{
            $result['errors'][] = '用户名不存在';
        }
        return $result;
    }
    private function authenticateUpdateSebi($uid,$sebiModel){
        $sebiModel->update(array(
            'sebi'=>0,
            'sebi_total'=>0,
            'sebi_consume'=>0,
            'sebi_surplus'=>0,
            'isfree'=>1,
        ),'uid ='.$uid);
    }
    private function authenticateUpdateDeposit($uid){
        //用户存款相关操作
        $depositModel = new UserDepositModel($this->conf);
        $depositModel->update(array(
            'sebi'=>0,
            'isget_sebi'=>0,
            'get_sebi'=>0,
        ),'uid='.$uid);
    }
 
    public function updatePremium($uid,$preminu = 0){
        $uid = round($uid);
        $preminu = round($preminu);
        $sql = 'UPDATE signup SET premium = '.$preminu.' UID = '.$uid.' LIMIT 1;';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0){
            return true;
        }
        return false;
    }
    
    public function updateLoginTime($uid,$time){
        $uid = round($uid);
        $time = round($time);
        $sql = 'UPDATE signup SET logintime = '.$time.' WHERE UID = '.$uid.' LIMIT 1;';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0)
            return true;
        return false;
    }
    
    public function insert($username,$pwd,$email,$gender,$reg_ip){
        $username = mysql_real_escape_string($username);
        $pwd = mysql_real_escape_string($pwd);
        $pwd = md5($pwd);
        $email = mysql_real_escape_string($email);
        $gender = mysql_real_escape_string($gender);
        $reg_ip = mysql_real_escape_string($reg_ip);
        $currtime = time();
        $sql = 'INSERT INTO signup(username,pwd,email,gender,reg_ip,addtime) VALUES (\''.$username.'\',\''.$pwd.'\',\''.$email.'\',\''.$gender.'\',\''.$reg_ip.'\',\''.$currtime.'\')';
        $rs = $this->conn->Execute($sql);
        $uid            = mysql_insert_id();
        if (intval($uid) == 0) {
            $sql = 'SELECT last_insert_id();';
            $res = $this->conn->execute($sql);
            $uid = $res->fields[0];
            $uid = intval($uid);
            unset($res);
        }
        return $uid;
    }
    
    public function updateUserProducts($uid,$pname){
        include BASE_PATH.'/include/config.products.php';

        if (is_array($products_letter)) {
            $uid = mysql_real_escape_string($uid);
            $first_letter = substr($pname, 0,1);
            $products_num = 0;
            foreach ($products_letter as $k => $v) {
                if ($first_letter === $v) {
                    $products_num = $k;
                    break;
                }
            }
            if ($products_num === 0) {
                return false;
            }
            $sql = 'SELECT products FROM signup WHERE UID ='.$uid.' LIMIT 1';
            $rs = $this->conn->Execute($sql);
            if ($rs) {
                $oproducts = $rs->fields['products'];
                if (strpos($oproducts, $products_num) !== false) {
                    return false;
                }
                $nproducts = empty($oproducts) ? $products_num : $oproducts.','.$products_num;
                $sql = 'UPDATE signup SET products = '.$nproducts.' WHERE UID='.$uid;
                $rs = $this->conn->execute($sql);
                return $rs;
            }
        }
        return false;
    }
    /*
     * return 添加存款信息，添加色币，升级并且如果成功，返回最新的级别，否则flase
     * */
    public function deposit($uid,$money,$dtime){
        $depositModel = new DepositModel($this->conf);
        $sebiModel = new SebiModel($this->conf);
        $re = $depositModel->addDepositRecord($uid, $money, $money, $dtime);
        if ($re) {
            $nre = $sebiModel->findSebiRecord($uid);
            if (!$nre) {
                $sebiModel->addSebiRecord($uid);
            }
            if($sebiModel->updateSebi($uid, $money)){
                $record = $sebiModel->findSebiRecord($uid);
                if ($record) {
                    return $this->updateMemberRank($uid, $record['sebi_surplus']);
                }
            }
        }
        return false;
    }
    /*
     * 更新用户级别
     * return 成功返回级别，失败返回false
     * */
    public function updateMemberRank($uid,$sebi_surplus) {
        $uid = round($uid);
        $rankModel = new RankModel($this->conf);
        $rang = $rankModel->getRange($sebi_surplus);
        $new_premium = $rankModel->getPremium($rang);
        $premium = $this->getMemberCurrPremium($uid);
        if ($new_premium != $premium) {
            $otime = strtotime(date('Y-m-d'));
            $sql = 'UPDATE signup SET premium ='.$new_premium.',otime='.$otime.' WHERE UID ='.$uid.' LIMIT 1;';
            $rs = $this->conn->execute($sql);
            if ($rs)
                return $new_premium;
        }
        return false;
    }
    public function getMemberCurrPremium($uid) {
        $uid = round($uid);
        $sql = 'SELECT premium FROM signup WHERE UID = '.$uid.' LIMIT 1';
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows() > 0)
            return $rs->fields['premium'];
        return 0;
    }
    public function get($uname){
        $uname = mysql_real_escape_string($uname);
        $sql    = "SELECT UID,username, email, pwd, emailverified, photo, fname, logintime, gender,premium,years,otime FROM signup WHERE username = '{$uname}' LIMIT 1;";
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows()> 0){
            return array(
              'UID'  => $rs->fields['UID'],
              'username'  => $rs->fields['username'],
              'email'=> $rs->fields['email'],
              'pwd'  => $rs->fields['pwd'],
              'emailverified'=>$rs->fields['emailverified'],
              'photo'=>$rs->fields['photo'],
              'fname'=>$rs->fields['fname'],
              'logintime'=>$rs->fields['logintime'],
              'gender'=>$rs->fields['gender'],
              'premium'=>$rs->fields['premium'],
              'years'=>$rs->fields['years'],
              'otime'=>$rs->fields['otime'],
            );
        }
        return false;
    }
    public function getEmail($email){
        $email = mysql_real_escape_string($email);
        $sql    = "SELECT UID,username, email, pwd, emailverified, photo, fname, logintime, gender,premium,years,otime FROM signup WHERE email = '{$email}' LIMIT 1;";
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows()> 0){
            return array(
                'UID'  => $rs->fields['UID'],
                'username'  => $rs->fields['username'],
                'email'=> $rs->fields['email'],
                'pwd'  => $rs->fields['pwd'],
                'emailverified'=>$rs->fields['emailverified'],
                'photo'=>$rs->fields['photo'],
                'fname'=>$rs->fields['fname'],
                'logintime'=>$rs->fields['logintime'],
                'gender'=>$rs->fields['gender'],
                'premium'=>$rs->fields['premium'],
                'years'=>$rs->fields['years'],
                'otime'=>$rs->fields['otime'],
            );
        }
        return false;
    }
    public function getUid($uid){
        $uname = round($uid);
        $sql    = "SELECT username, email, pwd, emailverified, photo, fname, logintime, gender,premium,years,otime FROM signup WHERE UID = '{$uid}' LIMIT 1;";
        $rs = $this->conn->Execute($sql);
        if($rs && $this->conn->Affected_Rows()> 0){
            return array(
                'username'  => $rs->fields['username'],
                'email'=> $rs->fields['email'],
                'pwd'  => $rs->fields['pwd'],
                'emailverified'=>$rs->fields['emailverified'],
                'photo'=>$rs->fields['photo'],
                'fname'=>$rs->fields['fname'],
                'logintime'=>$rs->fields['logintime'],
                'gender'=>$rs->fields['gender'],
                'premium'=>$rs->fields['premium'],
                'years'=>$rs->fields['years'],
                'otime'=>$rs->fields['otime'],
            );
        }
        return false;
    }
}
?>