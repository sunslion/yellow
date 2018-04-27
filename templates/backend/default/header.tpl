<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>AVS Admin Control Panel</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link href="{$relative_tpl}/css/style_admin.css?v=11" type="text/css" rel="stylesheet">
    <script type="text/javascript">
    var base_url = '{$baseurl}';
    </script>
    <script type="text/javascript" src="{$relative_tpl}/js/jquery-1.2.6.pack.js"></script>
    <script type="text/javascript" src="{$relative_tpl}/js/jquery.corner.js"></script>
    <script type="text/javascript" src="{$relative_tpl}/js/jquery.livequery.pack.js"></script>
    {if isset($crop)}<script type="text/javascript" src="{$relative_tpl}/js/jquery.album-0.1.js"></script>
    <script type="text/javascript" src="{$relative_tpl}/js/jquery.imgareaselect-0.6.1.min.js"></script>
    {/if}
    {if isset($editor)}
    <script type="text/javascript" src="{$baseurl}/addons/markitup/jquery.markitup.js"></script>
    <script type="text/javascript" src="{$baseurl}/addons/markitup/sets/{$editor_set}/set.js"></script>    
    <link rel="stylesheet" type="text/css" href="{$baseurl}/addons/markitup/skins/{$editor_skin}/style.css" />
    <link rel="stylesheet" type="text/css" href="{$baseurl}/addons/markitup/sets/{$editor_set}/style.css" />
    {/if}
    <script type="text/javascript" src="{$relative_tpl}/js/jquery.admin-0.1.js?t=1"></script>

</head>
<body style="background-color:#fff;">
<div id="container">
    <div id="header">
        <div id="menu">
		<img src="{$relative_tpl}/images/logo.png" style="margin-left: 15px;">		
        <ul>
        	{foreach from=$menus item=v}
        		<li>{if $active_menu eq $v}<span>{$admin_lang[$v]}</span>{else}<a href="{$v}.php">{$admin_lang[$v]}</a>{/if}</li>
        	{/foreach}
        </ul>
        </div>
    </div>
    <div id="content">