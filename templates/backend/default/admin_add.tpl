     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="add_user" method="POST" enctype="multipart/form-data" action="admin.php?m=add">
        <fieldset>
        <legend>Account Information</legend>
            <label for="realname" style="width:35%;">Realname: </label>
            <input type="text" name="realname" value="{$user.realname}" class="medium"><br>
            
            <label for="name" style="width:35%;">Username: </label>
            <input type="text" name="name" value="{$user.name}" class="medium"><br>
            
            <label for="password" style="width:35%;">Password: </label>
            <input type="password" name="password"><br>
            
            <label for="password_confirm" style="width:35%;">Confirm Password: </label>
            <input type="password" name="password_confirm"><br>
            
            <label for="email" style="width:35%;">Email Address: </label>
            <input type="text" name="email" value="{$user.email}" class="medium"><br>
            
            <label for="mobile" style="width:35%;">Phone Number: </label>
            <input type="text" name="mobile" value="{$user.mobile}" class="medium"><br>
			
			<label for="type" style="width:35%;">用户组: </label>
            <select name="type">
            {foreach from=$purviews key=k item=v}
            	<option value="{$k}"{if $user.type == $k} selected="selected"{/if}>{$v}</option>
            {/foreach}
            </select><br>
			
            <label for="status" style="width:35%;">Account Status: </label>
            <select name="status">
            <option value="1"{if $user.status == '1'} selected="selected"{/if}>启用</option>
            <option value="2"{if $user.status == '2'} selected="selected"{/if}>停用</option>
            </select><br>
            <label for="status" style="width:35%;">当天允许开户数: </label>
            <input type="text" name="vip" value="{$user.vip}" class="small"><br>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="add_admin" value="Add Admin" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>