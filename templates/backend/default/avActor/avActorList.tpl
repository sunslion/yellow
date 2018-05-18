<style>
    {literal}
        img{max-width: 50%;max-height: 30%}
    {/literal}
</style>
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
                <form  method="POST" action="avActor.php?m=avActorAdd" enctype="multipart/form-data">
                    <fieldset>
                        <legend>添加女优</legend>
                        <label for="orderNum">排序: </label>
                            <input name="orderNum" type="text" value="" class="large"><br />
                        <label for="push">是否推荐: </label>
                            <input type="radio" name="push" value="1" > 是
                            <input type="radio" name="push" value="0" checked> 否 <br />
                        <label for="name">中文姓名: </label>
                            <input name="name" type="text" value="" class="large"><br />
                        <label for="japan_name">日文姓名: </label>
                            <input name="japan_name" type="text" value="" class="large"><br />
                        <label for="front_avator_img">女优头像:</label>
                            <input name="front_avator_img" type="text" value="" class="large"><br />
                        {*<label for="avator_img">女优头像:</label>*}
                            {*<input name="avator_img" type="file"><font style="font-size:12px;margin-left:5px;color:red;" id="avator_img"></font><br>*}
                    </fieldset>
                    <div style="text-align: center;">
                        <input type="submit" name="adv_add" value="添加女优" class="button">
                    </div>
                </form>
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
                <td align="center"><b>排序</b></td>
                <td align="center"><b>是否推荐</b></td>
                <td align="center"><b>中文姓名</b></td>
                <td align="center"><b>日文姓名</b></td>
                <td align="center" width="400px" ><b>女优头像</b></td>
                <td align="center"><b>操作</b></td>
            </tr>
            {if $avactor}
                {section name=i loop=$avactor}
                    <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                        <td align="center">{$avactor[i].id}</td>
                        <td align="center">{$avactor[i].orderNum}</td>
                        <td align="center">
                            {if $avactor[i].push == 1}
                                是
                            {else}
                                否
                            {/if}
                        </td>
                        <td align="center">{$avactor[i].name}</td>
                        <td align="center"><a href="index.php?m=advedit&AID={$avactor[i].id}">{$avactor[i].japan_name}</a></td>
                        <td align="center">
                            <img src="{$avactor[i].front_avator_img}" alt="" >
                            <br/>
                            <a href="{$avactor[i].front_avator_img}" target="_blank" >{$avactor[i].front_avator_img}</a>
                        </td>
                        <td align="center">
                            <a href="avActor.php?m=avActorEdit&AID={$avactor[i].id}">Edit</a>&nbsp;&nbsp;
                            <a href="javascript:void(0);" onclick="del('{$avactor[i].id}');">Delete</a>
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
    function del(id){
        if(confirm('确定要删除？')){
            window.location.href = 'avActor.php?m=avActorList&a=delete&AID='+id;
        }
    }
    {/literal}
</script>
