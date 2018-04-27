     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
            <form name="search_novel" method="POST" action="novel.php?m=list">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">排序</td>
                <td>
                    <select name="sort">
                    <option value="VID"{if $option.sort == 'VID'} selected="selected"{/if}>ID</option>
                    <option value="title"{if $option.sort == 'title'} selected="selected"{/if}>小说名</option>
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
                    <input type="submit" name="search_novel" value=" -- 搜索 -- " class="button">
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
                <td align="center"><b>小说标题</b></td>
                <td align="center"><b>小说分类</b></td>
                <td align="center"><b>添加时间</b></td>
                <td align="center"><b>操作</b></td>
            </tr>
            {if $novels}
            {section name=i loop=$novels}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$novels[i].VID}</td>
                <td align="center">
                    <a href="novel.php?m=edit&vid={$novels[i].VID}">{$novels[i].title}</a>
                </td>
                <td align="center">{$novels[i].name}</td>
                <td align="center">{$novels[i].addtime|date_format}</td>
                <td align="center">
                    <a href="novel.php?m=edit&vid={$novels[i].VID}">编辑</a><br>
                    <a href="novel.php?m=del&vid={$novels[i].VID}" onClick="javascript:return confirm('确定要删除此吗?');">删除</a><br>
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">没有发现文章. 点击<a href="novel.php?m=add">这里</a> 添加文章!</div></td>
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