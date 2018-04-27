<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
$id = $filter->get('id','INT','GET');
if (isset($_POST['edit_admin'])) {
    $id = $filter->get('id','INT');
    $realname = $filter->get('realname');
    $password = $filter->get('password');
    $password_confirm = $filter->get('password_confirm');
    $email = $filter->get('email');
    $mobile = $filter->get('mobile');
    $type = $filter->get('type');
    $status = $filter->get('status');
    $vip = (int)$filter->get('vip','INTEGER');
    
    if ($email == '') {
        $errors[] = 'Email不能为空!';
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = 'Email格式不正确!';
    }else{
        $admins['email'] = $email;
    }
    
    if ($password == '') {
        $errors[]='登陆密码不能为空';
    }else if ($password != $password_confirm) {
        $errors[] = '密码请设置不一致!';
    }
    if (strlen($admins['mobile']) > 11) {
        $errors[] = '手机号码不能超过程11位';
    }else{
        $admins['mobile'] = $mobile;
    }
    $admins['type'] = $type;
    $admins['status'] = $status;
    
    if (!$errors) {
        $realname = mysql_real_escape_string($realname);
        $password = md5(mysql_real_escape_string($password));
        $email = mysql_real_escape_string($email);
        $mobile = mysql_real_escape_string($mobile);
        $type = intval($type);
        $status = intval($status);
        $vip = mysql_real_escape_string($vip);
        $time = time();
        $sql = "UPDATE admin SET realname='{$realname}',pass='{$password}',email='{$email}',mobile='{$mobile}',type={$type},status={$status},utime={$time},vip={$vip} WHERE id={$id}";
        
        if($conn->execute($sql)){
            VRedirect::go($config['BASE_URL']. '/siteadmin/admin.php?msg=编辑成功!');
            unset($_SESSION['AUID']);
            unset($_SESSION['APASSWORD']);
            unset($_SESSION['ATYPE']);
        }else{
            VRedirect::go($config['BASE_URL']. '/siteadmin/admin.php?err=编辑失败!');
        }
    }
    
}
$sql = "SELECT * FROM admin WHERE id = {$id}";
$rs = $conn->execute($sql);
if($rs){
   $user = $rs->getrows();
   $user = $user[0];
}

$smarty->assign('user', $user);
$smarty->assign('id', $id);