<?php
define('_VALID', true);
define('_ADMIN', true);
include('../include/config.php');
if(isset($config['admin_visit_ip']) && strpos($config['admin_visit_ip'], GetRealIP()) === false){
    header('HTTP/1.1 403 Forbidden');
    exit('4.3 Forbidden');
}
$err = NULL;
$msg = NULL;
if ( isset($_POST['submit_login']) ) {
    $username   = trim($_POST['username']);
    $password   = trim($_POST['password']);
        
    if ( $username == '' or $password == '' ) {
        $err = 'Please provide a username and password!';
    } else {
        if ( $username == $config['admin_name'] && $password == $config['admin_pass'] ) {
            $_SESSION['AUID']   = $config['admin_name'];
            $_SESSION['APASSWORD']  = $config['admin_pass'];
            $_SESSION['ATYPE'] = 0;
            VRedirect::go($config['BASE_URL']. '/siteadmin/index.php');
        } else {
            $password = mysql_real_escape_string($password);
            $password = md5($password);
            $username = mysql_real_escape_string($username);
            $sql = "SELECT id, realname,name,pass,email,mobile,type FROM admin WHERE status = 1 and  name='{$username}' and pass = '{$password}' LIMIT 1;";
            $rs = $conn->execute($sql);
            if($conn->Affected_Rows() == 1){
                $result = $rs->getrows();
                $user = $result[0];
                $_SESSION['AUID'] = $user['name'];
                $_SESSION['APASSWORD'] = $user['pass'];
                $_SESSION['ATYPE'] = $user['type'];
                $menus = $config['perm_'.$user['type'].'_menus'];
                if (!empty($menus)) {
                    $menus = json_decode($menus);
                    if (count($menus) > 0) {
                        $menu = $menus[count($menus) - 1];
                        VRedirect::go($config['BASE_URL']. '/siteadmin/'.$menu.'.php');
                    }
                }else{
                    echo '<meta http-equiv="refresh" content="3; url=/siteadmin/login.php" />';
                    die('您所在的用户组，目前没有可操作的版块，系统只能选择退出，如要操作，请联系管理员!');
                }
                
            }else{
                $err = 'Invalid username and/or password!';
            }
        }
    }
}

if ( isset($_POST['submit_forgot']) ) {
    if ( !isset($_SESSION['email_forgot']) )
        $_SESSION['email_forgot'] = 1;
    
    if ( $_SESSION['email_forgot'] == 3 ) {
        $err = 'Please try again later!';
    }
    
    if ( $err == '' ) {
		require '../classes/email.class.php';
        $mail           = new VMail();
        $mail->set();
        $mail->Subject  = 'Your ' .$config['site_name']. ' administrator username and password!';
        $message        = 'Username: ' .$config['admin_name']. "\n";
        $message       .= 'Password: ' .$config['admin_pass']. "\n";
        $mail->AltBody  = $message;
        $mail->Body     = nl2br($message);
        $mail->AddAddress($config['admin_email']);
        $mail->Send();
        $msg = 'Email was successfuly sent!';
    }
    
    $_SESSION['email_forgot'] = $_SESSION['email_forgot']+1;
}

$smarty->assign('msg',$msg);
$smarty->assign('err',$err);
$smarty->display('header.tpl');
$smarty->display('login.tpl');
?>
