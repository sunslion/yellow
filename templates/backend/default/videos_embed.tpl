     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="embedVideo" method="POST" enctype="multipart/form-data" action="videos.php?m=embed">
        <fieldset>
        <legend>Embed Video</legend>
            <label for="title">Title: </label>
            <input name="title" type="text" value="{$video.title|escape:'html'}" class="large"><br />
            <label for="category">Category: </label>
            <select name="category">
            {section name=i loop=$categories}
            <option value="{$categories[i].CHID}"{if $video.category == $categories[i].CHID} selected="selected"{/if}>{$categories[i].name|escape:'html'}</option>
            {/section}
            </select><br>
            <label for="ipod_filename">CK视频地址: </label>
            <input name="ipod_filename" type="text" value="{$video.ipod_filename|escape:'html'}" class="large" style="width:75%;"><br />
            <label for="ybPlayUrl">优播视频地址: </label>
            <input name="ybPlayUrl" type="text" value="{$video.ybPlayUrl|escape:'html'}" class="large" style="width:75%;"><br />
            <label for="pic">图片地址: </label>
            <input name="pic" type="text" value="{$video.pic|escape:'html'}" class="large"><br />
            <label for="tags">Tags: </label>
            <textarea name="tags" rows="6">{$video.tags|escape:'html'}</textarea><br>
            <label for="type">Type: </label>
            <select name="type">
            <option value="public"{if $video.type == 'public'} selected="selected"{/if}>public</option>
            <option value="private"{if $video.type == 'private'} selected="selected"{/if}>private</option>
            </select><br>
        </fieldset>
        <div style="text-align: center;">
            <input name="embed_video" type="submit" value="-- Embed Video --" id="save_video_button" class="button" onClick="document.getElementById('save_video_button').value='-- Embedding... --'";>
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>
