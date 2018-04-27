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
            	<div class="detail_right_scroll" style="display: none;">
                	   
                </div>
               
                <div class="login">
                    <div class='leftLogin'>
                        <p class="title"><a href="/">首页</a> > <a href="" class="select">注册</a></p>
                        <h3>注册久草在线账号</h3>
                        <p>注册之后，您可以享受更多服务！</p>
                        <p class="img"><img src="/templates/frontend/frontend-jiucao/img/line_03.jpg"></p>
                        <form name="login_form" id="login_form" method="post" action="/member/signupd">
                        {if $errors}<div style="background-color:#ddd;border:1px solid #999;height:auto;margin:5px 15px 0 15px;padding:10px;border-radius:15px;">
                        		{section name=i loop=$errors}
                        			<p style="color:red;margin:5px 0;">{$errors[i]}</p>
                        		{/section}
                        	</div>{/if}
                        <ul>
                            <li><label for="name">用户名</label><input type="text" id="username" name="username" maxlength="15" placeholder="用户名"><input type="hidden" name="formCode" value="{$formCode}"/></li>
                            <li><label for="name">密码</label><input type="password" id="pwd" name="pwd" placeholder="密码"></li>
                            <li><label for="name">重新输入密码</label><input type="password" id="repwd" name="repwd" placeholder="重新输入密码"></li>
                            <li><label for="name">邮箱</label><input type="text" id="email" name="email" placeholder="邮箱"></li>
                            <li>
                                <label>性别</label>
                                <span class="sex"><input type="radio" name="gender" value="1"/>男</span>
                                <span><input type="checkbox" name="age"/>我保证我年满18岁！</span>
                                <span class="sex"><input type="radio" name="gender" value="2"/>女</span>
                                <span><input type="checkbox" name="terms"/>我同意<a href="">使用条款</a>和<a href="">隐私政策</a></span>
                            </li>
                        </ul>
                        <button type="submit" id="login">注册</button>
                        </form>
                    </div>
                    <div class="regRight"> 
                       <div class="detail_right_title ps_6" ></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 正文 -->
<!-- 底部 -->
{include file="footer.tpl"}
<!-- 底部 -->