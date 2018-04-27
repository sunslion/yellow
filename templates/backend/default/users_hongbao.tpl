<link type="text/css" rel="stylesheet" href="{$relative_tpl}/css/bootstrap.css" />
<script type="text/javascript" src="/templates/frontend/frontend-default/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/templates/frontend/frontend-default/js/bootstrap.min.js?v=20151015"></script>
<script type="text/javascript">
 {literal}
  function payhongbao(uid){
        var h = (window.screen.availHeight / 4) - ($('#mymessage .modal-dialog').height() / 2);
 		$('#mymessage .modal-dialog').css({'top':h});
 		$('input[name="uid"]').val(uid);
 		$('#mymessage').modal('show');
 }
 $(function(){
 	$('button[name="update_hongbao"]').click(function(){
 		var uid = $('input[name="uid"]').val();
 		var amount = $('input[name="amount_hongbao"]').val();
 		amount = $.trim(amount);
 		if(amount == ''){
 			alert('请输入红包金额');
 			return false;
 		}
 		$.post('/ajax/update_hongbao',{'uid':uid,'amount':amount},function(data){
 			if(data){
 					if(data.flag ==1){
 						alert("扣除成功");
 						$('#mymessage').modal('hide');
 					}else if(data.flag == -1){
 						alert('金额不够扣!');
 					}else{
 						alert("扣除失败");
 					}
 				}
 		},'json');
 	});
 });
 {/literal}
</script>
<!-- Modal -->
<div class="modal fade" id="mymessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title" id="myModalLabel">扣除红包金额</h4>
      </div>
      <div class="modal-body" style="color:#000;">
            <table width="100%" cellpadding="0" cellspacing="5" border="0" style="background-color:#202020">
            <tr>
                <td style="padding-top:10px;">红包金额：</td><td style="padding-top:10px;"><input type="text" name="amount_hongbao" value="" style="color:black;"/></td>
            </tr>
            </table>
      </div>
      <div class="modal-footer">
      	<input type="hidden" name="uid" value=""/>
      	<button type="button" class="btn btn-default" name="update_hongbao">扣除金额</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
 <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
            <form name="search_videos" method="POST" action="users.php?m=hongbao">
            <table width="100%" cellpadding="0" border="0">
            <tr>
                <td align="center">青青草账户：<input type="text" name="username" value="{$option.username}"></td>
                <td align="left"></td>
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
                <td align="center"><b>红包金额</b></td>
                <td align="center"><b>累计金额</b></td>
                <td align="center"><b>扣除金额</b></td>
                <td align="center"><b>IP</b></td>
                <td align="center"><b>领取时间</b></td>
                <td align="center"><b>操作</b></td>
            </tr>
            {if $hongbaos}
            {section name=i loop=$hongbaos}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}" style="height:40px;">
                <td align="center" width="2%"><input name="user_id_checkbox_{$hongbaos[i].id}" id="user_checkbox_{$hongbaos[i].id}" type="checkbox"></td>
                <td align="center">{$hongbaos[i].id}</td>
                <td align="center">
                    {$hongbaos[i].username}
                </td>
                <td align="center">{$hongbaos[i].amount}</td>
                <td align="center">{$hongbaos[i].total}</td>
                <td align="center">{$hongbaos[i].detotal}</td>
                <td align="center">{$hongbaos[i].ip}</td>
                <td align="center">{$hongbaos[i].rtime|date_format}</td>
                <td align="center">
                    <a href="javascript:void(0);" onclick="payhongbao({$hongbaos[i].uid});">扣除红包</a>
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