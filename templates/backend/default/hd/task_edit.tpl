<div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form method="POST" enctype="multipart/form-data" action="hd.php?m=task_edit&id={$id}">
        <input type="hidden" name="id" value="{$id}"/>
        <fieldset>
        <legend>编辑任务</legend>
            <label for="title">任务标题: </label>
            <input type="text" name="tname" class="large" value="{$row.tname}"><br>
            <fieldset id="task">
        	<legend>成立条件</legend>
        	<div>
        	{foreach from=$condition key="ck" item="cv"}
        		{if $ck > 0}
        		<div>
        			<label for="context" style="display:inline;float:none;">条件连接:</label>
		            <select name="task[{$ck}][task_join]">
		            {foreach from=$task_join key="k" item="v"}
		            <option value="{$k}" {if $k==$cv.task_join}selected{/if}>{$v}</option>
		            {/foreach}
		            </select><br/>
        		{/if}
	            <label for="task_type" style="display:inline;float:none;width:80px;margin:0 5px;">条件类型:</label>
	            <select name="task[{$ck}][task_type]">
	            {foreach from=$task_type key="k" item="v"}
	            <option value="{$k}" {if $k==$cv.task_type}selected{/if}>{$v}</option>
	            {/foreach}
	            </select>
	            <label for="task_sign" style="display:inline;float:none;margin:0 5px;">成立条件:</label>
	            <select name="task[{$ck}][task_sign]">
	            {foreach from=$task_sign key="k" item="v"}
	            <option value="{$k}" {if $k==$cv.task_sign}selected{/if}>{$v}</option>
	            {/foreach}
	            </select>
	            <label for="credit" style="display:inline;float:none;margin:0 5px;">条件额度:</label>
	            <input type="text" name="task[{$ck}][credit]" value="{$cv.credit}" style="margin:12px;"/>
	            <label for="context" style="display:inline;float:none;margin:0 5px;">是否首存?:</label>
	            <select name="task[{$ck}][task_isfirst]">
	            	<option value="0" {if $cv.task_isfirst == 0}selected{/if}>否</option>
	            	<option value="1" {if $cv.task_isfirst == 1}selected{/if}>是</option>
	            </select>
	            {if $ck == 0}
	            <a href="javascript:void(0);" onclick="add(this);" style="margin-left:5px;"><img style="border:0;" src="/templates/backend/default/images/icons/add.png"/></a><a href="javascript:void(0);" onclick="remove(this);" style="margin-left:10px;"><img style="border:0;" src="/templates/backend/default/images/icons/remove.png"/></a>
	            {/if}
	            {if $ck > 0}</div>{/if}
            {/foreach}
            </div>
            </fieldset>
           	<label for="prize">奖品描述: </label>
            <input type="text" name="prize" class="large" value="{$row.prize}"><br>
            <label for="isshow">是否显示: </label>
            <input name="isshow" id="isshow" type="checkbox" style="margin-top:12px;" {if $row.isshow == 1}checked{/if} value="1"/><br>
            <label for="order" style="display:inline;float:none;margin:0 5px;">显示排序:</label>
            <input type="text" name="order" style="margin:12px;" value="{$row.order}"/><br/>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="edit_task" value="编辑任务" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>
<script type="text/javascript" src="/templates/frontend/frontend-default/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript">
var task_type = eval('{$task_type_json}');
var task_sign = eval('{$task_sign_json}');
var task_join = eval('{$task_join_json}');
var index = 1;
{literal}
	function createLabel(lcss,lhtml){
		var label = $('<label />');
		label.css(lcss);
		label.html(lhtml);
		return label;
	}
	function createSelect(sname,soption){
		var select = $('<select />');
		select.attr('name',sname);
		var fragment = document.createDocumentFragment();
		if(soption.length > 0){
			$.each(soption[0],function(i,j){
				var option = $('<option />');
				option.val(i).html(j);
				fragment.append(option[0])
			});
		}
		select.html(fragment);
		return select;
	}
	function remove(obj){
		var parent = $(obj).parent();
		var divs = parent.find('div');
		var len = divs.length;
		if(len > 0){
			$(divs[len-1]).remove();
			index--;
		}else{
			index = 0;
			alert('添加的条件已经删除完毕');
		}
	}
	function add(obj){
		index = $(obj).parent().find('div').length;
		index++;
		var fragment = document.createDocumentFragment();
		var lable_join =createLabel({'display':'inline','float':'none','margin':'0 5px'},'条件连接:');
		fragment.append(lable_join[0]);
		var select_join = createSelect('task['+index+'][task_join]',task_join);
		fragment.append(select_join[0]);
		fragment.append($("<br />")[0]);
		
		var label_type = createLabel({'display':'inline','float':'none','width':'80px','margin':'0 7px'},'条件类型:');
		fragment.append(label_type[0]);
		var select_type = createSelect('task['+index+'][task_type]',task_type);
		fragment.append(select_type[0]);
		
		var lable_sign = createLabel({'display':'inline','float':'none','margin':'0 9px'},'成立条件:');
		fragment.append(lable_sign[0]);
		var select_sign = createSelect('task['+index+'][task_sign]',task_sign);
		fragment.append(select_sign[0]);
		
		var lable_credit = createLabel({'display':'inline','float':'none','margin':'0 9px'},'条件额度:');
		fragment.append(lable_credit[0]);
		var input = $('<input />');
		input.attr({'name':'task['+index+'][credit]','type':'text'}).css({'margin':'12px'});
		fragment.append(input[0]);
		
		var lable_isfirst = createLabel({'display':'inline','float':'none','margin':'9px'},'是否首存?:');
		fragment.append(lable_isfirst[0]);
		var select_isfirst = createSelect('task['+index+'][task_isfirst]',[{'0':'否','1':'是'}]);
		fragment.append(select_isfirst[0]);
		
		var div = $('<div />');
		div.html(fragment);
		$(obj).parent().append(div);
	}
{/literal}
</script>