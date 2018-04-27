<div id="rightcontent">
    {include file="errmsg.tpl"}
    <div id="right">
        <div align="center">
            <div id="simpleForm">
                <form name="add_adv_group" method="POST" action="index.php?m=advzoneadd">
                    <fieldset>
                        <legend>添加广告位置</legend>
                        <label for="adv_width">Name: </label>
                        <input name="name" type="text"/><br>
                        <label for="adv_width">Width: </label>
                        <input name="width" type="text"/><font style="font-size:12px;margin-left:5px;color:red;">*px或%，比如100px或100%</font><br>
                        <label for="adv_height">Height: </label>
                        <input name="height" type="text"/><font style="font-size:12px;margin-left:5px;color:red;">**px或%，比如100px或100%</font><br>
                        <label for="position">显示位置：</label>
                        <label><input type="radio" name="position" value="left"/>靠左浮动</label>
                        <label><input type="radio" name="position" value="right"/>靠右浮动</label>
                        <label><input type="radio" name="position" value="" checked/>正常</label><br/><br/>
                        <label for="position">广告类型：</label>
                        <label><input type="radio" name="ismobile" value="0" checked/>PC端</label>
                        <label><input type="radio" name="ismobile" value="1"/>APP端</label><br/><br/>
                        <label for="position_left_right">靠左或右距离：</label>
                        <input name="position_left_right" type="text"/><font style="font-size:12px;margin-left:5px;color:red;">*加上单位px或%</font><br>
                        <label for="position_top">靠顶距离：</label>
                        <input name="position_top" type="text"/><font style="font-size:12px;margin-left:5px;color:red;">*加上单位px或%</font><br>
                        <label for="position_bottom">靠底距离：</label>
                        <input name="position_bottom" type="text"/><font style="font-size:12px;margin-left:5px;color:red;">*加上单位px或%</font><br>
                        <label style="color:red;width:280px;">*靠顶距离和靠底距离，二填一即可</label>
                    </fieldset>
                    <div style="text-align: center;">
                        <input type="submit" name="add_adv_group" value="Add Advertise Zone" class="button">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    {literal}

    {/literal}
</script>