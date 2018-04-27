     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="add_channel" method="POST" enctype="multipart/form-data" action="channels.php?m=add">
        <fieldset>
        <legend>Add Video / Album Category</legend>
            <label for="name">Category Name: </label>
            <input type="text" name="name" value="{$channel.name}" class="large"><br>
	    <label for="parentid">Parent Category: </label><select name="parentid"  class="inwidth1" id="select">
            <option value="-1" selected="selected">请选择上级分类</option>
			<option value="0">一级分类</option>
		{section name=i loop=$categories}
            <option value="{$categories[i].CHID}">{$categories[i].name|escape:'html'}</option>
            {/section}
	</select><br>
            <label for="picture">Category Image: </label>
            <input name="picture" type="file"><br>
            <label for="sort">排序：</label>
            <input type="text" name="sort" value="{$channel[0].sort}"/>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="add_channel" value="Add Category" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>