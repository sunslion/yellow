<!-- 正文 -->
<div class="detail">
	<div class="width1200">
        <div class="detail_left">
            {include file="left_menu.tpl"}
        </div>
        <div class="detail_right">
            {include file="header_ads.tpl"}
            <div class="detail_right_tab">
            	<div class="detail_right_scroll" style="display: none;"></div>
                <div class="imagesContent">
                    <div class="gc_vidoe_nav">
                        <a href="/" style="margin-left:15px;">首页 > </a>
                        <a href="{surl url=novel/index/cid id=$novel.category_id}">{$cname}  > </a>
                        <a href="{surl url=novel/show/id id=$novel.VID}" class="select"> {$novel.title}  </a>
                    </div>
                    <div class="gray">
                        <p class="bmulu"><a href="{surl url=novel/index/cid id=$novel.category_id}" class="mulu">返回目录</a></p>
                        <h3>{$novel.title}</h3>
                         {insert name=time_range assign=addtime time=$novel.time}
                        <p>加入：{$addtime}  类型：{$cname}  查看：{$novel.viewnumber}</p>
                    </div>
                    <div class="text">
                        {$novel.content}
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 正文 -->