{include file="header_ads.tpl"}
<div class="video-body">
	<div class="video-head">
	{section name=i loop=$novelchannels}
		<div class="video-title" style="float:left; margin-right:7px;margin-top:5px;"><a {if $novelchannels[i].CHID == $chid}style="color:red;"{else}style="color:#000;"{/if} href="{surl url=novel/index/cid id=$novelchannels[i].CHID}">{$novelchannels[i].name}</a></div>
	{/section}
	<div style="clear:both;"></div>
	</div>
	<div class="video-list storyList">
	{section name=i loop=$novellist}
		<div class='storyList-item'>
			<a href="{surl url=novel/show/id id=$novellist[i].VID}" class="title">{$novellist[i].title}</a>
			{insert name=time_range assign=addtime time=$novellist[i].time}
			<span class="time">{$addtime}</span>
		</div>
	{/section}
	</div>
</div>

<div class="video-more">
	<div class="video-title nextPage">{$pages}</div>
	<a href="javascript:void(0);" class="v-top"><img src="/templates/frontend/frontend-jiucao/m/img/top_03.png"/></a>
</div>