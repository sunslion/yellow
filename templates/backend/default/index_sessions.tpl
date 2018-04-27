     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>Sessions Configuration</h2>
        <div id="simpleForm">
        <form name="session_settings" method="POST" action="index.php?m=sessions">
        <fieldset>
        <legend>Session Settings</legend>
            <label for="session_driver">Session Driver: </label>
            <select name="session_driver">
            <!--<option value="files"{if $session_driver == 'files'} selected="selected"{/if}>Files</option>-->
            <option value="Sessions_Database"{if $session_driver == 'Sessions_Database'} selected="selected"{/if}>Database</option>
             <option value="Sessions_Memcache"{if $session_driver == 'Sessions_Memcache'} selected="selected"{/if}>Memcache</option>
            </select><br>
            <label for="session_lifetime">Session Lifetime: </label>
            <input type="text" name="session_lifetime" value="{$session_lifetime}" class="smallplus"><br>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="submit_sessions" value="Update Session Settings" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>