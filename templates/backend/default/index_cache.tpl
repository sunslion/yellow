 <div id="rightcontent">
    <div id="errorbox" style="display: none;"></div>
    <div id="messagebox" style="display: none;"></div>

    <div id="right">
        <div align="center">
            <h2>缓存清空</h2>
            <table width="80%" cellspacing="5" cellpadding="5" border="0">
            <tr class="view">
                <td align="center">
                    <a href="/siteadmin/index.php?m=cache&act=frontend">
                        <b>清空PC版文件缓存</b>
                    </a>
                </td>
                <td align="center">
                    <a href="/siteadmin/index.php?m=cache&act=frontend&sact=m">
                        <b>清空移动版文件缓存</b>
                    </a>
                </td>
                <td align="center">
                    <a href="/siteadmin/index.php?m=cache&act=backend">
                        <b>清空后台缓存</b>
                    </a>
                </td>
            </tr>
            </table>
        </div>
    </div>
    <br>
    <div id="right">
        <div id="static_content">
            {if $msg} {$msg} {/if}
            {if $num>0} {$num}个缓存文件被清空{/if}
        </div>
    </div>
 </div>
