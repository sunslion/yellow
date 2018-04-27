  {literal}
<script type="text/javascript" src="/templates/frontend/frontend-default/js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" href="/templates/backend/default/kindeditor/themes/default/default.css" />
<script charset="utf-8" src="/templates/backend/default/kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="/templates/backend/default/kindeditor/lang/zh_CN.js"></script>
		<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name="context"]', {
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
        <form name="edit_hd" method="POST" enctype="multipart/form-data" action="hd.php?m=edit">
        <input type="hidden" value="{$id}" name="id"/>
        <fieldset>
        <legend>修改活动 / 活动</legend>
            <label for="title">标题: </label>
            <input type="text" name="title" class="large" value="{$hd.title}"><br>
            <label for="title">URL: </label>
            <input type="text" name="url" class="large" value="{$hd.url}"><font style="font-size:13px;margin-left:5px;color:red;">外部链接地址，不填写系统自动产生路径</font><br><br>
            <label for="current">Current Image: </label>
            <img src="/media/hd/{$hd.id}.jpg?{0|rand:100}" style="margin-left: 1%;"><br>
            <label for="picture">Category Image: </label>
            <input name="img" type="file"><font style="font-size:13px;margin-left:5px;color:red;">适合尺寸:220px*130px</font><br>
            <label for="title">是否热门: </label>
            <input type="checkbox" name="ispopular" value="1" style="margin:12px;" {if $hd.ispopular == 1}checked{/if}/><br>
            <label for="context">内容: </label>
            <textarea name="context" style="width:500px;height:600px;visibility:hidden;">{$hd.context}</textarea><br>
           	<label for="title">keyword: </label>
            <input type="text" name="keyword" class="large" value="{$hd.keyword}"><font style="font-size:13px;margin-left:5px">多个用逗号(,)分隔，如AA,BB</font><br>
            <label for="category">活动分类: </label>
            <select name="cid">
            <option value="0">请选择分类</option>
            {section name=i loop=$categories}
            <option value="{$categories[i].id}" {if $categories[i].id == $hd.cid}selected{/if}>{$categories[i].name}</option>
            {/section}
            </select><br/>
            <label for="category">开始时间: </label>
            <input id="sdatetimepicker" name="stime" type="text" value="{$hd.stime|date_format}"><br/>
            <label for="category">结束时间: </label>
            <input id="edatetimepicker" name="etime" type="text" value="{$hd.etime|date_format}"><br/>
             <label for="picture"></label>
            <input name="hidden" type="hidden">
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="edit_hd" value="修改活动" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>
<link rel="stylesheet" type="text/css" href="/templates/backend/default/datetimepicker/jquery.datetimepicker.css"/ >
<script src="/templates/backend/default/datetimepicker/jquery.datetimepicker.js"></script>
 <script>
{literal}
$('#sdatetimepicker').datetimepicker({lang:"ch",format:"Y-m-d",timepicker:false,yearStart:2000,yearEnd:2050,todayButton:true});
$('#edatetimepicker').datetimepicker({lang:"ch",format:"Y-m-d",timepicker:false,yearStart:2000,yearEnd:2050,todayButton:true});
{/literal}
 </script>