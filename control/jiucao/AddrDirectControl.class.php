<?php
defined('_VALID') or die('Restricted Access!');
class AddrDirect extends Base{
	// 广告列表
    public function  onIndex(){
        //AddrDirect/index/code/abc
        @get_request_arg('code','STRING') ? $url = get_request_arg('code','STRING'):$url = "";
        //var_dump($url);exit;
        //非法请求 跳转到撸死你首页
        $errUrl =  'http://'.$_SERVER['HTTP_HOST'].'/';//非法请求跳转地址
        if(!isset($url) || !$url) exit( header('Location: ' . $errUrl));
        $ComSqlModel = $this->modelFactory->get('ComSql');
        $where = " `jumpShortAddr`='{$url}' ";
        $sql = "SELECT `url` FROM `adv_ads` WHERE ".$where;
        $res = $ComSqlModel->getNumInfo($sql);//获取一条数据
        //var_dump($res);
        if(!is_array($res)||!implode("", $res)){
            $imgAddr = $errUrl;
            //不是非法请求--跳转到长连接地址
        }else{
            $fullUrl = $res[0]['url'];
            //查找真实URL后面的数组
            $imgAddr = trim($fullUrl);//替换掉多余的$part
            $imgAddr ? $imgAddr = $imgAddr : $imgAddr = $errUrl;//判断地址是否为空，如果为空跳转到错误页
        }
        //如果查询不到数据--非法请求
        exit(header('Location: ' . $imgAddr));
    }    
}
?>