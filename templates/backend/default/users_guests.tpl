     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm"> 
        </div>                                                            
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>guests_Id</b></td>
                <td align="center"><b>IP</b></td>
                <td align="center"><b>色币总数</b></td>
                <td align="center"><b>色币消耗总数</b></td>
                <td align="center"><b>最近奖励时间</b></td>
            </tr>
            {if $guests}
            {section name=i loop=$guests}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$guests[i].guest_id}</td>
                <td align="center">{$guests[i].guest_ip}</td>
                <td align="center">{$guests[i].sebi_total}</td>
                <td align="center">{$guests[i].sebi_consume}</td>
                <td align="center"> {$guests[i].last_login|date_format}</td>
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