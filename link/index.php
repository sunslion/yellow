<?php
   $hpHost = 'http://'.$_SERVER['HTTP_HOST'];//域名地址
   $urlStr = $_SERVER['REQUEST_URI'];//获取的字符串
   $urlStr = trim($urlStr);
   $tripStr = strip_tags($urlStr);//过滤敏感标签
   $htmStr = htmlentities($tripStr);//过滤敏感标签
   $addstr = addslashes($htmStr);//过滤敏感标签
   $url = str_replace('/link/', '', $addstr);
   if(empty($url)) exit(header('Location:'.$hpHost));
   $host = $hpHost.'/AddrDirect?url=';
   $right_url = $host.$url;
   exit(header('Location:'.$right_url));
?>



