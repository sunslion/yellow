     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
            <form name="search_hd" method="POST" action="hd.php?m=prizes">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
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
                <td align="center"><b>几等奖</b></td>
                <td align="center"><b>中奖信息</b></td>
                 <td align="center"><b>ip</b></td>
                <td align="center"><b>抽奖时间</b></td>
                <td align="center"><b>操作</b></td>
            </tr>
            {if $hds}
            {section name=i loop=$hds}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$hds[i].id}</td>
                <td align="center">
                    {$hds[i].uname}
                </td>
                <td align="center">{$hds[i].prizes}</td>
                <td align="center">{$hds[i].info}</td>
                <td align="center">{$hds[i].ip}</td>
                <td align="center">{$hds[i].ptime|date_format}</td>
                <td align="center">
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">没有什么发现</div></td>
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