<div id="rightcontent">
    {include file="errmsg.tpl"}
    <div id="searchForm">
        <form name="search_advertise" method="POST" action="index.php?m=new_advs">
            <table width="100%" cellpadding="0" cellspacing="5" border="0" >
                <tr>
                    <td width="9%" align="right">广告类型：</td>
                    <td width="14%" align="center">
                        <select name="type" class="sel" id = "seachType">
                            <option value="0" {if $advsType[i].id eq $searchType}selected="selected"{/if} >全部广告</option>
                            {section name=i loop=$advsType}
                                <option value="{$advsType[i].id}" {if $advsType[i].id eq $searchType}selected="selected"{/if}>{$advsType[i].name}</option>
                            {/section}
                        </select>
                    </td>
                    <td width="6%" align="right">广告端口：</td>
                    <td width="8%" align="left">
                        <select name="ismobile" class="sel" id = "ismobile">
                            <option value="2"   {if $ismoblie eq 2}selected="selected"{/if} >PC/APP端</option>
                            <option value="0"   {if $ismoblie eq 0}selected="selected"{/if} > PC端</option>
                            <option value="1"  {if $ismoblie eq 1}selected="selected"{/if} >APP端</option>
                        </select>
                    </td>
                    <td width="6%" align="right">是否固定：</td>
                    <td width="14%" align="left">
                        <select name="seachisFix" class="sel" id = "seachisFix">
                            <option value="2"   {if $isFix eq 2}selected="selected"{/if} >全部</option>
                            <option value="1"  {if $isFix eq 1}selected="selected"{/if} >固定</option>
                            <option value="0"   {if $isFix eq 0}selected="selected"{/if} > 不固定</option>
                        </select>
                    </td>
                    <td colspan="2" align="center" width="5%">
                        <input type="button" name="search_advertise" value=" 广告查询  " class="button" onclick="search()">
                    </td>
                    <td colspan="2" align="left" width="40%">
                        <input type="button" name="" value="添加广告" class="button" onclick="location.href='index.php?m=new_advsadd'">
                    </td>
                    <!--  <td colspan="2" align="right" width="10%">
                         <input type="reset" name="reset_search" value=" -- Clear -- " class="button">
                     </td> -->
                    <td colspan="2" align="right" width="10%">
                        <input type="button" name="" value="清空广告缓存" class="button" id="clearcache" >
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div id="right">
        <table width="100%" cellspacing="2" cellpadding="3" border="0">
            <tr>
                <td align="center" width="20px"><b>ID</b></td>
                <td align="center"><b>Advertise Zone</b></td>
                <td align="center"><b>Name</b></td>
                <td align="center"><b>Url</b></td>
                <td align="center" width="400px" ><b>Image</b></td>
                <td align="center"><b>是否固定</b></td>
                <td align="center"><b>是否存在关闭按钮</b></td>
                <td align="center" width="20px"><b>Order</b></td>
                <td align="center"><b>Action</b></td>
            </tr>
            {if $advs}
                {section name=i loop=$advs}
                    <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                        <td align="center">{$advs[i].id}</td>
                        <td align="center">{$advs[i].zone_name}</td>
                        <td align="center"><a href="index.php?m=advedit&AID={$advs[i].adv_id}">{$advs[i].name}</a></td>
                        <td align="center">{$advs[i].url}</td>
                        <td align="center">
                           <!-- <img src="{if $advs[i].locImgAddr}{$advs[i].locImgAddr}{else}{$advs[i].media}{/if}" alt=""  height="{$advs[i].height}"> -->
                            <img src="{if $advs[i].locImgAddr}{$advs[i].locImgAddr}{else}{$advs[i].media}{/if}" alt="" >
                            <br/>
                            <a href="{if $advs[i].locImgAddr}{$advs[i].locImgAddr}{else}{$advs[i].media}{/if}" target="_blank" >{if $advs[i].locImgAddr}{$advs[i].locImgAddr}{else}{$advs[i].media}{/if}</a>
                        </td>
                        <td align="center">
                            {if $advs[i].isFix eq 1}
                                固定
                            {else}
                                不固定
                            {/if}
                        </td>
                        <td align="center">
                            {if $advs[i].isbtn eq 1}
                                是
                            {else}
                                否
                            {/if}
                        </td>
                        <td align="center">{$advs[i].orderby}</td>
                        <td align="center">
                            <a href="index.php?m=new_advsedit&AID={$advs[i].id}">Edit</a>&nbsp;&nbsp;
                            <a href="javascript:void(0);" onclick="del('{$advs[i].id}');">Delete</a>
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
        var ismobile = $("#ismobile").val();
        var type = $("#seachType").val();
        var isFix = $("#seachisFix").val();
        if(confirm('确定要删除？')){
            window.location.href = 'index.php?m=new_advs&a=delete&AID='+id+"&ismobile="+ismobile+"&isFix="+isFix;
        }
    }
    function search(){
        var type = $("#seachType").val();
        var ismobile = $("#ismobile").val();
        var isFix = $("#seachisFix").val();
        location.href = "index.php?m=new_advs&type="+type+"&ismobile="+ismobile+"&isFix="+isFix//路径加随机数强制刷新;
    }
    $("#clearcache").click(function (){
        var type = $("#seachType").val();
        var ismobile = $("#ismobile").val();
        var isFix = $("#seachisFix").val();
        location.href="index.php?m=new_advs&a=clearcache&type="+type+"&ismobile="+ismobile+"&isFix="+isFix//路径加随机数强制刷新;
    })
    {/literal}
</script>