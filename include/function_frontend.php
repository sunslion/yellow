<?php

defined('_VALID') or die('Restricted Access!');

/*
BBS 域名计算重组 
*/
function bbsDomain() {
        $domain = $_SERVER['HTTP_HOST'];
        $domain = str_replace("www.", "", "$domain");
        $bbsdomain = 'bbs.'.$domain;
        $bbsdomain_list = 'bbs.zhibose.com|bbs.zhibonan.com|bbs.zhibogan.com|bbs.zhibolu.com|bbs.zhibomo.com|bbs.zhiboav.com|bbs.zhibotk.com|bbs.zhibokan.com|bbs.zhibosp.com|bbs.zhibozy.com|bbs.avnanren.com|bbs.zhibokan.me|bbs.zhibokan.us|bbs.zhibokan.la|bbs.zhibokan.info|bbs.zhiboav.me|bbs.zhiboav.us|bbs.zhiboav.la|bbs.zhiboav.info|bbs.zhibose.me|bbs.zhibose.us|bbs.zhibose.la|bbs.zhibose.info|bbs.zhibolu.me|bbs.zhibolu.us|bbs.zhibolu.la|bbs.zhibolu.info|bbs.qqcbbs.com|bbs.qqc2015.com|bbs.qqc2016.com|bbs.qqc2017.com|bbs.qqc2018.com|bbs.qqc2019.com|bbs.qqc2020.com|bbs.ttcao1.com|bbs.ttcao2.com|bbs.ttcao3.com|bbs.ttcao4.com|bbs.ttcao5.com|bbs.ttcao6.com|bbs.ttcao7.com|bbs.ttcao8.com|bbs.ttcao9.com|bbs.ttcao10.com';
        $domain_array = explode('|',$bbsdomain_list);
        if(in_array($bbsdomain,$domain_array)){
       		return $bbsdomain1 = 'http://'.$bbsdomain;
        }else{
        	return $bbsdomain1 = "http://bbs.qqcbbs.com";
        }
}

/*
剩余时间专用函数
time : 2016-01-01 [YYYY-MM-DD]
*/
function PremiumRemainingTime($uid) {
	global $conn,$config,$type_of_user;
    if($type_of_user==='premium'){
    	$sql        = "SELECT `premium`,`premiumexpirytime` FROM signup where UID='".intval($uid)."' LIMIT 1";
    	$rs         = $conn->Execute($sql);
    	$endtime = $rs->fields['premiumexpirytime'];
    	$premium = $rs->fields['premium'];
    	$today=date('Y-m-d',time());
    	$today_strtotime = strtotime($today);
    	$endtime_strtotime = strtotime($endtime);
    	$SEC = $endtime_strtotime-$today_strtotime;
    	$MIN = $SEC/60;
    	$HR = $MIN/60;
    	$DAY = $HR/24;
    	if($DAY<0){$return['status'] = 'expired';}
    	else{$return['status'] = 'normal';}
    	$return['days'] = abs($DAY);
    	$return['ymd'] = $endtime;
    	return $return;
    }else{
        return false;
    }
}

function NewPremiumRemainingSEBI($uid,$premium){
    global $conn;
    include 'config.rank.php';
    $return = array();
    $uid = intval($uid);
    if ($premium == 0) {
        $sql = "SELECT sebi_tiyan FROM user_sebi WHERE UID={$uid} LIMIT 1;";
        $rs = $conn->execute($sql);
        $sebi_surplus = $rs -> fields['sebi_tiyan'];
        $return['sebi_surplus'] = $sebi_surplus;
    }elseif ($premium == 1) { 
        $sql = "SELECT sebi_surplus FROM user_sebi WHERE UID={$uid} LIMIT 1;";
        $rs = $conn->execute($sql);
        $sebi_surplus = $rs -> fields['sebi_surplus'];
        $sebi_surplus = intval($sebi_surplus);
        foreach ($rank_range as $k => $v){
            list($min,$max) = $v;
            if ($min <= $sebi_surplus && $max >= $sebi_surplus) {
                $return['rank'] = $rank[$k];
                break;
            }
        }
        $return['sebi_surplus'] = $sebi_surplus;
    }elseif ($premium == 2){
        $sql    = "SELECT years,otime FROM signup WHERE UID = {$uid} LIMIT 1";
        $rs     = $conn->execute($sql);
        $years = $rs->fields['years'];
        $otime = $rs->fields['otime'];
        $endTime = strtotime("+{$years} year",$otime);
        
        $Today = date("y-m-d");
        $Today = strtotime($Today);
        $return['today'] = $Today;
        $return['otime'] = $endTime;
        $return['rank'] = $rank[5];
    }elseif ($premium == 3){
        $return['rank'] = $rank[6];
    }
    $return['premium'] = $premium;
    $return['user_range'] = $user_range[$premium];
    return $return;
}
/*
到期显示
*/
function PremiumRemainingView( $array = array() ) {
	global $type_of_user;
	if( $type_of_user === 'premium' ) {
		switch ($array['status']) {
		case 'expired':
			$return = '已到期'.$array['days'].'天';
			break;
		default:
			if( $array['days'] < 5 ) {
				$return = '离到期日' . $array['days'] . '天';
			} else {
				$return = '还剩:' . $array['days'] . '天';
			}
			break;
		}
		return $return;
	} else {
		return '普通会员';
	}
}
function NewPremiumRemainingView( $array = array() ) {
    if(!isset($array['premium'])) return '';
    include 'config.rank.php';
    switch ($array['premium']) {
        case 0:
            $return = '还剩余'.intval($array['sebi_surplus']).'个体验币';
            break;
        case 1:
            $return = '还剩余'.intval($array['sebi_surplus']).'个色币';
            break;
        case 2:
            $days = round(($array['otime'] - $array['today']) / 86400);
            if( $days < 5 ) {
                $return = '离到期日' . $days . '天';
            } else {
                $return = '还剩:' . $days . '天';
            }
            break;
        case 3:
            $return = '';
            break;
        default:
            $return = '';
            break;
    }
    return $return;
}
/*
用户级别
*/
function PremiumNikename($array = array()){
	global $type_of_user;
	if($type_of_user==='premium'){
		switch ($array['status']) {
			case 'expired':
				$return = '屌丝';
				break;
			case 'normal':
				if( $array['days'] <= 30) {
					$return = '屌丝';
				} elseif ( $array['days']>30 AND $array['days'] <= 90 ) {
					$return = '老板';
				} elseif( $array['days'] > 90 AND $array['days'] <= 120) {
					$return = '富人';
				} elseif($array['days'] > 120 AND $array['days'] <= 210 ){
					$return = '富豪';
				} elseif ( $array['days']  > 210 AND $array['days'] <= 365 ){
					$return = '大富豪';
				} elseif( $array['days'] > 365 ) {
					$return = '福布斯';
				}
			break;
		}
		return $return;
	} else {
		return '普通会员';
	}
}
function NewPremiumNikename( $rank_index ){
    global $type_of_user;
    if($type_of_user === 'premium'){
        include 'config.rank.php';
        return !$rank[$rank_index] ? '普通会员' : $rank[$rank_index];
    } else {
        return '普通会员';
    }
}
function sdate_format($times){
    return date('Y-m-d H:i:s',$times);
}
function ddate_format($times){
    return date('Y.m.d',$times);
}
function clear_trim($txt,$len=50){
    return mb_substr(trim(strip_tags($txt)),0,$len,'utf-8');
}
