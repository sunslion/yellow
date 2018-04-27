<div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
		<form name="editServer" id="editServer" method="post" action="distributeds.php?m=distributed_edit&id={$distributed.id}">
        <fieldset>
        <legend>添加一台服务器</legend>
            <label for="distributeds_id" style="width: 15%;"> 线路选择: </label>			
			<select name="distributeds_id">
			{section name=i loop=$distributeds}
			      <option {if $distributeds[i].distributeds_id===$distributed.distributeds_id} selected="selected"{/if} value="{$distributeds[i].distributeds_id}">{$distributeds[i].gname}</option>
			{/section}
			 </select>
			
			<small>Eg. 游客线</small><br />			
            <label for="ip" style="width: 15%;"> IP: </label>
            <input name="ip" type="text" class="large" value="{$distributed.ip}" /><small>Eg. 127.0.0.1</small><br />
			<label for="region" style="width: 15%;"> 机房区域: </label>
			<input name="region" type="text" class="large" value="{$distributed.region}" /><small>Eg. 纽约机房</small><br />
<label for="url" style="width: 15%;"> URL: </label>
<input name="url" type="text" class="large" value="{$distributed.url}" /><small>Eg. http://s1.domain.com/</small><br />
<label for="httpkey" style="width: 15%;"> HTTPKEY: </label>
<input name="httpkey" type="text" class="large" value="{$distributed.httpkey}" /><small>Eg. 297f44b1395</small><br />
			<label for="vid_min" style="width: 15%;"> VID区域(最小): </label>
			<input name="vid_min" type="text" class="large" value="{$distributed.vid_min}" /><small>Eg. 1</small><br />
			<label for="vid_max" style="width: 15%;"> VID区域(最大): </label>
			<input name="vid_max" type="text" class="large" value="{$distributed.vid_max}" /><small>Eg. 9999</small><br />
      <label style="width: 15%;" for="remark">备注: </label>
      <textarea name="remark">{$distributed.remark}</textarea>		
        </fieldset>
        <div style="text-align: center;">
            <input name="edit_distributed" type="submit" value="-- 添加服务器 --" class="button">
        </div>        
        </form>
        </div>
        </div>
        </div>
     </div>
