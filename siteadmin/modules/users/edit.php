<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();
$aname = $_SESSION['AUID'];
$atime =  strtotime(date('Y-m-d'));
$atype = intval($_SESSION['ATYPE']);
if ( $atype > 0) {
    $sql = "SELECT vip FROM admin WHERE name = '{$aname}' LIMIT 1;";
    $rs = $conn->execute($sql);
    if ($rs) {
        $vip = $rs->fields['vip'];
        if( $vip > 0 ){
            $sql = "SELECT COUNT(id) AS total FROM user_vip WHERE aname='{$aname}' AND atime={$atime} LIMIT 1;";
            $rs = $conn->execute($sql);
            if($rs){
                $count = $rs->fields['total'];
                if ( $count >= $vip ) {
                    $errors[] = '当天开户数已经达到规定的个数('.$count.'个)';
                }
            }
        }
    }
}


require '../classes/country.class.php';
$country            = new I18N_ISO_3166();
$countries_twocode  = $country->twocountry;
$countries          = array();
foreach ( $countries_twocode as $code => $value )
    $countries[] = $value;

$user  = array();
$UID   = ( isset($_GET['UID']) && is_numeric($_GET['UID']) ) ? intval(trim($_GET['UID'])) : NULL;
if ( !$UID ) {
    $errors[] = 'Invalid user ID!';
}
require $config['BASE_DIR'].'/include/config.rank.php';
if ( !$errors ) {
    if ( isset($_POST['edit_user']) ) {
        require $config['BASE_DIR']. '/classes/filter.class.php';
        require $config['BASE_DIR']. '/classes/validation.class.php';
        $filter             = new VFilter();
        $valid              = new VValidation();
        $username = $filter->get('username');
        
        /*$uname = mysql_real_escape_string($username);
        if ( $atype > 0) {
            $sql = "SELECT id FROM user_vip WHERE uname='{$uname}' AND etime > {$atime} LIMIT 1;";
            $conn->execute($sql);
            if($conn->Affected_Rows() >= 1){
                $errors[] = '当前用户已经是VIP会员并且时间还未到期限,您未有权限擅自修改，如要修改，请联系管理员';
            }
        }*/
        
        $email              = $filter->get('email');
        $fname              = $filter->get('fname');
        $lname              = $filter->get('lname');
        $town               = $filter->get('town');
        $city               = $filter->get('city');
        $zip                = $filter->get('zip');
        $aboutme            = $filter->get('aboutme');
        $fav_movies         = $filter->get('fav_movie_show');
        $fav_music          = $filter->get('fav_music');
        $fav_books          = $filter->get('fav_book');
        $occupation         = $filter->get('occupation');
        $interests          = $filter->get('interest_hobby');
        $company            = $filter->get('company');
        $school             = $filter->get('school');
        $website            = $filter->get('website');
        $country            = $filter->get('country');
        $gender             = $filter->get('gender');
        $relation           = $filter->get('relation');
        $website            = $filter->get('website');
        $password           = $filter->get('password');
        $password_confirm   = $filter->get('password_confirm');
        $video_viewed       = $filter->get('video_viewed', 'INTEGER');
        $profile_viewed     = $filter->get('profile_viewed', 'INTEGER');
        $watched_video      = $filter->get('watched_video', 'INTEGER');
        $account_status     = $filter->get('account_status');
        $emailverified      = $filter->get('emailverified');
        //$premium            = $filter->get('premium');
        // $premium            = intval($premium);
        $years              = $filter->get('years');
        $years              = intval($years);
        //当设置等级不是普通用户的时候进行检查，用户是否有存款记录这个条件
        /*if ($premium > 0) {
            $sql = "SELECT COUNT(id) as total FROM user_deposit WHERE uid = {$UID} LIMIT 1;";
            $rs     = $conn->execute($sql);
            $dtotal = $rs->fields['total'];
            if ($dtotal == 0) {
                $errors[] = '当前用户没有存款记录，不能改变当前等级组';
            }
        }*/
        //当用户有了存款记录，但想更改用户更改级别时进行检查验证
        /*$sql = "SELECT sebi_surplus,isfree FROM user_sebi WHERE uid = {$UID} LIMIT 1;";
        $rs     = $conn->execute($sql);
        $sebi_surplus = $rs->fields['sebi_surplus'];
        $sebi_surplus = intval($sebi_surplus);
        $isfree = $rs->fields['isfree'];
        $isfree = intval($isfree);
        if ($isfree == 1 && $premium > 0) {
            $errors[] = '当前用户是普通用户，不能去提升用户的等级组';
        }
        $range = 0;
        foreach ($rank_range as $k => $v) {
            list($min,$max ) = $v;
            if ($min <= $sebi_surplus && $max >= $sebi_surplus) {
                $range = $k;
                break;
            }
        }
        $rangeGroup = 0;
        foreach ($user_rank_range as $ku => $vu){
            if (in_array($range, $vu)) {
                $rangeGroup = $ku;
                break;
            }
        }
        $sql =  "SELECT premium FROM signup WHERE UID = {$UID} LIMIT 1;";
        $rs     = $conn->execute($sql);
        $oldPremium = $rs->fields['premium'];
        $oldPremium = intval($oldPremium);
        if ($premium != $oldPremium) {
            if ($premium != $rangeGroup) {
                $errors[] = '设置的等级组不适合当前用户等级。';
            }
        }*/
        
        
        $product_gets = $_POST['products'];
        if ( $email == '' ) {
            $errors[] = 'Email field cannot be blank!';
        } elseif ( !$valid->email($email) ) {
            $errors[] = 'Email is not a valid email address!';
        } elseif ( $valid->emailExists($email, $UID) ) {
            $errors[] = 'Email is already used by another user!';
        }
        
        if ( $password != '' && $password != $password_confirm ) {
            $errors[] = 'Password and confirmation password are not the same!';
        }
        
        if ( $_FILES['avatar']['tmp_name'] != '' && !$errors ) {
			$imagesize 	= getimagesize($_FILES['avatar']['tmp_name']);
			if (!$imagesize) {
				$errors[] = 'Invalid image uploaded!';
			}
			
			if (!$errors ) {
				$ext = '';
          		if ($imagesize['2'] == 1) {
					$ext = 'gif';
          		} elseif ($imagesize['2'] == 2) {
					$ext = 'jpg';
          		} elseif ($imagesize['2'] == 3) {
					$ext = 'png';
				}
				
				if ($ext == '') {
					$errors[] = 'Invalid image format uploaded. Allowed formats: jpg, gif and png!';
				}
			}  
			
			if (!$errors) {
				$src		= $_FILES['avatar']['tmp_name'];
				$dst_tmp	= $config['BASE_DIR']. '/tmp/avatars/'.$UID.'.'.$ext;
				if (move_uploaded_file($src, $dst_tmp)) {
					require $config['BASE_DIR']. '/classes/image.class.php';
					$dst_orig	= $config['BASE_DIR']. '/media/users/orig/'.$UID.'.jpg';
					$image  = new VImageConv();
					
					$image->process($dst_tmp, $dst_orig, 'MAX_WIDTH', 500, 0);
					$image->resize(true, true);

					list ($width, $height) = getimagesize($dst_orig);
					$crop_w = min ($width, $height);
					$crop_h = $crop_w;
					if ($width > $height) {
						$crop_x = floor (($width - $crop_w)/2);
						$crop_y = 0;
					}
					else {
						$crop_x = 0;
						$crop_y = floor (($height - $crop_h)/2);
					}				
					
					$dst	= $config['BASE_DIR']. '/media/users/'.$UID.'.jpg';				
					$image->process($dst_orig, $dst, 'EXACT', $crop_w, $crop_h);
					$image->crop($crop_x, $crop_y, $crop_w, $crop_h, true);
					

					$photo_new = TRUE;
				} else {
					$errors[] = 'Failed to move uploaded file (invalid permissions?)!';
				}
			}
		}
        
        if ( !$errors ) {
            $sql_add = NULL;  
            if ( $password != '' ) {
				$passwd 	= md5($password);
                $sql_add 	= " ,pwd = '" .$passwd. "'";
            }
            
            if ( isset($_POST['delete_avatar']) && $_POST['delete_avatar'] == 'on' ) {
                $sql_add .= " ,photo = ''";
            }
            
            if ( isset($photo_new) ) {
                $sql_add .= " ,photo = '" .mysql_real_escape_string($UID.'.jpg'). "'";
            }
			/*if(isset($_POST['Date_Year'])&&isset($_POST['Date_Month'])&&isset($_POST['Date_Day'])&& $_POST['premium']){
				$_POST['premiumexpirytime'] = $_POST['Date_Year'].'-'.$_POST['Date_Month'].'-'.$_POST['Date_Day'];
			}*/
			$pro_str = '';
			if(!empty($product_gets)){
			    $pro_str = implode(',', $product_gets);
			    unset($product_gets);
			}
			$otime = strtotime(date('Y-m-d'));
            $sql = "UPDATE signup SET years = {$years},otime = {$otime} , products = '".mysql_real_escape_string($pro_str)."', email = '" .mysql_real_escape_string($email). "', fname = '" .mysql_real_escape_string($fname). "',lname = '" .mysql_real_escape_string($lname). "', gender = '" .mysql_real_escape_string($gender). "',
                                      relation = '" .mysql_real_escape_string($relation). "', aboutme = '" .mysql_real_escape_string($aboutme). "',
                                      town = '" .mysql_real_escape_string($town). "', city = '" .mysql_real_escape_string($city). "',
                                      zip = '" .mysql_real_escape_string($zip) ."', country = '" .mysql_real_escape_string($country). "',
                                      occupation = '" .mysql_real_escape_string($occupation). "', company = '" .mysql_real_escape_string($company). "',
                                      school = '" .mysql_real_escape_string($school). "', interest_hobby = '" .mysql_real_escape_string($interests). "',
                                      fav_movie_show = '" .mysql_real_escape_string($fav_movies). "', fav_music = '" .mysql_real_escape_string($fav_music). "',
                                      fav_book = '" .mysql_real_escape_string($fav_books). "', website = '" .mysql_real_escape_string($website). "',
                                      video_viewed = '" .mysql_real_escape_string($video_viewed). "', profile_viewed = '" .mysql_real_escape_string($profile_viewed). "',
                                      watched_video = '" .mysql_real_escape_string($watched_video). "', emailverified = '" .mysql_real_escape_string($emailverified). "',
                                      account_status = '" .mysql_real_escape_string($account_status). "'" .$sql_add. " WHERE UID = '" .mysql_real_escape_string($UID). "' LIMIT 1";//. "', premiumexpirytime = '" .mysql_real_escape_string($_POST['premiumexpirytime'])  premium = '".mysql_real_escape_string($premium)."',
            $conn->execute($sql);
            if ( $conn->Affected_Rows() === 1 || $photo_new ) {
                $etime = strtotime(time());
                $sql = "SELECT id FROM user_vip WHERE uname='{$uname}' AND atime = {$atime} LIMIT 1;";
                $rs = $conn->execute($sql);
                if ($conn->Affected_Rows() == 1) {
                    $sql = "UPDATE user_vip SET etime={$etime} WHERE uname='{$uname}' LIMIT 1;";
                }else{
                    $sql = "INSERT INTO user_vip(aname,uname,atime,etime) VALUES ('{$aname}','{$uname}',{$atime},{$etime});";
                }
                $conn->execute($sql);
                $messages[] = 'User information updated successfuly!';
            } else {
                $errors[]   = 'Failed to update user or nothing changed!';
            }
        }
    }
    $sql    = "SELECT * FROM signup WHERE UID = " .$UID. " LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( $conn->Affected_Rows() === 1 ) {
        $user = $rs->getrows();
        $ps = explode(',', $user[0]['products']);
        $smarty->assign('ps', $ps);
    } else {
        $errors[] = 'This user does not exist! Invalid user ID?';
    }
}
$smarty->assign('user_range',$user_range);
$smarty->assign('products', $products);
$smarty->assign('user', $user);
$smarty->assign('countries', $countries);