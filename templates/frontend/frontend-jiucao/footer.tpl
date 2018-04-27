<div class="notice">
		<a href="#" class="icon-speaker"></a>
		<div class="notice-cont">
			<span class="speaker"></span>
			<div class="msg">
				<marquee direction="left">  
					<p style="font-weight:bolder;line-height:42px;">{$set_notice}</p>
				</marquee>
			</div>
			<a href="javascript:void(0);" class="ntc-btn">收起公告</a>
		</div>
</div>
<div class="footer">
	<div class="width1200">
    	<div class="footer_logo">
        	<a href="javascript:;"></a>
        </div>
        <div class="footer_cet">
        	<div class="footer_cet_qq">
            	<!--<img src="/templates/frontend/frontend-jiucao/img/txqq.png" />-->
                <p>Yellow字幕网成立于2017年9月，于2017年10月1日正式上线运营。Yellow字幕网致力于 为AV爱好者免费提供最新的中文字幕资源，是目前最大的、最全面的AV中文网站。Yellow字幕网一直坚持对老司机负责这一经营理念，上线以来获得了广大老司机的一致认的可，尤其是那些关注我们微信公众号的老司机，永远不会翻车，永远带你秋名山上飙车</p>
            </div>
            <!--<ul>
            	<li>活动客服：3001313293<a href="http://wpa.qq.com/msgrd?v=3&uin=3001313293&site=qq&menu=yes" target="_blank"></a></li>
            	<li>活动客服：3001313293<a href="http://wpa.qq.com/msgrd?v=3&uin=3001313293&site=qq&menu=yes" target="_blank"></a></li>
            	<li>活动客服：3001313293<a href="http://wpa.qq.com/msgrd?v=3&uin=3001313293&site=qq&menu=yes" target="_blank"></a></li>
                <li><a style="background:none;color:#f0ff00;" href="http://tb.53kf.com/code/client/10140693/1" target="_blank">7X24小时点击咨询</a></li>
            </ul>-->
        </div>
        <div class="footer_code">
        	<!-- 二维码大小93*93 -->
        	<img src="http://rgwyz.com/images/yellow.jpg" />
            <p>
            	<span>手机扫一扫【微信版】</span>
				<span>扫描二维码进入开车模式</span>
				<span>老司机带你秋名山无线飙车~</span>
            </p>
        </div>
    </div>
</div>
<script type="text/javascript" src="/templates/frontend/frontend-jiucao/js/jquery.lazyload.min.js"></script>
<div style="display:none">
<center>
<script src="https://s22.cnzz.com/z_stat.php?id=1265360626&web_id=1265360626" language="JavaScript"></script>
<script language="JavaScript">
{literal}
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?e4fa146ca527418cd9e1709678bb7628";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
{/literal}
</script>
</center>
</div>
<a href="javascript:void(0);" class="v-top"><img src="/templates/frontend/frontend-jiucao/img/top.png"/></a>
</body>
<script type="text/javascript">
var back_img = '{$back_img}';
back_img = back_img ? back_img + '.jpg' : '';
var set_left_btn_top = '{$set_left_btn_top}';
var set_left_btn_url = '{$set_left_btn_url}';
var set_right_btn_top = '{$set_right_btn_top}';
var set_right_btn_url = '{$set_right_btn_url}';
{literal}
	$(function(){
		$(".ntc-btn").click(function(){
			$(".notice").hide(500);
		});
		$('img.lazy').lazyload();
		if(back_img !== ''){
			setTimeout(function(){
				$.getScript("/templates/frontend/frontend-jiucao/js/scoll_bg.js?t=3");
			},3000);
		}
		showAds(ps);//加载主广js
	});
{/literal}
</script>
</html>
