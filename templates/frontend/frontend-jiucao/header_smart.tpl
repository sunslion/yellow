<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title|escape:'html'}</title>
<meta name="keywords" content="{$keyword|escape:'html'}" />
<meta name="description" content="{$description|escape:'html'}" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
{include file="header_include_smart.tpl"}
</head>
<body>
<!-- 头部 -->
<div class="detail_title">
	<div class="width1200">
		<h1><a href="/"></a></h1>
        <div class="detail_submit">
        	<form name="search_form" method="POST" action="/search">
        	<input type="text" placeholder="请输入搜索关键字" name="kd" value="{$kd}"/>
            <input type="submit" value=""/>
            </form>
        </div>
        <div class="link">
	        <a href="http://cy.sougaga.com/yellowUn/index.html" class="btn-red" id="J-head-btn-charge"  target="_blank">赚钱联盟</a>
	        <ul>
		        <li><a href="https://www.emoneyspace.com/yzmw" target="_blank"><img src="/public/fb1.png"></a></li>
		        <li><a href="http://cy.sougaga.com/zmwdz/" target="_blank"><img src="/public/fb2.png"></a></li>
	        </ul>
	        <div class="ps_25"></div>
        </div>
    </div>
</div>
{if $back_img}
<a id="wrapper_left_bg" class="wrapper_bg_c hidden-xs" target="_blank" href="{$set_left_btn_url}"></a>
<a id="wrapper_right_bg" class="wrapper_bg_c hidden-xs" target="_blank" href="{$set_right_btn_url}"></a>
{/if}
<script type="text/javascript">
{literal}
$(function(){
	$('input[name="ajaxLogin"]').click(function(){
		var subdiv = $('<div />');
		var ajaxsub = $('.ajaxsub');
		var name = $.trim($('input[name="ajaxName"]').val());
		if(name == ''){
			subdiv.html('请填写用户名');
			ajaxsub.html(subdiv).fadeIn(1000).fadeOut(1000);
			return false;
		}
		var pwd = $.trim($('input[name="ajaxPwd"]').val());
		if(pwd == ''){
			subdiv.html('请填写密码');
			ajaxsub.html(subdiv).fadeIn(1000).fadeOut(1000);
			return false;
		}
		
		$.post('/member/ajaxAuthenticate',{'username':name,'password':pwd},function(d){
			if(d && d.length > 0){
				subdiv.html(d);
				ajaxsub.html(subdiv).fadeIn(1000).fadeOut(1000);
			}else{
				subdiv.html('成功登陆');
				ajaxsub.html(subdiv).fadeIn(1000).fadeOut(1000);
				setTimeout(function(){
					window.location.href = '/';
				},2000);
			}
		},'json');
	});
});
{/literal}
</script>
<!-- 头部 -->
