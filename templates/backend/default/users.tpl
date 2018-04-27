<link type="text/css" rel="stylesheet" href="{$relative_tpl}/css/bootstrap.css" />
<script type="text/javascript" src="/templates/backend/default/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/templates/backend/default/js/bootstrap.min.js?v=20151015"></script>
<!--
<script type="text/javascript">
var send_users ="{$send_users}";
 {literal}
 function sebi(uid){
        var h = (window.screen.availHeight / 4) - ($('#mymessage .modal-dialog').height() / 2);
 		$('#mymessage .modal-dialog').css({'top':h});
 		$('input[name="uid"]').val(uid);
 		$('#mymessage').modal('show');
 }
 $(function(){
 	$('input[name="send_inbox"]').click(function(){
 		var h = (window.screen.availHeight / 4) - ($('#mymessage .modal-dialog').height() / 2);
 		$('#inbox .modal-dialog').css({'top':h});
 		$('input[name="receiver"]').val(send_users);
 		$('#inbox').modal('show');
 	});
 	$('button[name="send_inbox"]').click(function(){
 		var receiver = $.trim($('input[name="receiver"]').val());
 		if(receiver == ''){
 			alert('请问你想发给谁?');
 			return false;
 		}
 		var count = receiver.split(',').length;
 		if(count > 10000){
 			alert('一次性发送不要超过10000');
 			return false;
 		}
 		var subject = $.trim($('input[name="subject"]').val());
 		if(subject == ''){
 			alert('主题不能为空');
 			return false;
 		}
 		var body = $.trim(editor.text());
 		if(body == ''){
 			alert('信息内容不能为空');
 			return false;
 		}
 		body = encodeURIComponent($.trim(editor.html()));
 		$.ajax({
 			type:"post",
 			url:"/ajax/send_email",
 			data:{'receiver':receiver,'subject':subject,'body':body},
 			dataType:"json",
 			cache:false,
 			async:false,
 			success:function(data){
 				if(data){
 					if(data.flag ==1){
 						alert("站内信息已经发送");
 					}else if(data.flag == -1){
 						alert('没有操作本模块的权限!请与管理员联系');
 					}else{
 						alert("站内信发送失败");
 					}
 				}
 				$('#inbox').modal('hide');
 			}
 		});
 	});
 	$('button[name="sebi_ok"]').click(function(){
 		 	var uid = $('input[name="uid"]').val();
 		 	var sebi = parseInt($('input[name="sebi"]').val());
 		 	$.ajax({
 		 			type:"post",
					url:"/ajax/addsebi",
					data:{'uid':uid,'sebi':sebi},
					dataType:"json",
					cache:false,
					async:false,
					success:function(data){
						if(data){
							if(data.flag == 1){
								alert('添加色币成功');
								window.location.reload();
							}else if(data.flag == -1){
 								alert('没有操作本模块的权限!请与管理员联系');
 							}else{
								alert('添加色币失败');
							}
						}
						$('#mymessage').modal('hide');
					}
 		 	});
 	});
 });
{/literal}
</script>
<link type="text/css" rel="stylesheet" href="/templates/backend/default/kindeditor/themes/default/default.css" />
<script type="text/javascript" src="/templates/backend/default/kindeditor/kindeditor-min.js"></script>
<script type="text/javascript" src="/templates/backend/default/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript">
{literal}
 var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name="body"]', {
					resizeType : 1,
					allowPreviewEmoticons : false,
					allowImageUpload : false,
					items : [
						'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
						'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
						'insertunorderedlist', '|', 'emoticons', 'image', 'link']
				});
			});
{/literal}
</script>
-->
<!-- Modal -->
<div class="modal fade" id="mymessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title" id="myModalLabel">给用户添加色币</h4>
      </div>
      <div class="modal-body" style="color:#000;">
            <table width="100%" cellpadding="0" cellspacing="5" border="0" style="background-color:#202020">
            <tr>
                <td style="padding-top:10px;">色币个数：</td><td style="padding-top:10px;"><input type="text" name="sebi" value="" style="color:black;"/></td>
            </tr>
            </table>
      </div>
      <div class="modal-footer">
      	<input type="hidden" name="uid" value=""/>
      	<button type="button" class="btn btn-default" name="sebi_ok">添加色币</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="inbox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" style="width:45%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title" id="myModalLabel">站内信</h4>
      </div>
      <div class="modal-body" style="color:#000;">
      <input type="hidden" name="receiver" value=""/>
            <table width="100%" cellpadding="0" cellspacing="5" border="0" style="background-color:#202020">
            <tr>
            	<td colspan="2">提示:站内信只能发送当前页面显示的对象</td>
            </tr>
            <tr>
                <td style="padding-top:10px;">主题：</td><td style="padding-top:10px;"><input type="text" name="subject" value="" style="color:black;"/></td>
            </tr>
           <tr>
                <td style="padding-top:10px;">信息：</td><td style="padding-top:10px;"><textarea id="body" name="body" style="width:200px;height:200px;visibility:hidden;"></textarea></td>
            </tr>
            </table>
      </div>
      <div class="modal-footer">
      	<input type="hidden" name="uid" value=""/>
      	<button type="button" class="btn btn-default" name="send_inbox">发送信息</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>

 <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
            <form name="search_videos" method="POST" action="users.php?m={$module}">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">Username:</td><td><input type="text" name="username" value="{$option.username}"></td>
                <td align="right">Email:</td><td><input type="text" name="email" value="{$option.email}"></td>
                <td align="right">Country:</td><td><input type="text" name="country" value="{$option.country}"></td>
            </tr>
            <tr>
                
                <td align="right">Gender:</td>
                <td>
                    <select name="gender">
                    <option value=""{if $option.gender == ''} selected="selected"{/if}>------</option>
                    <option value="male"{if $option.gender == 'male'} selected="selected"{/if}>Male</option>
                    <option value="female"{if $option.gender == 'female'} selected="selected"{/if}>Female</option>
                    </select>
                </td>
                <td align="right">Relation:</td>
                <td>
                    <select name="relation">
                    <option value=""{if $option.relation == ''} selected="selected"{/if}>--------</option>
                    <option value="Single"{if $option.relation == 'Single'} selected="selected"{/if}>Single</option>
                    <option value="Taken"{if $option.relation == 'Taken'} selected="selected"{/if}>Taken</option>
                    <option value="Open"{if $option.relation == 'Open'} selected="selected"{/if}>Open</option>
                    </select>
                </td>
                <td align="right">日期区间:</td>
            <td>
                                                   开始:<input id="sdatetimepicker" name="sdate" type="text" value="{$option.sdate}"> -- 结束:<input id="edatetimepicker" name="edate" type="text" value="{$option.edate}"></td>
                <!--<td align="right">Full Name:</td><td><input type="text" name="name" value="{$option.name}"></td>-->
            </tr>
            <tr>
                <td align="right">Sort:</td>
                <td>
                    <select name="sort">
                    <option value="UID"{if $option.sort == 'UID'} selected="selected"{/if}>UID</option>
                    <option value="username"{if $option.sort == 'username'} selected="selected"{/if}>Username</option>
                    <option value="email"{if $option.sort == 'email'} selected="selected"{/if}>Email</option>
                    <option value="addtime"{if $option.sort == 'addtime'} selected="selected"{/if}>Joined</option>
                    <option value="logintime"{if $option.sort == 'logintime'} selected="selected"{/if}>Last Login</option>
                    <option value="country"{if $option.sort == 'country'} selected="selected"{/if}>Country</option>
                    <option value="gender"{if $option.sort == 'gender'} selected="selected"{/if}>Gender</option>
                    <option value="video_viewed"{if $option.sort == 'video_viewed'} selected="selected"{/if}>Videos Viewed</option>
                    <option value="profile_viewed"{if $option.sort == 'profile_viewed'} selected="selected"{/if}>Profile Viewed</option>
                    <option value="watched_video"{if $option.sort == 'watched_video'} selected="selected"{/if}>Watched Videos</option>
                    </select>
                </td>
                <td align="right">Order:</td>
                <td>
                    <select name="order">
                    <option value="DESC"{if $option.order == 'DESC'} selected="selected"{/if}>DESC</option>
                    <option value="ASC"{if $option.order == 'ASC'} selected="selected"{/if}>ASC</option>
                    </select>
                </td>
                <td align="right">Display:</td>
                <td>
                    <select name="display">
                    <option value="10"{if $option.display == '10'} selected="selected"{/if}>10</option>
                    <option value="20"{if $option.display == '20'} selected="selected"{/if}>20</option>
                    <option value="30"{if $option.display == '30'} selected="selected"{/if}>30</option>
                    <option value="40"{if $option.display == '40'} selected="selected"{/if}>40</option>
                    <option value="50"{if $option.display == '50'} selected="selected"{/if}>50</option>
                    <option value="100"{if $option.display == '100'} selected="selected"{/if}>100</option>
                    </select>
                </td>
            </tr>
            <tr>
            <td align="right">产品归属:</td>
            <td align="left">
            	<select name="products">
            	<option value="">请选择</option>
            	{foreach from=$products key=k item=v}
	    		<option value="{$k}" {if $option.products == $k} selected="selected"{/if}>{$v}</option>
			    {/foreach}
			    </select>
            </td>
            <td align="right">是否VIP:</td>
            <td>
            <select name="premium">
              <option value="">请选择</option>
              <option value="1" {if $option.premium == '1'} selected="selected"{/if}>是</option>
              <option value="0" {if $option.premium == '0'} selected="selected"{/if}>否</option>
            </select>
            </td>
            <td align="right"></td>
            <td></td>
            </tr>
            <!--<tr>
            	<td align="right">开户人:</td>
            	<td colspan="5" align="left">
            	<select name="aname">
            	<option value="">请选择</option>
            	<option value="{$admin_name}" {if $option.aname == $admin_name} selected="selected"{/if}>{$admin_name}</option>
            	{foreach from=$admins key=k item=v}
	    		<option value="{$v.name}" {if $option.aname == $v.name} selected="selected"{/if}>{$v.name}</option>
			    {/foreach}
			    </select>
            </td>
            </tr>-->
            <tr>
                <td colspan="6" align="center" valign="bottom">
                    <input type="submit" name="search_videos" value=" -- Search -- " class="button">
                    <input type="reset" name="reset_search" value=" -- Clear -- " class="button">
                    <!--<input type="button" name="send_inbox" value=" -- 站内信 -- " class="button"> 一次性发送不要超过10000-->
                </td>
            </tr>
            </table>
            </form>
        </div>
        {if $total_users >= 1}
        <form name="user_select" method="post" id="user_select" action="">
        <div id="actions">
            <input type="submit" name="a" value="Delete_Multiple" class="action_button" onClick="javascript:return confirm('Are you sure you want to delete all selected users?');">
            <input type="submit" name="a" value="Suspend_Multiple" class="action_button" onClick="javascript:return confirm('Are you sure you want to suspend all selected users?');">
            <input type="submit" name="a" value="Approve_Multiple" class="action_button" onClick="javascript:return confirm('Are you sure you want to approve all selected users?');">
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
                <td align="center"><b>Id</b></td>
                <td align="center"><b>Username</b></td>
                <!--<td align="center"><b>开户人</b></td>-->
                <td align="center"><b>产品归属</b></td>
                <td align="center"><b>是否VIP</b></td>
                <td align="center"><b>等级组</b></td>
                <td align="center"><b>Join/Last Login Date</b></td>
                <td align="center"><b>Videos</b></td>
                <td align="center"><b>Status</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $users}
            {section name=i loop=$users}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center" width="2%"><input name="user_id_checkbox_{$users[i].UID}" id="user_checkbox_{$users[i].UID}" type="checkbox"></td>
                <td align="center">{$users[i].UID}</td>
                <td align="center">
                    <a href="users.php?m=view&UID={$users[i].UID}">{$users[i].username}<br><br>
                    <img src="../media/users/{if $users[i].photo == ''}nopic-{$users[i].gender}.gif{else}{$users[i].photo}{/if}" width="100"></a>
                </td>
                <!--<td align="center">{$users[i].aname}</td>-->
                <td align="center">{$users[i].products}</td>
                <td align="center">{if $users[i].premium > 0}是{else}否{/if}</td>
                
                {assign var="premium" value=$users[i].premium}
                <td align="center">{$user_range[$premium]}</td>
                <td align="center">
                    {$users[i].addtime|date_format}<br>
                    {$users[i].logintime|date_format}
                </td>
                <td align="center">
                {insert name=video_count assign=vdo UID=$users[i].UID}
                Owns: <a href="videos.php?m=all&UID={$users[i].UID}">{$vdo}</a><br>
                Viewed: {$users[i].watched_video}<br>
                Views: {$users[i].video_viewed}<br>
                                                        剩余色币: {$users[i].sebi_surplus|intval}<br>
                </td>
                <td align="center">{$users[i].account_status}</td>
                <td align="center">
                    <a href="users.php?m=view&UID={$users[i].UID}">View</a><br>
                    <a href="users.php?m=edit&UID={$users[i].UID}">Edit</a><br>
                    <a href="users.php?m={$module}{if $page !=''}&page={$page}{/if}&a=delete&UID={$users[i].UID}" onClick="javascript:return confirm('Are you sure you want to delete this user?');">Delete</a><br>
                    {if $users[i].account_status == 'Active'}
                    <a href="users.php?m={$module}{if $page !=''}&page={$page}{/if}&a=suspend&UID={$users[i].UID}" onClick="javascript:return confirm('Are you sure you want to suspend this user?');">Suspend</a>
                    {else}
                    <a href="users.php?m={$module}{if $page !=''}&page={$page}{/if}&a=activate&UID={$users[i].UID}" onClick="javascript:return confirm('Are you sure you want to activate this user?');">Activate</a>
                    {/if}
                    <br>
                    <a href="users.php?m=mail&email={$users[i].email}&username={$users[i].username}">Email</a><br />
                    <a href="users.php?m=deposit&uid={$users[i].UID}">用户存款记录</a><br />
                    <!--{if $users[i].premium == 0}<a href="javascript:" onclick="sebi('{$users[i].UID}');">添加体验币</a>{/if}-->
                </td>
            </tr>
            {/section}
            {else}
            <tr>
                <td colspan="7" align="center"><div class="missing">YOUR SEARCH DID NOT RETURN ANY RESULTS</div></td>
            </tr>
            {/if}
            </table>
            </form>
        </div>
        {if $total_users >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        <div class="pagingnav_clear"></div>
        {/if}                                                            
     </div>
<link rel="stylesheet" type="text/css" href="/templates/backend/default/datetimepicker/jquery.datetimepicker.css"/ >
<script src="/templates/backend/default/datetimepicker/jquery.datetimepicker.js"></script>
<script type="text/javascript">
{literal}
$('#sdatetimepicker').datetimepicker({lang:"ch",format:"Y-m-d",timepicker:false,yearStart:2000,yearEnd:2050,todayButton:true});
$('#edatetimepicker').datetimepicker({lang:"ch",format:"Y-m-d",timepicker:false,yearStart:2000,yearEnd:2050,todayButton:true});
{/literal}
 </script>