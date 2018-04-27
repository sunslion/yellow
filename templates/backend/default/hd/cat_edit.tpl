<div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="cat_edit" method="POST" enctype="multipart/form-data" action="hd.php?m=cat_edit">
        <input type="hidden" name="id" value="{$id}"/>
        <fieldset>
        <legend>编辑活动类别 / 活动类别</legend>
            <label for="name">活动类别名称: </label>
            <input type="text" name="name" class="large" value="{$row[0]}"><br>
             <label for="picture"></label>
            <input name="hidden" type="hidden">
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="cat_edit" value="编辑活动类别" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>