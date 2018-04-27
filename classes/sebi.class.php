<?php
defined('_VALID') or die('Restricted Access!');
class VSebi {
	public static function check($ip, $num ,$VID,$uid,$ispay=0){
	    global $conn,$type_of_user,$config,$premium;
		$time = strtotime(date('Y-m-d'));
		
		$tomorrow = $time + 86400;
		$expire = $tomorrow - time();
		$options = array(
		    'host'=>$config['mem_host'],
		    'port'=>$config['mem_port'],
		    'prefix'=>'sebiv',
		    'expire'=>$expire,
		    'length'=>99999999
		);
		$cache = Cache::getInstance('MemcacheAction',$options);
		//视频播放需要的色币个数，如若没设置，默认为0
		if ($num <= 0) {
			$num = 1;
		}
		$limit_arr = array();
		switch ($type_of_user) {
			case 'guest':
				return self::check_guest($cache, $ip, $VID, $time,$num,$ispay);
				break;
			case 'free':
				/*****免费*****/
			    return self::check_login_free_user($cache, $uid, $VID, $time,$num,$ispay);
				break;
			case 'premium':
			    if ($premium == 1) {
			        return self::check_login_vip_user($cache, $uid, $VID, $time,$num,$ispay);
			    }elseif($premium == 2){
			        $sql = "SELECT years,otime FROM signup WHERE UID = {$uid} LIMIT 0,1;";
			        $prs = $conn->execute($sql);
			        
			        $years = $prs->fields['years'];
			        $otime = $prs->fields['otime'];
			        $endTime = strtotime("+{$years} year",$otime);
			        if ($time > $endTime) {
			            $sql    = "UPDATE signup SET premium = '0' WHERE UID = {$uid} LIMIT 1;";
			            $conn->execute($sql);
			            	
			            $limit_arr['name'] = $_SESSION['username'];
			            $limit_arr['is_premium'] = 0;
			            return $limit_arr;
			        } 
			    }
			    break;
		}
		return false;
	}
	
	private static function check_login_free_user($cache,$uid,$VID,$time,$num,$ispay=0){
	    global $config, $conn;
	    //当天是否消费过色币看当前视频
	    $key = $uid.$VID.$time.'free';
	    if (self::isview($cache, $key)) {
	        return false;
	    }
	    //检查用户的体验币是否用完
	    $nkey = $uid.$time.'free';
	    require $config['BASE_DIR'].'/classes/NSebi.class.php';
	    $record = NSebi::findSebiRecord($uid);
	    if ($record && $record['sebi_tiyan'] > 0) {
	        $cache->_unset($nkey);
	    }
	    $limit_arr = $cache->get($nkey);
	    if(!$limit_arr){
	        $sql = "select veid from user_sebi_view where uid={$uid} and vid={$VID} and last_time={$time} LIMIT 1";
	        $rs = $conn->execute($sql);
	        if ( $conn->Affected_Rows() === 0 ) {
	            $sql = "SELECT sebi,sebi_tiyan FROM user_sebi WHERE uid = {$uid} LIMIT 0,1";
	            $rs    = $conn->execute($sql);
	             
	            if ( $conn->Affected_Rows() === 1 ) {
	                $free_sebi    = $rs->fields['sebi'];
	                $sebi_tiyan = $rs->fields['sebi_tiyan'];
	
	                if ( $sebi_tiyan < $num ) {
	                    $limit_arr['name'] = $_SESSION['username'];
	                    $limit_arr['sebi_surplus'] = $sebi_tiyan;
	                    $cache->set($nkey,$limit_arr);
	                    return $limit_arr;
	                } 
	                if ($ispay) {
	                    $sql = "UPDATE user_sebi SET sebi_tiyan = sebi_tiyan - {$num} WHERE uid = {$uid} LIMIT 1";
	                    $urs = $conn->execute($sql);
	                    $sql = "INSERT INTO user_sebi_view (uid,vid,last_time) VALUES ('{$uid}','{$VID}','{$time}')";
	                    $urs = $conn->execute($sql);
	                    $cache->set($key,$VID);
	                    return array('sebi_surplus'=>$sebi_tiyan,'num'=>$num);
	                }
	            }else {
	                $limit_arr['name'] = $_SESSION['username'];
	                $limit_arr['sebi_surplus'] = 0;
	                return $limit_arr;
	            }
	        }else{
	            $cache->set($key,$VID);
	        }
	    }else{
	        return $limit_arr;
	    }
	}
	//检查VIP用户
	private static function check_login_vip_user($cache,$uid,$VID,$time,$num,$ispay=0){
	    global $config, $conn;
	    //当天是否消费过色币看当前视频
	    $key = $uid.$VID.$time;
	    if (self::isview($cache, $key)) {
	        return false;
	    }
	    //检查用户的体验币是否用完
	    $nkey = $uid.$time;
	    $limit_arr = $cache->get($nkey);
	    if(!$limit_arr){
	        $sql = "select veid from user_sebi_view where uid={$uid} and vid={$VID} and last_time={$time} LIMIT 1";
	        $rs = $conn->execute($sql);
	        if ( $conn->Affected_Rows() === 0 ) {
	            $sql = "SELECT sebi_total,sebi_consume,sebi_surplus FROM user_sebi WHERE uid = {$uid} LIMIT 0,1";
	            $rs    = $conn->execute($sql);
	    
	            if ( $conn->Affected_Rows() === 1 ) {
	                $free_sebi_surplus    = $rs->fields['sebi_surplus'];
	                $sebi_consume = $rs->fields['sebi_consume'];
	                $sebi_total = $rs->fields['sebi_total'];
	                	
	                if ( $free_sebi_surplus < $num ) {
	                    $limit_arr['name'] = $_SESSION['username'];
	                    $limit_arr['sebi_surplus'] = $free_sebi_surplus;
	                    $uid_premium = intval($_SESSION['uid_premium']);
	                    if ($uid_premium > 0) {
	                        $limit_arr['is_premium'] = 0;
	                    }
	                    $cache->set($nkey,$limit_arr);
	                    return $limit_arr;
	                } 
	                if ($ispay) {
	                    $sql = "UPDATE user_sebi SET sebi_surplus = sebi_surplus - {$num},sebi_consume = sebi_consume + {$num} WHERE uid = {$uid} LIMIT 1";
	                    $urs = $conn->execute($sql);
	                    $sql = "INSERT INTO user_sebi_view (uid,vid,last_time) VALUES ('{$uid}','{$VID}','{$time}')";
	                    $conn->execute($sql);
	                    $cache->set($key,$VID);
	                    return array('sebi_surplus'=>$free_sebi_surplus,'num'=>$num);
	                }
	            }else {
	                $limit_arr['name'] = $_SESSION['username'];
	                $limit_arr['sebi_surplus'] = 0;
	                return $limit_arr;
	            }
	        }else{
	            $cache->set($key,$VID);
	        }
	    }else{
	        return $limit_arr;
	    }
	}
	
