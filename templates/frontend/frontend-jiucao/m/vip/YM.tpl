{include file="header.tpl"}
<link rel="stylesheet" type="text/css" href="/templates/frontend/frontend-jiucao/m/vip/css/reset.css"/>
<link rel="stylesheet" type="text/css" href="/templates/frontend/frontend-jiucao/m/vip/css/base.css"/>
<link rel="stylesheet" type="text/css" href="/templates/frontend/frontend-jiucao/m/vip/css/popup.css?t=2"/>
<link rel="stylesheet" type="text/css" href="/templates/frontend/frontend-jiucao/m/vip/css/vip.css?t=5"/>
<style>
{literal}
.swiper-container {
	width: 100%;
	height: 100%;
}
.swiper-slide {
	text-align: center;
	font-size: 18px;
	background: #fff;
	/* Center slide text vertically */
	display: -webkit-box;
	display: -ms-flexbox;
	display: -webkit-flex;
	display: flex;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	-webkit-justify-content: center;
	justify-content: center;
	-webkit-box-align: center;
	-ms-flex-align: center;
	-webkit-align-items: center;
	align-items: center;
}
/*覆写*/
.swiper-button-next, .swiper-button-prev {
	height: 128px;
	width: 40px;
	margin-top: -64px;
}
.swiper-button-next, .swiper-container-rtl .swiper-button-prev {
	background: url(/templates/frontend/frontend-jiucao/m/vip/img/vb_next.png) center center no-repeat;
	right: 0px;
}
.swiper-button-prev, .swiper-container-rtl .swiper-button-next {
	background: url(/templates/frontend/frontend-jiucao/m/vip/img/vb_prev.png) center center no-repeat;
	left: 0px;
}
.swiper-button-next.swiper-button-disabled, .swiper-button-prev.swiper-button-disabled {
	pointer-events: auto;
}
.swiper-container02 .swiper-button-next,.swiper-container02 .swiper-container-rtl .swiper-button-prev,.swiper-container02 .swiper-button-prev,.swiper-container02 .swiper-container-rtl .swiper-button-next{
	opacity: 0.35;	
}
.swiper-container02 .swiper-button-next:hover,.swiper-container02 .swiper-container-rtl .swiper-button-prev:hover,.swiper-container02 .swiper-button-prev:hover,.swiper-container02 .swiper-container-rtl .swiper-button-next:hover{
	opacity: 1;	
}
.swiper-container02 .swiper-button-next,.swiper-container02 .swiper-container-rtl .swiper-button-prev {
	background-image: url(/templates/frontend/frontend-jiucao/m/vip/img/vp_next.png);
	right: 10px;
}
.swiper-container02 .swiper-button-prev,.swiper-container02 .swiper-container-rtl .swiper-button-next {
	background-image: url(/templates/frontend/frontend-jiucao/m/vip/img/vp_prev.png);
	left: 10px;
	
}
.swiper-container02  .swiper-button-next.swiper-button-disabled, .swiper-container02  .swiper-button-prev.swiper-button-disabled {
	opacity: 0;
}
{/literal}
</style>
<div class="video-body vip ">
  <div class="">
    <div class="vcontent"> 
      <!--注册美亚-->
      <div class="vlayer">
        <div class="vtitle">
          <div class="padding"><a href="javascript:;" class="right" id="kt">查看开通流程</a><img src="/templates/frontend/frontend-jiucao/m/vip/img/vtitle_01.png" alt="注册美亚" title="" /><a style="margin-left:0.1rem;font-size:0.4rem;position:relative;top:0.3rem;color:red;" href="http://amm6966.com" target="_blank">官网:amm6966.com</a>
            <div class="line"><em>&nbsp;</em></div>
            <div class="clear">&nbsp;</div>
          </div>
        </div>
        <div class="vlogin">
          <div class="vlogin_circle blue_bg"></div>
          <div class="img"><img src="/templates/frontend/frontend-jiucao/m/vip/img/img/vlogin.png" alt="如何兑换？-7x24小时在线" title="如何兑换？-7x24小时在线" /></div>
          <!--表单提交-->
          <div  class="edit_form">
            <div class="padding">
              <form name="realAccount" id="realAccount" action="http://m.{$domain}/MarketCreateRealAccount.htm" target="_blank" method="post">
                <dl>
                  <dt>亚美账号:</dt>
                  <dd><span class="vinput_bg blue_bg">
                    <input type="text"  size="1" maxlength="1" readonly value="r"/>
                    <input type="hidden"  size="1" maxlength="1" name="prefix" value="r"/>
                    </span><span class="vinput_bg vuser_input">
                    <input type="text" name="loginname" id="loginname" maxlength="7" size="15" onmouseover="value=value.replace(/[^a-zA-Z0-9]/g,'')" onKeyDown="LimitTextArea(this)" onKeyUp="LimitTextArea(this)" onkeypress="LimitTextArea(this)" placeholder="输入4-7位数字加字母组合"/>
                    </span> </dd>
                </dl>
                <div class="clear">&nbsp;</div>
                <dl>
                  <dt>游戏密码: </dt>
                  <dd><span class="vinput_bg">
                    <input name="pwd" maxlength="10" id="pwd" type="password"  size="20"  placeholder="为8-10位字母+数字组合" />
                    </span> </dd>
                </dl>
                <div class="clear">&nbsp;</div>
                <dl>
                  <dt>手机号码: </dt>
                  <dd><span class="vinput_bg">
                    <input type="text" name="phone" maxlength="11" id="phone" size="19" onkeyup="value=value.replace(/\D/g,'')" placeholder="请输入手机号码" />
                    </span> </dd>
                </dl>
                <div class="clear">&nbsp;</div>
                <dl>
                  <dt>验&nbsp;证&nbsp;码: </dt>
                  <dd><span class="vinput_bg vrand_input">
                    <input type="text" id="marketCaptchaCode" name="marketCaptchaCode" maxlength="4"  placeholder="请输入验证码">
                    </span> </dd>
                  <dd><span class="vinput_bg vrand_bg">
                    <label id="autoRandom" value=""></label>
                    </span>
                    <input type="button" value="看不清？" onclick="autoRandom.innerHTML=createCode()" class="vrefresh">
                  </dd>
                </dl>
                <div class="clear">&nbsp;</div>
                <div class="btn_group"> <a href="javascript:register()" id="submitBtn" class="btn btn_red w150">立即注册</a></div>
              </form>
            </div>
          </div>
        </div>
        <div class="vbell m_t1">
          <div class="vblock">
            <div class="title red_bg">如何兑换？<i class="itrangle"></i></div>
            <div class="txt">
              <div class="padding"><span class="red_bg">7x24小时在线<i class="itrangle"></i></span>久草QQ：{$qq1}<a href="http://wpa.qq.com/msgrd?v=3&uin={$qq1}&site=qq&menu=yes" target="_blank" class="btn btn_blue">点击咨询</a></div>
            </div>
          </div>
          <div class="vblock">
            <div class="title red_bg">兑换格式<i class="itrangle"></i></div>
            <div class="txt">
              <div class="padding">
                <p><b>存款金额：XXX</b><b>亚美账号：XXX</b><b>久草账号：XXX</b></p>
                <p class="dblue_bg"><em class="icon ialarm"></em>注：客服核实开通久草VIP，游戏后加开裸聊账号</p>
              </div>
            </div>
          </div>
          <div class="vblock">
            <div class="title red_bg">亚美存款会员<i class="itrangle"></i></div>
            <div class="txt">
              <div class="padding">
                <p>美亚存款会员，可以参加亚美娱乐游戏，赢钱快速提款，输赢不会影响久草VIP使用。</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr/>
      <!--久草VIP会员等级兑换-->
      <div class="vlayer m_t1">
        <div class="vtitle">
          <div class="padding"><img src="/templates/frontend/frontend-jiucao/m/vip/img/vtitle_02.png" alt="久草VIP会员等级兑换" title="" />
            <div class="line"><em>&nbsp;</em></div>
            <div class="clear">&nbsp;</div>
          </div>
        </div>
        <div class="vmodel">
          <div class="padding">
            <div class="vdata">
              <table class="vtable">
                <tr>
                  <th>用户等级</th>
                  <th>亚美存款</th>
                  <th>色币数量</th>
                  <th width="26%">玩游戏赠送色币</th>
                  <th width="26%">游戏赠送裸聊点</th>
                </tr>
                <tr>
                  <td>新手</td>
                  <td>20</td>
                  <td>20</td>
                  <td>20&nbsp;X&nbsp;20%</td>
                  <td>40点</td>
                </tr>
                <tr>
                  <td>屌丝</td>
                  <td>50</td>
                  <td>50</td>
                  <td>50&nbsp;X&nbsp;20%</td>
                  <td>100点</td>
                </tr>
                <tr>
                  <td>老板</td>
                  <td>100</td>
                  <td>100</td>
                  <td>100&nbsp;X&nbsp;25%</td>
                  <td>200点</td>
                </tr>
                <tr>
                  <td>富人</td>
                  <td>200</td>
                  <td>200</td>
                  <td>200&nbsp;X&nbsp;25%</td>
                  <td>400点</td>
                </tr>
                <tr>
                  <td>富豪</td>
                  <td>300</td>
                  <td>300</td>
                  <td>300&nbsp;X&nbsp;30%</td>
                  <td>600点</td>
                </tr>
                <tr>
                  <td>大富豪</td>
                  <td>500</td>
                  <td>年VIP</td>
                  <td>[无色币限制]</td>
                  <td>1000点</td>
                </tr>
                <tr>
                  <td>福布斯</td>
                  <td>1000</td>
                  <td>年VIP</td>
                  <td>[无色币限制]</td>
                  <td>2000点</td>
                </tr>
              </table>
              <div class="clear">&nbsp;</div>
              <div class="vtable_tips">
                <div class="padding">
                  <p>1.会员通过色币使用VIP高速线路看视频（30分钟以下视频一个视频一个币）；</p>
                  <p>2.存款会员游戏后，加送免费色币使用；</p>
                  <p>3.满足存款条件的会员游戏后开通裸聊点；</p>
                  <p>4.首存 500 或 同一亚美账号（1个月内）累计存款 ≥ 500，游戏后可额外免费领取福利包<span class="red_bg">（爱奇艺VIP会员+成人网盘资源）</span></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="vreal_show m_t1">
        <div class="vs_title"><em class="ileft itrangle"><i></i></em><em class="iright itrangle"><i></i></em><span class="red_bg">
          <h2>直播真人裸聊、成人网盘资料下载</h2>
          <h1>VIP真人直播秀</h1>
          </span></div>
        <div class="vs_content">
          <div class="padding"> 
            <!-- Swiper -->
            <div class="swiper-container">
              <div class="swiper-wrapper"> <a href="javascript:;" class="swiper-slide"><img src="/templates/frontend/frontend-jiucao/m/vip/img/img/v1.jpg" /></a> <a href="javascript:;" class="swiper-slide"><img src="/templates/frontend/frontend-jiucao/m/vip/img/img/v2.jpg" /></a> <a href="javascript:;" class="swiper-slide"><img src="/templates/frontend/frontend-jiucao/m/vip/img/img/v3.jpg" /></a> <a href="javascript:;" class="swiper-slide"><img src="/templates/frontend/frontend-jiucao/m/vip/img/img/v4.jpg" /></a> <a href="javascript:;" class="swiper-slide"><img src="/templates/frontend/frontend-jiucao/m/vip/img/img/v5.jpg" /></a> </div>
              <!-- Add Arrows -->
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="vhot_game m_t1">
        <div class="vs_title"><em class="ileft itrangle"><i></i></em><em class="iright itrangle"><i></i></em><span class="red_bg">
          <h2>等值游戏筹码赢钱即可提款</h2>
          <h1>热门游戏推荐</h1>
          </span></div>
        <div class="vs_content">
          <div class="padding"> 
            <!-- Swiper -->
            <div class="swiper-container">
              <div class="swiper-wrapper"> <a href="http://m.am8.com/?id=a_5" target="_blank" class="swiper-slide"><img src="/templates/frontend/frontend-jiucao/m/vip/img/img/h1.jpg" alt="01-棋牌游戏-POKER GAMES" title="01-棋牌游戏-POKER GAMES" /><span class="shadow">&nbsp;</span><span class="txt">
                <h1>01<i></i></h1>
                <h2>棋牌游戏</h2>
                </span></a><a href="http://m.am8.com/?id=a_1" target="_blank" class="swiper-slide"><img src="/templates/frontend/frontend-jiucao/m/vip/img/img/h2.jpg" alt="02-真人娱乐-LIVE ENTERTAINMENT" title="02-真人娱乐-LIVE ENTERTAINMENT" /><span class="txt">
                <h1>02<i></i></h1>
                <h2>真人娱乐</h2>
                </span></a> <a href="http://m.am8.com/?id=a_3" target="_blank" class="swiper-slide"><img src="/templates/frontend/frontend-jiucao/m/vip/img/img/h3.jpg" alt="03-电子游戏-ELECTRONIC GAMES" title="03-电子游戏-ELECTRONIC GAMES" /><span class="txt">
                <h1>03<i></i></h1>
                <h2>电子游戏</h2>
                </span></a> <a href="http://m.am8.com/?id=a_2" target="_blank" class="swiper-slide"><img src="/templates/frontend/frontend-jiucao/m/vip/img/img/h4.jpg" alt="04-体育赛事-SPORTS EVENTS" title="04-体育赛事-SPORTS EVENTS" /><span class="txt">
                <h1>04<i></i></h1>
                <h2>体育赛事</h2>
                </span></a> <a href="http://m.am8.com/?id=a_6" target="_blank" class="swiper-slide"><img src="/templates/frontend/frontend-jiucao/m/vip/img/img/h5.jpg" alt="05-彩票游戏-LOTTERY GAMES" title="05-彩票游戏-LOTTERY GAMES" /><span class="txt">
                <h1>05<i></i></h1>
                <h2>彩票游戏</h2>
                </span></a> </div>
              <!-- Add Arrows -->
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="vfooter m_t1">
      <div class="padding">
        <div class="title"><img src="/templates/frontend/frontend-jiucao/m/vip/img/vfooter_title.png" alt="VIP特权" title="VIP特权" /></div>
        <div class="m_t1">
          <div class="vblock"><span class="icon ivf01"></span>
            <h1>海量成人视频库</h1>
          </div>
          <div class="vblock"><span class="icon ivf02"></span>
            <h1>多端播放无插件</h1>
          </div>
          <div class="vblock"><span class="icon ivf03"></span>
            <h1>热门游戏赢钱提现</h1>
          </div>
          <div class="vblock"><span class="icon ivf04"></span>
            <h1>真人辣妹热聊</h1>
          </div>
        </div>
      </div>
      <div class="video-more"><a href="javascript:void(0);" class="v-top"><img src="/templates/frontend/frontend-jiucao/m/vip/img/top_03.png"/></a> </div>
    </div>
  </div>
