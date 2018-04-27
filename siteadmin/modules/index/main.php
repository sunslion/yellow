<?php
defined('_VALID') or die('Restricted Access!');
Auth::checkAdmin();
require $config['BASE_DIR']. '/include/config.template.php';
if ( isset($_POST['submit_settings']) ) {
    $filter                 = new VFilter();
    $site_name              = $filter->get('site_name');
    $site_title             = $filter->get('site_title');
    $meta_description       = $filter->get('meta_description');
    $meta_keywords          = $filter->get('meta_keywords');
    $admin_name             = $filter->get('admin_name');
    $admin_pass             = $filter->get('admin_pass');
    $admin_email            = $filter->get('admin_email');
    $admin_visit_ip         = $filter->get('admin_visit_ip');
    $noreply_email          = $filter->get('noreply_email');
	$language				= $filter->get('language');
	$multi_language			= $filter->get('multi_language', 'INTEGER');
    $template				= $filter->get('template');
	$set_left_btn_top		= $filter->get('set_left_btn_top');
	$set_left_btn_url		= $filter->get('set_left_btn_url');
	$set_right_btn_top		= $filter->get('set_right_btn_top');
	$set_right_btn_url		= $filter->get('set_right_btn_url');
	$set_notice		        = $_POST['set_notice'];	
	$set_l_vip			    = $filter->get('set_l_vip');
	$lqq1		            = $filter->get('lqq1');
	$lqq2		            = $filter->get('lqq2');
	$ldomain		        = $filter->get('ldomain');
	$set_r_vip			    = $filter->get('set_r_vip');
	$rqq1		            = $filter->get('rqq1');
	$rqq2		            = $filter->get('rqq2');
	$rdomain		        = $filter->get('rdomain');
	
    if ( $site_name == '' ) {
        $errors[]   = 'Site name field cannot be blank!';
    }
    if ( $site_title == '' ) {
        $errors[]   = 'Site title field cannot be blank!';
    }
    
    if ( $meta_description == '' ) {
        $errors[]   = 'Meta description field cannot be blank!';                
    }
    
    if ( $meta_keywords == '' ) {
        $errors[]   = 'Meta keywords field cannot be blank!';
    }
    
    if ( $admin_name == '' ) {
        $errors[]   = 'Admin name (used for siteadmin login) cannot be blank!';
    } elseif ( strlen($admin_name) < 5 ) {
        $errors[]   = 'Admin name (used for siteadmin login) must be at least 6 characters long!';
    }
    
    if ( $admin_pass == '' ) {
        $errors[]   = 'Admin pass (used for siteadmin login) cannot be blank!';
    } elseif ( strlen($admin_pass) < 5 ) {
        $errors[]   = 'Admin pass (used for siteadmin login) must be at least 6 characters long!';
    }
    
    if ( $admin_email == '' ) {
        $errors[]   = 'Admin email field cannot be blank!';
    } elseif ( !VValidation::email($admin_email) ) {
        $errors[]   = 'Admin email field is not a valid email address!';
    }
    
    if ( $noreply_email == '' ) {
        $errors[]   = 'Noreply email field cannot be blank!';
    } elseif ( !VValidation::email($noreply_email) ) {
        $errors[]   = 'Noreply email field is not a valid email address!';
    }
    if ( !$errors ) {
        $config['site_name']            = $site_name;
        $config['site_title']           = $site_title;
        $config['meta_description']     = $meta_description;
        $config['meta_keywords']        = $meta_keywords;
        $config['admin_name']           = $admin_name;
        $config['admin_pass']           = $admin_pass;
        $config['admin_email']          = $admin_email;
        $config['admin_visit_ip']       = $admin_visit_ip;
        $config['noreply_email']        = $noreply_email;
		$config['language']				= $language;
		$config['multi_language']		= $multi_language;
		$config['template']				= $template;		
		$config['set_left_btn_top']          = $set_left_btn_top;
		$config['set_left_btn_url']          = $set_left_btn_url;
		$config['set_right_btn_top']          = $set_right_btn_top;
		$config['set_right_btn_url']          = $set_right_btn_url;
		$config['set_notice']           = $set_notice;
		$config['set_l_vip']            = $set_l_vip;
		$config['lqq1']                  = $lqq1;
		$config['lqq2']                  = $lqq2;
		$config['ldomain']               = $ldomain;
		$config['set_r_vip']            = $set_r_vip;
		$config['rqq1']                  = $rqq1;
		$config['rqq2']                  = $rqq2;
		$config['rdomain']               = $rdomain;
        update_config($config);
        update_smarty();    
        $messages[] = 'System Settings Updated Successfuly!';
    }
}
$vips_arr = array(
	''=>'-----',
	'ZL'=>'尊龙',
	'BTT'=>'博天堂',
	'HJ'=>'和记',
	'HY'=>'环亚',
	'KF'=>'凯发',
	'KS'=>'凯时',
	'LC'=>'乐橙',
	'LL'=>'利来',
	'YM'=>'亚美',
);
$smarty->assign('vips_arr',$vips_arr);
$smarty->assign('templates', $templates);
?>