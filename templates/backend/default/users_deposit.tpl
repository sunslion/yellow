 <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
            <form name="search_deposit" method="POST" action="users.php?m=deposit&uid={$uid}">
            <table width="100%" cellpadding="0" cellspacing="5" border="0"> 
            <tr>
            	<td align="right"><a name="add_deposit" href="users.php?m=all" style="background-color:#D4D4D4;padding:6px 20px;border-radius:8px;border-right: 1px solid #bbb;border-bottom: 1px solid #ccc;border-top: 1px solid #ccc;border-left: 1px solid #bbb;margin-right:10px;">-- 返回用户列表页 --</a><a name="add_deposit" href="users.php?m=deposit_add&uid={$uid}" style="background-color:#D4D4D4;padding:6px 20px;border-radius:8px;border-right: 1px solid #bbb;border-bottom: 1px solid #ccc;border-top: 1px solid #ccc;border-left: 1px solid #bbb;">-- 添加记录 --</a></td>
            	<td align="right">存款总额:<font style="color:red;">{$money}</font>元 </td>
            	<td align="center">存款得到的色币总数:<font style="color:red;">{$dsebi}</font>个</td>
            	<td align="left">玩游戏奖励色币:<font style="color:red;">{$psebi}</font>个</td>
            	<td align="left">总色币数:<font style="color:red;">{$tsebi}</font>个</td>
            	<td></td>
            	<td></td>
            	<td></td>
            </tr>
            <tr>
            	<td align="right">是否是游戏后赠送的色币:<input type="checkbox" name="isget_sebi" value="1" {if $option.isget_sebi == 1}checked="checked"{/if}/></td>
                <td align="left" style="width:38%;">存款日期:开始:<input id="sdatetimepicker" name="sdate" type="text" value="{$option.sdate}"> -- 结束:<input id="edatetimepicker" name="edate" type="text" value="{$option.edate}"></td>
                <td align="left">Order:<select name="order">
                    <option value="DESC"{if $option.order == 'DESC'} selected="selected"{/if}>DESC</option>
                    <option value="ASC"{if $option.order == 'ASC'} selected="selected"{/if}>ASC</option>
                    </select></td>
               <td align="left">Display:<select name="display">
                    <option value="10"{if $option.display == '10'} selected="selected"{/if}>10</option>
                    <option value="20"{if $option.display == '20'} selected="selected"{/if}>20</option>
                    <option value="30"{if $option.display == '30'} selected="selected"{/if}>30</option>
                    <option value="40"{if $option.display == '40'} selected="selected"{/if}>40</option>
                    <option value="50"{if $option.display == '50'} selected="selected"{/if}>50</option>
                    <option value="100"{if $option.display == '100'} selected="selected"{/if}>100</option>
                    </select></td>
                <td></td>
            	<td></td>
            	<td></td>
                <td></td>
            </tr>
   
            <tr>
                <td colspan="6" align="center" valign="bottom">
                    <input type="submit" name="search_deposit" value=" -- Search -- " class="button">
                    <input type="reset" name="reset_search" value=" -- Clear -- " class="button">
                </td>
            </tr>
            </table>
            </form>
        </div>
        {if $total >= 1}
        <form name="user_select" method="post" id="user_select" action="">
        <div id="actions">用户：{$username}
            <!--<input type="submit" name="delete_selected_users" value="Delete" class="action_button" onClick="javascript:return confirm('Are you sure you want to delete all selected users?');">
            <input type="submit" name="suspend_selected_users" value="Suspend" class="action_button" onClick="javascript:return confirm('Are you sure you want to suspend all selected users?');">
            <input type="submit" name="approve_selected_users" value="Approve" class="action_button" onClick="javascript:return confirm('Are you sure you want to approve all selected users?');">-->
        </div>
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        <div class="pagingnav_clear"></div>
        {/if}                                                            
        <div id="right">
            <table width="100%" cellspacing="1" cellpadding="3" border="0">
            <tr>
                <td align="center"><b><input name="check_all_users" type="checkbox" id="user_check_all"></b></td>
                <td align="center"><b>添加日期</b></td>
                <td align="center"><b>存款日期</b></td>
                <td align="center"><b>本次存款额度</b></td>
                <td align="center"><b>是否玩游戏赠送</b></td>
                <td align="center"><b>本次所得色币</b></td>
                <td align="center"><b>玩游戏获得的赠送色币</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $deposits}
            {foreach from=$deposits  item=v}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center" width="2%"><input name="user_id_checkbox_{$v.id}" id="user_checkbox_{$v.id}" type="checkbox"></td>
                <td align="center">{$v.atime|sdate_format}<br></td>
                <td align="center">{$v.dtime|sdate_format}</td>
                <td align="center">{$v.money}元</td>
                 <td align="center">{if $v.isget_sebi == 1}是{else /}否{/if}</td>
                <td align="center">{$v.sebi}个</td>
                <td align="center">{$v.get_sebi}个</td>
                <td align="center">
                    <a href="users.php?m=deposit_edit&id={$v.id}">Edit</a><br>
                    <a href="users.php?m=deposit&a=delete&id={$v.id}" onClick="javascript:return confirm('Are you sure you want to delete this it?');">Delete</a><br>
                </td>
            </tr>
            {/foreach}
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
<script type="text/javascript" src="/templates/backend/default/js/jquery-1.11.1.min.js"></script>
<script src="/templates/backend/default/datetimepicker/jquery.datetimepicker.js"></script>
<script type="text/javascript">
{literal}
$('#sdatetimepicker').datetimepicker({lang:"ch",format:"Y-m-d",timepicker:false,yearStart:2000,yearEnd:2050,todayButton:false});
$('#edatetimepicker').datetimepicker({lang:"ch",format:"Y-m-d",timepicker:false,yearStart:2000,yearEnd:2050,todayButton:false});
{/literal}
 </script>