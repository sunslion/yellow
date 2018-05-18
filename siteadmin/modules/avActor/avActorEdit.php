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

//添加专辑
if(isset($_REQUEST['fimgAdd']) && !$errors ) {
    //调取 编辑函数
    $fimgAdd = fimgAdd($conn,$id,$config);
    if(!is_array($fimgAdd)||$fimgAdd['code']!=1){
        $errors[] = $fimgAdd['msg'];
    }else{
        $messages[] = $fimgAdd['msg'];
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
//查询女优
$sql = "SELECT * FROM `av_actor`  WHERE `id` = $id LIMIT 1 ";
$rs     = $conn->execute($sql);
if($rs && $conn->Affected_Rows() > 0){
    $avactor    = $rs->getrows();
}
//查询专辑
$where .=" ORDER BY `orderNum` ASC , `addtime` DESC";//排序 第一优序列号排序 第二优先时间倒序
$sql = "SELECT * FROM `av_actor_fpic`  WHERE `aid` = $id ".$where ;
$pic_rs = $conn->execute($sql);
if($pic_rs && $conn->Affected_Rows() > 0){
    $avactor_pic = $pic_rs->getrows();
}
$smarty->assign('avactor', $avactor[0]);
$smarty->assign('avactor_pic', $avactor_pic);

//编辑女优
function adv_edit($conn,$id,$config){
    $basedir = dirname(dirname(dirname(dirname(__FILE__))));
    $logo_path = $basedir.'/public/avImg';//图片实际存储根目录地址
    $view_path = '/public/avImg';//前台显示图片地址
    $hpHost = 'http://'.$_SERVER['HTTP_HOST'];//域名地址
    $name   = trim($_REQUEST['name']); //中文名
    intval($_REQUEST['orderNum'])||$_REQUEST['orderNum']==='0' ? $orderNum = intval($_REQUEST['orderNum']) : $orderNum = '1'; //排序
    $japan_name   = trim($_REQUEST['japan_name']); //日文名
    $birth_day   = trim($_REQUEST['birth_day']); //出生日期
    $birth_palce   = trim($_REQUEST['birth_palce']); //出生地
    $agency   = trim($_REQUEST['agency']); //经济公司
    $blood_type   = trim($_REQUEST['blood_type']); //血型
    $tall   = trim($_REQUEST['tall']); //身高
    $weight   = trim($_REQUEST['weight']); //体重
    $size   = trim($_REQUEST['size']); //三围
    $cup_size   = trim($_REQUEST['cup_size']); //罩杯
    $front_avator_img   = trim($_REQUEST['front_avator_img']); //头像图片
    $push  = intval($_REQUEST['push']); //是否推荐
    $addtime   = date('Y-m-d H:i:s',time()); //简介
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
    $sql = "SELECT `avator_img` FROM `av_actor` WHERE `id`=" . $id;
    $beforArr = $conn->execute($sql);
    $beforImgArr = $beforArr->getrows(1); //历史信息
    //如果是本地上传的图片
    if ( $_FILES['avator_img']['tmp_name'] != '' || $_FILES['cover_img']['tmp_name'] != '') {
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

        //删除修改之前图片---
        if($_FILES['avator_img']['tmp_name'] && $beforImgArr[0]['avator_img'] && file_exists($basedir.$beforImgArr[0]['avator_img'])){
            $beforImg = $logo_path . '/' . basename($beforImgArr[0]['avator_img']);
            $imgStatus = delImage($beforImg); //删除无用图片
        }
    }
    //进行数据入库--------
    $name = mysql_real_escape_string($name);
    $japan_name = mysql_real_escape_string($japan_name);
    $avator_img = mysql_real_escape_string($avator_img);
    $front_avator_img = mysql_real_escape_string($front_avator_img);
    $birth_day = mysql_real_escape_string($birth_day);
    $birth_palce = mysql_real_escape_string($birth_palce);
    $agency = mysql_real_escape_string($agency);
    $blood_type = mysql_real_escape_string($blood_type);
    $tall = mysql_real_escape_string($tall);
    $weight = mysql_real_escape_string($weight);
    $size = mysql_real_escape_string($size);
    $cup_size = mysql_real_escape_string($cup_size);
    $sql = "UPDATE av_actor SET `name`= '{$name}',`japan_name`= '{$japan_name}',`orderNum`= '{$orderNum}',`birth_day`= '{$birth_day}',`birth_palce`= '{$birth_palce}',`agency`= '{$agency}',`blood_type`= '{$blood_type}',`tall`= '{$tall}',`weight`= '{$weight}',`size`= '{$size}',`push`= '{$push}',`cup_size`= '{$cup_size}',`addtime`= '{$addtime}' " ;
    if($avator_img){
        $sql.=",avator_img='{$avator_img}'";
    }
    if($front_avator_img){
        $sql.=",front_avator_img='{$front_avator_img}'";
    }
    $sql .= " WHERE id = " .intval($id). " LIMIT 1;";
    $result = $conn->execute($sql);
    //判断入库情况
    if ($result && $conn->Affected_Rows() > 0) {
        return array('code'=>1,'msg'=>'女优修改成功');
    }else{
        return array('code'=>0,'msg'=>'女优修改失败');
    }
}

//添加专辑
function fimgAdd($conn,$id,$config){
    $basedir = dirname(dirname(dirname(dirname(__FILE__))));
    $logo_path = $basedir.'/public/avImg';//图片实际存储根目录地址
    $view_path = '/public/avImg';//前台显示图片地址
    $hpHost = 'http://'.$_SERVER['HTTP_HOST'];//域名地址
    $tag   = trim($_REQUEST['tag']); //标签
    $title   = trim($_REQUEST['title']); //专辑名称
    $push   = intval($_REQUEST['push']); //推荐
    $front_cover_img   = trim($_REQUEST['front_cover_img']); //简介
    $details   = trim($_REQUEST['details']); //简介
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

    }
    //进行数据入库--------
    $front_cover_img = mysql_real_escape_string($front_cover_img);
    $cover_img = mysql_real_escape_string($cover_img);
    $tag = mysql_real_escape_string($tag);
    $details = mysql_real_escape_string($details);
    $title = mysql_real_escape_string($title);
    $sqlFile = '`aid`, `cover_img`, `push`,`title`,`tag`,`details`,`front_cover_img`';
    $sqlValue = "'{$id}','{$cover_img}','{$push}','{$title}','{$tag}','{$details}','{$front_cover_img}'";
    $sql = "INSERT INTO av_actor_fpic($sqlFile) VALUES($sqlValue)";
    $result = $conn->execute($sql);
    //判断入库情况
    if ($result && $conn->Affected_Rows() > 0) {
        return array('code'=>1,'msg'=>'专辑添加成功');
    }else{
        return array('code'=>0,'msg'=>'专辑添加失败');
    }
}

//删除图库
function imgDel($conn,$id,$config){
    $basedir = dirname(dirname(dirname(dirname(__FILE__))));
    $logo_path = $basedir.'/public/avImg';//图片实际存储根目录地址
    $view_path = '/public/avImg';//前台显示图片地址
    $hpHost = 'http://'.$_SERVER['HTTP_HOST']; //域名地址
    //删除图片
    //------查询本地'原图片'地址
    $sql = "SELECT `cover_img`  FROM `av_actor_fpic` WHERE `id`=" . $id;
    $beforArr = $conn->execute($sql);
    $beforImgArr = $beforArr->getrows(1); //历史信息
    $beforImg = $logo_path . '/' . basename($beforImgArr[0]['cover_img']);
    $imgStatus = delImage($beforImg); //删除无用图片
    //删除图库图像
    $sql = "SELECT `image`  FROM `av_actor_pic` WHERE `aid`=" . $id;
    $beforArr = $conn->execute($sql);
    $beforImgArr = $beforArr->getrows(1); //历史信息
    if(is_array($beforImgArr) && $beforImgArr[0]['image']){
        foreach ($beforImgArr  as $k=>$v){
            $beforImg = $logo_path . '/' . basename($v['image']);
            $imgStatus = delImage($beforImg); //删除无用图片
        }
    }
    //删除数据--------
    $sql2 =  "DELETE FROM `av_actor_pic` WHERE aid = $id";
    $res2 = $conn->execute($sql2);
    $sql =  "DELETE FROM `av_actor_fpic` WHERE id = $id";
    $result = $conn->execute($sql);
    //判断入库情况
    if ($result && $conn->Affected_Rows() > 0) {
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
    echo '<strong>"'.$msg.'",3秒将跳转到列表页！请等待...</strong>';
    $referPage = $_COOKIE["referPage"];//如果存在返回页
    if($referPage){
        exit(header("refresh:3;url=".$referPage));
    }
}

?>