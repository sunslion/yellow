<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();


$sql =<<<EOF

CREATE TABLE IF NOT EXISTS `adv_ads` (
  `id` bigint(20) unsigned NOT NULL,
  `zone_id` int(10) NOT NULL,
  `url` varchar(255) NOT NULL DEFAULT '',
  `media` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `title` text NOT NULL,
  `mime` enum('jpg','swf','flv','mp4') NOT NULL DEFAULT 'jpg',
  `views` bigint(20) NOT NULL DEFAULT '0',
  `clicks` bigint(20) NOT NULL DEFAULT '0',
  `addtime` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `adv_zone`
--

CREATE TABLE IF NOT EXISTS `adv_zone` (
  `id` tinyint(3) unsigned NOT NULL,
  `name` varchar(99) NOT NULL DEFAULT '',
  `width` int(4) unsigned NOT NULL DEFAULT '0',
  `height` int(4) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adv_ads`
--
ALTER TABLE `adv_ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adv_zone`
--
ALTER TABLE `adv_zone`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advgrp_name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

EOF;

mysql_query($sql);
exit;

if ( isset($_GET['a']) ) {
    $action     = trim($_GET['a']);
    $AID        = ( isset($_GET['AID']) && is_numeric($_GET['AID']) ) ? intval(trim($_GET['AID'])) : NULL;
    if ( $action == 'activate' or $action == 'suspend' ) {
        $status = ( $_GET['a'] == 'activate' ) ? '1' : '0';
        $sql    = "UPDATE adv SET adv_status = '" .$status. "' WHERE adv_id = " .$AID. " LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() ) {
            $messages[] = 'Advertise successfuly ' .$_GET['a']. 'ed!';
        } else {
            $errors[] = 'Failed to ' .$_GET['a']. ' advertise! Invalid advertise id!?';
        }
    } elseif ( $action == 'delete' ) {
        $sql    = "DELETE FROM adv WHERE adv_id = " .$AID. " LIMIT 1";
        $conn->execute($sql);
        $messages[]    = 'Advertise deleted successfully!';
    } else {
        $errors[] = 'Invalid action specified! Allowed actions: activate, suspend and delete!';
    }
}

$query      = constructQuery();
$sql        = $query['select'];
$rs         = $conn->execute($sql);
$advs       = $rs->getrows();

function constructQuery()
{
    global $smarty;

    $query              = array();
    $query_select       = "SELECT a.*, g.advgrp_name FROM adv AS a, adv_group AS g WHERE a.adv_group = g.advgrp_id";
    $query_count        = "SELECT COUNT(adv_id) AS total_advs FROM adv";
    $query_add          = NULL;
    $option_orig        = array('sort' => 'a.adv_id', 'order' => 'DESC');
    $option             = ( isset($_SESSION['search_advertise_option']) ) ? $_SESSION['search_advertise_option'] : $option_orig;
    
    if ( isset($_POST['search_advertise']) ) {
        $option['sort']     = trim($_POST['sort']);
        $option['order']    = trim($_POST['order']);
        
        $query_add = " ORDER BY " .$option['sort']. " " .$option['order'];
        
        $_SESSION['search_advertise_option'] = $option;
    }
    
    $query['select']    = $query_select . $query_add;
    $query['count']     = $query_count . $query_add;
    
    $smarty->assign('option', $option);
    
    return $query;
}

$smarty->assign('advs', $advs);
?>
