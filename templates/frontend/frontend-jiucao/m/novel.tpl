{include file="header_ads.tpl"}
<div class="video-body">
	<div class="video-head images-back">
		<div class="video-title"><a href="{surl url=novel/index/cid id=$novel.category_id}" style="color:#000;">返回目录</a></div>
	</div>
	<div class="video-list images-list">
		<h3>{$novel.title}</h3>
		{insert name=time_range assign=addtime time=$novel.time}
		<h4>加入：{$addtime}  类型：{$cname}  查看：{$novel.viewnumber}</h4>
		<p class="story">
			{$novel.content}
		</p>	
	</div>
</div>
<div class="video-more">
	<a href="javascript:void(0);" class="v-top"><img src="/templates/frontend/frontend-jiucao/m/img/top_03.png"/></a>
</div>