<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
$AID    = ( isset($_GET['AID']) && advExists($_GET['AID']) ) ? intval($_GET['AID']) : NULL;
if ( !$AID ) {
    $errors[]    = 'Invalid advertise id!';
}
//包含加密类
include_once 'ShortCodeModel.class.php';
//调用编辑广告方法
if(isset($_REQUEST['adv_edit']) && !$errors ) {
    //调取 编辑函数
    $editState = adv_edit($conn,$AID,$config);
    if(!is_array($editState)||$editState['code']!=1){
        $errors[] = $editState['msg'];
    }else{
        $messages[] = $addState['msg'];
        getrefer();//成功跳转数据
    }
}
//查询编辑列表页
$adv    = array('adv_id' => 0, 'adv_name' => '', 'adv_group' => 0, 'adv_text' => '', 'adv_status' => '0');
$sql = "SELECT a.*, g.name as zone_name,g.width,g.height FROM adv_ads a LEFT JOIN adv_zone g ON (a.zone_id=g.id) WHERE a.id = " .intval($AID). " LIMIT 1";
$rs     = $conn->execute($sql);
if($rs && $conn->Affected_Rows() > 0){
    $adv    = $rs->getrows();
    $adv    = $adv['0'];
    list($t,$r,$b,$l) = explode(' ', $adv['margin']);
    $smarty->assign('t', $t);
    $smarty->assign('r', $r);
    $smarty->assign('b', $b);
    $smarty->assign('l', $l);
    $smarty->assign('adv', $adv);
}
//调用数据库广告位模板
$sql        = "SELECT * FROM adv_zone ORDER BY name ASC";
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
$smarty->assign('advzones', $advzones);
unset($advzones);

