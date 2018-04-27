<?php

/*
	Email:office.frontend@gmail.com
	最终完善于20150330
	完善了会员类型判断
*/

defined('_VALID') or die('Restricted Access!');

class VBandwidth
{
    public static function check( $ip, $size ,$VID )
    {
        global $config, $conn, $lang, $user_limit_bandwidth,$type_of_user,$uid;
        $limit = $user_limit_bandwidth*1024*1024;
	    //$limit =-1;
        $time = strtotime(date('Y-m-d'));
        //	$sql = "SELECT guest_id, bandwidth FROM guests WHERE guest_ip = " .$ip. " AND last_login ='".$time."' LIMIT 0,1;"; $rs    = $conn->execute($sql);

    	if(!$size OR $size<1 OR empty($size)){
    	   VRedirect::go($config['BASE_URL']. '/limited/video/'."$VID");
    	   exit();
    	}
$logstr = $type_of_user . "\n";
	   //防止让数据异常的老鼠坏了限制这一锅汤
	   switch ($type_of_user) {
	       case 'guest':
                /*****游客*****/
                $sql = "SELECT guest_id, bandwidth FROM guests WHERE guest_ip = '" .$ip. "' AND last_login ='".$time."' LIMIT 0,1;";
                $rs  = $conn->execute($sql);
$logstr .= $sql . "\n";
                if ( $conn->Affected_Rows() === 1 ) {
                    $guest_id           = $rs->fields['guest_id'];
                    $guest_bandwidth    = $rs->fields['bandwidth'];
                	if ( $guest_bandwidth > $limit ) {
                		//$_SESSION['error'] = $lang['guest.limit'];
if( $ip == '43.240.117.41') {
    file_put_contents('cache/go43.log', $logstr . "\n" . $guest_bandwidth  . "\n\n" . $limit . "\n" . $config['BASE_URL']. '/limited/video/'."$VID");
}
                        VRedirect::go($config['BASE_URL']. '/limited/video/'."$VID");
                	} else {
                		$sql = "UPDATE guests SET bandwidth = bandwidth + " .$size. " WHERE guest_id = " .$guest_id. " LIMIT 1;";
                        $conn->execute($sql);
                	}

                } else {
                    $sql = "INSERT INTO guests (guest_ip, last_login, bandwidth) VALUES ('" .$ip. "', '" .$time. "', " .$size. ");";
if( $ip == '43.240.117.41') {
    file_put_contents('insert43.sql', $sql);
}
                    $conn->execute($sql);
                }
                /*****游客END*****/
				break;
			case 'free':
                /*****免费*****/
                $sql = "SELECT guest_id, bandwidth FROM userbandwidth WHERE user_id = " .$uid. " AND last_login ='".$time."'  LIMIT 0,1;";
                $rs  = $conn->execute($sql);

                if ( $conn->Affected_Rows() === 1 ) {
                    $guest_id           = $rs->fields['guest_id'];
                    $guest_bandwidth    = $rs->fields['bandwidth'];

                	if ( $guest_bandwidth > $limit ) {
                			//$_SESSION['error'] = $lang['guest.limit'];
                		VRedirect::go($config['BASE_URL']. '/limited/video/'."$VID");
                	} else {
                		$sql = "UPDATE userbandwidth SET bandwidth = bandwidth + " .$size. " WHERE guest_id = " .$guest_id. " LIMIT 1";
                        $conn->execute($sql);
                	}
                } else {
                    $sql = "INSERT INTO userbandwidth (user_id, last_login, bandwidth) VALUES (" .$uid. ", '" .$time. "', " .$size. ")";
                    $conn->execute($sql);
                }
                /*****免费END*****/
				break;
			case 'premium':
                /*****收费*****/
                $sql = "SELECT guest_id, bandwidth FROM userbandwidth WHERE user_id = " .$uid. " AND last_login ='".$time."' LIMIT 0,1;";
                $rs  = $conn->execute($sql);
                if ( $conn->Affected_Rows() === 1 ) {
                    $guest_id           = $rs->fields['guest_id'];
                    $guest_bandwidth    = $rs->fields['bandwidth'];
        			if ( $guest_bandwidth > $limit ) {
            			//$_SESSION['error'] = $lang['guest.limit'];
            			VRedirect::go($config['BASE_URL']. '/limited/video/'."$VID");
        			} else {
                        $sql = "UPDATE userbandwidth SET bandwidth = bandwidth + " .$size. " WHERE guest_id = " .$guest_id. " LIMIT 1;";
                        $conn->execute($sql);
       		       }
                } else {
            		$sql = "INSERT INTO userbandwidth (user_id, last_login, bandwidth) VALUES (" .$uid. ", '" .$time. "', " .$size. ");";
            		$conn->execute($sql);
                }
/*****收费END*****/
				break;
        }

        return false;
    }
}
?>
