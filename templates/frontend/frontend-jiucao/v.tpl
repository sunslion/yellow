{include file="header.tpl"}
<!-- 正文 -->
<div class="detail">
	<div class="width1200">
        <div class="detail_left">
            {include file="left_menu.tpl"}
        </div>
        <div class="detail_right">
            {include file="header_ads.tpl"}
            <div class="detail_right_tab">
                <!-- 首页 -->
                <div class="detail_tab detail_tab2">
                    <div class="detail_right_div">
			{include file="higSuggest/index.tpl"}
                        <h3>
                            <span class="detail_right_span">最新更新</span>
                        </h3>
                        <ul>
                        	{section name=i loop=$newvideolist}
                            <li>
                                <p class="img">
                                    <img class="lazy" data-original="{$newvideolist[i].pic}" src="/templates/frontend/frontend-jiucao/img/loading.gif?t=2" alt="{$newvideolist[i].title}" title="{$newvideolist[i].title}" onerror="this.src='/templates/frontend/frontend-jiucao/img/backlogo.png'"/>
                                    <a href="{surl url=video/show/id id=$newvideolist[i].VID}"></a>
                                </p>
                                <p>{$newvideolist[i].title}</p>

                                <p>
                                    <i>{$newvideolist[i].addtime}</i>
                                    <strong>{$newvideolist[i].viewnumber}观看</strong>
                                </p>
                            </li>
                            {/section}
                        </ul>
                    </div>
                    <div class="ps_26"></div>
                    {php}$i=26;{/php}
                    {section name=i loop=$indexvideolist}
                    <div class="detail_right_div">
                        <h3>
                            <span class="detail_right_span">{$indexvideolist[i].name}</span>
                            <a href="{surl url=video/index/cid id=$indexvideolist[i].CHID}">更多&gt;&gt;</a>
                        </h3>
                        <ul>
                        	{section name=j loop=$indexvideolist[i].videos}
                            <li>
                                <p class="img">
                                    <img class="lazy" data-original="{$indexvideolist[i].videos[j].pic}" src="/templates/frontend/frontend-jiucao/img/loading.gif?t=2" alt="{$indexvideolist[i].videos[j].title}" title="{$indexvideolist[i].videos[j].title}" onerror="this.src='/templates/frontend/frontend-jiucao/img/backlogo.png'"/>
                                    <a href="{surl url=video/show/id id=$indexvideolist[i].videos[j].VID}"></a>
                                </p>
                                <p>{$indexvideolist[i].videos[j].title}</p>

                                <p>
                                    <i>{$indexvideolist[i].videos[j].addtime}</i>
                                    <strong>{$indexvideolist[i].videos[j].viewnumber}观看</strong>
                                </p>
                            </li>
                           {/section}
                        </ul>
                    </div>
                    <div class="ps_{php}echo ++$i{/php}"></div>
                    {/section}
                </div>
                <!-- 首页 -->
            </div>
        </div>
        <div style="clear:both;"></div>
    </div>
</div>
<!-- 正文 -->
<!-- 底部 -->
{include file="footer.tpl"}
<!-- 底部 -->
