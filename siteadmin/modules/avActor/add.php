<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
//包含加密类
if ( isset($_POST['adv_add']) ) {
    //var_dump($_POST);exit;
    $addState = adv_add($conn,$config);
    //判断数据合法性
    if(!is_array($addState)||$addState['code']!=1){
        $errors[] = $addState['msg'];
    }else{
        $messages[] = $addState['msg'];
        getrefer();//成功跳转数据
    }
}
function adv_add($conn,$config){
    $basedir = dirname(dirname(dirname(dirname(__FILE__))));
    $logo_path = $basedir.'/ps';//图片实际存储根目录地址
    $view_path = '/ps';//前台显示图片地址
    $hpHost = 'http://'.$_SERVER['HTTP_HOST'];//域名地址
    $name   = trim($_REQUEST['name']); //标题
    intval($_REQUEST['orderby'])||$_REQUEST['orderby']==='0' ? $orderby = intval($_REQUEST['orderby']) : $orderby = '1'; //排序
    $japan_name   = trim($_REQUEST['japan_name']); //标题
    //判断女优位是否为空
    if (empty($name)) {
        return array('code'=>0,'msg'=>'请填写女优名称');
    }
    //判断女优标题是否为空
    if (empty($japan_name)) {
        return array('code'=>0,'msg'=>'请填写女优日文名称');
    }
    $jpgpath = '';
    //如果是本地上传的图片
    if ( $_FILES['avator_img']['tmp_name'] != ''|| $_FILES['avdesc_img']['tmp_name'] != '') {
        //上传avator_img图片
        if($_FILES['avator_img']['tmp_name']){
            //判断是否是通过HTTP POST上传的
            if ( !is_uploaded_file($_FILES['avator_img']['tmp_name']) ) {
                $msg = 'avator_img非法方式上传图片';
                return array('code'=>0,'msg'=>$msg);
            }
            $filename           = substr($_FILES['avator_img']['name'], strrpos($_FILES['avator_img']['name'], DIRECTORY_SEPARATOR)+1);
            $extension          = strtolower(substr($_FILES['avator_img']['name'], strrpos($_FILES['avator_img']['name'], '.')+1));
            $extensions_allowed = explode(',', trim($config['image_allowed_extensions']));
            if ( !in_array($extension, $extensions_allowed) ) {
                $msg = 'avator_img该图片类型不允许上传';
                return array('code'=>0,'msg'=>$msg);
            }
            $name_q   = time().rand(1, 999999999);
            $jpgname    = $name_q. '.' .$extension;
            //创建保存目录--如目录创建未成功报错
            if(!file_exists($logo_path)&&!mkdir($logo_path,0777,true)){
                return array('code'=>0,'msg'=>'avator_img创建图片目录失败');
            }
            //上传图片
            if(!move_uploaded_file($_FILES['avator_img']['tmp_name'], $logo_path. '/' .$jpgname)) return array('code'=>0,'msg'=>'avator_img图片上传失败');
            //保存本地图片地址---展示前台地址
            $avator_img = $view_path.'/'.$jpgname;//实际本地图片地址src地址---redirect查询 imgReadAddr跳转到该地址
        }
        //上传avdesc_img图片
        if($_FILES['avdesc_img']['tmp_name']){
            if ( !is_uploaded_file($_FILES['avdesc_img']['tmp_name']) ) {
                $msg = 'avdesc_img非法方式上传图片';
                return array('code'=>0,'msg'=>$msg);
            }
            $filename           = substr($_FILES['avdesc_img']['name'], strrpos($_FILES['avdesc_img']['name'], DIRECTORY_SEPARATOR)+1);
            $extension          = strtolower(substr($_FILES['avdesc_img']['name'], strrpos($_FILES['avdesc_img']['name'], '.')+1));
            $extensions_allowed = explode(',', trim($config['image_allowed_extensions']));
            if ( !in_array($extension, $extensions_allowed) ) {
                $msg = 'avdesc_img该图片类型不允许上传';
                return array('code'=>0,'msg'=>$msg);
            }
            $name_q   = time().rand(1, 999999999);
            $jpgname    = $name_q. '.' .$extension;
            //创建保存目录--如目录创建未成功报错
            if(!file_exists($logo_path)&&!mkdir($logo_path,0777,true)){
                return array('code'=>0,'msg'=>'avdesc_img创建图片目录失败');
            }
            //上传图片
            if(!move_uploaded_file($_FILES['avdesc_img']['tmp_name'], $logo_path. '/' .$jpgname)) return array('code'=>0,'msg'=>'avdesc_img图片上传失败');
            //保存本地图片地址---展示前台地址
            $avdesc_img = $view_path.'/'.$jpgname;
        }
    }else{
        //判断图片地址不能为空
        return array('code'=>0,'msg'=>'请上传女优图片');
    }
    //进行数据入库--------
    $name = mysql_real_escape_string($name);
    $japan_name = mysql_real_escape_string($japan_name);
    $avator_img = mysql_real_escape_string($avator_img);
    $avdesc_img= mysql_real_escape_string($avdesc_img);
    $time = time();
    $sqlFile = '`name`, `japan_name`, `avator_img`, `avdesc_img`,`addtime`,`orderby`';
    $sqlValue = "'{$name}','{$japan_name}','{$avator_img}','{$avdesc_img}','{$time}','{$orderby}'";
    $sql = "INSERT INTO avactor ($sqlFile)
            VALUES ($sqlValue)";
    $result = $conn->execute($sql);
    //判断入库情况
    if ($result && $conn->Affected_Rows() > 0) {
        return array('code'=>1,'msg'=>'女优添加成功');
    }else{
        return array('code'=>0,'msg'=>'女优添加失败');
    }
}

//获取记忆跳转
function getrefer(){
    echo "<strong>女优添加成功，2秒将跳转到列表页！请等待...</strong>";
    $referPage = $_COOKIE["referPage"];//如果存在返回页
    if($referPage){
        exit(header("refresh:2;url=".$referPage));
    }
}

?>