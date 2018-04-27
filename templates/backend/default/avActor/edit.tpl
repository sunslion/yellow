<div id="rightcontent">
    {include file="errmsg.tpl"}
    <div id="right">
        <div align="center">
            <div id="simpleForm">
                <form name="add_adv" method="POST" action="avActor.php?m=edit" enctype="multipart/form-data">
                    {if $adv.text != ''}
                        <fieldset>
                            <legend>Preview:</legend>
                            <div style="width: 100%; text-align: center;">{$adv.text}</div>
                        </fieldset>
                    {/if}
                    <fieldset>
                        <legend>添加女优</legend>
                        <input type="hidden" name="AID" value="{$avactor.id}">
                        <label for="orderby">排序: </label>
                        <input name="orderby" type="text" value="{$avactor.orderby}" class="large"><br />
                        <label for="name">中文姓名: </label>
                        <input name="name" type="text" value="{$avactor.name}" class="large"><br />
                        <label for="japan_name">日文姓名: </label>
                        <input name="japan_name" type="text" value="{$avactor.japan_name}" class="large"><br />
                        <label for="avator_img">女优头像:</label>
                        <input name="avator_img" type="file"><font style="font-size:12px;margin-left:5px;color:red;" id="avator_img"></font><br>
                        <img src="{$avactor.avator_img}" style="width:600px;"/><br/>
                        <a href="{$avactor.avator_img}" target="_blank">{$avactor.avator_img}</a><br/>
                        <label for="avdesc_img">介绍照片:</label>
                        <input name="avdesc_img" type="file"><font style="font-size:12px;margin-left:5px;color:red;" id="avdesc_img"></font><br>
                        <img src="{$avactor.avdesc_img}" style="width:600px;"/><br/>
                        <a href="{$avactor.avdesc_img}" target="_blank">{$avactor.avdesc_img}</a><br/>
                    </fieldset>
                    <div style="text-align: center;">
                        <input type="submit" name="edit" value="  编辑女优  " class="button">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>