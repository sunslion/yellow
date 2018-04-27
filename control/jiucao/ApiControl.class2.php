<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP version 5                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2004 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// $Id:$

defined('_VALID') or die('Restricted Access!');
$a = include_once('ChannelModel.class.php');
var_dump(__FILE__);

$dirPath = dirname(dirname(dirname(__FILE__)));
$conf = include_once($dirPath.'/include/config.db.php');

//var_dump($conf);
//var_dump($dirPath.'/include/config.php');
$ChannelModel = new ChannelModel();
//var_dump($ChannelModel);
echo "asfsdfsdf";
exit;
//echo "YYY";
class Api {
    
    public function loadModel(){
        
        
    }
    public function onIndex() {
        //模拟登陆
        $_GET['ac'] = 'list';
        $_GET['pg'] = 1;
        $_GET['rid'] = '';
        $_GET['t'] = 0;
        $_GET['wd'] = '';
        
        $ac = $_GET['ac']; //get_request_arg('ac','STRING');//控制
        $rid = (int)$_GET['rid']; //get_request_arg('rid');//playerID
        $t = (int)$_GET['t']; //get_request_arg('t');//分类
        $ids = $_GET['ids']; //get_request_arg('ids','STRING');
        $h = (int)$_GET['h']; //get_request_arg('h');
        $pg = (int)$_GET['pg']; //get_request_arg('pg');
        $wd = $_GET['wd']; //get_request_arg('wd');
        $pagesize = 20;
        $pg = $pg < 1 ? 1 : $pg;
        $t = $t === 0 ? -1 : $t;
        $rid = $rid === 0 ? 1 : $rid;
        $wd = strip_tags($wd);
        if (strlen($wd) > 20) {
            $wd = substr($wd, 0, 20);
        }
        if (!empty($ids)) {
            $ids = strip_tags($ids);
            if (strpos($ids, ',') !== false) {
                $ids_arr = explode(',', $ids);
                foreach ($ids_arr as & $id) {
                    $id = round($id);
                }
                $ids = implode(',', $ids_arr);
            } else $ids = round($ids);
        }
        $dat = array(0, $t, $ids, $h, $wd, $pg);
        //var_dump($dat);
        switch ($ac) {
            case 'list':
                echo $this->outList(0, $t, $ids, $h, $wd, $pg);
                break;

            case 'videolist':
                echo $this->outList(1, $t, $ids, $h, $wd, $pg);
                break;

            default:
                die('err{0}');
        }
    }
    private function videolistOut($addtime, $id, $cid, $name, $cname, $pic, $lang, $area, $year, $state, $playfrom, $playurl) {
        return <<<EOT
            <video><last>{$addtime}</last><id>{$id}</id><tid>{$cid}</tid><name><![CDATA[{$name}]]></name><type>{$cname}</type><pic>{$pic}</pic><lang>{$lang}</lang><area>{$area}</area><year>{$year}</year><state>{$state}</state><note><![CDATA[]]></note><actor><![CDATA[]]></actor><director><![CDATA[]]></director><dl><dd flag="{$playfrom}"><![CDATA[{$playurl}]]></dd></dl><des><![CDATA[]]></des></video>
EOT;
        
    }
    private function vlistOut($addtime, $id, $cid, $name, $cname, $playfrom) {
        return <<<EOT
        <video><last>{$addtime}</last><id>{$id}</id><tid>{$cid}</tid><name><![CDATA[{$name}]]></name><type>{$cname}</type><dt>{$playfrom}</dt><note><![CDATA[]]></note></video>
EOT;
        
    }
    private function outList($isV, $t, $ids, $h, $wd, $pg, $pagesize = 20) {
        $xml = '<?xml version="1.0" encoding="utf-8"?><rss version="4.0">%s</rss>';
        $classStr = $this->outClass();//标题--女神学生</ty><ty id="2">美熟少妇</ty>
        //var_dump($classStr);
        $where = array();
        if ($t > 0) {
            $where['channel'] = array(
                $t,
                '='
            );
        }
        if (!empty($ids)) {
            $where['VID'] = array(
                $ids,
                'in'
            );
        }
        if ($h > 0) {
            $etime = time();
            $stime = strtotime("-{$h} hours");
            $where['addtime'] = ' addtime > ' . $stime . ' AND addtime < ' . $etime;
        }
        if (!empty($wd)) {
            $where['title'] = array(
                $wd,
                'like',
                'OR'
            );
            $where['keyword'] = array(
                $wd,
                'like'
            );
        }
        $video = $this->modelFactory->get('video');
        $total = $video->getTotal($where);
        $pageCount = ceil($total / $pagesize);
        $pageindex = ($pg - 1) * $pagesize;
        $videoList = $video->getAll($where, $pageindex, $pagesize, 'addtime DESC');
        $listXml = "<list page=\"{$pg}\" pagecount=\"{$pageCount}\" pagesize=\"{$pagesize}\" recordcount=\"{$total}\">%s</list>";
        $videoXml = '';
        $channel = $this->modelFactory->get('channel');
        foreach ($videoList as $v) {
            $channelObj = $channel->get($v['channel']);
            if ($isV) {
                $videoXml.= $this->videolistOut($v['addtime'], $v['VID'], $v['channel'], $v['title'], $channelObj['name'], $v['pic'], '', '', '', '', 'ckplayer', $v['ipod_filename']);
            } else {
                $videoXml.= $this->vlistOut($v['addtime'], $v['VID'], $v['channel'], $v['title'], $channelObj['name'], 'ckplayer');
            }
        }
        $listXml = $classStr . sprintf($listXml, $videoXml);
        return sprintf($xml, $listXml);
    }
    private function outClass() {
        $channels = $this->getChannels();
        $classXml = '<class>%s</class>';
        $tyXml = '<ty id="%s">%s</ty>';
        $tyXmlStr = '';
        foreach ($channels as $v) {
            $tyXmlStr.= sprintf($tyXml, $v['CHID'], $v['name']);
        }
        return sprintf($classXml, $tyXmlStr);
    }
    private function synInsert($varr) {
        $duration = $this->secondsToHour($varr[0]['metadata']['time']);
        list($filename, $ext) = explode('.', $varr[0]['orgfile']);
        $title = addslashes($filename);
        $ipod_filename = $varr[0]['rpath'];
        $ipod_filename = str_replace('\\', '/', $ipod_filename);
        $ipod_filename = urlencode($ipod_filename);
        $ipod_filename = str_replace('%2F', '/', $ipod_filename);
        $ipod_filename = str_replace('+', ' ', $ipod_filename);
        $ipod_filename = $varr[0]['qrprefix'] . $ipod_filename . '/index.m3u8';
        $pic = $varr[0]['output']['pic1'];
        $pic = str_replace($varr[0]['outdir'], $varr[0]['qrprefix'], $pic);
        $pic = str_replace('\\', '/', $pic);
        $pic = urlencode($pic);
        $pic = str_replace('%2F', '/', $pic);
        $pic = str_replace('%3A', ':', $pic);
        $pic = str_replace('+', ' ', $pic);
        $time = strtotime($varr[0]['begin']);
        $_id = $varr[0]['_id'];
        $category = $varr[0]['category'];
        $vkey = $varr[0]['shareid'];
        $video = $this->modelFactory->get('video');
        if ($video->insert(array(
            'title' => $title,
            'duration' => $duration,
            'ipod_filename' => $ipod_filename,
            'pic' => $pic,
            'vkey' => $vkey,
            'zid' => $_id,
            "channel" => $category,
            'addtime' => $time,
        ))) {
            return true;
        }
        return false;
    }
    //无用
    public function onUpdate() {
        $this->isajax = 1;
        $json = file_get_contents("php://input");
        $result = array(
            'status' => 0,
            'msg' => 'fail'
        );
        if (empty($json)) {
            echo json_encode($result);
            exit;
        }
        $varr = json_decode($json, true);
        if (!is_array($varr) || empty($varr)) {
            echo json_encode($result);
            exit;
        }
        $_id = $varr[0]['_id'];
        $category = intval($varr[0]['category']);
        $video = $this->modelFactory->get('video');
        if ($video->getTotal("zid = '{$_id}'")) {
            if ($video->update(array(
                'channel' => $category
            ) , "zid = '{$_id}'")) {
                $result['status'] = 1;
                $result['msg'] = 'success';
                echo json_encode($result);
                exit;
            }
        } else {
            if ($this->synInsert($varr)) {
                $videoTotal = $video->getTotal('channel=' . $category);
                if ($videoTotal) {
                    $channel = $this->modelFactory->get('channel');
                    $channel->update(array(
                        'total_videos' => $videoTotal
                    ) , 'CHID=' . $category);
                }
                $result['status'] = 1;
                $result['msg'] = 'success';
                echo json_encode($result);
                exit;
            }
        }
        echo json_encode($result);
        exit;
    }
    //无用
    public function onDel() {
        $this->isajax = 1;
        $json = file_get_contents("php://input");
        $result = array(
            'status' => 0,
            'msg' => 'fail'
        );
        if (empty($json)) {
            echo json_encode($result);
            exit;
        }
        $arr = json_decode($json, true);
        if (!is_array($arr) || empty($arr)) {
            echo json_encode($result);
            exit;
        }
        $video = $this->modelFactory->get('video');
        $options = array();
        foreach ($arr as $v) {
            $options[] = "'{$v}'";
        }
        $videos = $video->getAll('zid in (' . implode(',', $options) . ')', 1, 0);
        print_r($videos);
        if ($video->delete(array(
            'zid' => $arr
        ))) {
            $cids = array();
            if ($videos && is_array($videos)) {
                foreach ($videos as $va) {
                    if (!in_array($va['channel'], $cids)) {
                        $cids[] = $va['channel'];
                    }
                }
            }
            if (count($cids) > 0) {
                foreach ($cids as $category) {
                    $videoTotal = $video->getTotal('channel=' . $category);
                    $channel = $this->modelFactory->get('channel');
                    $channel->update(array(
                        'total_videos' => $videoTotal
                    ) , 'CHID=' . $category);
                }
                unset($cids);
            }
            unset($arr);
            unset($options);
            unset($videos);
            $result['status'] = 1;
            $result['msg'] = 'success';
            echo json_encode($result);
            exit;
        }
        echo json_encode($result);
        exit;
    }
    //无用
    public function onGetchannel() {
        $channels = $this->getChannels();
        echo json_encode($channels);
        exit;
    }
    //无用
    private function secondsToHour($seconds) {
        $seconds = intval($seconds);
        if ($seconds < 60) {
            $tt = '00:00' . sprintf("%02d", $seconds % 60);
        }
        $t = 0;
        if ($seconds >= 60) {
            $h = intval($seconds / 60);
            $s = $seconds % 60;
            if ($s === 60) {
                $s = 0;
                ++$h;
            }
            if ($h === 60) {
                $h = 0;
                ++$t;
            }
            if ($t) {
                $t = sprintf("%02d", $t);
            }
            $s = sprintf("%02d", $s);
            $h = sprintf("%02d", $h);
            $tt = $t . ':' . $h . ':' . $s;
        }
        if ($seconds >= 3600) {
            $t = intval($seconds / 3600);
            $h = intval($seconds / 60 - $t * 60);
            $s = $seconds % 60;
            if ($s === 60) {
                $s = 0;
                ++$h;
            }
            if ($h === 60) {
                $h = 0;
                ++$t;
            }
            if ($t) {
                $t = sprintf("%02d", $t);
            }
            $s = sprintf("%02d", $s);
            $h = sprintf("%02d", $h);
            $tt = $t . ':' . $h . ':' . $s;
        }
        if (!(int)$t) {
            $tt = $h . ':' . $s;
        }
        return $seconds > 0 ? $tt : '00:00:00';
    }
    private function formatBytes($size) {
        $units = array(
            ' B',
            ' KB',
            ' MB',
            ' GB',
            ' TB'
        );
        for ($i = 0; $size >= 1024 && $i < 4; $i++) {
            $size/= 1024;
        }
        return round($size, 2) . $units[$i];
    }
    protected function getChannels($parent=0){
        $key = 'channel_'.$parent;
        //$channels =  $this->cache->get($key);
        //if (!$channels) {
            $channelModel = $this->modelFactory->get('channel');
            $channels = $channelModel->getAll($parent);
            $this->cache->set($key,$channels,3600);
        //}
        //var_dump($parent);
        return $channels;
    }
}
?>
