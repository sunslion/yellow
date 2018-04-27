     <div id="rightcontent">
     
     {literal}
     <style type="text/css">
     .guest,.free,.premium{
     	display: block!important;
     	float: left!important;
     	width: 80px!important;
     	margin-top: 1px!important;
     	text-align: left!important;
     }
     </style>
     {/literal}
     
        {include file="errmsg.tpl"}
        <div id="right">
        <div align="center">
        <div id="simpleForm">
        		<form method="post" action="distributeds.php?m=distributeds_add">
                <fieldset>
                <legend>添加分布线路</legend>
        <label for="gname" style="width: 15%;"> 线路名称: </label>
        <input name="gname" type="text" class="large" placeholder="请填写线路名称" id="gname" /><small>Eg. 普通线路</small><br />			
       
                    <label style="width: 15%;"> 权限控制: </label>
                    <div style="display: inline-block;  margin: 5px 0 5px 10px;" class="large">
                    
        <label class="guest" for="guest">Guest:<input type="checkbox" name="permisions[]" id="guest" value="guest"></label>
        <label class="free" for="free">Free:<input type="checkbox" name="permisions[]" id="free" value="free"></label>
        <label class="premium" for="premium">Premium:<input type="checkbox" name="permisions[]" id="premium" value="premium"></label>
                    </div>
                    <br />
        			<label for="server_ip" style="width: 15%;"> 状态: </label>
        			<select name="status">
        			
        			      <option value="0" selected="selected">正常</option>
        			      <option value="1">暂停</option>
        			            </select>
        			            <small>Eg. 正常或暂停</small><br />
        			<label for="ftp_username" style="width: 15%;">备注: </label>
        			<textarea name="remark">请填写备注，仅管理员可见</textarea>		<br />
                </fieldset>
                <div style="text-align: center;">
                    <input name="AddDistributeds" type="submit" value="-- 添加线路 --" class="button">
                </div>        
                </form>
                </div>
        </div>
        </div>
     </div>
