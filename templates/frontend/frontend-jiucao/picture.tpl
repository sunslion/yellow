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
                <div class="gc_vidoe_nav">
                            <a href="/">首页 > </a>
                            <a href="{surl url=picture/index/cid id=$picture.category_id}">{$cname} > </a>
                            <a href="{surl url=picture/show/id id=$picture.VID}" class="select">{$picture.title}  </a>
                        </div>
                <div class="imagesContent">
                    <p class="bmulu"><a href="{surl url=picture/index/cid id=$picture.category_id}" class="mulu">返回目录</a></p>
                    <h3>{$picture.title}【{$picture.count}P】</h3>
                    {insert name=time_range assign=addtime time=$picture.addtime}
                    <p>加入：{$addtime}  类型：{$cname}  查看：{$picture.viewnumber}</p>

                    <div class="images">
                    	{section name=i loop=$picture.imgs}
                    		<div {if $smarty.section.i.index > 2}style="display:none;" class="nodisplay"{/if} style="background-color: #f6f7fb;margin-bottom:10px;">
                        	<img src="{$picture.imgs[i]}" onerror="this.src='/templates/frontend/frontend-jiucao/img/backlogo.png'">
                        	</div>
                        {/section}
                    </div>
                    <div class="ckxq">点击展开</div>    
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
{literal}
$(function(){
	$('div.ckxq').click(function(){
		var prev = $(this).prev('.images');
		var nodivs = $(prev).find('div.nodisplay');
		if($(nodivs).is(':hidden')){
			$(this).html('点击收缩');
			nodivs.show();
		}else{
			$(this).html('点击展开');
			nodivs.hide();
		}
	});
});
{/literal}
</script>
<!-- 正文 -->