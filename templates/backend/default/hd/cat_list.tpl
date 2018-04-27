     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
        </div>
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>类别名称</b></td>
                <td align="center"><b>添加时间</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $cat_list}
            {section name=i loop=$cat_list}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$cat_list[i].id}</td>
                <td align="center">{$cat_list[i].name}</td>
                <td align="center">{$cat_list[i].atime|date_format}</a></td>
                <td align="center">
                    <a href="hd.php?m=cat_edit&id={$cat_list[i].id}">Edit</a><br>
                    <a href="hd.php?m=cat_del&id={$cat_list[i].id}" onClick="javascript:return confirm('Are you sure you want to delete this channel?');">Delete</a><br>
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">NO CATEGORIES FOUND. CLICK <a href="hd.php?m=cat_add">HERE</a> TO ADD CATEGORIES!</div></td>
            </tr>
            {/if}
            </table>
        </div>
     </div>