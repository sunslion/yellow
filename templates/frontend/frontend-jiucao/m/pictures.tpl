{include file="header_ads.tpl"}
<div class="video-body">
	<div class="video-head">
	{section name=i loop=$picturechannels}
		<div class="video-title" style="float:left; margin-right:7px;margin-top:5px;"><a {if $picturechannels[i].CHID == $chid}style="color:red;"{else}style="color:#000;"{/if} href="{surl url=picture/index/cid id=$picturechannels[i].CHID}">{$picturechannels[i].name}</a></div>
	{/section}
	<div style="clear:both;"></div>
	</div>
	<div class="video-list">
	{section name=i loop=$picturelist}
		<div class="video-item">
			<a href="{surl url=picture/show/id id=$picturelist[i].VID}">
				<div class="log"><img class="lazy" data-original="{$picturelist[i].default}" src="/templates/frontend/frontend-jiucao/m/img/loading.gif" alt="{$picturelist[i].title}" title="{$picturelist[i].title}" onerror="this.src='/templates/frontend/frontend-jiucao/img/backlogo.png'"/></div>
				<div class="title t-left">{$picturelist[i].title}</div>
				<div class="video-foot">
					<div class="time">类型：{$picturelist[i].cname}</div>
					{insert name=time_range assign=addtime time=$picturelist[i].addtime}
					<div class="view">{$addtime}</div>
				</div>
				<div class="video-foots">
					<div class="time">{$picturelist[i].viewnumber}</div>
					<div class="view">{$picturelist[i].count}P</div>
				</div>
			</a>
		</div>
	{/section}
	</div>
</div>

<div class="video-more">
	<div class="video-title nextPage">{$pages}</div>
	<a href="javascript:void(0);" class="v-top"><img src="/templates/frontend/frontend-jiucao/m/img/top_03.png"/></a>
</div>