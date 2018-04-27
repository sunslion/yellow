<?php
defined('_VALID') or die('Restricted Access!');
class Member extends Base{
    public function onLogin() {
        $this->pushAssigns(array('errors'=>isset($_SESSION['errors'])?$_SESSION['errors']:''));
        $this->tpls = array('login.tpl');
        if (isset($_SESSION['errors'])) {
            unset($_SESSION['errors']);
        }
    }
    public function onAuthenticate(){
        $result = $this->beforeLogin();
        if (isset($result['errors']) && !empty($result['errors'])) {
            $_SESSION['errors'] = $result['errors'];
            Libs_Redirect::go('/member/login');
        }
        if (isset($result['user']) && !empty($result['user'])) {
            $this->afterLogin($result['user']);
            $redirect = '/';
            if (isset($_SESSION['redirect'])) {
                $redirect = $_SESSION['redirect'];
                unset($_SESSION['redirect']);
            }
            Libs_Redirect::go($redirect);
        }
    }
    
    public function onAjaxAuthenticate(){
        $this->isajax = 1;
        $result = $this->beforeLogin();
        if (isset($result['user']) && !empty($result['user'])) {
            $this->afterLogin($result['user']);
        }
        echo json_encode($result['errors']);
        exit;
    }
    private function beforeLogin(){
        $filter = new Libs_Filter();
        $username = $filter->get('username');
        $pwd = $filter->get('password'); 
        $login_remember = $filter->get('login_remember','INTEGER');
        $signupModel = $this->modelFactory->get('signup');
        $result = $signupModel->authenticate($username,$pwd);
        
        if ($login_remember === 1) {
            Libs_Remember::set($this->cache,$username, $pwd);
        }
        return $result;
    }
    private function afterLogin($user){
        $currTime = time();
        set_session_vals(array(
            'session_id'=> $currTime,
            'uid' => $user['UID'],
            'username' => $user['username'],
            'uid_premium' => $user['premium'],
            'email' => $user['email'],
            'emailverified' => $user['emailverified'],
            'photo' => $user['photo'],
            'fname' => $user['fname'],
            'gender' => $user['gender'],
            'message' => 'Welcome ' .$user['username']. '!'
        ));
        $this->cache->set('login'.$user['UID'],$currTime);
    }
    public function onSignup() {
        $this->pushAssigns(array('errors'=>isset($_SESSION['errors'])?$_SESSION['errors']:''));   
        $this->tpls = array('signup.tpl');
        if (isset($_SESSION['errors'])) {
            unset($_SESSION['errors']);
        }
    }
    public function onSignupd(){
        $filter = new Libs_Filter();
        $username = $filter->get('username');
        $pwd = $filter->get('pwd');
        $repwd = $filter->get('repwd');
        $email = $filter->get('email');
        $gender = $filter->get('gender');
        $age = $filter->get('age');
        $terms = $filter->get('terms');
        $ip = ip2long(GetRealIP());
        $signupModel = $this->modelFactory->get('signup');
        $result = $signupModel->reg($username,$pwd,$repwd,$email,$gender,$age,$terms,$ip);
        if (is_array($result)) {
            $_SESSION['errors'] = $result;
            Libs_Redirect::go('/member/signup');
        }else{
            $this->afterLogin(array(
                'UID'=>$result,
                'username'=>$username,
                'premium'=>0,
                'email'=>$email,
                'emailverified'=>0,
                'photo'=>0,
                'fname'=>0,
                'gender'=>$gender,
                'message'=>'Welcome '.$username.'!',
            ));
            Libs_Redirect::go('/');
        }
    }
    public function onExit(){
        if (isset($_SESSION['uid'])) {
            $this->cache->rm('login'.$_SESSION['uid']);
        }
        del_session_vals(array('session_id','uid','username','uid_premium','email','emailverified','photo','fname','gender','message'));
        Libs_Redirect::go('/');
    }
}