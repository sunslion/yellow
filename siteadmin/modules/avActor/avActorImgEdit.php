<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
isset($_REQUEST['AID']) ? $id  = intval($_REQUEST['AID']) : $id = 0;
(isset($_REQUEST['pic_id']) && intval($_REQUEST['pic_id'])) ? $pic_id  = intval($_REQUEST['pic_id']) : $pic_id = 0;
if ( !$id ) {
    $errors[]    = 'Invalid advertise id!';
}
//编辑图片
if(isset($_REQUEST['edit']) && !$errors ) {
    //调取 编辑函数
    $editState = adv_edit($conn,$id,$config);
    if(!is_array($editState)||$editState['code']!=1){
        $errors[] = $editState['msg'];
    }else{
        $messages[] = $editState['msg'];
        //getrefer();//成功跳转数据
    }
}

//添加图库图片
if(isset($_REQUEST['imgAdd']) && !$errors ) {
    //调取 编辑函数
    $imgAdd = imgAdd($conn,$id,$config);
    if(!is_array($imgAdd)||$imgAdd['code']!=1){
        $errors[] = $imgAdd['msg'];
    }else{
        $messages[] = $imgAdd['msg'];
        //getrefer();//成功跳转数据
    }
}
//删除图库图片
if(isset($_REQUEST['imgDel']) && !$errors && $pic_id) {
    //调取 编辑函数
    $imgDel = imgDel($conn,$pic_id,$config);
    //判断数据合法性
    if(!is_array($imgDel)||$imgDel['code']!=1){
        getrefer($imgDel['msg']);
    }else{
        getrefer($imgDel['msg']);//成功跳转数据
    }
}

//查询编辑列表页
$sql = "SELECT * FROM `av_actor_fpic`  WHERE `id` = $id LIMIT 1";
$rs     = $conn->execute($sql);
$avactor_fpic = array();
if($rs && $conn->Affected_Rows() > 0){
    $avactor_fpic    = $rs->getrows();
}
//查询图库
$where = 'ORDER BY id ASC';
$sql = "SELECT * FROM `av_actor_pic`  WHERE `aid` = $id ".$where;
$pic_rs = $conn->execute($sql);
$avactor_pic = array();
if($pic_rs && $conn->Affected_Rows() > 0){
    $avactor_pic = $pic_rs->getrows();
}
$smarty->assign('avactor_fpic', $avactor_fpic[0]);
$smarty->assign('avactor_pic', $avactor_pic);

