<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
$adv    = array('name' => '', 'group' => 0, 'text' => '', 'status' => '1');
//包含加密类
include_once 'ShortCodeModel.class.php';
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
//展示添加页面
$sql        = "SELECT * FROM adv_zone ORDER BY id ASC";
$rs         = $conn->execute($sql);
if ($rs && $conn->Affected_Rows() > 0) {
    $advzones  = $rs->getrows();
    $zones = array();
    if (is_array($advzones) && !empty($advzones)) {
        foreach ($advzones as $k => $v) {
            $zones[$v['id']] = $v['width'].','.$v['height'];
        }
    }
    $smarty->assign('zones','['.json_encode($zones).']');
    unset($zones);
}
$smarty->assign('adv', $adv);
$smarty->assign('advzones', $advzones);
unset($advzones);

function adv_add($conn,$config){
    $basedir = dirname(dirname(dirname(dirname(__FILE__))));
    $logo_path = $basedir.'/ps';//图片实际存储根目录地址
    $view_path = '/ps';//前台显示图片地址
    $hpHost = 'http://'.$_SERVER['HTTP_HOST'];//域名地址
    $name   = trim($_REQUEST['name']); //标题
    trim($_REQUEST['zone_id']) ? $zone_id = trim($_REQUEST['zone_id']):$zone_id = 0;//广告类型
    trim($_REQUEST['url']) ? $url = trim($_REQUEST['url']):$url = '';//广告跳转链接
    trim($_REQUEST['media']) ? $media = trim($_REQUEST['media']):$media = '';//广告图片原地址
    $title = trim($_REQUEST['title']); //详细介绍
    $margin = $_REQUEST['margin']; // 间距
    $isbtn  = intval($_REQUEST['isbtn']);
    intval($_REQUEST['orderby']) ? $orderby = intval($_REQUEST['orderby']) : $orderby = '0'; //排序
    intval($_REQUEST['isFix'])||$_REQUEST['isFix']==='0' ? $isFix = intval($_REQUEST['isFix']):$isFix = 2;//默认广告不固定
    //参数非空判断
    if (is_array($margin) && !empty($margin)) {
        foreach ($margin as $k => &$v) {
            $v = intval($v);
        }
        $margin = implode(' ', $margin);
    }else{$margin = '';}

    //判断广告位是否为空
    if (empty($zone_id)) {
        return array('code'=>0,'msg'=>'请选择广告位');
    }
    //判断广告标题是否为空
    if (!$name) {
        return array('code'=>0,'msg'=>'请填写广告名称name');
    }
    //判断跳转地址不能为空
    if (!$url) {
        return array('code'=>0,'msg'=>'广告跳转地址不能为空');
    }
    //拼接数据---拼接跳转链接地址http://www.lsn68.com/?s=vod-show-id-3.html
    $dom =  '/';
    //AddrDirect/index/code/
    $pathUrl =$dom."AddrDirect/index/code/";//link地址--重定向地址
    $jumpShortAddr = getCode($url); //加密图片跳转短链接
    $jumpReadAddr = $pathUrl.$jumpShortAddr;//经过加密前台展示广告跳转地址
    $jpgpath = '';
    //如果是本地上传的图片
    if ( $_FILES['relogopic']['tmp_name'] != '' ) {
        //判断是否是通过HTTP POST上传的
        if ( !is_uploaded_file($_FILES['relogopic']['tmp_name']) ) {
            $msg = '非法方式上传图片';
            return array('code'=>0,'msg'=>$msg);
        }
        $filename           = substr($_FILES['relogopic']['name'], strrpos($_FILES['relogopic']['name'], DIRECTORY_SEPARATOR)+1);
        $extension          = strtolower(substr($_FILES['relogopic']['name'], strrpos($_FILES['relogopic']['name'], '.')+1));
        $extensions_allowed = explode(',', trim($config['image_allowed_extensions']));
        if ( !in_array($extension, $extensions_allowed) ) {
            $msg = '该图片类型不允许上传';
            return array('code'=>0,'msg'=>$msg);
        }
        $name_q   = time().rand(1, 999999999);
        $jpgname    = $name_q. '.' .$extension;
        //创建保存目录--如目录创建未成功报错
        if(!file_exists($logo_path)&&!mkdir($logo_path,0777,true)){
            return array('code'=>0,'msg'=>'创建图片目录失败');
        }
        //上传图片
        if(!move_uploaded_file($_FILES['relogopic']['tmp_name'], $logo_path. '/' .$jpgname)) return array('code'=>0,'msg'=>'图片上传失败');
        //保存本地图片地址---展示前台地址
        $locImgAddr = $view_path.'/'.$jpgname;//实际本地图片地址src地址---redirect查询 imgReadAddr跳转到该地址
        //保存本地图片地址
        $media  = $hpHost.$view_path.'/'.$jpgname;//广告图片原地址
    }else{
        //判断图片地址不能为空
        if (!$media) {
            return array('code'=>0,'msg'=>'请上传广告图片');
        }
        $img = getImage($media,$logo_path.'/');//下载图片
        if(!is_array($img)||$img['code']!=1) return array('code'=>$img['code'],'msg'=>'图片下载错误');
        $jpgname = $img['file_name'];
        $locImgAddr = $view_path.'/'.$jpgname;//实际本地图片地址src地址---redirect查询 imgReadAddr跳转到该地址
    }  
    //进行数据入库--------
    $zone_id = intval($zone_id);
    $url = mysql_real_escape_string($url);
    $media = mysql_real_escape_string($media);
    $name = mysql_real_escape_string($name);
    $title = mysql_real_escape_string($title);
    $margin = mysql_real_escape_string($margin);
    $jumpReadAddr = mysql_real_escape_string($jumpReadAddr);
    $jumpShortAddr = mysql_real_escape_string($jumpShortAddr);
    $locImgAddr = mysql_real_escape_string($locImgAddr);
    $time = time();
    $sqlFile = '`zone_id`, `url`, `media`, `name`, `title`, `addtime`,`margin`,`isbtn`,`orderby`,`jumpReadAddr`,`jumpShortAddr`,`locImgAddr`';
    $sqlValue = "{$zone_id},'{$url}','{$media}','{$name}','{$title}',{$time},'{$margin}',{$isbtn},{$orderby},'{$jumpReadAddr}','{$jumpShortAddr}','{$locImgAddr}'";
    //如果广告是固定广告
    if($isFix!=2&&$isFix){
        $sqlFile .= ',`isFix`';
        $sqlValue .= ",{$isFix}";
    }
    $sql = "INSERT INTO adv_ads ($sqlFile)
            VALUES ($sqlValue)";
    //echo $sql;exit;
    $result = $conn->execute($sql);
    //判断入库情况
    if ($result && $conn->Affected_Rows() > 0) {
        write_ads_cache();
        return array('code'=>1,'msg'=>'广告添加成功');
    }else{
        return array('code'=>0,'msg'=>'广告添加失败');
    }
}

