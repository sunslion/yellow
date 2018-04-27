{include file="header.tpl"}
<!-- 正文 -->
<div class="detail">
	<div class="width1200">
        <div class="detail_left">
             {include file="left_menu.tpl"}
        </div>
        <div class="detail_right">
            {include file="header_ads.tpl"}
            <div class="detail_right_tab" style="overflow: hidden; background: #fff; margin-top:20px; padding-left:10px;">
                <div class="gc_vidoe_nav">
                    <a href="/">首页 > </a>
                    <a href="{surl url=video/index/cid id=$video.channel}">{$cname} > </a>
                    <a href="{surl url=video/show/id id=$video.VID}" class="select">{$video.title}  </a>
                </div>

                <div class="gc_video_content">
                    <div class="gc_vodeo_left">
                        <div class="play" style="text-align:center;position:relative;background-color:#000;">
                        <div class="ps_4" id="play_ads" style="display:none;"></div>

                       <!--popup-->
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
						        	<img src="/templates/frontend/frontend-jiucao/img/p_vmodel.png" />
						        	<div class="padding"><a href="/vip" class="btn btn_blue"><em class="icon ivip"></em>加入VIP</a></div>
						        </div>
						    </div>
						    </div>
						</div>

                        <div id="a1"></div>
                        </div>
                        <div class="watch">
                            <span class="title"> {$video.title}</span>
                            <span class="people"><em>{$video.viewnumber}</em>次观看</span>
                            <span class="nice" id="nice">
                                <i class="r1"><img src="/templates/frontend/frontend-jiucao/img/r1_03.png"></i>
                                <i class="g1" style="display: none"><img src="/templates/frontend/frontend-jiucao/img/g1_03.png"></i>
                                {$video.likes}</span>
                            <span class="poor" id="poor">
                                <i class="r2"><img src="/templates/frontend/frontend-jiucao/img/r2_03.png"></i>
                                <i class="g2"  style="display: none"><img src="/templates/frontend/frontend-jiucao/img/g2_03.png"></i>
                                {$video.dislikes}
                            </span>
                            <span id="likes_msg" style="color:red;"></span>
                        </div>

                        <div class="dz">
                            <span>采集地址：</span>
                           <a style="color:#05a7ff" href="/video/show/id/{$id}/" target="_blank">{$video.ipod_filename}</a>
                            <button value="{$video.ipod_filename}" class="ckCont">复制地址</button>
                        </div>
                        {if $video.ybPlayUrl}
                            <div class="dz">
                                <span>边下边看：</span>
                                <a href="/video/show/id/{$id}/type/2" target="_blank">
                                    <textarea rows="2" cols="20" readonly="readonly" >{$video.ybPlayUrl}</textarea>
                                </a>
                                <button value="{$video.ybPlayUrl}" class="ybCont">复制地址</button>
                             </div>
                         <a style="color: #fff;" href="/video/YbGuide" target="_blank">
                            <div class="dz_3" style="margin: 5px 0;"> <span style="line-height: 30px;"> 下载教程</span> </div>
                         </a>
                        {/if}
                        <div class="clear"></div>
                        <div class="ps_23 palyAdv">
                        </div>
                        <div class="clear"></div>
                        <div class="videoMore sugetVideo" >
                            <p class="moreVideo">相关视频</p>
                            <ul>
                                {section name=i loop=$suggestVideoB}
                                    <li>
                                        <p>
                                            <img class="lazy" data-original="{$suggestVideoB[i].pic}" src="/templates/frontend/frontend-jiucao/img/loading.gif?t=2" alt="{$suggestVideoB[i].title}" title="{$suggestVideoB[i].title}" onerror="this.src='/templates/frontend/frontend-jiucao/img/backlogo.png'"/>
                                            <a href="{surl url=video/show/id id=$suggestVideoB[i].VID}"></a>
                                        </p>
                                        <p>{$suggestVideoB[i].title}</p>
                                        <p>
                                            <i>{$suggestVideoB[i].addtime}</i>
                                            <strong>{$suggestVideoB[i].viewnumber}观看</strong>
                                        </p>
                                    </li>
                                {/section}
                            </ul>
                        </div>
                    </div>
                     <div class="gc_vodeo_right">
                         <div class=" ps_20"></div>
                         <div name="related_videos" style="display:none">
                             <div class="videoMore" id="videoMore_right">
                                <ul>
                                {include file="related_videos.tpl"}
                                </ul>
                             </div>
                             {if $videocount > 4}
                             <div class="more" id="videos_more">展开</div>
                             {/if}
                         </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 正文 -->
<script type="text/javascript" src="/public/ckplayX/ckplayer.js?t=8" charset="utf-8"></script>
<script type="text/javascript" src="/templates/frontend/frontend-jiucao/js/player.js" charset="utf-8"></script>
<script type="text/javascript" src="/templates/frontend/frontend-jiucao/js/clipboard.min.js" charset="utf-8"></script>
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
    $(function(){
        //默认只显示4个视频
        $('#videoMore_right li').each(function(index,element){
            if(index>=5){
                $(this).hide();
            }
        })
        //点击更多显示全部视频
        $('#videos_more').click(function(){
            $('#videoMore_right li').show();
            $(this).hide();//隐藏更多
        })
    })

    //复制
    var clipboard = new Clipboard('.ckCont', {
        text: function() {
            return $('.ckCont').val();
        }
    });
    clipboard.on('success', function(e) {
        alert("复制成功");
    });

    //复制
    var clipboard = new Clipboard('.ybCont', {
        text: function() {
            return $('.ybCont').val();
        }
    });
    clipboard.on('success', function(e) {
        alert("复制成功");
    });
{/literal}
</script>
{include file="footer.tpl"}
