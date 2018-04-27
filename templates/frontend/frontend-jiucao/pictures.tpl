<!-- 正文 -->
<div class="detail">
	<div class="width1200">
        <div class="detail_left">
           {include file="left_menu.tpl"}
        </div>
        <div class="detail_right">
            {include file="header_ads.tpl"}
            <div class="detail_right_tab">
            	<div class="detail_right_scroll">
                	<ul>
                    	{section name=i loop=$picturechannels}
                    	<li{if $picturechannels[i].CHID == $chid} class="active"{/if}><a href="{surl url=picture/index/cid id=$picturechannels[i].CHID}"> {$picturechannels[i].name}  </a></li>
                    	{/section}
                    </ul>
                </div>
                <!-- 首页 -->
                <div class="detail_tab detail_tab2">
                    <div class="detail_right_div">
                        <ul>
                        {section name=i loop=$picturelist}
                            <li>
                                <a href="{surl url=picture/show/id id=$picturelist[i].VID}">
                                    <p class="img">
                                        <img class="lazy" data-original="{$picturelist[i].default}" src="/templates/frontend/frontend-jiucao/img/loading.gif?t=2" alt="{$picturelist[i].title}" title="{$picturelist[i].title}" onerror="this.src='/templates/frontend/frontend-jiucao/img/backlogo.png'"/>
                                    </p>
                                    <p class="textLeft">{$picturelist[i].title}【{$picturelist[i].count}P】</p>
                                </a>
                                    <p>
                                        <i>类型：{$picturelist[i].cname}</i>
                                        {insert name=time_range assign=addtime time=$picturelist[i].addtime}
                                        <strong>{$addtime}</strong>
                                    </p>
                                    <p class="iagIcon">
                                        <i>{$picturelist[i].viewnumber}</i>
                                        <strong>{$picturelist[i].count}P</strong>
                                    </p>     
                            </li>
  						{/section}
                        </ul>
                        <div class="nextPage">
			                {$pages}
			            </div>
                    </div>
                </div>
                <!-- 首页 -->
            </div>
        </div>
    </div>
</div>
<!-- 正文 -->