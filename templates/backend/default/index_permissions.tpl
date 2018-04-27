<link type="text/css" rel="stylesheet" href="{$relative_tpl}/css/bootstrap.css" />
<script type="text/javascript" src="/templates/backend/default/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/templates/backend/default/js/bootstrap.min.js?v=20151015"></script>
<!-- Modal -->
<div class="modal fade" id="loader" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content" style="text-align:center;background-color:white;padding:40px 0;">
      <img src="/templates/backend/default/images/loading.gif" />
    </div>
  </div>
</div>
     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>Permissions Configuration</h2>
        <div id="simpleForm">
        <form name="permissions_settings" method="POST" action="index.php?m=permissions">
        <fieldset>
        <legend style="width:auto;border-bottom:none;">Permission Settings</legend>
            <label for="user_registration" style="width: 40%;">User Registrations: </label>
            <select name="user_registration">
            <option value="1"{if $user_registration == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $user_registration == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="email_verification" style="width: 40%;">Email Verification: </label>
            <select name="email_verification">
            <option value="1"{if $email_verification == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $email_verification == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="video_view" style="width: 40%;">Video Watching: </label>
            <select name="video_view">
            <option value="all"{if $video_view == 'all'} selected="selected"{/if}>All Visitors</option>
            <option value="registered"{if $video_view == 'registered'} selected="selected"{/if}>Registered Members</option>
            </select><br>
            <label for="video_comments" style="width: 40%;">Video Comments: </label>
            <select name="video_comments">
            <option value="1"{if $video_comments == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $video_comments == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="photo_comments" style="width: 40%;">Photo Comments: </label>
            <select name="photo_comments">
            <option value="1"{if $photo_comments == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $photo_comments == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="blog_comments" style="width: 40%;">Blog Comments: </label>
            <select name="blog_comments">
            <option value="1"{if $blog_comments == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $blog_comments == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="wall_comments" style="width: 40%;">Wall Comments: </label>
            <select name="wall_comments">
            <option value="1"{if $video_comments == '1'} selected="selected"{/if}>Yes</option>
            <option value="0"{if $video_comments == '0'} selected="selected"{/if}>No</option>
            </select><br>
            <label for="private_msgs" style="width: 40%;">Private Messaging: </label>
            <select name="private_msgs">
            <option value="all"{if $private_msgs == 'all'} selected="selected"{/if}>All</option>
            <option value="friends"{if $private_msgs == 'friends'} selected="selected"{/if}>Friends</option>
            <option value="disabled"{if $private_msgs == 'disabled'} selected="selected"{/if}>Disabled</option>
            </select><br>
            <label for="video_rate" style="width: 40%;">Video Rating: </label>
            <select name="video_rate">
            <option value="user"{if $video_rate == 'user'} selected="selected"{/if}>User</option>
            <option value="ip"{if $video_rate == 'ip'} selected="selected"{/if}>IP</option>
            </select><br>
            <label for="photo_rate" style="width: 40%;">Photo Rating: </label>
            <select name="photo_rate">
            <option value="user"{if $photo_rate == 'user'} selected="selected"{/if}>User</option>
            <option value="ip"{if $photo_rate == 'ip'} selected="selected"{/if}>IP</option>
            </select><br>
            <label for="game_rate" style="width: 40%;">Game Rating: </label>
            <select name="game_rate">
            <option value="user"{if $game_rate == 'user'} selected="selected"{/if}>User</option>
            <option value="ip"{if $game_rate == 'ip'} selected="selected"{/if}>IP</option>
            </select><br>
			<label for="edit_videos" style="width: 40%;">Edit Videos: </label>
			<select name="edit_videos">
            <option value="0"{if $edit_videos == '0'} selected="selected"{/if}>No</option>
            <option value="1"{if $edit_videos == '1'} selected="selected"{/if}>Yes</option>			
			</select><br />
			<label for="stype" style="width: 40%;">添加用户组: </label>
			<textarea name="purviews" style="margin: 5px 0px 5px 10px; width: 481px; height: 200px;">{$purviews}</textarea>
			<label for="stype" style="width: 60%;">请填写用户组名称，用单竖线(|)分隔</label>
	        </fieldset>
	        <div style="text-align: center;">
	            <input type="submit" name="submit_permissions" value="Update Permission Settings" class="button">
	        </div>
         </form>
         
        <form name="menus_settings" method="POST" action="index.php?m=permissions">
        <fieldset id="menu_permission">
        <legend style="width:auto;border-bottom:none;">Menu Permission Settings</legend>
        	<label for="user_permission" style="width:10%;font-weight:bolder;color:red;margin-right:10px;">用户组: </label>
        	{foreach from=$purview_arr key=k item=v}
        		<label style="position:relative;bottom:2px;width:auto;margin-right:10px;"><input type="radio" name="user_type" value="{$k}"/><font style="position:relative;bottom:3px;">{$v}</font></label>
        	{/foreach}<br/>
        	<label for="user_permission" style="width:10%;font-weight:bolder;color:red;margin-right:10px;">主菜单项:  </label>
        	{foreach from=$menus item=v}
        		<label style="position:relative;bottom:2px;width:auto;margin-right:10px;"><input type="checkbox" name="menus[]" value="{$v}"/><font style="position:relative;bottom:3px;">{$admin_lang[$v]}</font></label>
        	{/foreach}<br/>
        	<label for="user_permission" id="menus_sub_action" style="width:10%;font-weight:bolder;color:red;display:none;">子菜单和功能项:</label><br/>
        	{foreach from=$sub_menus key=k item=v}
        		<div id="menu_{$k}" style="display:none;">
        			<label for="sub_menu" style="width:10%;color:red;">{$admin_lang[$k]}:</label><br/>
        			<div style="margin-left: 70px;margin-bottom:15px;">
        			{foreach from=$v  item=sv}
        				{assign var="key" value="$k.$sv"}
        				{if $admin_lang[$key] != ''}
        				<label style="position:relative;bottom:2px;width:auto;margin-right:25px;"><input type="checkbox" name="menus[{$k}][]" value="{$k}.{$sv}"/>
        				<font style="position:relative;bottom:3px;">{$admin_lang[$key]}</font></label>
        				{/if}
        			{/foreach}
        			<div style="clear:both;"></div>
        			</div>
        			<div style="clear:both;"></div>
        		</div>
        	{/foreach}
        	{foreach from=$sub_menus_action key=k item=v}
        		{foreach from=$v key=sk item=sv}
        			{assign var="key" value="$k.$sk"}
        			<div id="action_[{$key}]" style="display:none;">
	        			<label for="sub_menu_action" style="width:auto;color:red;">{$admin_lang[$k]}-{$admin_lang[$key]}页面功能菜单:</label><br/>
	        			<div style="margin-left: 70px;margin-bottom:15px;">
	        			{foreach from=$sv  item=ssv}
	        				{assign var="skey" value="$key.$ssv"}
	        				<label for="sub_menu_action" style="position:relative;bottom:2px;width:auto;margin-right:25px;"><input type="checkbox" name="menus[{$key}][]" value="{$key}.{$ssv}"/><font style="position:relative;bottom:3px;">{$admin_lang[$skey]}</font></label>
	        			{/foreach}
	        			<div style="clear:both;"></div>
	        			</div>
		        		<div style="clear:both;"></div>
		        		</div>
        		 {/foreach}
		   {/foreach}
	        </fieldset>
	        <div style="text-align: center;">
	            <input type="submit" name="submit_menus" value="Update Menus Settings" class="button">
	        </div>
        </form>
        </div>
        </div>
        </div>
     </div>
     {literal}
     <script type="text/javascript">
     	function in_array(str,arr){
     		var len = arr.length;
     		for(var i=0;i<len;i++){
     			if(str == arr[i])
     				return true;
     		}
     		return false;
     	}
     	$(function(){
     		$('input[name="menus[]"]').click(function(){
     			var ucount = $('input[name="user_type"]:checked').length;
     			if(ucount <= 0){
     				$(this).removeAttr('checked');
     				alert("请选择用户组");
     				return;
     			}
     			var mcount = $('input[name="menus[]"]:checked').length;
     			if(mcount > 0){
     				$('#menus_sub_action').show();
     			}else{
     				$('#menus_sub_action').hide();
     			}
     			var val = $(this).val();
     			var key = 'menu_'+val;
     			var subkey = 'input[name="menus['+val+'][]"]';
     			$(subkey).removeAttr('checked').unbind("click").click(function(){
     				var val = $(this).val();
     				var actionobj = document.getElementById('action_['+val+']');
     				if(actionobj){
     					$(actionobj).toggle();
     				}
     			});
     			var sub_div =  $('#'+key);
     			sub_div.toggle();
     			var subinput = $(sub_div.find('input'));
     			var len = subinput.length;
     			for ( var i = 0;i < len; i++){
     				var val = $( subinput[i] ).val();
     				var key = 'action_['+val+']';
     				var acobj = document.getElementById(key);
     				if(acobj){
     					$(acobj).hide().find('input').removeAttr('checked');
     				}
     			}
     		});
     		
     		$('input[name="user_type"]').click(function(){
     			var type = $(this).val();
     			$('#loader').modal('show').unbind('click');
     			$.post('/siteadmin/index.php',{'m':'get_permissions','user_type':type},function(data){
     				var menus = $('input[name="menus[]"]');
     				var len = menus.length;
     				
     				$(menus).removeAttr('checked');
 					for(var i=0;i<len;i++){
 						var val= $(menus[i]).val();
 						var key = '#menu_'+ val;
 						if(!$(key).is(":hidden")){
 							$(key).hide();
 						}
 						var subkey = 'input[name="menus['+val+'][]"]';
 						var subkeyobj = $(subkey);
 						subkeyobj.removeAttr('checked');
 						var slen = subkeyobj.length;
 						for ( var j = 0; j < slen;j++){
 							var subdivaction = 'action_['+$(subkeyobj[j]).val()+']';
	 						var subactionobj = document.getElementById(subdivaction);
	 						if (subactionobj){
	 							$(subactionobj).hide().find('input').removeAttr('checked');
	 						}
 						}
 					}
 					$('#menus_sub_action').hide();
     				
     				if(data && data.menus){	
     					if(len>0){
     						$('#menus_sub_action').show();
     					}
     					var arr = [];
     					for(var i = 0;i < len;i++){
     						var key = '#menu_'+$(menus[i]).val();
     						$($(key).find('input')).unbind("click").click(function(){
 								var sval = $(this).val();
 								var skey = 'action_['+sval+']';
 								var subactionobj = document.getElementById(skey);
 								if(subactionobj){
 									$(subactionobj).toggle();
 								}
 								
     						});
     						if(in_array($(menus[i]).val(),data.menus)){
     							$(menus[i]).prop('checked','checked');
     							$(key).show();
     						}
     					}
     					if(data && data.submus){
     						var mlen = 	data.menus.length;
     						for(var i=0;i<mlen;i++){
     							var mkey = 'input[name="menus['+data.menus[i]+'][]"]';
     							var submenus = $(mkey);
     							var slen = submenus.length;
     							for(var j = 0;j < slen;j++){
     								var sbval = $(submenus[j]).val();
     								if( in_array( sbval , data.submus ) ){
     									$(submenus[j]).prop('checked','checked');
     									var subakey = 'action_['+sbval+']';
     									var actionDiv = document.getElementById(subakey);
     									if(actionDiv){
     										$(actionDiv).show();
     									}
     								}
     							}
     						}
     						var smlen = data.submus.length;
     						var temp_arr = [];
     						for(var i = 0;i < smlen;i++){
     							var arr =  data.submus[i].split('.');
     							if(arr.length >= 3){
     								var sub_key = arr[0]+'.'+arr[1];
     								var sub_action = 'input[name="menus['+sub_key+'][]"]';
     								if( !in_array(sub_action,temp_arr) ){
     									temp_arr.push(sub_action);
     								}
     							}
     						}
     						var tlen = temp_arr.length;
     						for(var i = 0;i < tlen;i++){
     							var obj_arr = $(temp_arr[i]);
     							var olen = obj_arr.length;
     							for( var j = 0;j < olen;j++){
     								if( in_array($(obj_arr[j]).val(),data.submus) ){
     									$(obj_arr[j]).prop('checked','checked');
     								}
     							}
     						}
     					}
     				}
					$('#loader').modal('hide');
     			},'json');
     		});
     	});
     </script>
     {/literal}