{include file="header.tpl"}
{include file="header_ads.tpl"}
<div class="nav-log long">
{foreach from=$channels key=k item=v name=channel}
	<a href="{if $v.CHID == 6}{surl url=novel}{elseif $v.CHID == 7}{surl url=picture}{else}{surl url=video/index/cid id=$v.CHID}{/if}" class="log-link a{$smarty.foreach.channel.index}"><img src="/templates/frontend/frontend-jiucao/m/img/{if $v.CHID == 6}book_03.png{elseif $v.CHID == 7}text_03.png{else}play-ico.png{/if}" class="log" /><p class="name">{$v.name}</p></a>
{/foreach}
</div>
{include file="footer.tpl"}