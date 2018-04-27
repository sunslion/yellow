<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

if ( isset($_GET['a']) ) {
    $action     = trim($_GET['a']);
    $AID        = ( isset($_GET['AID']) && is_numeric($_GET['AID']) ) ? intval(trim($_GET['AID'])) : NULL;

    if ( isset($_GET['a']) && ( $_GET['a'] == 'clearcache') ) {
        write_ads_cache();
        $messages[] = 'Advertise cache were deleted successfuly';
    }elseif ( $action == 'activate' or $action == 'suspend' ) {
        $status = ( $_GET['a'] == 'activate' ) ? '1' : '0';
        $sql    = "UPDATE adv SET adv_status = '" .$status. "' WHERE adv_id = " .$AID. " LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() ) {
            $messages[] = 'Advertise successfuly ' .$_GET['a']. 'ed!';
        } else {
            $errors[] = 'Failed to ' .$_GET['a']. ' advertise! Invalid advertise id!?';
        }
    } elseif ( $action == 'delete' ) {
        $basedir = dirname(dirname(dirname(dirname(__FILE__))));
        $logo_path = $basedir.'/ps';//图片实际存储根目录地址
        //删除修改之前图片---
        $sql = "SELECT `locImgAddr` FROM `adv_ads` WHERE `id`=".$AID;
        $beforArr = $conn->execute($sql);
        $beforImgArr = $beforArr->getrows(1);
        if(implode('', $beforImgArr)){
            $beforImg = $logo_path. '/' .basename($beforImgArr[0]['locImgAddr']);
            $imgStatus = delImage($beforImg); //删除无用图片
            //if($imgStatus['code']!=1) return array('code'=>0,'msg'=>$imgStatus['msg']);
        }
        //删除数据
        $sql    = "DELETE FROM adv_ads WHERE id = " .$AID. " LIMIT 1";
        $conn->execute($sql);
        write_ads_cache();
        getrefer();//删除成功跳转到首页
        //$messages[]    = 'Advertise deleted successfully!';
    } else {
        $errors[] = 'Invalid action specified! Allowed actions: activate, suspend and delete!';
    }
}


//查询参数
intval($_REQUEST['type']) ? $type = intval($_REQUEST['type']):$type = 0;
intval($_REQUEST['ismobile']) ? $ismobile = intval($_REQUEST['ismobile']):$ismobile = 0;
intval($_REQUEST['isFix'])||$_REQUEST['isFix']==='0' ? $isFix = intval($_REQUEST['isFix']):$isFix = 2;//默认广告不固定
$sql      = constructQuery($type,$ismobile,$isFix);
$rs         = $conn->execute($sql);
$advs       = $rs->getrows();
//var_dump($advs);
function constructQuery($type,$ismobile=2,$isFix=2)
{
    global $smarty;
    $query              = array();
    $where = " WHERE 1=1";
    //var_dump($where .= " AND g.`ismobile`='$ismobile' ");
    if($ismobile!=2) $where .= " AND g.`ismobile`='$ismobile' ";
    if($type) $where .= " AND `zone_id`='{$type}' ";
    if($isFix!=2) $where .= " AND a.`isFix`='$isFix' ";
    //排序 第一优序列号排序 第二优先时间倒序
    $where .=" ORDER BY `orderby` ASC , `addtime` DESC";
    $sql = "SELECT a.*, g.name as zone_name,g.width,g.height FROM adv_ads a LEFT JOIN adv_zone g ON (a.zone_id=g.id)".$where;
    return $sql;
}

//查询广告位列表
$sql2        = "SELECT `id`,`name` FROM `adv_zone` ORDER BY `id` ASC";
$rs2         = $conn->execute($sql2);
$advsType       = $rs2->GetAll();
//var_dump($advsType);exit;
//var_dump($advs);
$smarty->assign('ismoblie', $ismobile);
$smarty->assign('advsType', $advsType);
$smarty->assign('advs', $advs);
$smarty->assign('searchType', $type);
$smarty->assign('isFix', $isFix);

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
