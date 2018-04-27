<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

$admins = array('realname'=>'','name'=>'','email'=>'','mobile'=>'','type'=>'','status'=>'');
if (isset($_POST['add_admin'])) {
    $realname = $filter->get('realname');
    $name = $filter->get('name');
    $password = $filter->get('password');
    $password_confirm = $filter->get('password_confirm');
    $email = $filter->get('email');
    $mobile = $filter->get('mobile');
    $type = $filter->get('type');
    $status = $filter->get('status');
    $vip = (int)$filter->get('vip','INTEGER');
    
    if ($name == '') {
        $errors[] = '请填写上用户名，用于后台登陆';
    }else{
        $admins['name'] = $name;
    }
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
    
    $admins['mobile'] = $mobile;
    $admins['type'] = $type;
    $admins['status'] = $status;
    
    if (!$errors) {
        $realname = mysql_real_escape_string($realname);
        $name = mysql_real_escape_string($name);
        $password = md5(mysql_real_escape_string($password));
        $email = mysql_real_escape_string($email);
        $mobile = mysql_real_escape_string($mobile);
        $type = intval($type);
        $status = intval($status);
        $vip = mysql_real_escape_string($vip);
        $time = time();
        $sql = "INSERT INTO admin (realname,name,pass,email,mobile,type,status,vip,addtime) 
                VALUES ('{$realname}','{$name}','{$password}','{$email}','{$mobile}','{$type}','{$status}','{$vip}',{$time});";echo $sql;
        if($conn->execute($sql)){
           VRedirect::go($config['BASE_URL']. '/siteadmin/admin.php?msg=添加成功!');
        }else{
            $errors[] = '添加失败';
        }
    }
    $smarty->assign('user', $admins);
}