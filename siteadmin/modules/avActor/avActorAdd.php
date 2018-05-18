<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
//包含加密类
if ( isset($_POST['adv_add']) ) {
    $addState = adv_add($conn,$config);
    //判断数据合法性
    if(!is_array($addState)||$addState['code']!=1){
        getrefer($addState['msg']);
    }else{
        getrefer($addState['msg']);//成功跳转数据
    }
}
function adv_add($conn,$config){
    $basedir = dirname(dirname(dirname(dirname(__FILE__))));
    $logo_path = $basedir.'/public/avImg';//图片实际存储根目录地址
    $view_path = '/public/avImg';//前台显示图片地址
    $hpHost = 'http://'.$_SERVER['HTTP_HOST'];//域名地址
    $name   = trim($_REQUEST['name']); //中文名
    $japan_name   = trim($_REQUEST['japan_name']); //日文名
    $front_avator_img   = trim($_REQUEST['front_avator_img']); //图片
    $push   = intval($_REQUEST['push']); //是否推荐
    intval($_REQUEST['orderNum'])||$_REQUEST['orderNum']==='0' ? $orderNum = intval($_REQUEST['orderNum']) : $orderNum = '1'; //排序
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
    }
    //进行数据入库--------
    $name = mysql_real_escape_string($name);
    $front_avator_img = mysql_real_escape_string($front_avator_img);
    $japan_name = mysql_real_escape_string($japan_name);
    $avator_img = mysql_real_escape_string($avator_img);
    $sqlFile = '`name`, `japan_name`, `avator_img`,`orderNum`,`push`,`front_avator_img`';
    $sqlValue = "'{$name}','{$japan_name}','{$avator_img}','{$orderNum}','{$push}','{$front_avator_img}'";
    $sql = "INSERT INTO av_actor($sqlFile) VALUES ($sqlValue)";
    $result = $conn->execute($sql);
    //判断入库情况
    if ($result && $conn->Affected_Rows() > 0) {
        return array('code'=>1,'msg'=>'女优添加成功');
    }else{
        return array('code'=>0,'msg'=>'女优添加失败');
    }
}

//获取记忆跳转
function getrefer($msg){
    echo '<strong>"'.$msg.'",2秒将跳转到列表页！请等待...</strong>';
    $referPage = $_COOKIE["referPage"];//如果存在返回页
    if($referPage){
        exit(header("refresh:2;url=".$referPage));
    }
}
exit();
?>