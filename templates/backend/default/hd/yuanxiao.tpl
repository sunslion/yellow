     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
            <form name="search_hd" method="POST" action="hd.php?m=newyear&type=2">
            <input type="hidden" name="type" value="2"/>
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr style="padding:15px 0;"><td colspan="7" align="left"><a name="add_deposit" href="hd.php?m=newyear&type=2" style="background-color:#D4D4D4;padding:6px 20px;border-radius:8px;border-right: 1px solid #bbb;border-bottom: 1px solid #ccc;border-top: 1px solid #ccc;border-left: 1px solid #bbb;margin-right:10px;">--元宵猜灯中奖信息--</a><a name="add_deposit" href="hd.php?m=newyear&type=1" style="background-color:#D4D4D4;padding:6px 20px;border-radius:8px;border-right: 1px solid #bbb;border-bottom: 1px solid #ccc;border-top: 1px solid #ccc;border-left: 1px solid #bbb;">-- 祝福领红包信息 --</a></td></tr>
            <tr>
            	 <td align="right">用户名或UID</td>
            	 <td><input type="text" name="keyword" value="{$option.where}"></td>
                <td align="right">排序</td>
                <td>
                    <select name="sort">
                    <option value="id"{if $option.sort == 'id'} selected="selected"{/if}>ID</option>
                    </select>
                </td>
                <td align="right">规则(正排/倒排)</td>
                <td>
                    <select name="order">
                    <option value="DESC"{if $option.order == 'DESC'} selected="selected"{/if}>DESC</option>
                    <option value="ASC"{if $option.order == 'ASC'} selected="selected"{/if}>ASC</option>
                    </select>
                </td>
                <td colspan="2" align="center">
                    <input type="submit" name="search_hd" value=" -- 搜索 -- " class="button">
                    <input type="reset" name="reset_search" value=" -- 清除 -- " class="button">
                </td>
            </tr>
            </table>
            </form>
        </div>
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>ID</b></td>
                <td align="center"><b>用户名</b></td>
                <td align="center"><b>中奖信息</b></td>
                <td align="center"><b>ip</b></td>
                <td align="center"><b>抽奖时间</b></td>
            </tr>
            {if $rows}
            {section name=i loop=$rows}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$rows[i].id}</td>
                <td align="center">
                    {$rows[i].uname}
                </td>   
                <td align="center">{$rows[i].info}</td>
                <td align="center">{$rows[i].ip}</td>
                <td align="center">{$rows[i].atime|date_format}</td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="5" align="center"><div class="missing">没有什么发现</div></td>
            </tr>
            {/if}
            </table>
        </div>
         {if $total >= 1}
	        <div id="paging" style="width:100%;">
	            <div class="pagingnav">{$paging}</div>
	        </div>
        {/if}
     </div>