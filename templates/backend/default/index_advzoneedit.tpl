<div id="rightcontent">
    {include file="errmsg.tpl"}
    <div id="right">
        <div align="center">
            <div id="simpleForm">
                <form name="edit_adv_group" method="POST" action="index.php?m=advzoneedit&AGID={$zone[0].id}">
                    <fieldset>
                        <legend>Editing Zone: {$zone[0].name}</legend>
                        <label for="adv_width">Name: </label>
                        <input name="name" type="text" value="{$zone[0].name}"/><br>
                        <label for="adv_width">Width: </label>
                        <input name="width" type="text" value="{$zone[0].width}"><font style="font-size:12px;margin-left:5px;color:red;">**px或%，比如100px或100%</font><br>
                        <label for="adv_height">Height: </label>
                        <input name="height" type="text" value="{$zone[0].height}"><font style="font-size:12px;margin-left:5px;color:red;">**px或%，比如100px或100%</font><br>
                        <label for="position">显示位置：</label>
                        <label><input type="radio" name="position" value="left" {if $zone[0].position == 'left'}checked{/if}/>靠左浮动</label>
                        <label><input type="radio" name="position" value="right"{if $zone[0].position == 'right'}checked{/if}/>靠右浮动</label>
                        <label><input type="radio" name="position" value="" {if $zone[0].position == ''}checked{/if}/>正常</label><br/><br/>
                        <label for="position">广告类型：</label>
                        <label><input type="radio" name="ismobile" value="0" {if $zone[0].ismobile == 0}checked{/if}/>PC端</label>
                        <label><input type="radio" name="ismobile" value="1" {if $zone[0].ismobile == 1}checked{/if}/>APP端</label><br/><br/>
                        <label for="position_left_right">靠左或右距离：</label>
                        <input name="position_left_right" type="text" value="{$zone[0].position_left_right}"/><font style="font-size:12px;margin-left:5px;color:red;">*加上单位px或%</font><br>
                        <label for="position_top">靠顶距离：</label>
                        <input name="position_top" type="text" value="{$zone[0].position_top}"/><font style="font-size:12px;margin-left:5px;color:red;">*加上单位px或%</font><br>
                        <label for="position_botton">靠底距离：</label>
                        <input name="position_botton" type="text" value="{$zone[0].position_bottom}"/><font style="font-size:12px;margin-left:5px;color:red;">*加上单位px或%</font><br>
                        <label style="color:red;width:280px;">*靠顶距离和靠底距离，二填一即可</label>
                    </fieldset>
                    <div style="text-align: center;">
                        <input type="submit" name="edit_adv_group" value="Update Advertise Zone" class="button">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>