//判断广告是否存在
function advExists( $adv_id ) {
    global $conn;
    $sql    = "SELECT id FROM adv_ads WHERE id = " .intval($adv_id). " LIMIT 1";
    $conn->execute($sql);
    return $conn->Affected_Rows();
}
//编辑广告
function adv_edit($conn,$AID,$config){
    $basedir = dirname(dirname(dirname(dirname(__FILE__))));
    $logo_path = $basedir.'/ps';//图片实际存储根目录地址
    $view_path = '/ps';//前台显示图片地址
    $hpHost = 'http://'.$_SERVER['HTTP_HOST'];//域名地址
    $name   = trim($_REQUEST['name']); //标题
    trim($_REQUEST['zone_id']) ? $zone_id = trim($_REQUEST['zone_id']):$zone_id = '0';//广告类型
    trim($_REQUEST['url']) ? $url = trim($_REQUEST['url']):$url = '';//广告跳转链接
    trim($_REQUEST['media']) ? $media = trim($_REQUEST['media']):$media = '';//广告图片原地址
    $title = trim($_REQUEST['title']); //详细介绍
    $margin = $_REQUEST['margin']; // 间距
    $_REQUEST['orderby']==='0'|| intval($_REQUEST['orderby']) ? $orderby = intval($_REQUEST['orderby']) : $orderby = '1'; //排序
    intval($_REQUEST['isFix'])||$_REQUEST['isFix']==='0' ? $isFix = intval($_REQUEST['isFix']):$isFix = 2;//默认广告不固定
    intval($_REQUEST['isbtn'])||$_REQUEST['isbtn']==='0' ? $isbtn = intval($_REQUEST['isbtn']):$isbtn = 0;//默认不存在关闭按钮
    //参数非空判断
    if (is_array($margin) && !empty($margin)) {
        foreach ($margin as $k => &$v) {
            $v = intval($v);
        }
        $margin = implode(' ', $margin);
    }else{$margin = '';}
    //判断广告标题是否为空
    if (!$name) {
        return array('code'=>0,'msg'=>'Advertise name field cannot be left blank!');
    }
    //判断广告位是否为空
    if (!$zone_id) {
        return array('code'=>0,'msg'=>'请选择广告位');
    }
    //判断图片地址不能为空
    if (!$media) {
        return array('code'=>0,'msg'=>'请上传广告图片');
    }
    //判断跳转地址不能为空
    if (!$url) {
        return array('code'=>0,'msg'=>'广告跳转地址不能为空');
    }
    //拼接数据---拼接跳转链接地址http://www.lsn68.com/?s=vod-show-id-3.html
    $dom =  '/';
    $pathUrl =$dom."AddrDirect/index/code/";//link地址--重定向地址
    $jumpShortAddr = getCode($url); //加密图片跳转短链接
    $jumpReadAddr = $pathUrl.$jumpShortAddr;//经过加密前台展示广告跳转地址
    $jpgpath = '';
    //------查询本地'原图片'地址
    $sql = "SELECT `locImgAddr`,`media` FROM `adv_ads` WHERE `id`=" . $AID;
    $beforArr = $conn->execute($sql);
    $beforImgArr = $beforArr->getrows(1); //历史信息
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
        //如果是远程下载的图片
    }else{
        //下载图片与本地图片源地址不一致、本地图片不存在（物理、数据库不存在）--重新下载图片
        if($media!=trim($beforImgArr[0]['media'])||!$beforImgArr[0]['locImgAddr']||!file_exists($basedir.$beforImgArr[0]['locImgAddr'])){
            $img = getImage($media,$logo_path.'/');//下载图片
            if(!is_array($img)||$img['code']!=1) return array('code'=>$img['code'],'msg'=>'图片下载错误');
            $jpgname = $img['file_name'];
            $locImgAddr = $view_path.'/'.$jpgname;//实际本地图片地址src地址---redirect查询 imgReadAddr跳转到该地址
        }else{
            $falDelImg = true;
        }
    }
    //删除修改之前图片---
    if(!$falDelImg&&$beforImgArr[0]['locImgAddr']&&file_exists($basedir.$beforImgArr[0]['locImgAddr'])) {
        $beforImg = $logo_path . '/' . basename($beforImgArr[0]['locImgAddr']);
        $imgStatus = delImage($beforImg); //删除无用图片
        //if($imgStatus['code']!=1) return array('code'=>0,'msg'=>$imgStatus['msg']);
    }
    //更新修改时间
    $addtime = time();
    //进行数据入库--------
    $sql = "UPDATE adv_ads SET "."name = '" .mysql_real_escape_string($name). "',".
        "url = '" .mysql_real_escape_string($url). "',".
        "media = '" .mysql_real_escape_string($media). "',".
        "title = '" .mysql_real_escape_string($title). "',".
        "margin = '".mysql_real_escape_string($margin)."',".
        "jumpReadAddr = '".mysql_real_escape_string($jumpReadAddr)."',".
        "jumpShortAddr = '".mysql_real_escape_string($jumpShortAddr)."',".
        "addtime = '".mysql_real_escape_string($addtime)."',".
        "isbtn = '{$isbtn}',orderby='{$orderby}',";
    if($locImgAddr){
        $sql.="locImgAddr = '".mysql_real_escape_string($locImgAddr)."',";
    }
    if($isFix!=2){
        $sql.="isFix = '".mysql_real_escape_string($isFix)."',";
    }
    $sql .= "zone_id = " .intval($zone_id). " WHERE id = " .intval($AID). " LIMIT 1;";
    $result = $conn->execute($sql);
    //判断入库情况
    if ($result && $conn->Affected_Rows() > 0) {
        return array('code'=>1,'msg'=>'广告修改成功');
    }else{
        return array('code'=>0,'msg'=>'广告修改失败');
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
// 删除广告图片
function delImage($img = ''){
    $img = trim($img);
    if(empty($img))  return array('code'=>0,'msg'=>'请选择删除图片');
    if(!file_exists($img)) return array('code'=>0,'msg'=>'未找到删除图片');
    if(!unlink($img)) return array('code'=>0,'msg'=>'删除旧图片失败');
    return array('code'=>1,'msg'=>'删除旧图片成功');
}

//获取记忆跳转
function getrefer(){
    echo "<strong>广告修改成功，2秒将跳转到列表页！请等待...</strong>";
    $referPage = $_COOKIE["referPage"];//如果存在返回页
    if($referPage){
        exit(header("refresh:2;url=".$referPage));
    }
}

?>