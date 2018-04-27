{literal}
<link rel="stylesheet" href="/templates/backend/default/kindeditor/themes/default/default.css" />
		<script charset="utf-8" src="/templates/backend/default/kindeditor/kindeditor-min.js"></script>
		<script charset="utf-8" src="/templates/backend/default/kindeditor/lang/zh_CN.js"></script>
		<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name="content"]', {
					resizeType : 1,
					allowPreviewEmoticons : false,
					allowImageUpload : false,
					themeType : 'default'
				});
			});
		</script>
{/literal}	
  <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="edit_novel" method="POST" enctype="multipart/form-data" action="novel.php?m=edit">
        <fieldset>
        <legend>添加小说 / 小说</legend>
            <label for="title">标题: </label>
            <input type="text" name="title" class="large" value="{$novel.title}"><br>
            <label for="content">内容: </label>
            <textarea name="content" style="width:500px;height:400px;visibility:hidden;">{$novel.content}</textarea><br>
            <label for="category">小说分类: </label>
            <select name="category">
            <option value="">请选择分类</option>
            {section name=i loop=$categories}
            <option {if $categories[i].CHID == $novel.category_id}selected{/if}  value="{$categories[i].CHID}">{$categories[i].name}</option>
            {/section}
            <br>
             <label for="picture"></label>
            <input name="vid" type="hidden" value="{$vid}">
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="edit_novel" value="修改小说" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>