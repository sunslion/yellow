<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
function output($e,$m){
    $m['error'] = $e;
    $m['message'] = $m;
    echo json_encode($m);
    exit;
}
$url_path = '/pic/';
$save_path = $config['BASE_DIR'].$url_path;
$ext_arr = array(
  'image' => array('gif','jpg','jpeg','png')  
);
$max_size = 1024000;
$msg = array('error'=>0,'message'=>'');
$error = '';
if (!empty($_FILES['imgFile']['error'])) {
    switch ($_FILES['imgFile']['error']) {
        case '1':
            $error = '超过php.ini允许的大小';    
            break;
        case '2':
            $error = '超过表单允许的大小';
            break;
        case '3':
            $error = '图片只有部分被上传';
            break;
        case '4':
            $error = '请选择图片';
            break;
        case '6':
            $error = '找不到临时目录';
            break;
        case '7':
            $error = '写文件到硬盘出错';
            break;
        case '8':
            $error = 'File upload stopped by extension。';
            break;
        case '999':
        default:
            $error = '未知错误';
            break;
    }
    output(1, $error);
}
if (!empty($_FILES)) {
    $files = $_FILES['imgFile'];
    $file_name = $files['name'];
    $tmp_name = $files['tmp_name'];
    $file_size = $files['size'];
    
    if (empty($file_name)) {
        output(1, '请选择文件');
    }
    if (@is_dir($save_path) === false) {
        output(1, '上传目录不存在');
    }
    if (@is_writable($save_path) === false) {
        output(1, '上传目录没有写的权限');
    }
    if (@is_uploaded_file($tmp_name) === false) {
        output(1, '上传失败');
    }
    if ($file_size > $max_size) {
        output(1, '上传文件大小超过限制');
    }
    //获得文件扩展名
    $temp_arr = explode(".", $file_name);
    $file_ext = array_pop($temp_arr);
    $file_ext = trim($file_ext);
    $file_ext = strtolower($file_ext);
    //检查扩展名
    if (in_array($file_ext, $ext_arr['image']) === false) {
        output(1,"上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr['image']) . "格式。");
    }
    //从文件内容检查
    $file_ext = getFileType($tmp_name);
    if (in_array($file_ext, $ext_arr['image']) === false) {
        output(1,"上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr['image']) . "格式。");
    }
    if (!file_exists($save_path)) {
        mkdir($save_path,644);
    }
    $ymd = date('Ymd');
    $save_path .= $ymd .'/';
    $url_path .= $ymd . '/';
    if (!file_exists($save_path)) {
        mkdir($save_path,0755);
    }
    $new_file_name = date('YmdHis').'_'.rand(10000, 9999).'.'.$file_ext;
    $file_path = $save_path.$new_file_name;
    if (move_uploaded_file($tmp_name, $file_path) === false) {
        output(1, '上传文件失败。');
    }
    chmod($file_path, 0755);
    $file_url = $url_path.$new_file_name;
    header('Content-type:text/html;charset=UTF-8');
    echo json_encode(array('error'=>0,'url'=>$file_url));exit;
}else{
    output(1, '文件错误');
}