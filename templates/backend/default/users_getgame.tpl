<link type="text/css" rel="stylesheet" href="{$relative_tpl}/css/bootstrap.css" />
<script type="text/javascript" src="/templates/backend/default/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/templates/backend/default/js/bootstrap.min.js?v=20151015"></script>
<script type="text/javascript">
 {literal}
 $(function(){
	 $('#check_guname').click(function(){
	    var gname = $.trim($('input[name="gname"]').val());
	    if(gname == ''){
	    	alert('游戏账户不能为空');
	    	return false;
	    }
	 	$.post('users.php',{'m':'check_guname','guname':gname},function(d){
	 		if(d && d.flag == 1){
	 			$('#check_guname_result').html('在平台上游戏账户存在，未绑定 ');
	 		}else{
	 			$('#check_guname_result').html(d.msg);
	 		}
	 	},'json');
	 });
 });
 {/literal}
</script>
 <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
            <form name="search_videos" method="POST" action="users.php?m=getgame">
            <table width="100%" cellpadding="0" border="0">
            <tr>
                <td align="center">青青草账户：<input type="text" name="username" value="{$option.username}"></td>
                <td align="left">游戏账户：<input type="text" name="gname" value="{$option.gname}"><input type="button" id="check_guname" class="button" style="margin-left:5px;" value="在平台上检测游戏账户是否存在"/><span id="check_guname_result" style="font-size:14px;color:red;width:280px;"></sapn></td>
            </tr>
            <tr>
                <td colspan="2" align="center" valign="bottom">
                    <input type="submit" name="search_videos" value=" -- Search -- " class="button">
                    <input type="reset" name="reset_search" value=" -- Clear -- " class="button">
                </td>
            </tr>
            </table>
            </form>
        </div>
        {if $total >= 1}
        <form name="user_select" method="post" id="user_select" action="">
        <div id="actions">
            <!--<input type="submit" name="a" value="Delete_Multiple" class="action_button" onClick="javascript:return confirm('Are you sure you want to delete all selected users?');">
            <input type="submit" name="a" value="Suspend_Multiple" class="action_button" onClick="javascript:return confirm('Are you sure you want to suspend all selected users?');">
            <input type="submit" name="a" value="Approve_Multiple" class="action_button" onClick="javascript:return confirm('Are you sure you want to approve all selected users?');">-->
        </div>
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        <div class="pagingnav_clear"></div>
        {/if}                                                            
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr style="height:40px;">
                <td align="center"><b><input name="check_all_users" type="checkbox" id="user_check_all"></b></td>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>Username</b></td>
                <td align="center"><b>游戏账户</b></td>
                <td align="center"><b>产品归属</b></td>
                <td align="center"><b>是否获得色币</b></td>
                <td align="center"><b>等级组</b></td>
                <td align="center"><b>绑定时间</b></td>
            </tr>
            {if $gusers}
            {section name=i loop=$gusers}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}" style="height:40px;">
                <td align="center" width="2%"><input name="user_id_checkbox_{$gusers[i].UID}" id="user_checkbox_{$gusers[i].UID}" type="checkbox"></td>
                <td align="center">{$gusers[i].UID}</td>
                <td align="center">
                    {$gusers[i].username}
                </td>
                <td align="center">{$gusers[i].gusername}</td>
                {assign var="gameid" value=$gusers[i].gameid}
                <td align="center">{$products[$gameid]}</td>
                <td align="center">{if $gusers[i].isgetsebi > 0}是{else}否{/if}</td>
                {assign var="premium" value=$gusers[i].premium}
                <td align="center">{$user_range[$premium]}</td>
                <td align="center">
                    {$gusers[i].btime|date_format}<br>
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="8" align="center"><div class="missing">YOUR SEARCH DID NOT RETURN ANY RESULTS</div></td>
            </tr>
            {/if}
            </table>
            </form>
        </div>
        {if $total >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        <div class="pagingnav_clear"></div>
        {/if}                                                            
     </div>
 <link rel="stylesheet" type="text/css" href="/templates/backend/default/datetimepicker/jquery.datetimepicker.css"/ >

<script src="/templates/backend/default/datetimepicker/jquery.datetimepicker.js"></script>
 <script>
{literal}
$('#sdatetimepicker').datetimepicker({lang:"ch",format:"Y-m-d",timepicker:false,yearStart:2000,yearEnd:2050,todayButton:true});
$('#edatetimepicker').datetimepicker({lang:"ch",format:"Y-m-d",timepicker:false,yearStart:2000,yearEnd:2050,todayButton:true});
{/literal}
 </script>