<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{$title|escape:'html'}</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<meta name="apple-touch-fullscreen" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="format-detection" content="telephone=no" />
<meta name="apple-mobile-web-app-status-bar-style" content="black">
 <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
{include file="header_include_smart.tpl"}
</head>
<body>
<div class="head">
	<div class="log"><img src="/templates/frontend/frontend-jiucao/m/img/logo.png" alt=""></div>
	<div class="top-link">
	<!--
	{if !$islogin}
		<span>
		<a href="{surl url=member/signup id=''}" class="link-item"><img src="/templates/frontend/frontend-jiucao/m/img/reg-ico.png" alt=""> 注册</a>
		<a href="{surl url=member/login id=''}" class="link-item"><img src="/templates/frontend/frontend-jiucao/m/img/login-ico.png" alt=""> 登陆</a>
		</span>
	{else}
		<span id="userOpen">
		<a class="link-item omit" href="javascript:void(0);">{$username}</a>
		<i class="itrangle"></i>
			<span class="user-popup" id="userPopup">
			<a href="/">级别：{$premiumName}</a>
			{if $premium == 1}<a href="/">色币数：{$sebi_surplus}</a>{/if}
			{if $premium == 2}<a href="/">到期日：{$over_time}</a>{/if}
			<a href="/member/exit">退出</a>
			</span>
        </span>
	{/if}
		<a href="{surl url=vip id=''}" class="link-item"><img src="/templates/frontend/frontend-jiucao/m/img/vip-ico.png" alt=""> 加入VIP</a>-->
		<a class="link-item" href="https://www.emoneyspace.com/yzmw" target="_blank"><img src="/public/fb1.png"></a>
		<a class="link-item" href="http://cy.sougaga.com/zmwdz/" target="_blank"><img src="/public/fb2.png"></a>
	</div>
	<div class="search" id="searchOpen"><img src="/templates/frontend/frontend-jiucao/m/img/search-ico.png" alt=""></div>
</div>
<div class="search-contain" id="search">	
	<form name="search_form" method="POST" action="/search">
	<div class="label">
		<input type="text" class="text" name="kd" value="{$kd}" placeholder="输入搜索关键字" />
		<div class="hide" id="searchClose">隐藏</div>
	</div>
	<div class="form-btn">
		<button type="submit" class="submit">搜索</button>
	</div>
	</form>
</div>
<div class="navs">
	<div class="navs-body">
		<div id="nav">
			<a href="/" class="nav-item{if $CHID == 0} on{/if}">首页</a>
			<a href="/avActor/Avlist" class="nav-item">Av女优画册</a>
			<a href="/avActor" class="nav-item{if $CHID == 8080} on{/if}" >Av女优一览</a>
			{section name=i loop=$channels}
			<a href="{surl url=video/index/cid id=$channels[i].CHID}" class="nav-item{if $channels[i].CHID == $CHID} on{/if}">{$channels[i].name}</a>
			{/section}
		</div>
	</div>
	<div class="nav-menu" id="navOpen"><img src="/templates/frontend/frontend-jiucao/m/img/nav-ico.png"/></div>
	 <div class="nav-popup" id="navPopup"><i></i></div>
</div>