	private static function check_guest($cache,$ip,$VID,$time,$num,$ispay = 0) {
	    global $config, $conn;
	    $ip = ip2long($ip);
	    //当天是否消费过色币看当前视频
	    $key = $ip.$VID.$time; 
	    if(self::isview($cache, $key))
	        return false;
	    //检查用户的体验币是否用完
	    $nkey = $ip.$time;
	    $limit_arr = $cache->get($nkey);
	    if(!$limit_arr){
	        //$sql = "SELECT veid FROM guests_view where  last_time = {$time} AND vid = {$VID}  AND guest_ip = '{$ip}' LIMIT 0,1;";
	        //$rs = $conn->execute($sql);
	        if ( !self::isview($cache, $key) ) {//$conn->Affected_Rows() === 0
	            	
	            $sql = "SELECT guest_id, sebi_total, sebi_consume FROM guests WHERE guest_ip = {$ip} AND last_login = {$time} LIMIT 0,1;";
	            $rs    = $conn->execute($sql);
	            	
	            if ( $conn->Affected_Rows() === 1 ) {
	                $guest_id           = $rs->fields['guest_id'];
	                $guest_sebi_total    = $rs->fields['sebi_total'];
	                $guest_sebi_consume = $rs->fields['sebi_consume'];
	                	
	                if ( $guest_sebi_total < $num ) {
	                    $limit_arr['name'] = '游客';
	                    $limit_arr['sebi_surplus'] = $guest_sebi_total;
	                    $cache->set($nkey,$limit_arr);
	                    return $limit_arr;
	                }
	                if ($ispay) {
	                    $sebi_total = $guest_sebi_total - $num;
	                    if ($sebi_total <= 0) {
	                        $sebi_total = 0;
	                    }
	                    $guest_sebi_consume = $guest_sebi_consume + $num;
	                    $sql = "UPDATE guests SET sebi_total = {$sebi_total},sebi_consume = {$guest_sebi_consume},last_login = '{$time}'  WHERE guest_id = {$guest_id} LIMIT 1;";
	                    $urs = $conn->execute($sql);
	                    $sql = "INSERT INTO guests_view (guest_ip,vid,last_time) VALUES ('{$ip}','{$VID}','{$time}')";
	                    $conn->execute($sql);
	                    $cache->set($key,$VID);
	                }
	            }else{
	                $limit_arr['name'] = '游客';
	                $limit_arr['sebi_surplus'] = 0;
	                return $limit_arr;
	            }
	        }else{
	            $cache->set($key,$VID);
	        }
	    }else{
	        return $limit_arr;
	    }
	}
	
	private static function isview($cache,$key){
	    $isview = $cache->get( $key );
	    return $isview;
	}
}
