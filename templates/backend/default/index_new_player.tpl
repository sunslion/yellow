<div id="rightcontent">
   {include file="errmsg.tpl"}
   <div id="right">
   <div align="center">
   <h2>设置新版播放器的广告</h2>
   <div id="simpleForm">
   <form name="player_settings" method="POST" action="index.php?m=new_player">
   <small>本模块设置禁止使用一切回车与特殊符号</small>
   <fieldset>
   <legend>广告类型</legend>
   <select name="type">
    	<option value="1"{if $player.type == 1} selected{/if}>PC端</option>
    	<option value="2"{if $player.type == 2} selected{/if}>移动端</option>
    </select>
   </fieldset>
   <fieldset>
   <legend>前置广告</legend>
   
<label for="front_ads_guest">游客前置广告图: </label>
<textarea name="front_ads_guest">{$player.front_ads_guest}</textarea>
<small>广告图1|广告图2|广告图3|广告图4....</small><br>
<label for="front_ads_uri_guest">游客前置广告图链接: </label>
<textarea name="front_ads_uri_guest">{$player.front_ads_uri_guest}</textarea>
<small>广告链接1|广告链接2|广告链接3|广告链接4....</small><br>
<label for="front_ads_time_guest">游客广告时间: </label>
<textarea name="front_ads_time_guest">{$player.front_ads_time_guest}</textarea>
<small>广告时间1|广告时间2|广告时间3|广告时间4....</small><br>


<label for="front_ads_free">免费会员前置广告图: </label>
<textarea name="front_ads_free">{$player.front_ads_free}</textarea>
<br>
<label for="front_ads_uri_free">免费会员前置广告图链接: </label>
<textarea name="front_ads_uri_free">{$player.front_ads_uri_free}</textarea>
<br>
<label for="front_ads_time_free">免费会员广告时间: </label>
<textarea name="front_ads_time_free">{$player.front_ads_time_free}</textarea>
<br>


<label for="front_ads_premium">付费用户前置广告图: </label>
<textarea name="front_ads_premium">{$player.front_ads_premium}</textarea>
<br>
<label for="front_ads_uri_premium">付费用户前置广告图链接: </label>
<textarea name="front_ads_uri_premium">{$player.front_ads_uri_premium}</textarea>
<br>
<label for="front_ads_time_premium">付费用户广告时间: </label>
<textarea name="front_ads_time_premium">{$player.front_ads_time_premium}</textarea>
<br>

   </fieldset>
	<fieldset>
   <legend>前置广告显示</legend>
       <label for="front_ads_view">开启哪些会员的开头广告:</label>
       <input name="front_ads_view" type="text" value="{$player.front_ads_view}"><small>设置此处请确认上方广告是否正确,格式与广告相同|隔开,guest|free|premium</small><br>
   </fieldset>
   <fieldset>
   <legend>暂停广告</legend>
       <label for="stop_ads">暂停广告图片: </label>
       <textarea name="stop_ads">{$player.stop_ads}</textarea>
       <small>广告图</small><br>
       
       <br>
       <label for="stop_ads_uri">暂停广告链接: </label>
       <textarea name="stop_ads_uri">{$player.stop_ads_uri}</textarea><small>广告链接</small><br>
       
   </fieldset>
   <div style="text-align: center;">
       <input type="submit" name="submit_player" value="更新广告" class="button">
   </div>
   </form>
   </div>
   </div>
   </div>
</div>
<script type="text/javascript">
{literal}
$(function(){
	$('select[name="type"]').change(function(){
		$.post('/ajax/get_new_player',{'type':$.trim($('select[name="type"]').val())},function(d){
			if(d){
				$('textarea[name="front_ads_guest"]').text(d.front_ads_guest);
				$('textarea[name="front_ads_uri_guest"]').text(d.front_ads_uri_guest);
				$('textarea[name="front_ads_time_guest"]').text(d.front_ads_time_guest);
				$('textarea[name="front_ads_free"]').text(d.front_ads_free);
				$('textarea[name="front_ads_uri_free"]').text(d.front_ads_uri_free);
				$('textarea[name="front_ads_time_free"]').text(d.front_ads_time_free);
				$('textarea[name="front_ads_premium"]').text(d.front_ads_premium);
				$('textarea[name="front_ads_uri_premium"]').text(d.front_ads_uri_premium);
				$('textarea[name="front_ads_time_premium"]').text(d.front_ads_time_premium);
				$('input[name="front_ads_view"]').val(d.front_ads_view);
				$('textarea[name="stop_ads"]').text(d.stop_ads);
				$('textarea[name="stop_ads_uri"]').text(d.stop_ads_uri);
			}
		},'json');
	});
});
{/literal}
 </script>