<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
if ( isset($_GET['a']) ) {
    $action     = trim($_GET['a']);
    $AID        = ( isset($_GET['AID']) && is_numeric($_GET['AID']) ) ? intval(trim($_GET['AID'])) : NULL;
    if ( $action == 'delete' ) {
        $basedir = dirname(dirname(dirname(dirname(__FILE__))));
        $logo_path = $basedir.'/ps';//图片实际存储根目录地址
        //删除修改之前图片---
        $sql = "SELECT `avator_img`,`avdesc_img` FROM `avactor` WHERE `id`=".$AID;
        $beforArr = $conn->execute($sql);
        $beforImgArr = $beforArr->getrows(1);
        if(implode('', $beforImgArr)){
            $avator_img = $logo_path. '/' .basename($beforImgArr[0]['avator_img']);
            $avdesc_img = $logo_path. '/' .basename($beforImgArr[0]['avdesc_img']);
            $imgStatus = delImage($avator_img); //删除无用图片
            $imgStatus = delImage($avdesc_img); //删除无用图片
            //if($imgStatus['code']!=1) return array('code'=>0,'msg'=>$imgStatus['msg']);
        }
        //删除数据
        $sql    = "DELETE FROM avactor WHERE id = " .$AID. " LIMIT 1";
        $result =  $conn->execute($sql);
        //判断入库情况
        if ($result && $conn->Affected_Rows() > 0) {
            getrefer();//删除成功跳转到首页
            exit();
        }
        //$messages[]    = 'Advertise deleted successfully!';
    } else {
        $errors[] = 'Invalid action specified! Allowed actions: activate, suspend and delete!';
    }
}
$sql      = constructQuery();
$rs         = $conn->execute($sql);
$avactor       = $rs->GetAll();
$smarty->assign('avactor', $avactor);
function constructQuery()
{
    global $smarty;
    $query              = array();
    //排序 第一优序列号排序 第二优先时间倒序
    $where .=" ORDER BY `orderby` ASC , `addtime` DESC";
    $sql = "SELECT *  FROM avactor ".$where;
    return $sql;
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
function getrefer(){
    echo "<strong>广告删除成功，2秒将跳转到列表页！请等待...</strong>";
    $referPage = $_COOKIE["referPage"];//如果存在返回页
    if($referPage){
        exit(header("refresh:2;url=".$referPage));
    }
}
?>
