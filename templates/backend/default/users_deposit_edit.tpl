     <div id="rightcontent">
        {include file="errmsg.tpl"}
        <div id="searchForm">
        <a href="users.php?m=deposit&uid={$uid}" style="background-color:#D4D4D4;padding:6px 15px;border-radius:5px;border-right: 1px solid #bbb;border-bottom: 1px solid #ccc;border-top: 1px solid #ccc;border-left: 1px solid #bbb;font-size:12px;margin-left:20px;font-size:12px;">返回存储记录列表</a>
        </div>
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        <form name="edit_deposit" method="POST" enctype="multipart/form-data" action="users.php?m=deposit_edit&uid={$uid}">
        <fieldset>
        <legend>添加用户存款记录--{$username}({$user_range})</legend>
            <label for="money" style="width:35%;">本次存款金额: </label>
            <input type="text" name="money" class="medium" value="{$deposit.money}"><br><input name="id" type="hidden" value="{$id}" /><input name="edit_deposit" type="hidden" value="edit_deposit" />         
            <label for="isget_sebi" style="width:35%;">是否玩游戏赠送色币: </label>
            <input type="checkbox" name="isget_sebi" {if $deposit.isget_sebi ==1}checked="checked"{/if} value="1" style="box-sizing: border-box;position:relative;top:8px;margin-left:10px;"><br>
            
            <label for="sebi" style="width:35%;">本次存款所得色币: </label>
            <input type="text" name="sebi" value="{$deposit.sebi}" class="medium"/><br>
            
            <label for="get_sebi" style="width:35%;">玩游戏所得色币: </label>
            <input type="text" name="get_sebi" value="{$deposit.get_sebi}" class="medium" /><br>
				
            <label for="dtime" style="width:35%;">存款时间: </label>
            <input type="text" name="dtime" id="dtime" value="{$deposit.dtime|sdate_format}" class="medium"><br>
        </fieldset>
        <div style="text-align: center;">
            <input type="button" name="edit_deposit" value="编辑记录" onclick="check_submit();return false;" class="button">
        </div>
        </form>
        </div>
        </div>
        </div>
     </div>
<link rel="stylesheet" type="text/css" href="/templates/backend/default/datetimepicker/jquery.datetimepicker.css"/ >
<script type="text/javascript" src="/templates/backend/default/js/jquery-1.11.1.min.js"></script>
<script src="/templates/backend/default/datetimepicker/jquery.datetimepicker.js"></script>
<script type="text/javascript">
var rank_range = eval('{$rank_range}');
var rank_scale = eval('{$rank_scale}');
var regNum = /^\d+(\.\d+)?$/;
{literal}
$(function(){
	$('#dtime').datetimepicker({lang:"ch",format:"Y-m-d H:i:s",timepicker:false,yearStart:2000,yearEnd:2050,todayButton:true});
	
	$('input[name="money"]').keyup(function(){
		var cval = $.trim($(this).val());
		cval = parseInt(Math.round(cval));
		$('input[name="sebi"]').val(cval);

		if( $('input[name="isget_sebi"]').is(':checked') ){
			get_sebi();
		}else{
			$('input[name="get_sebi"]').val(0);
		}
	});
	$('input[name="money"]').blur(function(){
		$(this).trigger('keyup');
	});
	$('input[name="isget_sebi"]').click(function(){
		if( $(this).is(':checked')){
			get_sebi();
		}else{
			$('input[name="get_sebi"]').val(0);
		}
	});
});
function get_sebi(){
	var money = parseFloat($.trim($('input[name="money"]').val()));
	if ( !money ){
		$('input[name="isget_sebi"]').removeAttr('checked');
		alert('存款金额不能为空或其他字符,而是数字!');
		return;
	}
	if (rank_range.length > 0){
		var rank_range_arr = rank_range[0];
		var key = 0;
		var gmax = 0;
		$.each(rank_range_arr,function(i,e){
			var min = e[0];
			var max = e[1];
			if( min <= money && max >= money ){
				key = i;
				gmax = e[1];
				return;
			}
		});
		var scale = 0;
		if( rank_scale.length > 0 ){
			var rank_scale_arr = rank_scale[0];
			$.each(rank_scale_arr,function(i,e){
				if(i == key){
					scale = e;
					return;
				}
			});
		}
		var get_sebi = Math.round( money * scale );
		$('input[name="get_sebi"]').val(get_sebi);
	}
}
function check_submit(){
	var money = $.trim($('input[name="money"]').val());
	if (money == ''){
		alert('本次存款金额不能为空');
		return;
	}
	if ( !regNum.test(money) ){
		alert('本次存款金额需填写有效数字');
		return;
	}
	var sebi = $.trim($('input[name="sebi"]').val());
	if (sebi ==''){
		alert('本次存款所得色币不能为空');
		return;
	}
	if (!regNum.test(sebi)){
		alert('本次存款所得色币需填写有效数字');
		return;
	}
	
	if ($('input[name="isget_sebi"]').is(':checked')) {
		var get_sebi = $.trim($('input[name="get_sebi"]').val());
		if (get_sebi ==''){
			alert('玩游戏所得色币不能为空');
			return;
		}
		if (!regNum.test(get_sebi)){
			alert('玩游戏所得色币需填写有效数字');
			return;
		}
	}
	var dtime = $.trim($('#dtime').val());
	if(dtime == ''){
		alert('存款时间不能为空');
		return;
	}
	$('form[name="edit_deposit"]').submit();
}
{/literal}
 </script>