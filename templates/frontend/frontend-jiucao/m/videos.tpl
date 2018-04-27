{include file="header_ads.tpl"}
<div class="video-body">
	<div class="video-head">
		<div class="video-title">{$channelname}</div>
	</div>
	<div class="video-list">
	{section name=i loop=$videolist}
		<div class="video-item"><a href="{surl url=video/show/id id=$videolist[i].VID}">
			<div class="log"><img class="lazy" data-original="{$videolist[i].pic}" src="/templates/frontend/frontend-jiucao/m/img/loading.gif" title="{$videolist[i].title}" onerror="this.src='/templates/frontend/frontend-jiucao/img/backlogo.png'"/></div>
			<div class="title">{$videolist[i].title}</div>
			<div class="xin-level">
				{rate rate=$videolist[i].rate}
			</div>
			<div class="video-foot">
				<div class="time">{$videolist[i].addtime}</div>
				<div class="view">{$videolist[i].viewnumber}观看</div>
			</div>
		</a></div>
		{/section}
	</div>
</div>

<div class="video-more">
	<div class="video-title"><ul class="nextPage">{$pages}</ul><div style="clear:both;"></div></div>
	<a href="javascript:void(0);" class="v-top"><img src="/templates/frontend/frontend-jiucao/m/img/top_03.png"/></a>
</div>