</div>

<!--阴影层-->
<div class="shadow"  style="display:none;">&nbsp;</div>

<!--popup start 开通引导弹窗-->
<div class="popup plead" style="display:none;" >
  <div class=""> <a href="javascript:;" class="icon iclose" data-role="close">&nbsp;</a>
    <div class="content">
      <div class="swiper-container02">
        <div class="swiper-wrapper">
          <div class="swiper-slide p1">
            <div class="title">
              <div class="padding">
                <h1><b>01</b><i></i>注册美亚</h1>
              </div>
            </div>
            <div class="img"><div class="padding"><img src="/templates/frontend/frontend-jiucao/m/vip/img/img/p1.jpg" />
              <p>按要求填写完整后，点击“立即注册”</p></div>
            </div>
          </div>
          <div class="swiper-slide p2">
            <div class="title">
              <div class="padding">
                <h1><b>02</b><i></i>注册成功</h1>
              </div>
            </div>
            <div class="img"><div class="padding"><img src="/templates/frontend/frontend-jiucao/m/vip/img/img/p2.png" />
              <p>进入会员中心，点击“存款”</p></div>
            </div>
          </div>
          <div class="swiper-slide p2">
            <div class="title">
              <div class="padding">
                <h1><b>03</b><i></i>会员存款</h1>
              </div>
            </div>
            <div class="img"><img src="/templates/frontend/frontend-jiucao/m/vip/img/img/p3.png" />
              <p>选择充值方式</p>
            </div>
          </div>
          <div class="swiper-slide p3">
            <div class="title">
              <div class="padding">
                <h1><b>04</b><i></i>联系客服</h1>
              </div>
            </div>
            <div class="content"><div class="padding">
              <h1>联系<span class="red">7x24小时</span>久草在线客服</h1>
              <div class="txt"><span class="red_bg"><i class="itrangle"></i>兑换格式</span>
                <div class="txt_line">
                  <h2>存款金额：XXX</h2>
                  <h2>亚美账号：XXX</h2>
                  <h2>久草账号：XXX</h2>
                </div>
              </div>
              <p class="red">注：客服核实开通久草VIP，游戏后加开裸聊账号</p>
              <p class="gray">久草QQ：{$qq1}</p>
              <div class="btn_group"><a href="http://wpa.qq.com/msgrd?v=3&uin={$qq1}&site=qq&menu=yes" target="_blank"><img src="/templates/frontend/frontend-jiucao/m/vip/img/btn_zx.png" /></a></div></div>
            </div>
            <div class="img"><img src="/templates/frontend/frontend-jiucao/m/vip/img/img/p7.png" /></div>
          </div>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="/templates/frontend/frontend-jiucao/m/vip/js/swiper-3.4.1.min.js"></script> 
