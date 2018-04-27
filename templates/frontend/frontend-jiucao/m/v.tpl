{include file="header.tpl"}
<!-- {include file="category_more.tpl"} APP导航栏-->
{include file="higSuggest/index.tpl"}
{include file="header_ads.tpl"}
<div class="video-body">
	<div class="video-head">
		<div class="video-title">最新更新</div>
	</div>
	<div class="video-list">
	{section name=i loop=$newvideolist max=4}
		<div class="video-item">
			<a href="{surl url=video/show/id id=$newvideolist[i].VID}">
				<div class="log"><img class="lazy" data-original="{$newvideolist[i].pic}" src="/templates/frontend/frontend-jiucao/m/img/loading.gif" alt="{$newvideolist[i].title}" title="{$newvideolist[i].title}" onerror="this.src='/templates/frontend/frontend-jiucao/img/backlogo.png'"/></div>
				<div class="title">{$newvideolist[i].title}</div>
				<div class="video-foot">
					<div class="time">{$newvideolist[i].addtime}</div>
					<div class="view">{$newvideolist[i].viewnumber}观看</div>
				</div>
			</a>
		 </div>
	{/section}
		<div class="ps_35"></div>
	</div>
</div>
{php}$i=35;{/php}
{section name=i loop=$indexvideolist}
<div class="video-body">
	<div class="video-head">
		<div class="video-title">{$indexvideolist[i].name}</div>
		<a href="{surl url=video/index/id id=$indexvideolist[i].CHID}" class="more">更多 <img src="/templates/frontend/frontend-jiucao/m/img/more-ico.png"/></a>
	</div>
	<div class="video-list">
	{section name=j loop=$indexvideolist[i].videos max=4}
		<div class="video-item">
			<a href="{surl url=video/show/id id=$indexvideolist[i].videos[j].VID}">
				<div class="log"><img class="lazy" data-original="{$indexvideolist[i].videos[j].pic}" src="/templates/frontend/frontend-jiucao/m/img/loading.gif" alt="{$indexvideolist[i].videos[j].title}" title="{$indexvideolist[i].videos[j].title}" onerror="this.src='/templates/frontend/frontend-jiucao/img/backlogo.png'"/></div>
				<div class="title">{$indexvideolist[i].videos[j].title}</div>
				<div class="video-foot">
					<div class="time">{$indexvideolist[i].videos[j].addtime}</div>
					<div class="view"><img src="/templates/frontend/frontend-jiucao/m/img/eyes_04.png" />{$indexvideolist[i].videos[j].viewnumber}</div>
				</div>
			</a>
		</div>
	{/section}	
	</div>
	<div class="ps_{php}echo ++$i{/php}"></div>
</div>
{/section}
<div class="video-more">
	<a href="javascript:void(0);" class="v-top"><img src="/templates/frontend/frontend-jiucao/m/img/top_03.png"/></a>
</div>
{include file="footer.tpl"}