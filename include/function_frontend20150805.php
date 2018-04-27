<?php

defined('_VALID') or die('Restricted Access!');

/*
BBS 域名计算重组 作者:office.frontend@gmail.com
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
作者:office.frontend@gmail.com
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

/*
作者:office.frontend@gmail.com
到期显示
*/

function PremiumRemainingView($array = array()) {
global $type_of_user;
if($type_of_user==='premium'){
	switch ($array['status']) {
	case 'expired':
	$return = '已到期'.$array['days'].'天';
	break;
	default:
	if($array['days']<5){
	$return = '离到期日'.$array['days'].'天';
	}else{
	$return = '还剩:'.$array['days'].'天';
	}
	break;
	}
	return $return;
}else{
return '普通会员';
}
	
}

/*
作者:office.frontend@gmail.com
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
				if($array['days']<=30){
					$return = '屌丝';
				}
				elseif($array['days']>30 AND $array['days']<=90){
					$return = '老板';
				}
				elseif($array['days']>90 AND $array['days']<=120){
					$return = '富人';
				}
				elseif($array['days']>120 AND $array['days']<=210){
					$return = '富豪';
				}
				elseif($array['days']>210 AND $array['days']<=365){
					$return = '大富豪';
				}
				elseif($array['days']>365){
				$return = '福克斯';
				}
			break;
		}

		return $return;
	}else{
	return '普通会员';
	}
}



?>
