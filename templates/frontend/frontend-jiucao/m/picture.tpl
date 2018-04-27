{include file="header_ads.tpl"}
<div class="video-body">
	<div class="video-head images-back">
		<div class="video-title" onclick="history.go(-1)">返回目录</div>
	</div>
	<div class="video-list images-list">
		<h3>{$picture.title}【{$picture.count}P】</h3>
		{insert name=time_range assign=addtime time=$picture.addtime}
		<h4>加入：{$addtime} 类型：{$cname}  查看：{$picture.viewnumber}</h4>
		{section name=i loop=$picture.imgs}
			<div {if $smarty.section.i.index > 2}style="display:none;" class="nodisplay"{/if} style="background-color: #f6f7fb;margin-bottom:10px;">
			<img src="{$picture.imgs[i]}" onerror="this.src='/templates/frontend/frontend-jiucao/img/backlogo.png'">
			</div>
		{/section}	
	</div>
</div>
<div class="video-more">
	<div class="video-title">加载更多</div>
	<a href="javascript:void(0);" class="v-top"><img src="/templates/frontend/frontend-jiucao/m/img/top_03.png"/></a>
</div>
<script type="text/javascript">
{literal}
$(function(){
	$('div.video-title').click(function(){
		var prev = $('.images-list');
		var nodivs = $(prev).find('div.nodisplay');
		if($(nodivs).is(':hidden')){
			$(this).html('点击收缩');
			nodivs.show();
		}else{
			$(this).html('点击展开');
			nodivs.hide();
		}
	});
});
{/literal}
</script>