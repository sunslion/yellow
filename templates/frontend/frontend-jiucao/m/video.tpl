{include file="header.tpl"}
{include file="header_ads.tpl"}
<div class="video-body gray">
	<div class="palyContent">
	<!--视频播放框-->
	<div class="play" style="text-align:center;position:relative;background-color:#000;">
		<div id="a1"></div>
	</div>
	<div class="playName">
		<div class="left">
			<p class="name">{$video.title}</p>
		</div>
		<div class="right" style="position:absolute;right: 0;">
			<span class="watch"><img src="/templates/frontend/frontend-jiucao/m/img/eyes_04.png">{$video.viewnumber}次</span>
			<span class="watch"><img src="/templates/frontend/frontend-jiucao/m/img/r1_03.png">{$video.likes}次</span>
			<span class="watch"><img src="/templates/frontend/frontend-jiucao/m/img/r2_03.png">{$video.dislikes}次</span>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="dz">
		<span>采集地址:</span>
		<a  href="/video/show/id/{$id}/" target="_blank"><input id="ckcont"  type="text" value="{$video.ipod_filename}" /></a>
		{*<button value="{$video.ipod_filename}"  style="z-index: 999999" onclick="ckcont()" >复制地址</button>*}
	</div>
    {if $video.ybPlayUrl}
		<div class="dz">
			<span>边下边看:</span>
			<a  href="/video/show/id/{$id}/type/2" target="_blank"><input  value="{$video.ybPlayUrl}"  id="ybcont" type="text" value="{$video.ybPlayUrl}" /></a>
			<button value="{$video.ybPlayUrl}" style="z-index: 999999" onclick="ybcont()" >复制地址</button>
		</div>
		 <div  class="youbo">
			 <a   href="/video/YbGuide" target="_blank">下载教程 </a>
		 </div>
    {/if}
	<p style="padding:10px 0;font-size:0.6rem;">更多精彩，请关注官方开车公众号：妹字幕</p>
</div>
{*推荐视频*}
<div class="video-body video-related">
    <div>
        <div class="ps_51"></div>
        <div class="clear">&nbsp;</div>
    </div>
    <div class="video-head">
        <div class="video-title">相关视频</div>
    </div>
    <div class="video-list">
        {section name=i loop=$suggestVideo max=4}
            <div class="video-item">
                <a href="{surl url=video/show/id id=$suggestVideo[i].VID}">
                    <img class="lazy" data-original="{$suggestVideo[i].pic}" src="/templates/frontend/frontend-jiucao/img/loading.gif?t=2" alt="{$suggestVideo[i].title}" title="{$suggestVideo[i].title}" onerror="this.src='/templates/frontend/frontend-jiucao/img/backlogo.png'"/>
                    <div class="title">{$suggestVideo[i].title}</div>
                    {*<div class="video-foot">*}
                        {*<div class="time">{$suggestVideo[i].addtime}</div>*}
                        {*<div class="view">{$suggestVideo[i].viewnumber}观看</div>*}
                    {*</div>*}
                </a>
            </div>
        {/section}
    </div>
    <p style="padding:10px 0;color:red;font-size:0.6rem;">更多精彩，请关注官方开车公众号：fu2dzy</p>
</div>
<div class="shadow" style="display:none;">&nbsp;</div>
<div class="popup pvip" style="display:none;">
	<div class="title">温馨提示<a href="javascript:;" class="icon iwclose" data-role="close"></a></div>
    <div class="content">
    <div class="padding">
    	<div class="line"></div>
        <p>主人，真的不考虑加入 VIP 吗？</p>
        <p id="msg">奴家已经陪伴您<b>30</b>分钟了</p>
        <div class="line"></div>
    	<div class="btn_group">
        	<img src="/templates/frontend/frontend-jiucao/m/img/p_vmodel.png" />
        	<div class="padding"><a href="/vip" class="btn btn_blue"><em class="icon ivip"></em>加入VIP</a></div>
        </div>
    </div>
    </div>
</div>
<script type="text/javascript" src="/public/ckplayX/ckplayer.js?t=5" charset="utf-8"></script>
<script type="text/javascript" src="/templates/frontend/frontend-jiucao/m/js/player.js" charset="utf-8"></script>
<script type="text/javascript">
    var url = '{$video.ipod_filename}';
    var ybUrl = '{$video.ybPlayUrl}';
    var picurl = '{$video.pic}';
    var vid = '{$id}';
    var type = '{$type}';//播放器类型-2 优播 1 ck
	{literal}
    // 实例化类
	$(function(){
        if(type==2){
            ybInit();//优播
        }else{
            init();//ck播放
        }
		$('#nice').click(function(){
			setLikesAndDislikes(1,vid);
		});
		$('#poor').click(function(){
			setLikesAndDislikes(2,vid);
		});
	});
	function setLikesAndDislikes(t,vid){
		$.post('/video/ajax_likes',{'t':t,'vid':vid},function(d){
			if(d && d.code == 0){
				$(".r"+t).hide();
                $(".g"+t).show();
			}
			setTimeout(function(){
				$('#likes_msg').html('');
			},3000);
			$('#likes_msg').html(d.msg);
		},'json');
	}
    function ckcont() {
        var ckcont = $('#ckcont').val();
        var e=document.getElementById("ckcont");//对象是content
        e.select(); //选择对象
        document.execCommand("Copy"); //执行浏览器复制命令
        alert("已复制好:"+ckcont);
    }
    function ybcont() {
        var ybcont = $('#ybcont').val();
        var e=document.getElementById("ybcont");//对象是content
        e.select(); //选择对象
        document.execCommand("Copy"); //执行浏览器复制命令
        alert("已复制好:"+ybcont);
    }
     //复制方法
   //  function copyTextToClipboard(text) {
   //      var textArea = document.createElement("textarea")
   //      textArea.style.position = 'fixed'
   //      textArea.style.top = 0
   //      textArea.style.left = 0
   //      textArea.style.width = '2em'
   //      textArea.style.height = '2em'
   //      textArea.style.padding = 0
   //      textArea.style.border = 'none'
   //      textArea.style.outline = 'none'
   //      textArea.style.boxShadow = 'none'
   //      textArea.style.background = 'transparent'
   //      textArea.value = text
   //      document.body.appendChild(textArea)
   //      textArea.select()
   //      try {
   //          var msg = document.execCommand('copy') ? '成功' : '失败'
   //          //console.log('复制内容 ' + msg)
			// alert('复制成功！'+text)
			// //alert();
   //      } catch (err) {
   //          //console.log('不能使用这种方法复制内容')
   //          alert('复制失败！'+text)
   //      }
   //      document.body.removeChild(textArea)
   //  }
{/literal}
</script>
{include file="footer.tpl"}
