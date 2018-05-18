<div id="rightcontent">
    {include file="errmsg.tpl"}
    <div id="right">
        <div align="center">
            <div id="simpleForm">
                <form name="add_adv" method="POST" action="avActor.php?m=avActorImgEdit&AID={$avactor_fpic.id}" enctype="multipart/form-data">
                    {if $adv.text != ''}
                        <fieldset>
                            <legend>Preview:</legend>
                            <div style="width: 100%; text-align: center;">{$adv.text}</div>
                        </fieldset>
                    {/if}
                    <fieldset>
                        <legend>女优专辑</legend>
                        <label for="title">专辑名称: </label>
                            <input name="title" type="text" value="{$avactor_fpic.title}" class="large"><br />
                        <label for="orderNum">排序: </label>
                            <input name="orderNum" type="text" value="{$avactor_fpic.orderNum}" class="large"><br />
                        <label for="push">是否推荐: </label>
                             <input type="radio" name="push" value="1"{if $avactor_fpic.push == 1}checked{/if}> 是
                             <input type="radio" name="push" value="0" {if $avactor_fpic.push == 0}checked{/if}> 否 <br />
                        <label for="tag">标签: </label>
                            <input name="tag" type="text" value="{$avactor_fpic.tag}" class="large"><br />
                        <label for="details">简介: </label>
                             <textarea rows="3" cols="20" name="details">{$avactor_fpic.details}</textarea><br />
                        <label for="front_cover_img">封面图: </label>
                            <input name="front_cover_img" type="text" value="{$avactor_fpic.front_cover_img}" class="large"><br />
                            <img src="{$avactor_fpic.front_cover_img}" style="width:20%;"/><br/>
                            <a href="{$avactor_fpic.front_cover_img}" target="_blank">{$avactor_fpic.front_cover_img}</a><br/>
                        {*<label for="cover_img">封面图像:</label>*}
                            {*<input name="cover_img" type="file"><font style="font-size:12px;margin-left:5px;color:red;" ></font><br>*}
                            {*<img src="{$avactor_fpic.cover_img}" style="width:20%;"/><br/>*}
                            {*<a href="{$avactor_fpic.cover_img}" target="_blank">{$avactor_fpic_fpic.cover_img}</a><br/>*}
                    </fieldset>
                    <div style="text-align: center;">
                        <input type="submit" name="edit" value="  编辑专辑  " class="button">
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
                    <legend>添加图库</legend>
                        <form name="add_adv" method="POST" action="avActor.php?m=avActorImgEdit&AID={$avactor_fpic.id}" enctype="multipart/form-data">
                            <label for="image">图库图像:</label>
                                 <input name="front_image" type="text" value="" class="large"><br />
                            {*<label for="image">图库图像:</label>*}
                                {*<input name="image" type="file"><font style="font-size:12px;margin-left:5px;color:red;" id="image"></font><br>*}
                            <div style="text-align: center;">
                                <input type="submit" name="imgAdd" value="  添加图库  " class="button">
                            </div>
                        </form>
                    </fieldset>
                {section name=i loop=$avactor_pic}
                   <ul>
                      <li>
                          <img src="{$avactor_pic[i].front_image}" style="width:20%;"/><br/>
                          <a href="{$avactor_pic[i].front_image}" target="_blank">{$avactor_pic[i].front_image}</a>
                      </li>
                      <li>
                          <a href="javascript:void(0)" onclick="del('{$avactor_fpic.id}','{$avactor_pic[i].id}');">删除 </a>
                      </li>
                   </ul>
                {/section}
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    {literal}
        function del(fid,pid){
            if(confirm('确定要删除？')){
                window.location.href = 'avActor.php?m=avActorImgEdit&imgDel=imgDel&AID='+fid+'&pic_id='+pid;
            }
        }
    {/literal}
</script>