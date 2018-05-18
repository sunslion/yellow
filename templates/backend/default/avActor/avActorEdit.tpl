<div id="rightcontent">
    {include file="errmsg.tpl"}
    <div id="right">
        <div align="center">
            <div id="simpleForm">
                <form name="add_adv" method="POST" action="avActor.php?m=avActorEdit&AID={$avactor.id}" enctype="multipart/form-data">
                    {if $adv.text != ''}
                        <fieldset>
                            <legend>Preview:</legend>
                            <div style="width: 100%; text-align: center;">{$adv.text}</div>
                        </fieldset>
                    {/if}
                    <fieldset>
                        <legend>修改女优</legend>
                        <input type="hidden" name="AID" value="{$avactor.id}">
                        <label for="orderNum">排序: </label>
                            <input name="orderNum" type="text" value="{$avactor.orderNum}" class="large"><br />
                        <label for="push">是否推荐: </label>
                            <input type="radio" name="push" value="1"{if $avactor.push == 1}checked{/if}> 是
                            <input type="radio" name="push" value="0" {if $avactor.push == 0}checked{/if}> 否 <br />
                        <label for="name">中文姓名: </label>
                            <input name="name" type="text" value="{$avactor.name}" class="large"><br />
                        <label for="japan_name">日文姓名: </label>
                            <input name="japan_name" type="text" value="{$avactor.japan_name}" class="large"><br />
                        <label for="birth_day">出生日期: </label>
                            <input name="birth_day" type="text" value="{$avactor.birth_day}" class="large"><br />
                        <label for="birth_palce">出生地: </label>
                            <input name="birth_palce" type="text" value="{$avactor.birth_palce}" class="large"><br />
                        <label for="agency">经济公司: </label>
                             <input name="agency" type="text" value="{$avactor.agency}" class="large"><br />
                        <label for="blood_type">血型: </label>
                            <input name="blood_type" type="text" value="{$avactor.blood_type}" class="large"><br />
                        <label for="tall">身高: </label>
                            <input name="tall" type="text" value="{$avactor.tall}" class="large"><br />
                        <label for="weight">体重: </label>
                            <input name="weight" type="text" value="{$avactor.weight}" class="large"><br />
                        <label for="size">三围: </label>
                            <input name="size" type="text" value="{$avactor.size}" class="large"><br />
                        <label for="cup_size">罩杯: </label>
                            <input name="cup_size" type="text" value="{$avactor.cup_size}" class="large"><br />
                        <label for="front_avator_img">头像:</label>
                            <input name="front_avator_img" type="text" value="{$avactor.front_avator_img}" class="large"><br />
                            <img src="{$avactor.front_avator_img}" style="width:20%;"/><br/>
                            <a href="{$avactor.front_avator_img}" target="_blank">{$avactor.front_avator_img}</a><br/>
                        {*<label for="avator_img">头像:</label>*}
                            {*<input name="avator_img" type="file"><font style="font-size:12px;margin-left:5px;color:red;" ></font><br>*}
                            {*<img src="{$avactor.avator_img}" style="width:20%;"/><br/>*}
                            {*<a href="{$avactor.avator_img}" target="_blank">{$avactor.avator_img}</a><br/>*}
                    </fieldset>
                    <div style="text-align: center;">
                        <input type="submit" name="edit" value="  编辑女优  " class="button">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="rightcontent">
    {include file="errmsg.tpl"}
    <div id="right">
        <div align="center">
            <div id="simpleForm">
                    {if $adv.text != ''}
                        <fieldset>
                            <legend>Preview:</legend>
                            <div style="width: 100%; text-align: center;">{$adv.text}</div>
                        </fieldset>
                    {/if}
                    <fieldset>
                    <legend>女优专辑</legend>
                        <form name="add_adv" method="POST" action="avActor.php?m=avActorEdit&AID={$avactor.id}" enctype="multipart/form-data">
                            <label for="title">专辑名称: </label>
                                <input name="title" type="text" value=" " class="large"><br />
                            <label for="push">是否推荐: </label>
                                <input type="radio" name="push" value="1" > 是
                                <input type="radio" name="push" value="0" checked > 否 <br />
                            <label for="tag">标签: </label>
                                <input name="tag" type="text" value="" class="large"><br />
                            <label for="details">简介: </label>
                            <textarea rows="3" cols="20" name="details"> </textarea><br />
                            <label for="front_cover_img">封面图像:</label>
                                <input name="front_cover_img" type="text" value="" class="large"><br />
                            {*<label for="cover_img">封面图像:</label>*}
                                {*<input name="cover_img" type="file"><font style="font-size:12px;margin-left:5px;color:red;" ></font><br>*}
                            <div style="text-align: center;">
                                <input type="submit" name="fimgAdd" value="  添加专辑  " class="button">
                            </div>
                        </form>
                    </fieldset>
            </div>
        </div>
    </div>
</div>

<div id="rightcontent">
    {include file="errmsg.tpl"}
    <div id="right">
        <table width="100%" cellspacing="2" cellpadding="3" border="0">
            <tr>
                <td align="center" width="20px"><b>ID</b></td>
                <td align="center"><b>专辑标题</b></td>
                <td align="center"><b>排序</b></td>
                <td align="center"><b>是否推荐</b></td>
                <td align="center"><b>标签</b></td>
                <td align="center"><b>简介</b></td>
                <td align="center" width="400px" ><b>封面图像</b></td>
                <td align="center"><b>操作</b></td>
            </tr>
            {if $avactor_pic}
                {section name=i loop=$avactor_pic}
                    <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                        <td align="center">{$avactor_pic[i].id}</td>
                        <td align="center">{$avactor_pic[i].title}</td>
                        <td align="center">{$avactor_pic[i].orderNum}</td>
                        <td align="center">
                            {if $avactor_pic[i].push == 1}
                                推荐
                            {else}
                                不推荐
                            {/if}
                        </td>
                        <td align="center">{$avactor_pic[i].tag}</td>
                        <td align="center">
                            <textarea rows="3" cols="20" name="details">
                                {$avactor_pic[i].details}
                            </textarea>
                        </td>
                        <td align="center">
                            <img src="{$avactor_pic[i].front_cover_img}" alt="" style="width: 40%" >
                            {*<br/>*}
                            {*<a href="{$avactor_pic[i].avator_img}" target="_blank" >{$avactor_pic[i].avator_img}</a>*}
                        </td>
                        <td align="center">
                            <a href="avActor.php?m=avActorImgEdit&AID={$avactor_pic[i].id}">Edit</a>&nbsp;&nbsp;
                            <a href="javascript:void(0)" onclick="del('{$avactor.id}','{$avactor_pic[i].id}');">删除 </a>
                        </td>
                    </tr>
                {/section}
            {else}
                <tr>
                    <td colspan="8" align="center"><div class="missing">NO ADVERTISE  FOUND</div></td>
                </tr>
            {/if}
        </table>
    </div>
</div>
<script type="text/javascript">
    {literal}
        function del(aid,fid){
            if(confirm('确定要删除？')){
                window.location.href = 'avActor.php?m=avActorEdit&imgDel=imgDel&AID='+aid+'&pic_id='+fid;
            }
        }
    {/literal}
</script>