<link rel="stylesheet" type="text/css" href="/templates/frontend/frontend-jiucao/m/vip/css/swiper-3.4.1.min.css">
<script type="text/javascript">
{literal}
$(function(){
		$('#autoRandom').html(createCode());
		$('#vrefresh').click(function(){$('#autoRandom').html(createCode());});
	    /*弹窗关闭与开启*/
		$("[data-role='close']").click(function(){
			$(this).parents(".popup").hide();
			$(".shadow").hide();
		})	
		$(".shadow").click(function(){
			$(this).hide();
			$(".popup").hide();	
		});
		//swpier 幻灯片切换
		var swiper = new Swiper('.swiper-container', {
			pagination: '.swiper-pagination',
			slidesPerView: 3,
			paginationClickable: true,
			spaceBetween: 30,
			keyboardControl: true,
			nextButton: '.swiper-button-next',
			prevButton: '.swiper-button-prev',
		});  	
		//开通弹窗
		$("#kt").click(function(){
			$(".shadow").show();
			$(".plead").show();
			var swiper02 = new Swiper('.swiper-container02', {
				pagination: '.swiper-pagination',
				slidesPerView: 1,
				paginationClickable: true,
				spaceBetween: 0,
				keyboardControl: true,
				nextButton: '.swiper-button-next',
				prevButton: '.swiper-button-prev',
			});
			//swiper02.slideTo(1, 1000, false);
			$('.swiper-container02 .swiper-pagination span').eq(0).trigger('click');
			
		})
		$('#submitBtn').click(function(){
			register();
		});
		function register(){
			var name = document.getElementById("loginname").value;
			var passwordfield = document.getElementById("pwd").value;
			var phone = document.getElementById("phone").value;
			var flag = true;
			var isphone= /^\d{11,12}$/;
			var marketCaptchaCode=document.getElementById("marketCaptchaCode").value;  
            var autoRandom=document.getElementById("autoRandom").innerHTML;
			var isname = /^([a-zA-Z]|\d){4,7}$/;
			var ispwd = /^([a-zA-Z0-9]){8,10}$/;
           
			if(name==''){
				flag = false;
				alert('帐号不能为空');
				return;
			}else if(!isname.test(name)){
				flag = false;
				alert('输入4-7位数字加字母组合');
				return;
			}
			if(passwordfield==''){
				flag = false;
				alert('登陆密码不能为空');
				return;
			}else if(!ispwd.test(passwordfield)){
				flag = false;
				alert('密密码由8-10位字母和数字组合');
				return;
			}

			if(phone=='' || phone=='请填写正确的手机号码'){
				flag = false;
				alert('联系电话不能为空');
				return;
			}else if(!isphone.test(phone)){
				flag = false;
				alert('电话长度应用为11~12位正确的手机号');
				return;
			} 
			if(flag){
				var form = document.getElementById("realAccount");
			    form.submit();
			}
		}
        function createCode()  
        {  
            var seed = new Array(  
                    '0123456789',  
                    '0123456789',  
                    '0123456789'  
            );               //创建需要的数据数组  
            var idx,i;  
            var result = '';   //返回的结果变量  
            for (i=0; i<4; i++) //根据指定的长度  
            {  
                idx = Math.floor(Math.random()*3); //获得随机数据的整数部分-获取一个随机整数  
                result += seed[idx].substr(Math.floor(Math.random()*(seed[idx].length)), 1);//根据随机数获取数据中一个值  
            }  
            return result; //返回随机结果  
        }
    function LimitTextArea(field){ 
	    maxlimit=7; 
	    if (field.value.length > maxlimit) 
	    field.value = field.value.substring(0, maxlimit); 
   }
	});
{/literal}
</script>
{include file="footer.tpl"}