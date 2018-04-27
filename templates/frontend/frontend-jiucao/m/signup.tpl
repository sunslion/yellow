{include file="header.tpl"}
{include file="header_ads.tpl"}
<div class="video-body">
	<div class="video-list storyList">
		<div class="regcontent">
			<ul id="regcontent">
				<li class="select" style="color:red;">注册</li>
			</ul>
			<div class="reg change">
			{if $errors}<div style="background-color:#ddd;border:1px solid #999;height:auto;margin:5px 15px 0 15px;padding:10px;border-radius:15px;">
                        		{section name=i loop=$errors}
                        			<p style="color:red;margin:5px 0;">{$errors[i]}</p>
                        		{/section}
              </div>{/if}
			<form name="login_form" id="login_form" method="post" action="/member/signupd">
				<ul class="logins">
					<li><label>用户名</label><input type="text" id="username" name="username" maxlength="15" placeholder="请输入账号"><input type="hidden" name="formCode" value="{$formCode}"/></li>
					<li><label>密码</label><input type="password" id="pwd" name="pwd" placeholder="请输入密码"></li>
					<li><label>确认密码</label><input type="password" id="repwd" name="repwd" placeholder="请输入密码"></li>
					<li><label>邮箱</label><input type="text" id="email" name="email" placeholder="请输入邮箱"></li>
					<li>
						<label>性别</label>
						<input type="radio" name="gender" value="1" /><b>男</b>
						<input type="radio" name="gender" value="2" /><b>女</b>
					</li>
					<li class="not ok">
						<input name="age" type="checkbox"/>
						<span>我保证我年满18岁！</span>
					</li>
					<li class="not ok">
						<input name="terms" type="checkbox"/>
						<span>我同意<a href="">使用条款</a>和<a href="">隐私政策</a></span>
					</li>
					<li class="not" style="margin-top: 0.5rem"><button type="submit" id="login">注册</button></li>
				</ul>
				</form>
			</div>
		</div>
	</div>
</div>
{include file="footer.tpl"}