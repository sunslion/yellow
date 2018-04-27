<div class="nav-log">
	<a href="/avActor" class="log-link a8" target="_blank"><img src="/templates/frontend/frontend-jiucao/m/img/play-ico.png" class="log" /><p class="name">AV女优一览</p></a>
	{foreach from=$channels key=k item=v name=channel}
	{if $smarty.foreach.channel.index < 7}
	<a href="{surl url=video/index/cid id=$v.CHID}" class="log-link a{$smarty.foreach.channel.index}"><img src="/templates/frontend/frontend-jiucao/m/img/play-ico.png" class="log" /><p class="name">{$v.name}</p></a>
	{/if}
	{/foreach}
	<a href="{surl url=channels}" class="log-link a7"><img src="/templates/frontend/frontend-jiucao/m/img/menu-ico.png" class="log" /><p class="name">全部分类</p></a>
</div>