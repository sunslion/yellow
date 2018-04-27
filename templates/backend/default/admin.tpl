 <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
            <form name="search_videos" method="POST" action="admin.php?m={$module}">
            <table width="100%" cellpadding="0" cellspacing="5" border="0">
            <tr>
                <td align="right">Username:</td><td><input type="text" name="name" value="{$option.name}"></td>
                <td align="right">Email:</td><td><input type="text" name="email" value="{$option.email}"></td>
                <td align="right">mobile:</td><td><input type="text" name="mobile" value="{$option.mobile}"></td>
            </tr>
            
            <tr>
                <td align="right">用户组:</td>
                <td>
                    <select name="type">
                    	<option value="0">请选择</option>
                    	{foreach from=$purviews key=k item=v}
                    		<option value="{$k}"{if $option.type == $k} selected="selected"{/if}>{$v}</option>
                    	{/foreach}
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
                <td colspan="6" align="center" valign="bottom">
                    <input type="submit" name="search_admin" value=" -- Search -- " class="button">
                    <input type="reset" name="reset_search" value=" -- Clear -- " class="button">
                </td>
            </tr>
            </table>
            </form>
        </div>
        {if $total_users >= 1}
        <form name="user_select" method="post" id="user_select" action="">
        <!--<div id="actions">
            <input type="submit" name="delete_selected_users" value="Delete" class="action_button" onClick="javascript:return confirm('Are you sure you want to delete all selected users?');">
            <input type="submit" name="suspend_selected_users" value="Suspend" class="action_button" onClick="javascript:return confirm('Are you sure you want to suspend all selected users?');">
            <input type="submit" name="approve_selected_users" value="Approve" class="action_button" onClick="javascript:return confirm('Are you sure you want to approve all selected users?');">
        </div>-->
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
                <td align="center"><b>realname</b></td>
                <td align="center"><b>Email</b></td>
                <td align="center"><b>Mobile</b></td>
                <td align="center"><b>Status</b></td>
                <td align="center"><b>Actions</b></td>
            </tr>
            {if $users}
            {foreach from=$users  item=v}
            <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                <td align="center" width="2%"><input name="user_id_checkbox_{$v.id}" id="user_checkbox_{$v.id}" type="checkbox"></td>
                <td align="center">{$v.id}</td>
                <td align="center">
                    {$v.name}<br>
                </td>
                <td align="center">{$v.realname}</td>
                <td align="center">{$v.email}</td>
                <td align="center">
 					{$v.mobile}
                </td>
                {assign var="ky" value="$v.status"}
                <td align="center">{$act[$v.status]}</td>
                <td align="center">
                    <a href="admin.php?m=edit&id={$v.id}">Edit</a><br>
                    <a href="admin.php?m={$module}{if $page !=''}&page={$page}{/if}&a=delete&id={$v.id}" onClick="javascript:return confirm('Are you sure you want to delete this user?');">Delete</a><br>
                    {if $v.status == '1'}
                    <a href="admin.php?m={$module}{if $page !=''}&page={$page}{/if}&a=suspend&id={$v.id}" onClick="javascript:return confirm('Are you sure you want to suspend this user?');">Suspend</a>
                    {else}
                    <a href="admin.php?m={$module}{if $page !=''}&page={$page}{/if}&a=activate&id={$v.id}" onClick="javascript:return confirm('Are you sure you want to activate this user?');">Activate</a>
                    {/if}
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
        {if $total_users >= 1}
        <div id="paging">
            <div class="pagingnav">{$paging}</div>
        </div>
        <div class="pagingnav_clear"></div>
        {/if}                                                            
     </div>