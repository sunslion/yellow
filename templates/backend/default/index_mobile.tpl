<div id="info"></div>
<script type="text/javascript">
var current_type='faq';
{literal}
function static(type) {
  if(type==current_type) {
	var new_parent='editor_'+type;
	$("#"+new_parent).show();
	var content = $("#area_"+type).val();
	$("#ed_content").val(content);
	return;
  }
  var new_parent='editor_'+type;
  var old_parent='editor_'+current_type;
  var inner = $("#editor_"+current_type).html();
  current_type=type;
  $("#"+old_parent).html('');
  $("#"+new_parent).html(inner);
 
  var content = $("#area_"+type).val();
  $("#ed_content").val(content);
  $("#"+new_parent).show();
  $("#"+old_parent).hide();
}
function update() {
  var cont=$("#ed_content").val();
  $("#area_"+current_type).val(cont);
  $("#editor_"+current_type).hide();
}
{/literal}
</script>

     
     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <h2>Mobile template settings</h2>
        <div id="simpleForm">
        <form name="mobile_settings" id="mobile_settings" method="POST" action="index.php?m=mobile">
	<textarea style="display:none;" id="area_faq" name="area_faq">{$static.faq}</textarea>
	<textarea style="display:none;" id="area_terms" name="area_terms">{$static.terms}</textarea>
	<textarea style="display:none;" id="area_privacy" name="area_privacy">{$static.privacy}</textarea>
	<textarea style="display:none;" id="area_dmca" name="area_dmca">{$static.dmca}</textarea>
        <fieldset>
        <legend>Mobile Configuration</legend>
            <label for="mobile_sitename">Mobile Site Title: </label>
            <input type="text" name="mobile_sitename" class="large" value="{$cnf.mobile_sitename}" />
	    <label for="mobile_sitename_info">&nbsp;</label>
	    <div style="font-size:11px;color:#cc0000;font-weight:bold;margin-left:25px;white-space:nowrap;">Keep site name short. It will appear in top leftcorner.</div><br />
	    <label for="mobile_seo_title">Mobile SEO Title: </label>
            <input type="text" name="mobile_seo_title" class="large" value="{$cnf.mobile_seo_title}" />
            <label for="mobile_seo_description">Mobile SEO Description: </label>
            <input type="text" name="mobile_seo_description" class="large" value="{$cnf.mobile_seo_description}" />
	</fieldset>  
	<fieldset>
        <legend>Mobile Display Settings</legend>
            <label for="mobile_view_limit">Mobile Items per Page: </label>
            <input type="text" name="mobile_view_limit" value="{$cnf.mobile_view_limit}" /><br />
            <label for="mobile_tint">Mobile Template: </label>
            <select name="mobile_tint"><option value="blue" selected="selected">Blue finished</option><option value="red"{if $cnf.mobile_tint == 'red'} selected="selected"{/if}>Red finished</option><option value="red"{if $cnf.mobile_tint == 'green'} selected="selected"{/if}>Green finished</option></select><br />
            <label for="mobile_tint">Display category thumbs: </label>
            <select name="mobile_thumbs"><option value="1" selected="selected">Yes</option><option value="0"{if $$cnf.mobile_thumbs == '0'} selected="selected"{/if}>No</option></select><br />
            <label for="mobile_watch_type">Video watch type: </label>
            <select name="mobile_watch_type"><option value="page" selected="selected">Separate watch video page</option><option value="link"{if $cnf.mobile_watch_type == 'link'} selected="selected"{/if}>Direct fullscreen playback</option></select><br />
            <label for="mobile_watch_player">Watch playback (on separate watch page): </label>
            <select name="mobile_watch_player"><option value="poster" selected="selected">Via poster image</option><option value="html5"{if $cnf.mobile_watch_player == 'html5'} selected="selected"{/if}>Direct HTML5 player</option><option value="link"{if $cnf.mobile_watch_player == 'link'} selected="selected"{/if}>Link to video file</option></select><br />
            <label for="mobile_watch_limit">Watch limit for unlogged users: </label>
            <select name="mobile_watch_limit"><option value="0" selected="selected">No</option><option value="1"{if $cnf.mobile_watch_type == '1'} selected="selected"{/if}>Yes</option></select><br />	
	    <label for="mobile_watch_limit">&nbsp;</label>
	    <table border="0"><tr><td style="font-size:11px;">
		Watch limit for not logged in users is great choice to earn money if you define ad banner in 'mobile_video' ads group.<br />
		We sugegst to use some 250x250px banner then. It will be displayed instead of player then for not logged in users.
	    </td></tr></table>
	</fieldset>
	<fieldset>
        <legend>Mobile Footer Links</legend>
            <label for="mobile_faq">FAQ: </label>
            <select name="mobile_faq"><option value="1" selected="selected">Yes</option><option value="0"{if $$cnf.mobile_faq == '0'} selected="selected"{/if}>No</option></select> <a href="javascript:void(0);" onclick="static('faq')">Edit</a><br />
		{literal}
		<script type="text/javascript">
		$(document).ready(function(){
			$('#ed_content').markItUp(staticSettings);
		});
		</script>
		{/literal}
		<div id="editor_faq" style="display:none;">
		<div id="ed_div">
			<input name="static_page" type="hidden" value="terms" id="static_page" />
			<div id="static_txt_page">
				<textarea id="ed_content" cols="50" rows="20" style="width:97%;"></textarea>
				<input type="button" id="sub_ed" onclick="update();" value="Update" class="button">
			</div>
		</div>
		</div>

            <label for="mobile_terms">Terms and Conditions: </label>
            <select name="mobile_terms"><option value="1" selected="selected">Yes</option><option value="0"{if $$cnf.mobile_terms == '0'} selected="selected"{/if}>No</option></select>  <a href="javascript:void(0);" onclick="static('terms')">Edit</a><br />
            <div id="editor_terms" style="display:none;"></div>
	    <label for="mobile_privacy">Privacy Policy: </label>
            <select name="mobile_privacy"><option value="1" selected="selected">Yes</option><option value="0"{if $$cnf.mobile_privacy == '0'} selected="selected"{/if}>No</option></select>  <a href="javascript:void(0);" onclick="static('privacy')">Edit</a><br />	
            <div id="editor_privacy" style="display:none;"></div>
	    <label for="mobile_dmca">DMCA: </label>
            <select name="mobile_dmca"><option value="1" selected="selected">Yes</option><option value="0"{if $$cnf.mobile_dmca == '0'} selected="selected"{/if}>No</option></select>  <a href="javascript:void(0);" onclick="static('dmca')">Edit</a><br />	
	    <div id="editor_dmca" style="display:none;"></div>
	</fieldset> 
        <div style="text-align: center;">
            <input type="submit" name="submit" value="Update Mobile Settings" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>
