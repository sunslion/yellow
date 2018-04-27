<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';
require $config['BASE_DIR']. '/include/compat/json.php';

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

$data           = array('status' => 0, 'msg' => '', 'rating_code' => '', 'rate' => 0, 'ratedby' => 0, 'debug' => '');
if ( isset($_POST['game_id']) && isset($_POST['rating']) ) {
    $allowed        = false;
    $filter         = new VFilter();
    $game_id        = $filter->get('game_id', 'INTEGER');
    $vote           = $filter->get('rating', 'INTEGER');
        
    $sql            = "SELECT rate, ratedby FROM game WHERE GID = " .$game_id. " LIMIT 1";
    $rs             = $conn->execute($sql);
    $rate           = $rs->fields['rate'];
    $ratedby        = $rs->fields['ratedby'];
    
    if ( $config['game_rate'] == 'user' ) {
        if ( isset($_SESSION['uid']) ) {
            $uid        = intval($_SESSION['uid']);
            $allowed    = true;
        }
    } else {
        $allowed        = true;
    }

    if ( $allowed ) {
        if ( $config['game_rate'] == 'user' ) {
            $sql    = "SELECT GID FROM game_rating_id WHERE GID = " .$game_id. " AND UID = " .$uid. " LIMIT 1";
            $data['debug'] = $sql;
        } else {
            $sql    = "SELECT GID FROM game_rating_ip WHERE GID = " .$game_id. " AND ip = " .ip2long($_SERVER['REMOTE_ADDR']). " LIMIT 1";
            $data['debug'] = $sql;
        }
    
        $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
            $data['msg']    = $lang['ajax.rate_already'];
        } else {        
            $value          = round($rate*$ratedby, 1);
            $rate           = $value+$vote;
            $ratedby        = $ratedby+1;
            $rate           = round($rate/$ratedby, 1);
            $sql            = "UPDATE game SET rate = " .$rate. ", ratedby=ratedby+1 WHERE GID = " .$game_id. " LIMIT 1";
            $conn->execute($sql);
            if ( $config['game_rate'] == 'user' ) {
                $sql    = "INSERT INTO game_rating_id SET GID = " .$game_id. ", UID = " .$uid;
            } else {
                $sql    = "INSERT INTO game_rating_ip SET GID = " .$game_id. ", ip = " .ip2long($_SERVER['REMOTE_ADDR']);
            }
            $conn->execute($sql);
            $data['msg']    = ( $ratedby == '1' ) ? $ratedby. ' '.$lang['global.rating'] : $ratedby. ' '.$lang['global.ratings'];
        }
    
        $data['rate']       = $rate;
        $date['ratedby']    = $ratedby;
    } else {
        $data['msg']            = '<a href="' .$config['BASE_URL']. '/login">'.$lang['ajax.rate_login'].'</a>';
    }
    
    $data['rating_code']    = get_static_rating($rate);
}

echo json_encode($data);
die();
?>
