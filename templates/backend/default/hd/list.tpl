     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
            <form name="search_hd" method="POST" action="hd.php?m=list">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">排序</td>
                <td>
                    <select name="sort">
                    <option value="VID"{if $option.sort == 'VID'} selected="selected"{/if}>ID</option>
                    <option value="title"{if $option.sort == 'title'} selected="selected"{/if}>活动名</option>
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
                <td align="center"><b>活动标题</b></td>
                <td align="center"><b>活动分类</b></td>
                <td align="center"><b>活动开始时间</b></td>
                 <td align="center"><b>活动结束时间</b></td>
                <td align="center"><b>添加时间</b></td>
                <td align="center"><b>操作</b></td>
            </tr>
            {if $hds}
            {section name=i loop=$hds}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$hds[i].id}</td>
                <td align="center">
                    {$hds[i].title}
                </td>
                <td align="center">{$hds[i].name}</td>
                <td align="center">{$hds[i].atime|date_format}</td>
                <td align="center">{$hds[i].etime|date_format}</td>
                <td align="center">{$hds[i].atime|date_format}</td>
                <td align="center">
                    <a href="hd.php?m=edit&id={$hds[i].id}">编辑</a><br>
                    <a href="hd.php?m=del&id={$hds[i].id}" onClick="javascript:return confirm('确定要删除此吗?');">删除</a><br>
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">没有发现活动. 点击<a href="hd.php?m=add">这里</a> 添加活动!</div></td>
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