<?php
defined('_VALID') or die('Restricted Access!');
class Libs_Redirect
{
    public static function go( $url ) 
    {
        session_write_close();
        if ( headers_sent() ) {
            echo "<script>document.location.href='" .$url. "';</script>\n";
        } else {
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: '. $url);
        }
        die();
    }
    public static function gomsg($url,$msg,$t=0) {
        session_write_close();
        if($url==""){ $url='javascript:void(0)'; $urljs="alert('{$msg}');history.go(-1);"; } else{ $urljs="alert('{$msg}');location='".$url."';"; }
        echo <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>系统提示</title>
<style>
.container{ padding:9px 20px 20px; text-align:left; }
.infobox{ clear:both; margin-bottom:10px; padding:30px; text-align:center; border-top:4px solid #DEEFFA; border-bottom:4px solid #DEEEFA; background:#F2F9FD; zoom:1; }
.infotitle1{ margin-bottom:10px; color:#09C; font-size:14px; font-weight:700;color:#ff0000; }
h3{ margin-bottom:10px; font-size:14px; color:#09C; }
</style>
</head>
<body>
<span style="display:none"><script>function jump(){ $urljs } setTimeout("jump()",$t);</script></span>
</body>
</html>
EOT;
        exit;
    }
}
?>