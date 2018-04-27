     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="simpleForm">
                <form name="system_settings" method="POST" action="distributeds.php?m=distributed_config">
                <fieldset>
                <legend>模块配置</legend>
                    <label for="site_name">新视频同步时间: </label>
                    <input type="text" name="synctime" value="{$synctime}" class="large"><br>
        	</fieldset>
<div style="text-align: center;">
                    <input type="submit" name="submit_settings" value="更新模块配置" class="button">
</div>
</form>
</div>