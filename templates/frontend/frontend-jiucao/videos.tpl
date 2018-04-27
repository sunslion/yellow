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
                        <h3>
                            <span class="detail_right_span">{$channelname}</span>
                        </h3>
                        <ul>
                        {section name=i loop=$videolist}
                            <li>
                                <p>
                                    <img class="lazy" data-original="{$videolist[i].pic}" src="/templates/frontend/frontend-jiucao/img/loading.gif?t=2" alt="{$videolist[i].title}" title="{$videolist[i].title}" onerror="this.src='/templates/frontend/frontend-jiucao/img/backlogo.png'"/>
                                    <a href="{surl url=video/show/id id=$videolist[i].VID}"></a>
                                </p>
                                <p>{$videolist[i].title}</p>
                                <p>
                                    <i>{$videolist[i].addtime}</i>
                                    <strong>{$videolist[i].viewnumber}观看</strong>
                                </p>
                            </li>
                       {/section}
                        </ul>
                        <ul class="nextPage">{$pages}</ul>
                    </div>
                </div>
                <!-- 首页 -->
            </div>
        </div>
    </div>
</div>
<!-- 正文 -->