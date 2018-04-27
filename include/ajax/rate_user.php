<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/dbconn.php';

function get_static_rating( $rate )
{
    $class_1            = '';
    $class_2            = '';
    $class_3            = '';
    $class_4            = '';
    $class_5            = '';
    if ( $rate > 0.5 ) {
        if ( $rate >= 1 ) {
            $class_1 = ' class="full"';
        } elseif ( $rate >= 0.5 ) {
            $class_1 = ' class="half"';
        }
        
        if ( $rate >= 2 ) {
            $class_2 = ' class="full"';
        } elseif ( $rate >= 1.5 ) {
            $class_2 = ' class="half"';
        }
        
        if ( $rate >= 3 ) {
            $class_3 = ' class="full"';
        } elseif ( $rate >= 2.5 ) {
            $class_3 = ' class="half"';
        }
                                                                                                                                                        
        if ( $rate >= 4 ) {
            $class_4 = ' class="full"';
        } elseif ( $rate >= 3.5 ) {
            $class_4 = ' class="half"';
        }
                                                
        if ( $rate >= 5 ) {
            $class_5 = ' class="full"';
        } elseif ( $rate >= 4.5 ) {
            $class_5 = ' class="half"';
        }
    }
                                                    
    $output     = array();
    $output[]   = '<ul>';
    $output[]   = '<li><span' .$class_1. '>&nbsp;</span></li>';
    $output[]   = '<li><span' .$class_2. '>&nbsp;</span></li>';
    $output[]   = '<li><span' .$class_3. '>&nbsp;</span></li>';
    $output[]   = '<li><span' .$class_4. '>&nbsp;</span></li>';
    $output[]   = '<li><span' .$class_5. '>&nbsp;</span></li>';
    $output[]   = '</ul>';
    
    return implode("\n", $output);
}

$data           = array('msg' => '', 'rating_code' => '', 'rate' => 0, 'ratedby' => 0, 'debug' => '');
if ( isset($_POST['user_id']) && isset($_POST['rating']) ) {
    $allowed        = false;
    $filter         = new VFilter();
    $user_id        = $filter->get('user_id', 'INTEGER');
    $vote           = $filter->get('rating', 'INTEGER');
    
    $sql            = "SELECT rate, ratedby FROM signup WHERE UID = " .$user_id. " LIMIT 1";
    $rs             = $conn->execute($sql);
    $rate           = $rs->fields['rate'];
    $ratedby        = $rs->fields['ratedby'];
    
    if ( $config['rating'] == 'user' ) {
        if ( isset($_SESSION['uid']) ) {
            $uid        = intval($_SESSION['uid']);
            $allowed    = true;
        }
    } else {
        $allowed    = true;
    }
    
    if ( $allowed ) {
        if ( $config['rating'] == 'user' ) {
            $sql    = "SELECT UID FROM users_rating_id WHERE UID = " .$user_id. " AND RID = " .$uid. " LIMIT 1";
        } else {
            $sql    = "SELECT UID FROM users_rating_ip WHERE UID = " .$user_id. " AND ip = " .ip2long($_SERVER['REMOTE_ADDR']). " LIMIT 1";
        }
        $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
            $data['msg']    = $lang['ajax.rate_already'];
        } else {        
            $value          = round($rate*$ratedby, 1);
            $rate           = $value+$vote;
            $ratedby        = $ratedby+1;
            $rate           = round($rate/$ratedby, 1);
            $sql            = "UPDATE signup SET rate = " .$rate. ", ratedby=ratedby+1, popularity = popularity+1 WHERE UID = " .$user_id. " LIMIT 1";
            $conn->execute($sql);
            if ( $config['rating'] == 'user' ) {
                $sql    = "INSERT INTO users_rating_id SET UID = " .$user_id. ", RID = " .$uid;
            } else {
                $sql    = "INSERT INTO users_rating_ip SET UID = " .$user_id. ", ip = " .ip2long($_SERVER['REMOTE_ADDR']);
            }
            $conn->execute($sql);
            $data['msg']    = ( $ratedby == '1' ) ? $ratedby. ' '.$lang['global.rating'] : $ratedby. ' '.$lang['global.ratings'];
        }
    
        $data['rate']       = $rate;
        $data['ratedby']    = $ratedby;
    } else {
        $data['msg']            = '<a href="' .$config['BASE_URL']. '/login">'.$lang['ajax.rate_login'].'</a>';
    }
        
    $data['rating_code']    = get_static_rating($rate);
}

echo json_encode($data);
die();
?>
