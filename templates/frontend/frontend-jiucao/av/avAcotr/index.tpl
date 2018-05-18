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
            <div class="hot_beauty">
                <div class="hot_title">推荐AV女优</div>
                <div class="content">
                    {php}$i=1;{/php}
                    <ul>
                        {section name=i loop=$avactorPush max=18}
                            <li class="a{php}echo $i++;{/php}">
                                <a href="intro.html" target="_blank">
                                    <a href="/avActor/Avintro/actor_id/{$avactorPush[i].id}" target="_blank">
                                        <img src="{$avactorPush[i].front_avator_img}" alt="{$avactorPush[i].japan_name}" data-baiduimageplus-ignore="{$avactorPush[i].front_avator_img}">
                                    </a>
                                </a>
                            </li>
                        {/section}
                    </ul>
                </div>
            </div>
            <div class="hot_beauty_pic mt2">
                <div class="hot_title">AV女优精选</div>
                <div class="content">
                    <ul>
                        {section name=i loop=$avactor}
                            <li>
                                <a href="/avActor/Avdesc/id/{$avactor[i].id}/actor_id/{$avactor[i].actor_id}" target="_blank">
                                    <img src="{$avactor[i].front_cover_img}" alt="{$avactor[i].title}" width="220" height="300" original="{$avactor[i].front_cover_img}">
                                </a>
                                <p><span class="name">数量:</span>{$avactor[i].imgCount}张</p>
                                <p><span class="name">女优:</span>
                                    <a href="/avActor/Avintro/actor_id/{$avactor[i].actor_id}" target="_blank" class="tags">{$avactor[i].name}({$avactor[i].japan_name})</a>
                                </p>
                                <p><span class="name">标签:</span>
                                    {if is_array($avactor[i].tag)}
                                        {section name=j loop=$avactor[i].tag}
                                            <a href="javascript:void(0);" target="_blank" class="tags">{$avactor[i].tag[j]}</a>
                                        {/section}
                                    {/if}
                                </p>
                                <p class="p_title"><a href="javascript:void(0);" target="_blank">{$avactor[i].title}</a></p>
                            </li>
                        {/section}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>