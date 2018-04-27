<?php
require 'common.php';
$remoteAddRequestUrl = 'http://www.jiucao.com/sys/add';
$result = curlGetData($remoteAddRequestUrl);
var_dump($result);