     <link rel="stylesheet" href="/templates/backend/default/spread/css/common.css" type="text/css" />
     <style type="text/css">
     {literal}
/*自适应圆角投影*/
.round_shade_box{width:1px; height:1px; font-size:0; display:none; _background:white; _border:1px solid #cccccc;}
.round_shade_top{margin:0 12px 0 10px; background:url(/templates/backend/default/spread/image/zxx_round_shade.png) repeat-x -20px -40px; _background:white; zoom:1;}
.round_shade_topleft{width:11px; height:10px; background:url(/templates/backend/default/spread/image/zxx_round_shade.png) no-repeat 0 0; _background:none; float:left; margin-left:-11px; position:relative;}
.round_shade_topright{width:12px; height:10px; background:url(/templates/backend/default/spread/image/zxx_round_shade.png) no-repeat -29px 0; _background:none; float:right; margin-right:-12px; position:relative;}
.round_shade_centerleft{background:url(/templates/backend/default/spread/image/zxx_round_shade.png) no-repeat 0 -1580px; _background:none;}
.round_shade_centerright{background:url(/templates/backend/default/spread/image/zxx_round_shade.png) no-repeat right -80px; _background:none;}
.round_shade_center{font-size:14px; margin:0 12px 0 10px; padding:10px; background:white; letter-spacing:1px; line-height:1.5;}
.round_shade_bottom{margin:0 12px 0 11px; background:url(/templates/backend/default/spread/image/zxx_round_shade.png) repeat-x -20px bottom; _background:white; zoom:1;}
.round_shade_bottomleft{width:11px; height:10px; background:url(/templates/backend/default/spread/image/zxx_round_shade.png) no-repeat 0 -30px; _background:none; float:left; margin-left:-11px; position:relative;}
.round_shade_bottomright{width:12px; height:10px; background:url(/templates/backend/default/spread/image/zxx_round_shade.png) no-repeat -29px -30px; _background:none; float:right; margin-right:-12px; position:relative;}
.round_shade_top:after,.round_shade_bottom:after,.zxx_zoom_box:after{display:block; content:"."; height:0; clear:both; overflow:hidden; visibility:hidden;}
.round_box_close{padding:2px 5px; font-size:12px; color:#ffffff; text-decoration:none; border:1px solid #cccccc; -moz-border-radius:4px; -webkit-border-radius:4px; background:#000000; opacity:0.8; filter:alpha(opacity=80); position:absolute; right:-5px; top:-5px;}
.round_box_close:hover{opacity:0.95; filter:alpha(opacity=95);}
/*自适应圆角投影结束*/
.zxx_zoom_left{width:45%; float:left; margin-top:20px; border-right:1px solid #dddddd;}
.zxx_zoom_left h4{margin:5px 0px 15px 5px; font-size:1.1em;}
.small_pic{display:inline-block; width:48%; height:150px; font-size:120px; text-align:center; *display:inline; zoom:1; vertical-align:middle;}
.small_pic img{padding:3px; background:#ffffff; border:1px solid #cccccc; vertical-align:middle;}
.zxx_zoom_right{width:50%; float:left; margin-top:20px; padding-left:2%;}
.zxx_zoom_right h4{margin:5px 0px; font-size:1.1em;}
.zxx_zoom_right p.zxx_zoom_word{line-height:1.5; font-size:1.05em; letter-spacing:1px; margin:0 0 35px; padding-top:5px;}
{/literal}
</style>
     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm"> 
        <form name="search_spread_count" method="POST" action="users.php?m=spread">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">状态</td>
                <td>
                    <select name="status">
                    <option value="0"{if $status == '0'} selected="selected"{/if}>未审核</option>
                    <option value="1"{if $status == '1'} selected="selected"{/if}>已审核</option>
                    </select>
                </td>
                <td align="right">日期</td>
                <td>
                <link rel="stylesheet" type="text/css" href="/templates/backend/default/datetimepicker/jquery.datetimepicker.css"/ >
				<script src="/templates/backend/default/datetimepicker/jquery.js"></script>
				<script src="/templates/backend/default/datetimepicker/jquery.datetimepicker.js"></script>
                <input id="datetimepicker" name="date" type="text" value="{$date}">
                </td>
                <td align="right">用户名</td>
                <td>
                    <input id="username" name="username" type="text" value="{$username}">
                </td>
                <td colspan="2" align="center">
                    <input type="submit" name="search_spread_count" value=" -- 搜索 -- " class="button">
                    <input type="reset" name="reset_search" value=" -- 清除 -- " class="button">
                </td>
            </tr>
            </table>
            </form>
            <script>
            {literal}
			$('#datetimepicker').datetimepicker({lang:"ch",format:"Y-m-d",timepicker:false,yearStart:2000,yearEnd:2050,todayButton:true});
			{/literal}
		  </script>
        </div>                                                            
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>用户名</b></td>
                <td align="center"><b>IP</b></td>
                <td align="center"><b>图片</b></td>
                <td align="center"><b>状态</b></td>
                <td align="center"><b>上传时间</b></td>
                <td align="center"><b>操作</b></td>
            </tr>
            {if $spreads}
            {section name=i loop=$spreads}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$spreads[i].id}</td>
                <td align="center">{$spreads[i].username}</td>
                <td align="center">{$spreads[i].ip}</td>
                <td align="center"><div class="small_pic"><a href="#pic_{$spreads[i].id}" title="点击图片可以放大查看"><img style="width:200px;height:100px;" src="{$spreads[i].simg}"/></a></div></td>
                <td align="center">{if $spreads[i].status == 0}未审核{/if}{if $spreads[i].status == 1}审核通过{/if}{if $spreads[i].status == 2}审核未通过{/if}</td>
                <td align="center"> {$spreads[i].utime|date_format}</td>
                <td align="center"> {if $spreads[i].status == 0}<a href="/siteadmin/users.php?m=spread&t=verify&id={$spreads[i].id}">审核</a>{else}已审核{/if} / <a href="/siteadmin/users.php?m=spread&t=del&id={$spreads[i].id}">删除</a></td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">YOUR SEARCH DID NOT RETURN ANY RESULTS</div></td>
            </tr>
            {/if}
            </table>
        </div>
        {if $total >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        <div class="pagingnav_clear"></div>
        {/if}                                                            
     </div>
     {if $spreads}
            {section name=i loop=$spreads}
            <div id="pic_{$spreads[i].id}" style="display:none;"><img src="{$spreads[i].simg}" style="width:80%;"/></div>
       		{/section}
     {/if}
     <script type="text/javascript" src="/templates/backend/default/spread/js/content_zoom.js"></script>
	<script type="text/javascript">
	{literal}
		$(document).ready(function() {
			$('div.small_pic a').fancyZoom({scaleImg: true, closeOnClick: true});
		});
	{/literal}
	</script>