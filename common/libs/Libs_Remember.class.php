<?php
defined('_VALID') or die('Restricted Access!');
class Libs_Remember
{
    public static function check($cache,$conf = array())
    {    
        if (!isset($_SESSION['uid']) && isset($_COOKIE['remember'])) {
            $checkKey = self::getKey();
            $cookie     = unserialize($_COOKIE['remember']);
            if (is_array($cookie)) {
                if ($cookie['check'] == $checkKey) {
                    $userinfo = $cache->get($checkKey);
                    if(!$userinfo){
                        return false;
                    }
                    $userinfo = json_decode($userinfo,true);
                    $username = $userinfo['username'];
                    $password = $userinfo['pwd'];
                    $userModel = new SignupModel($conf);
                    $user = $userModel->get($username);
                    
                    if ($user['pwd'] === $password) {
                        $currTime = time();
                        $userModel->updateLoginTime($user['UID'], $currTime);
                        
                        set_session_vals(array(
                            'session_id'=> $currTime,
                            'uid' => $user['UID'],
                            'username' => $username,
                            'uid_premium' => $user['premium'],
                            'email' => $user['email'],
                            'emailverified' => $user['emailverified'],
                            'photo' => $user['photo'],
                            'fname' => $user['fname'],
                            'gender' => $user['gender'],
                            'message' => 'Welcome ' .$username. '!'
                        ));
                       
                        self::set($cache,$username, $user['pwd']);
                    }
                }
            }
        }
    }
    
    public static function set($cache,$username, $password){
        $expire = strtotime('+14 days')- time();
        $checkKey = self::getKey();
        $userinfo = array(
            'username'=>$username,
            'pwd'=>md5($password),
        );
        $userinfo_json = json_encode($userinfo);
        $cache->set($checkKey,$userinfo_json,$expire);
        $user       = array('check' => $checkKey);
        $cookie     = serialize($user);
        setcookie('remember', $cookie, time()+60*60*24*14, '/');
    }
    private static function getKey(){
        $browser    = (isset($_SERVER['HTTP_USER_AGENT'])) ? sha1($_SERVER['HTTP_USER_AGENT']) : NULL;
        $ip         = ip2long(GetRealIP());
        return strtolower(crypt($browser . $ip,$ip));
    }
    public static function del()
    {
        setcookie('remember', '', time()-60*60*24*100, '/');
    }
}
?>