     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
        <div id="right">
            <table width="100%" cellspacing="2" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>URL</b></td>
                <td align="center"><b>Last Used</b></td>
                <td align="center"><b>Currently Used</b></td>
                <td align="center"><b>Status</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $servers}
            {section name=i loop=$servers}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$servers[i].server_id}</td>
                <td align="center"><a href="servers.php?m=edit&id={$servers[i].server_id}">{$servers[i].url}</a></td>
                <td align="center"><b>{$servers[i].last_used|date_format}</b></td>
                <td align="center"><b>{if $servers[i].current_used == 1}yes{else}no{/if}</b></td>
                <td align="center"><b>{if $servers[i].status == '1'}Active{else}Suspended{/if}</b></td>
                <td align="center">
                    <a href="servers.php?m=edit&id={$servers[i].server_id}">Edit</a><br>
                    <a href="servers.php?m=all&a=delete&id={$servers[i].server_id}">Delete</a><br>
                    {if $servers[i].status == 1}
                    <a href="servers.php?m=all&a=suspend&id={$servers[i].server_id}">Suspend</a><br>
                    {else}
                    <a href="servers.php?m=all&a=activate&id={$servers[i].server_id}">Activate</a><br>
                    {/if}
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">NO SERVERS FOUND. CLICK <a href="servers.php?m=add">HERE</a> TO ADD SERVERS!</div></td>
            </tr>
            {/if}
            </table>
        </div>
     </div>