<style>
    {literal}
        img{max-width: 50%;max-height: 30%}
    {/literal}
</style>
<div id="rightcontent">
    {include file="errmsg.tpl"}
    <div id="right">
        <table width="100%" cellspacing="2" cellpadding="3" border="0">
            <tr>
                <td align="center" width="20px"><b>ID</b></td>
                <td align="center"><b>排序</b></td>
                <td align="center"><b>中文姓名</b></td>
                <td align="center"><b>日文姓名</b></td>
                <td align="center" width="400px" ><b>女优头像</b></td>
                <td align="center"><b>女优介绍照片</b></td>
                <td align="center"><b>操作</b></td>
            </tr>
            {if $avactor}
                {section name=i loop=$avactor}
                    <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                        <td align="center">{$avactor[i].id}</td>
                        <td align="center">{$avactor[i].orderby}</td>
                        <td align="center">{$avactor[i].name}</td>
                        <td align="center"><a href="index.php?m=advedit&AID={$avactor[i].id}">{$avactor[i].japan_name}</a></td>
                        <td align="center">
                            <img src="{$avactor[i].avator_img}" alt="" >
                            <br/>
                            <a href="{$avactor[i].avator_img}" target="_blank" >{$avactor[i].avator_img}</a>
                        </td>
                        <td align="center">
                            <img src="{$avactor[i].avdesc_img}" alt="" >
                            <br/>
                            <a href="{$avactor[i].avdesc_img}" target="_blank" >{$avactor[i].avdesc_img}</a>
                        </td>
                        <td align="center">
                            <a href="avActor.php?m=edit&AID={$avactor[i].id}">Edit</a>&nbsp;&nbsp;
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
            window.location.href = 'avActor.php?m=list&a=delete&AID='+id;
        }
    }
    {/literal}
</script>
