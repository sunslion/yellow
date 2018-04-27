<div id="rightcontent">
    {include file="errmsg.tpl"}
    <div id="right">
        <div align="center">
            <div id="simpleForm">
                <form name="add_adv" method="POST" action="avActor.php?m=add" enctype="multipart/form-data">
                    {if $adv.text != ''}
                        <fieldset>
                            <legend>Preview:</legend>
                            <div style="width: 100%; text-align: center;">{$adv.text}</div>
                        </fieldset>
                    {/if}
                    <fieldset>
                        <legend>添加女优</legend>
                        <label for="orderby">排序: </label>
                        <input name="orderby" type="text" value="" class="large"><br />
                        <label for="name">中文姓名: </label>
                        <input name="name" type="text" value="" class="large"><br />
                        <label for="japan_name">日文姓名: </label>
                        <input name="japan_name" type="text" value="" class="large"><br />
                        <label for="avator_img">女优头像:</label>
                        <input name="avator_img" type="file"><font style="font-size:12px;margin-left:5px;color:red;" id="avator_img"></font><br>
                        <label for="avdesc_img">介绍照片:</label>
                        <input name="avdesc_img" type="file"><font style="font-size:12px;margin-left:5px;color:red;" id="avdesc_img"></font><br>
                    </fieldset>
                    <div style="text-align: center;">
                        <input type="submit" name="adv_add" value="添加女优" class="button">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>