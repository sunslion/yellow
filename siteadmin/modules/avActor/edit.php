<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
( isset($_REQUEST['AID']) && advExists($_REQUEST['AID']) ) ? $id  = intval($_REQUEST['AID']) : $id = NULL;
if ( !$id ) {
    $errors[]    = 'Invalid advertise id!';
}
if(isset($_REQUEST['edit']) && !$errors ) {
    //调取 编辑函数
    $editState = adv_edit($conn,$id,$config);
    if(!is_array($editState)||$editState['code']!=1){
        $errors[] = $editState['msg'];
    }else{
        $messages[] = $addState['msg'];
        getrefer();//成功跳转数据
    }
}
//查询编辑列表页
$sql = "SELECT * FROM `avactor`  WHERE `id` = " .intval($id). " LIMIT 1";
$rs     = $conn->execute($sql);
if($rs && $conn->Affected_Rows() > 0){
    $avactor    = $rs->getrows();
    $smarty->assign('avactor', $avactor[0]);
}

//var_dump($avactor);exit;
//判断广告是否存在
function advExists( $id ) {
    global $conn;
    $sql    = "SELECT id FROM avactor WHERE id = " .intval($id). " LIMIT 1";
    $conn->execute($sql);
    return $conn->Affected_Rows();
}
function adv_edit($conn,$id,$config){
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
    //------查询本地'原图片'地址
    $sql = "SELECT `avator_img`,`avdesc_img` FROM `avactor` WHERE `id`=" . $id;
    $beforArr = $conn->execute($sql);
    $beforImgArr = $beforArr->getrows(1); //历史信息
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
        //删除修改之前图片---
        if($_FILES['avator_img']['tmp_name'] && $beforImgArr[0]['avator_img'] && file_exists($basedir.$beforImgArr[0]['avator_img'])){
            $beforImg = $logo_path . '/' . basename($beforImgArr[0]['avator_img']);
            $imgStatus = delImage($beforImg); //删除无用图片
        }
        if($_FILES['avdesc_img']['tmp_name'] && $beforImgArr[0]['avdesc_img'] && file_exists($basedir.$beforImgArr[0]['avdesc_img'])){
            $beforImg = $logo_path . '/' . basename($beforImgArr[0]['avdesc_img']);
            $imgStatus = delImage($beforImg); //删除无用图片
        }
    }
    //进行数据入库--------
    $name = mysql_real_escape_string($name);
    $japan_name = mysql_real_escape_string($japan_name);
    $avator_img = mysql_real_escape_string($avator_img);
    $avdesc_img= mysql_real_escape_string($avdesc_img);
    $time = time();
    $sql = "UPDATE avactor SET "."name = '" .mysql_real_escape_string($name). "',".
            "japan_name = '" .mysql_real_escape_string($japan_name). "',".
            "addtime = '{$time}',orderby='{$orderby}'";
    if($avator_img){
        $sql.=",avator_img = '".mysql_real_escape_string($avator_img)."'";
    }
    if($avdesc_img){
        $sql.=",avdesc_img = '".mysql_real_escape_string($avdesc_img)."'";
    }
    $sql .= " WHERE id = " .intval($id). " LIMIT 1;";
    $result = $conn->execute($sql);
//    echo $sql;exit;
    //判断入库情况
    if ($result && $conn->Affected_Rows() > 0) {
        return array('code'=>1,'msg'=>'女优修改成功');
    }else{
        return array('code'=>0,'msg'=>'女优修改失败');
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
    echo "<strong>女优修改成功，2秒将跳转到列表页！请等待...</strong>";
    $referPage = $_COOKIE["referPage"];//如果存在返回页
    if($referPage){
        exit(header("refresh:2;url=".$referPage));
    }
}

?>