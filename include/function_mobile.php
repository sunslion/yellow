<?php
/*|******************************************************
|*|	iPhone / iPod - Mobile Webapp Module Version 2.0
|*| -----------------------------
|*| AVS Version 2.0+
|*| 12-03-2009
|*|******************************************************
|*/

function insert_video_rating( $options ){
    global $conn;
    $vid        = intval($options['video']);
    $sql        = "SELECT rate, ratedby FROM video WHERE VID = " .$vid. " LIMIT 1";
    $rs         = $conn->execute($sql);
    $rate 		= $rs->fields['rate'];
    $ratedby 	= $rs->fields['ratedby'];
    $avg		= 0;
    $votes		= 0;
    if($ratedby){
    	$avg 	= $rate * 20;
    	$votes 	= 'vote';
    	if($ratedby > 1){
    		$votes 	= 'votes';
    	}	
    	$value  = $avg.'% ('.$ratedby.' '.$votes.')';
    }else{
    	$value = 'Not Rated';
    } 
    return $value;
}


function insert_added_ago( $options ){
    global $conn;
    
    $vid        = intval($options['video']);
    $sql        = "SELECT addtime FROM video WHERE VID = " .$vid. " LIMIT 1";
    $rs         = $conn->execute($sql);
    $addtime 	= $rs->fields['addtime'];
	$now 		= time();
	$diff		= $now - $addtime;

	$min	= 60;
	$hour 	= 60 * 60;
	$day	= 60 * 60 * 24;
	$week 	= 60 * 60 * 24 * 7;
	$month 	= 60 * 60 * 24 * 30;
	$year 	= 60 * 60 * 24 * 365;
	
	if($diff < $hour){
		$var = round($diff/$min);
		$value = ($var > 1) ? $var.' minutes ago' : $var.' minute ago';
	}elseif($diff < $day){
		$var = round($diff/$hour);
		$value = ($var > 1) ? $var.' hours ago' : $var.' hour ago';
	}elseif($diff < $week){
		$var = round($diff/$day);
		$value = ($var > 1) ? $var.' days ago' : $var.' day ago';
	}elseif($diff < $month){
		$var = round($diff/$week);
		$value = ($var > 1) ? $var.' weeks ago' : $var.' week ago';
	}elseif($diff < $year){
		$var = round($diff/$month);
		$value = ($var > 1) ? $var.' months ago' : $var.' month ago';
	}else{
		$var = round($diff/$year);
		$value = ($var > 1) ? $var.' years ago' : $var.' year ago';
	}
    return $value;
}

?>
