<div id="rightcontent">
        {include file="errmsg.tpl"}
{literal}
<style type="text/css">
.help_n{
	overflow: hidden;
	border-top: 2px dashed #ddd;
	clear: both;
	padding-top: 15px;
}
.help_n label{
	padding: 10px 10px 10px 20px;
	clear: both;
	overflow: hidden;
	color: green;
	font-weight: bold;
	background: #f6f6f6;
	display: block;
}
.help_n p{
	clear: both;
	line-height: 19px;
	font-size: 13px;
	padding-left: 20px;
	color: #868686;
	
}

.help_n pre{
clear: both;
padding-left: 20px!important;
color: #000;

}
</style>
{/literal}
        <div id="right">
            <fieldset style="border: 0;">
            <h2>帮助与说明</h2>
            
<div class="help_n">
            <label>插件介绍</label>
            <p>这是一个用来分散用户播放视频时对单一服务器造成压力的插件，用户进入播放页面后，随机分配一个属于当前等级的(guest,free,premium)线路进行播放，同时也允许用户手动切换同等级线路。</p>
            <p>在后台中可以增加线路与线路所属服务器，同时支持绑定域名。</p>
</div>
<div class="help_n">
            <label>VID区域解释</label>
            <p>每一个视频都有一个唯一的编号，这个编号随着视频的增加而增加，考虑到一台服务器不可能装下所有视频，所以本插件根据视频VID进行了灵活的切分，你再新增服务器设置的时候需要确定两者的大小不可以颠倒。</p>
            <p>这一块默认是设置好的，不要轻易改动，否则将会造成视频数据不对称而无法播放</p>
</div>
<div class="help_n">
            <label>权限控制解释</label>
            <p>权限控制的意思就是谁对这条线路拥有访问权，这个地方可以多选,如果你选择多个那么属于你所选取的用户组用户对此线路拥有访问权限。</p>
</div>
<div class="help_n">
            <label>需要说明的</label>
            <p>后端服务器是根据母服务器数据新增情况来增量同步的，这个过程所需时间 会受到网络速度，硬件配置的影响。我这里帮你们设定了一个时间差，在用户上传成功之后，30分钟之后才使用其他线路播放，这三十分钟之间使用程序默认的进行播放（超过三十分钟这条线路直接参与三种等级的随机播放），这三十分钟的时间给了服务器用来数据同步。这个配置你可以在设置中修改。不建议设置过低。</p>
            
            <p>程序原本的两台服务器三种等级的用户均可访问。新增线路做限制，这样能避免同步不及时造成的无法播放现象</p>
</div>

<div class="help_n">
            <label>更多问题</label>
            <pre>请联系作者邮箱：office.frontend@gmail.com</pre>
</div>

            </fieldset>
            
        </div>
     </div>