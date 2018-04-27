     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
        <div id="right">
            <table width="100%" cellspacing="2" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>ID</b></td>
                <td align="center"><b>线路名称</b></td>
                <td align="center"><b>添加时间</b></td>
                <td align="center"><b>播放权限</b></td>
                <td align="center"><b>线路状态</b></td>
                <td align="center"><b>操作</b></td>
            </tr>
            {if $distributeds}
            {section name=i loop=$distributeds}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$distributeds[i].distributeds_id}</td>
                <td align="center"><a href="distributeds.php?m=distributeds_edit&id={$distributeds[i].distributeds_id}">{$distributeds[i].gname}</a></td>
                <td align="center"><b>{$distributeds[i].addtime|date_format:"%Y-%m-%d %H:%M"}</b></td>
                <td align="center"><b>{$distributeds[i].permisions}</b></td>
                <td align="center"><b>{if $distributeds[i].status==='0'}开启{else}关闭{/if}</b></td>
                <td align="center">
                    <a href="distributeds.php?m=distributeds_edit&id={$distributeds[i].distributeds_id}">改</a><br>
                    <a href="distributeds.php?m=distributeds_all&a=delete&id={$distributeds[i].distributeds_id}">删</a><br>
                    {if $distributeds[i].status==='0'}
                    <a href="distributeds.php?m=distributeds_all&a=off&id={$distributeds[i].distributeds_id}">关闭它</a>
                    {else}
                    <a href="distributeds.php?m=distributeds_all&a=on&id={$distributeds[i].distributeds_id}">开启它</a>
                    {/if}<br>
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">暂时找不到线路，点击 <a href="distributeds.php?m=add">这里</a> 添加一条线路。</div></td>
            </tr>
            {/if}
            </table>
        </div>
     </div>