//下载文件到本地
function getImage($url='',$save_dir=''){
    $url = trim($url);
    $save_dir = trim($save_dir);
    if($url==''){
        return array('file_name'=>'','save_path'=>'','code'=>2);
    }
    if($save_dir==''){
        return array('file_name'=>'','save_path'=>'','code'=>4);
    }	
    $ext=strrchr($url,'.');
    if(!in_array($ext,array('.gif','.png','.jpg'))){
          return array('file_name'=>'','save_path'=>'','code'=>3);
    }
    $filename=time().rand(1, 999999999).$ext;
    //创建保存目录
    if(!file_exists($save_dir)&&!mkdir($save_dir,0777,true)){
        return array('file_name'=>'','save_path'=>'','code'=>5);
    }
    //获取远程文件所采用的方法
    $imgO = file_get_contents($url);
    $code = file_put_contents($save_dir.$filename,$imgO);
    if( $code ){
       return array('file_name'=>$filename,'save_path'=>$save_dir.$filename,'code'=>1);
    }else{
       return array('file_name'=>$filename,'save_path'=>$save_dir.$filename,'code'=>0);
    }       
}

//获取记忆跳转
function getrefer(){
    echo "<strong>广告添加成功，2秒将跳转到列表页！请等待...</strong>";
    $referPage = $_COOKIE["referPage"];//如果存在返回页
    if($referPage){
        exit(header("refresh:2;url=".$referPage));
    }
}

?>