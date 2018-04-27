{include file="header.tpl"}
<!-- 正文 -->
<div class="detail">
	<div class="width1200">
        <div class="detail_left">
            {include file="left_menu.tpl"}
        </div>
        <div class="detail_right">
            {include file="header_ads.tpl"}
            <div class="detail_right_tab">
            	<div class="detail_right_scroll" style="display: none;"></div>
                <div class="login">
                    <div class='leftLogin'>
                        <p class="title"><a href="/">首页</a> > <a href="/" class="select">登录</a></p>
                        <h3>登陆久草在线账号</h3>
                        <p>登陆之后，您可以享受更多服务！</p>
                        <p class="img"><img src="/templates/frontend/frontend-jiucao/img/line_03.jpg"></p>
                        <form name="login_form" id="login_form" method="post" action="/member/authenticate" onsubmit="return login();">
                        <ul>
                        	{if $errors}<li style="background-color:#ddd;border:1px solid #999;">
								{section name=i loop=$errors}
                        			<p style="color:red;margin:5px 0;">{$errors[i]}</p>
                        		{/section}
							</li>{/if}
                            <li><label for="name" {if $errors}class="has_error"{/if}>用户名</label><input {if $errors}class="has_error"{/if} type="text" id="rname" name="username" placeholder="用户名"/><input type="hidden" name="formCode" value="{$formCode}"/></li>
                            <li style="margin-bottom: 0"><label for="name" {if $errors}class="has_error"{/if}>密码</label><input {if $errors}class="has_error"{/if} type="password" id="rpass" name="password" placeholder="密码"/></li>
                            <li>
                                <label style="font-size: 0">&nbsp;</label> 
                                <span style="float:none;width:140px;"><input id="login_remember" name="login_remember" type="checkbox" value="1">两周内免登录</span>
                                <!--<span style="float:none;width:140px;"><a href="">忘记密码</a></span>-->
                            </li>
                        </ul>
                        <button id="login" type="submit" onclick="return login();">登陆</button>
                        </form>
                    </div>
                    <div class="regRight"> 
                       <div class="detail_right_title ps_5" ></div>
                    </div>
                </div>

<script type="text/javascript">
{literal}
  function login(){
  	var rname = $.trim($('#rname').val());
  	var rpass = $.trim($('#rpass').val());
  	if(rname == '' || rpass == ''){
  		alert('用户名或密码不能为空');
  		return false;
  	}
  	return true;
  }
{/literal}
</script>
            </div>
        </div>
    </div>
</div>
<!-- 正文 -->
<!-- 底部 -->
{include file="footer.tpl"}
<!-- 底部 -->