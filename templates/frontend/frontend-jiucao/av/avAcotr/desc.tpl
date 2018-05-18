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

<!-- 头部 -->
<div class="mt">
    <div class="width1000">
        <div class="pic">
            <div class="pic_title">
                <h1>{$list.title}</h1>
            </div>
            <div class="pic_intro">
                <p><span class="name">图片数量： {$list.imgCount} 张</p>
                <p><span class="name">AV女优：
                         <a href="/avActor/Avintro/actor_id/{$list.aid}" target="_blank" class="tags">{$list.name}({$list.japan_name})</a>
                </p>
                <p><span class="name">标签：{$list.tag}</p>
                <p><span class="name">经典作品：<a href="/search?kd={$list.name}-{$list.japan_name}" target="_blank" class="tags">{$list.name}({$list.japan_name})</a>
                <p><span class="name">简介： {$list.details}</p>
            </div>
            <div class="content">
                {*<img style="display: none" src="/" alt="测试专辑-1" class="content_img" title="测试专辑-1">
                <img style="display: none" src="/" alt="测试专辑-1" class="content_img" title="测试专辑-1">*}
                {section name=i loop=$imgArr}
                    <img src="{$imgArr[i].front_image}" alt="{$list.title}" class="content_img" title="{$list.title}" />
                {/section}
            </div>
            <a href="javascript:void(0);" class="more" style="text-align:center;" alt="点击加载更多画册" class="more">
                <!-- <img src="" alt=""> -->
            </a>
            <script type="text/javascript">
                {literal}
                    $(function(){
                        var nimg = $(".pic .content").find("img").size();
                        $(".pic .content img:gt(4)").hide();
                        if(nimg < 5){
                            $(".more").hide();
                        }
                        $(".more").click(function(){
                            if(nimg > 5){
                                $(".pic .content img:gt(4)").show();
                                $(".more").hide();
                            }
                        })
                    })
                {/literal}
            </script>
        </div>
    </div>
</div>
</body>
</html>