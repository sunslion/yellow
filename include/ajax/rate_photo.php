<?php
defined('_VALID') or die('Restricted Access!');

if ( $config['photo_module'] == '0' ) {
    die();
}

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
if ( isset($_POST['item_id']) && isset($_POST['rating']) ) {
    $allowed        = false;
    $filter         = new VFilter();
    $photo_id       = $filter->get('item_id', 'INTEGER');
    $vote           = $filter->get('rating', 'INTEGER');
    
    $sql            = "SELECT p.rate, p.ratedby, a.rate AS arate, a.ratedby AS aratedby FROM photos AS p, albums AS a
                       WHERE p.PID = " .$photo_id. " AND a.AID = p.AID LIMIT 1";
    $rs             = $conn->execute($sql);
    $rate           = $rs->fields['rate'];
    $ratedby        = $rs->fields['ratedby'];
    $arate          = $rs->fields['arate'];
    $aratedby       = $rs->fields['aratedby'];
    
    if ( $config['photo_rate'] == 'user' ) {
        if ( isset($_SESSION['uid']) ) {
            $uid        = intval($_SESSION['uid']);
            $allowed    = true;
        }
    } else {
        $allowed    = true;
    }
    
    if ( $allowed ) {
        if ( $config['photo_rate'] == 'user' ) {
            $sql    = "SELECT PID FROM photo_rating_id WHERE PID = " .$photo_id. " AND UID = " .$uid. " LIMIT 1";
        } else {
            $sql    = "SELECT PID FROM photo_rating_ip WHERE PID = " .$photo_id. " AND ip = " .ip2long($_SERVER['REMOTE_ADDR']). " LIMIT 1";
        }
        
        $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
            $data['msg']    = $lang['ajax.rate_already'];
        } else {        
            $value          = round($rate*$ratedby, 1);
            $rate           = $value+$vote;
            $ratedby        = $ratedby+1;
            $rate           = round($rate/$ratedby, 1);
            $avalue         = round($arate*$aratedby, 1);
            $arate          = $avalue+$vote;
            $aratedby       = $aratedby+1;
            $arate          = round($arate/$aratedby, 1);
            $sql            = "UPDATE photos AS p, albums AS a
                               SET p.rate = " .$rate. ", p.ratedby = " .$ratedby. ",
                                   a.rate = " .$arate. ", a.ratedby = " .$aratedby. "
                               WHERE p.PID = " .$photo_id. " AND p.AID = a.AID";
            $data['debug'] = $sql;
            $conn->execute($sql);
            if ( $config['photo_rate'] == 'user' ) {
                $sql    = "INSERT INTO photo_rating_id SET PID = " .$photo_id. ", UID = " .$uid;
            } else {
                $sql    = "INSERT INTO photo_rating_ip SET PID = " .$photo_id. ", ip = " .ip2long($_SERVER['REMOTE_ADDR']);
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
