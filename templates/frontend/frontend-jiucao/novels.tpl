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
                		{section name=i loop=$novelchannels}
                    	<li{if $novelchannels[i].CHID == $chid} class="active"{/if}><a href="{surl url=novel/index/cid id=$novelchannels[i].CHID}"> {$novelchannels[i].name}  </a></li>
                    	{/section}
                    </ul>
                </div>
                <!-- 首页 -->
                <div class="detail_tab detail_tab2 whiteDetail">
                    <div class="detail_right_div ">
                         <ul class="xiaoshuo whiteDetail">
                         {section name=i loop=$novellist}
                            <li>
                               <a href="{surl url=novel/show/id id=$novellist[i].VID}"><h3>{$novellist[i].title}</h3></a> 
                               {insert name=time_range assign=addtime time=$novellist[i].time}							
                               <p class="title">加入：{$addtime}  类型：{$novellist[i].cname}  查看：{$novellist[i].viewnumber}</p>
                               {insert name=cleanandtrim_content assign=content content=$novellist[i].content len=160}
                               <p class="text">{$content}...</p> 
                               <p class="redayall"><a href="{surl url=novel/show/id id=$novellist[i].VID}">点击阅读全文</a></p>
                            </li>
                          {/section}
                        </ul>
                        <div class="nextPage" style="margin-top: 30px;">
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
<script type="text/javascript" src="/templates/frontend/frontend-jiucao/js/swiper-3.4.1.min.js"></script>
<script type="text/javascript">
{literal}
    var mySwiper = new Swiper ('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        loop: true ,
        // 如果需要前进后退按钮
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev'
  });
  {/literal}    
 </script>