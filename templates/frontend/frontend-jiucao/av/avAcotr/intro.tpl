<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{$title|escape:'html'}</title>
    <meta name="keywords" content="{$keyword|escape:'html'}" />
    <meta name="description" content="{$description|escape:'html'}" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="/templates/frontend/frontend-jiucao/av/avAcotr/css/style.css">
    <script type="text/javascript" src="/templates/frontend/frontend-jiucao/js/jquery-1.8.3.min.js?v=1"></script>
</head>
<body>
<!-- 头部 -->
<div class="detail_title">
    <div class="width1200">
        <h1><a href="/"></a></h1>
        <div class="detail_submit">
            <form name="search_form" method="POST" action="/search">
                <input type="text" placeholder="请输入搜索关键字" name="kd" value="{$kd}"/>
                <input type="submit" value=""/>
            </form>
        </div>
        <div class="link">
            <a href="http://www.f2dfc.com" class="btn-red" id="J-head-btn-charge"  target="_blank">现金广告赞助</a>
            <ul>
                <li><a href="https://www.emoneyspace.com/yzmw" target="_blank"><img src="/public/fb1.png"></a></li>
                <li><a href="http://cy.sougaga.com/zmwdz/" target="_blank"><img src="/public/fb2.png"></a></li>
            </ul>
        </div>
    </div>
</div>
<script type="text/javascript">
    {literal}
    $('input[name="ajaxLogin"]').click(function(){
        var subdiv = $('<div />');
        var ajaxsub = $('.ajaxsub');
        var name = $.trim($('input[name="ajaxName"]').val());
        if(name == ''){
            subdiv.html('请填写用户名');
            ajaxsub.html(subdiv).fadeIn(1000).fadeOut(1000);
            return false;
        }
        var pwd = $.trim($('input[name="ajaxPwd"]').val());
        if(pwd == ''){
            subdiv.html('请填写密码');
            ajaxsub.html(subdiv).fadeIn(1000).fadeOut(1000);
            return false;
        }
        $.post('/member/ajaxAuthenticate',{'username':name,'password':pwd},function(d){
            if(d && d.length > 0){
                subdiv.html(d);
                ajaxsub.html(subdiv).fadeIn(1000).fadeOut(1000);
            }else{
                subdiv.html('成功登陆');
                ajaxsub.html(subdiv).fadeIn(1000).fadeOut(1000);
                setTimeout(function(){
                    window.location.href = '/';
                },2000);
            }
        },'json');
    });
    {/literal}
</script>
    <div class="mt">
        <div class="width1000">
            <div class="intro">
                <div class="intro_r">
                    <h1>{$avactor.name}({$avactor.japan_name})</h1>
                    <div class="right">
                        <p>血型：{$avactor.blood_type}型</p>
                        <p>身高／体重： {$avactor.tall} 厘米 / {$avactor.weight}千克</p>
                        <p>三围：{$avactor.size} cm</p>
                        <p>罩杯：{$avactor.cup_size}</p>
                    </div>
                    <div class="left">
                        <p>出生：{$avactor.birth_day}</p>
                        <p>出道地点：{$avactor.birth_palce}</p>
                        <p>经纪公司：{$avactor.agency}</p>
                    </div>
                    <div class="clear">&nbsp;</div>
                </div>
                <div class="intro_l">
                    <img src="{$avactor.front_avator_img}" alt="{$avactor.name}({$avactor.japan_name})">
                </div>
                <div class="clear">&nbsp;</div>
            </div>
            <div class="hot_beauty_pic mt2">
                <div class="content">
                    <ul>
                        {section name=i loop=$list}
                            <li>
                                <a href="/avActor/Avdesc/id/{$list[i].id}/actor_id/{$list[i].actor_id}" target="_blank">
                                    <img src="{$list[i].front_cover_img}" alt="{$list[i].title}" width="220" height="300" original="{$list[i].front_cover_img}">
                                </a>
                                <p><span class="name">数量:</span>{$list[i].imgCount}张</p>
                                <p><span class="name">女优:</span><a href="/search?kd={$avactor.name}-{$avactor.japan_name}" target="_blank" class="tags">{$list[i].name}({$list[i].japan_name})</a></p>
                                <p><span class="name">标签:</span>
                                    {if is_array($list[i].tag)}
                                        {section name=j loop=$list[i].tag}
                                            <a href="javascript:void(0);" target="_blank" class="tags">{$list[i].tag[j]}</a>
                                        {/section}
                                    {/if}
                                </p>
                                <p class="p_title"><a href="javascript:void(0);" target="_blank">{$list[i].title}</a></p>
                            </li>
                        {/section}
                    </ul>
                </div>
                <!--翻页-->
                {*<div class="pavigation"><a class="pa" href="/item/13193.html">上一页</a> <span>1</span> <a href="/item/13193_2.html">2</a> <a href="/item/13193_3.html">3</a> <a href="/item/13193_4.html">4</a> <a href="/item/13193_5.html">5</a> <a href="/item/13193_6.html">6</a> <a href="/item/13193_7.html">7</a> <a href="/item/13193_8.html">8</a> <a href="/item/13193_9.html">9</a> <a href="/item/13193_10.html">10</a> ..<a href="/item/13193_34.html">34</a> <a class="pa" href="/item/13193_2.html">下一页</a></div>*}
            </div>
        </div>
    </div>
</body>

</html>