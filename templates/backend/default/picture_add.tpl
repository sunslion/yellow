<link type="text/css" rel="stylesheet" href="/templates/backend/default/kindeditor/themes/default/default.css" />
<script type="text/javascript" src="/templates/backend/default/kindeditor/kindeditor-min.js?t=5"></script>
<script type="text/javascript" src="/templates/backend/default/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript">
{literal}
 var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name="description"]', {
					resizeType : 1,
					allowPreviewEmoticons : false,
					allowImageUpload : true,
					uploadJson:'picture.php?m=upload',
					items : ['image']
				});
				
			});
{/literal}
</script>
<style type="text/css">
{literal}
.ke-dialog-body{height:auto!important;}
{/literal}
</style>
 <div id="rightcontent">
    {include file="errmsg.tpl"}
    <div id="right">
    <div align="center">
    <div id="simpleForm">
    <form name="add_picture" method="POST" enctype="multipart/form-data" action="picture.php?m=add">
    <fieldset>
    <legend>Picture Information</legend>
        <label for="title">标题: </label>
        <input type="text" name="title" value="{$picture.title}" class="large"><br>
        
        <label for="keyword">关键词: </label>
        <input type="text" name="keyword" value="{$picture.keyword}" class="large"><br>
        
        <label for="des">简单描述: </label>
        <textarea type="text" name="des" value="{$picture.des}" style="width:50%;height:150px;"></textarea><br>
        
        <label for="category_id">类型: </label>
        <select name="category_id" id="category_id">
        <option value="0">-----</option>
        {section name=i loop=$channels}
        	<option value="{$channels[i].CHID}">{$channels[i].name}</option>
        {/section}
        </select><br>
        
		<label for="keyword" style="margin-right:10px;">图片编辑区: </label>
        <textarea id="description" name="description" style="width:200px;height:400px;visibility:hidden;"></textarea><br>
    </fieldset>
    <div style="text-align: center;">
        <input type="submit" name="add_picture" value="Add picture" class="button">
    </div>
    </form>
    </div>
    </div>
    </div>
 </div>