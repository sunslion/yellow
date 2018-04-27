<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();

$sql="select * from mobile_static";
$rs = $conn->execute($sql);
if($rs==false) {
$sql = "CREATE TABLE IF NOT EXISTS `mobile_static` (
  `ID` int(11) NOT NULL auto_increment,
  `name` varchar(20) character set utf8 collate utf8_unicode_ci NOT NULL,
  `content` text character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";
$conn->execute($sql);
$sql = "INSERT INTO `mobile_static` (`ID`, `name`, `content`) VALUES
(1, 'faq', 'Your content goes here'),
(2, 'terms', 'Your content goes here'),
(3, 'privacy', 'Your content goes here'),
(4, 'dmca', 'Your content goes here');";
$conn->execute($sql);
}



if(!isset($config['mobile_sitename']))
	$config['mobile_sitename'] = $config['site_name'];
if(!isset($config['mobile_view_limit']))
	$config['mobile_view_limit'] = '5';
if(!isset($config['mobile_seo_title']))
	$config['mobile_seo_title'] = 'Free video share service for mobile devices';
if(!isset($config['mobile_seo_description']))
	$config['mobile_seo_description'] = 'video, mobile, iphone, ipad, android';
if(!isset($config['mobile_tint']))
	$config['mobile_tint'] = 'blue';
if(!isset($config['mobile_watch_type']))
	$config['mobile_watch_type'] = 'page';
if(!isset($config['mobile_watch_player']))
	$config['mobile_watch_player'] = 'poster';
if(!isset($config['mobile_watch_limit']))
	$config['mobile_watch_limit'] = '0';

if(isset($_POST['submit'])) {
	
	$faq=trim($_POST['area_faq']);
	$terms=trim($_POST['area_terms']);
	$privacy=trim($_POST['area_privacy']);
	$dmca=trim($_POST['area_dmca']);

	$sql="UPDATE mobile_static SET content='".mysql_real_escape_string($faq)."' WHERE name='faq'";
	$conn->execute($sql);
	$sql="UPDATE mobile_static SET content='".mysql_real_escape_string($terms)."' WHERE name='terms'";
	$conn->execute($sql);
	$sql="UPDATE mobile_static SET content='".mysql_real_escape_string($privacy)."' WHERE name='privacy'";
	$conn->execute($sql);
	$sql="UPDATE mobile_static SET content='".mysql_real_escape_string($dmca)."' WHERE name='dmca'";
	$conn->execute($sql);

	$config['mobile_sitename'] = trim($_POST['mobile_sitename']);
	$config['mobile_seo_title'] = trim($_POST['mobile_seo_title']);
	$config['mobile_seo_description'] = trim($_POST['mobile_seo_description']);
	$config['mobile_tint'] = trim($_POST['mobile_tint']);
	$config['mobile_watch_limit'] = trim($_POST['mobile_watch_limit']);
	$config['mobile_watch_type'] = trim($_POST['mobile_watch_type']);
	$config['mobile_watch_player'] = trim($_POST['mobile_watch_player']);
	$config['mobile_view_limit'] = trim($_POST['mobile_view_limit']);
	$config['mobile_thumbs'] = trim($_POST['mobile_thumbs']);
	$config['mobile_faq'] = trim($_POST['mobile_faq']);
	$config['mobile_terms'] = trim($_POST['mobile_terms']);
	$config['mobile_privacy'] = trim($_POST['mobile_privacy']);
	$config['mobile_dmca'] = trim($_POST['mobile_dmca']);

    update_config($config);  
    $messages[] = 'Mobile Template Settings Updated Successfuly!';

}

$sql="select * from mobile_static";
$rs=$conn->execute($sql);
$rows = $rs->getrows();
$static=array();
foreach ($rows as $row) {
	$static[$row['name']]=$row['content'];
}

// smarty displays
$smarty->assign('static', $static);
$smarty->assign('cnf', $config);
$smarty->assign('page', 'terms');
$smarty->assign('edit', true);
$smarty->assign('editor', true);
$smarty->assign('editor_set', 'static');
$smarty->assign('editor_skin', 'markitup');
?>