//编辑女优
function adv_edit($conn,$id,$config){
    $basedir = dirname(dirname(dirname(dirname(__FILE__))));
    $logo_path = $basedir.'/public/avImg';//图片实际存储根目录地址
    $view_path = '/public/avImg';//前台显示图片地址
    $hpHost = 'http://'.$_SERVER['HTTP_HOST'];//域名地址
    $name   = trim($_REQUEST['name']); //中文名
    intval($_REQUEST['orderNum'])||$_REQUEST['orderNum']==='0' ? $orderNum = intval($_REQUEST['orderNum']) : $orderNum = '1'; //排序
    $tag   = trim($_REQUEST['tag']); //标签
    $title   = trim($_REQUEST['title']); //图库名称
    $push   = intval($_REQUEST['push']); //推荐
    $details   = trim($_REQUEST['details']); //简介
    $front_cover_img   = trim($_REQUEST['front_cover_img']); //简介
    //------查询本地'原图片'地址
    $sql = "SELECT `cover_img` FROM `av_actor_fpic` WHERE `id`=" . $id;
    $beforArr = $conn->execute($sql);
    $beforImgArr = $beforArr->getrows(1); //历史信息
    //如果是本地上传的图片
    if ( $_FILES['cover_img']['tmp_name'] != '') {
        //上传cover_img图片
        //判断是否是通过HTTP POST上传的
        if ( !is_uploaded_file($_FILES['cover_img']['tmp_name']) ) {
            $msg = 'cover_img非法方式上传图片';
            return array('code'=>0,'msg'=>$msg);
        }
        $filename           = substr($_FILES['cover_img']['name'], strrpos($_FILES['cover_img']['name'], DIRECTORY_SEPARATOR)+1);
        $extension          = strtolower(substr($_FILES['cover_img']['name'], strrpos($_FILES['cover_img']['name'], '.')+1));
        $extensions_allowed = explode(',', trim($config['image_allowed_extensions']));
        if ( !in_array($extension, $extensions_allowed) ) {
            $msg = 'cover_img该图片类型不允许上传';
            return array('code'=>0,'msg'=>$msg);
        }
        $name_q   = time().rand(1, 999999999);
        $jpgname    = $name_q. '.' .$extension;
        //创建保存目录--如目录创建未成功报错
        if(!file_exists($logo_path)&&!mkdir($logo_path,0777,true)){
            return array('code'=>0,'msg'=>'cover_img创建图片目录失败');
        }
        //上传图片
        if(!move_uploaded_file($_FILES['cover_img']['tmp_name'], $logo_path. '/' .$jpgname)) return array('code'=>0,'msg'=>'cover_img图片上传失败');
        //保存本地图片地址---展示前台地址
        $cover_img = $view_path.'/'.$jpgname;//实际本地图片地址src地址---redirect查询 imgReadAddr跳转到该地址
        //删除修改之前图片---
        if($_FILES['cover_img']['tmp_name'] && $beforImgArr[0]['cover_img'] && file_exists($basedir.$beforImgArr[0]['cover_img'])){
            $beforImg = $logo_path . '/' . basename($beforImgArr[0]['cover_img']);
            $imgStatus = delImage($beforImg); //删除无用图片
        }
        $cover_img = mysql_real_escape_string($cover_img);
    }
    //进行数据入库--------
    $tag = mysql_real_escape_string($tag);
    $details = mysql_real_escape_string($details);
    $title = mysql_real_escape_string($title);
    $sql = "UPDATE av_actor_fpic SET `push`= '{$push}',`title`= '{$title}',`orderNum`= '{$orderNum}',`tag`= '{$tag}',`details`= '{$details}' " ;
    if($cover_img){
        $sql.=",cover_img='{$cover_img}'";
    }
    if($front_cover_img){
        $sql.=",front_cover_img='{$front_cover_img}'";
    }
    $sql .= " WHERE id = " .intval($id). " LIMIT 1;";
    $result = $conn->execute($sql);
    //判断入库情况
    if ($result && $conn->Affected_Rows() > 0) {
        return array('code'=>1,'msg'=>'女优修改成功');
    }else{
        return array('code'=>0,'msg'=>'女优修改失败');
    }
    //判断入库情况
    if ($result && $conn->Affected_Rows() > 0) {
        return array('code'=>1,'msg'=>'图库添加成功');
    }else{
        return array('code'=>0,'msg'=>'图库添加失败');
    }
}
//添加图库
function imgAdd($conn,$id,$config){
    $basedir = dirname(dirname(dirname(dirname(__FILE__))));
    $logo_path = $basedir.'/public/avImg';//图片实际存储根目录地址
    $view_path = '/public/avImg';//前台显示图片地址
    $hpHost = 'http://'.$_SERVER['HTTP_HOST'];//域名地址
    //如果是本地上传的图片
    if ( $_FILES['image']['tmp_name'] != '') {
        //上传image图片
        if($_FILES['image']['tmp_name']){
            //判断是否是通过HTTP POST上传的
            if ( !is_uploaded_file($_FILES['image']['tmp_name']) ) {
                $msg = 'image非法方式上传图片';
                return array('code'=>0,'msg'=>$msg);
            }
            $filename           = substr($_FILES['image']['name'], strrpos($_FILES['image']['name'], DIRECTORY_SEPARATOR)+1);
            $extension          = strtolower(substr($_FILES['image']['name'], strrpos($_FILES['image']['name'], '.')+1));
            $extensions_allowed = explode(',', trim($config['image_allowed_extensions']));
            if ( !in_array($extension, $extensions_allowed) ) {
                $msg = 'image该图片类型不允许上传';
                return array('code'=>0,'msg'=>$msg);
            }
            $name_q   = time().rand(1, 999999999);
            $jpgname    = $name_q. '.' .$extension;
            //创建保存目录--如目录创建未成功报错
            if(!file_exists($logo_path)&&!mkdir($logo_path,0777,true)){
                return array('code'=>0,'msg'=>'image创建图片目录失败');
            }
            //上传图片
            if(!move_uploaded_file($_FILES['image']['tmp_name'], $logo_path. '/' .$jpgname)) return array('code'=>0,'msg'=>'image图片上传失败');
            //保存本地图片地址---展示前台地址
            $image = $view_path.'/'.$jpgname;//实际本地图片地址src地址---redirect查询 imgReadAddr跳转到该地址
        }
    }
    //进行数据入库--------
    $front_image   = trim($_REQUEST['front_image']); //简介
    $image = mysql_real_escape_string($image);
    $sqlFile = '`aid`,`image`,`front_image`';
    $sqlValue = "'{$id}','{$image}','{$front_image}'";
    $sql = "INSERT INTO av_actor_pic ($sqlFile)VALUES($sqlValue)";
    $result = $conn->execute($sql);
    //判断入库情况
    if ($result && $conn->Affected_Rows() > 0) {
        return array('code'=>1,'msg'=>'图库添加成功');
    }else{
        return array('code'=>0,'msg'=>'图库添加失败');
    }
}

//删除
function imgDel($conn,$id,$config){
    $basedir = dirname(dirname(dirname(dirname(__FILE__))));
    $logo_path = $basedir.'/public/avImg';//图片实际存储根目录地址
    $view_path = '/public/avImg';//前台显示图片地址
    $hpHost = 'http://'.$_SERVER['HTTP_HOST']; //域名地址
    //删除图片
    //------查询本地'原图片'地址
    $sql = "SELECT `image`  FROM `av_actor_pic` WHERE `id`=" . $id;
    $beforArr = $conn->execute($sql);
    $beforImgArr = $beforArr->getrows(1); //历史信息
    $beforImg = $logo_path . '/' . basename($beforImgArr[0]['image']);
    $imgStatus = delImage($beforImg); //删除无用图片
    //删除数据--------
    $sql =  "DELETE FROM `av_actor_pic` WHERE id = $id";
    $res = $conn->execute($sql);
    //判断入库情况
    if ($res && $conn->Affected_Rows() > 0) {
        return array('code'=>1,'msg'=>'图库图片删除成功');
    }else{
        return array('code'=>0,'msg'=>'图库图片删除失败');
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
//设置列表页cookier;
function referPage(){
    $refer = 'http://' . $_SERVER ['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $_COOKIE["referPage"] = $refer;
    setcookie("referPage", $refer, time()+3600);
}
referPage();
//获取记忆跳转
function getrefer($msg){
    echo '<strong>"'.$msg.'",2秒将跳转到列表页！请等待...</strong>';
    $referPage = $_COOKIE["referPage"];//如果存在返回页
    if($referPage){
        exit(header("refresh:2;url=".$referPage));
    }
}
?>