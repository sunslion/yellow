     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
        <div id="right">
            <table width="100%" cellspacing="2" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>ID</b></td>
                <td align="center"><b>所属线路</b></td>
                <td align="center"><b>IP</b></td>
                <td align="center"><b>机房名称</b></td>
                <td align="center"><b>链接</b></td>
                <td align="center"><b>VID区域</b></td>
                <td align="center"><b>添加时间</b></td>
                <td align="center"><b>操作</b></td>
            </tr>
            {if $distributeds}
            {section name=i loop=$distributeds}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$distributeds[i].id}</td>
                <td align="center">{$distributeds[i].distributeds_id}</td>
                <td align="center">{$distributeds[i].ip}</td>
                <td align="center">{$distributeds[i].region}</td>
                <td align="center">{$distributeds[i].url}</td>
                <td align="center"> <!--最小-->大于:{$distributeds[i].vid_min} <!--最大-->小于:{$distributeds[i].vid_max}</td>
                <td align="center"><b>{$distributeds[i].addtime|date_format:"%Y-%m-%d %H:%M"}</b></td>
                <td align="center">
                    <a href="distributeds.php?m=distributed_edit&id={$distributeds[i].id}">改</a><br>
                    <a href="distributeds.php?m=distributed_all&a=delete&id={$distributeds[i].id}">删</a><br>
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