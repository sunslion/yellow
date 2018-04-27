     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="add_adv" method="POST" action="index.php?m=new_advsadd" enctype="multipart/form-data">
        {if $adv.text != ''}
        <fieldset>
        <legend>Preview:</legend>
        <div style="width: 100%; text-align: center;">{$adv.text}</div>
        </fieldset>
        {/if}
        <fieldset>
        <legend>Add Advertise</legend>
            <label for="group">Advertise Zone: </label>
            <select name="zone_id">
            <option value="0"{if $adv.group == '0'} selected="selected"{/if}>Select Advertise Zone</option>
            {section name=i loop=$advzones}
            <option value="{$advzones[i].id}"{if $adv.zone_id == $advzones[i].id} selected="selected"{/if}>{$advzones[i].name}</option>
            {/section}
            </select><br>
			 <label for="name">Name: </label>
            <input name="name" type="text" value="{$adv.name}" class="large"><br />
            <label for="desc">Description: </label>
            <input name="title" type="text" value="{$adv.title}" class="large"><br />
            <label for="url">Url: </label>
            <input name="url" type="text" value="{$adv.url}" class="large"><br />
            <label for="video">Image: </label>
            <input name="media" type="text" value="{$adv.media}" class="large"><br />
          	<label for="relogo">广告图片:</label>
			<input name="relogopic" type="file"><font style="font-size:12px;margin-left:5px;color:red;" id="upload_msg"></font><br>
			
			<label for="margin">图片距上:</label>
          	<input name="margin[]" type="text" value="" class="small"><br />
          	<label for="margin">图片距右:</label>
          	<input name="margin[]" type="text" value="" class="small"><br />
          	<label for="margin">图片距下:</label>
          	<input name="margin[]" type="text" value="" class="small"><br />
          	<label for="margin">图片距左:</label>
          	<input name="margin[]" type="text" value="" class="small"><br />
            <label for="position">是否固定：</label>
            <label><input type="radio" name="isFix" value="0" checked />不固定</label>
            <label><input type="radio" name="isFix" value="1"  />固定</label><br/><br/>
			<label for="orderby">排序:</label>
			<input name="orderby" type="text"/><br/>
        </fieldset>
        <div style="text-align: center;">
            <input type="submit" name="adv_add" value="Add Advertise" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>
     <script type="text/javascript">
     		var zones = eval('{$zones}');
     		 {literal}
     		 	$(function(){
     		 		function getMsg(index,str){
     		 			var msg = {
	     		 			'%':'%s%按%j%计算',
	     		 			'auto':'%s%为自动'
     		 			};
     		 			var names = ['宽度','高度'];
     		 			var s = '';
     		 			$.each(msg,function(i,j){
     		 				if(str.indexOf(i)>=0){
     		 					s = j.replace('%s%',names[index]);
     		 					if(parseInt(str) > 0){
     		 						s = s.replace('%j%',str);
     		 					}
     		 				}
     		 			});
     		 			if(s)
     		 				return s;
     		 			else
     		 				return names[index]+'为：'+str+'px';
     		 		}

     		 		
     		 		$('select[name="zone_id"]').change(function(){
     		 			var id = $(this).val();
     		 			if(zones && zones.length>0){
     		 				var zone = zones[0];
     		 				if(zone && id != 0){
     		 					var arr = zone[id].split(',');
     		 					var str = '';
     		 					if(arr){
     		 						if(arr[0])
     		 							str += getMsg(0,arr[0])+'，';
     		 						if(arr[1])
     		 							str += getMsg(1,arr[1]);	
     		 					}
     		 					$('#upload_msg').html('上传图片尺寸说明：'+str);
     		 				}else
     		 					$('#upload_msg').html('');
     		 			}
     		 		});
     		 	});
     		 {/literal}
     </script>