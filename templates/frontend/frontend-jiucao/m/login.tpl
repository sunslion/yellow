{include file="header.tpl"}
{include file="header_ads.tpl"}
<div class="video-body">
	<div class="video-list storyList">
		<div class="regcontent">
			<ul id="regcontent">
				<li class="select">登陆</li>
			</ul>
			<div class="login change">
			<form name="login_form" id="login_form" method="post" action="/member/authenticate" onsubmit="return login();">
				<ul class="logins">
					{if $errors}<li>
								{section name=i loop=$errors}
                        			<p style="color:red;margin:5px 0;">{$errors[i]}</p>
                        		{/section}
							</li>{/if}
					<li><label>用户名</label><input type="text" id="rname" name="username" value="" placeholder="请输入账号"></li>
					<li><label>密码</label><input type="password" id="rpass" name="password" value="" placeholder="请输入密码"></li>
					<li class="not">
						<input id="login_remember" name="login_remember" type="checkbox" value="1"/>
						<span>两周内自动登陆</span>
						<a href="">忘记密码？</a>
					</li>
					<li class="not"><button id="reg" type="submit" onclick="return login()">登录</button></li>
				</ul>
		 </form>
			</div>
		</div>
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
{include file="footer.tpl"}