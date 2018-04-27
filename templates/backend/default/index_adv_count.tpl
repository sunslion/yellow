     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
            <form name="search_adv_count" method="POST" action="index.php?m=adv_count">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">排序</td>
                <td>
                    <select name="sort">
                    <option value="advid"{if $option.sort == 'advid'} selected="selected"{/if}>广告ID</option>
                    <option value="count"{if $option.sort == 'count'} selected="selected"{/if}>统计量</option>
                    </select>
                </td>
                <td align="right">日期</td>
                <td>
                <link rel="stylesheet" type="text/css" href="/templates/backend/default/datetimepicker/jquery.datetimepicker.css"/ >
				<script src="/templates/backend/default/datetimepicker/jquery.js"></script>
				<script src="/templates/backend/default/datetimepicker/jquery.datetimepicker.js"></script>
                <input id="datetimepicker" name="date" type="text" value="{$date}">
                </td>
                <td align="right">规则(正排/倒排)</td>
                <td>
                    <select name="order">
                    <option value="DESC"{if $option.order == 'DESC'} selected="selected"{/if}>DESC</option>
                    <option value="ASC"{if $option.order == 'ASC'} selected="selected"{/if}>ASC</option>
                    </select>
                </td>
                <td colspan="2" align="center">
                    <input type="submit" name="search_adv_count" value=" -- 搜索 -- " class="button">
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
            <table width="100%" cellspacing="2" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>ADVId</b></td>
                <td align="center"><b>广告标题</b></td>
                <td align="center"><b>广告位名称</b></td>
                <td align="center"><b>点击数量</b></td>
                <td align="center"><b>日期</b></td>
            </tr>
            {if $advcounts}
            {section name=i loop=$advcounts}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center">{$advcounts[i].advid}</td>
                <td align="center">{$advcounts[i].title}</td>
                <td align="center">{$advcounts[i].zone_name}</td>
				<td align="center"><b>{$advcounts[i].count}</b></td>
                <td align="center">
                    {$advcounts[i].date|date_format}
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">NO ADVERTISE ZONE FOUND</div></td>
            </tr>
            {/if}
            </table>
        </div>
     </div>