<div id="rightcontent">
    {include file="errmsg.tpl"}
    <div id="searchForm">
        <input type="button" name="" value="Add Advzone" style="margin-left:20px;" class="button" onclick="location.href='index.php?m=advzoneadd'">
    </div>
    <div id="right">
        <table width="100%" cellspacing="2" cellpadding="3" border="0">
            <tr>
                <td align="center"><b>Id</b></td>
                <td align="center"><b>Name</b></td>
                <td align="center"><b>Size</b></td>
                <td align="center"><b>isMobile</b></td>

                <td align="center"><b>Actions</b></td>
            </tr>
            {if $advzones}
                {section name=i loop=$advzones}
                    <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
                        <td align="center">{$advzones[i].id}</td>
                        <td align="center"><a href="index.php?m=advzoneedit&id={$advzones[i].id}">{$advzones[i].name}</a></td>
                        <td align="center"><b>{$advzones[i].width}</b>x<b>{$advzones[i].height}</b></td>
                        <td align="center">
                            <b>
                                {if $advzones[i].ismobile eq 1}
                                    APP端
                                {else}
                                    PC端
                                {/if}
                            </b>
                        </td>
                        <td align="center">
                            <a href="index.php?m=advzoneedit&AGID={$advzones[i].id}">Edit</a><br>
                        </td>
                    </tr>
                {/section}
            {else}
                <tr>
                    <td colspan="8" align="center"><div class="missing">NO ADVERTISE ZONE FOUND</div></td>
                </tr>
            {/if}
        </table>
    </div>
</div>