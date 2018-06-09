<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <title>AV女优画报</title>
    <script type="text/javascript" src="/templates/frontend/frontend-jiucao/m/av/avAcotr/js/jquery-1.11.3.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/templates/frontend/frontend-jiucao/m/av/avAcotr/css/style.css">
</head>

<body>
    <div class="head">
        <div class="log">
            <a href="/">
                <img src="/templates/frontend/frontend-jiucao/m/av/avAcotr/images/logo.png" alt="log">
            </a>
        </div>
        <div class="top-link">
            <a class="link-item" href="https://www.emoneyspace.com/yzmw" target="_blank"><img src="/templates/frontend/frontend-jiucao/m/av/avAcotr/images/fb1.png"></a>
            <a class="link-item" href="http://cy.sougaga.com/zmwdz/" target="_blank"><img src="/templates/frontend/frontend-jiucao/m/av/avAcotr/images/fb2.png"></a>
        </div>
        <div class="search" id="searchOpen"><img src="/templates/frontend/frontend-jiucao/m/av/avAcotr/images/icon/search-ico.png" alt=""></div>
    </div>
{*{include file="header.tpl"}*}
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>AV女优画报</title>
<link rel="stylesheet" type="text/css" href="/templates/frontend/frontend-jiucao/m/av/avAcotr/css/style.css">

    <div class="mt">
        <div class="list">
            <ul>
                {section name=i loop=$avactor}
                    <li>
                        <a href="/avActor/Avdesc/id/{$avactor[i].id}/actor_id/{$avactor[i].actor_id}" target="_blank">
                            <img src="{$avactor[i].front_cover_img}"  alt="{$avactor[i].title}" width="220" height="300" original="https://mtl.ttsqgs.com/images/img/7448/0.jpg">
                        </a>
                        <p>
                            <span class="name">数量：</span>
                            {$avactor[i].imgCount} 张
                        </p>
                        <p><span class="name">女优:</span>
                            <a href="javascript:void(0);" target="_blank" class="tags">{$avactor[i].name}({$avactor[i].japan_name})</a>
                        </p>
                        <p><span class="name">标签：</span>
                            {if is_array($avactor[i].tag)}
                                {section name=j loop=$avactor[i].tag}
                                    <a href="javascript:void(0);" target="_blank" class="tags">{$avactor[i].tag[j]}</a>
                                {/section}
                            {/if}
                        <p><span class="name">影视:</span>
                            <a href="/search?kd={$avactor[i].name}-{$avactor[i].japan_name}" target="_blank" class="tags">点击进入 激爽观看</a>
                        </p>
                        <p class="p_title">
                            <a href="javascript:void(0);"  target="_blank" >{$avactor[i].title}</a>
                        </p>
                    </li>
                {/section}
            </ul>
        </div>
        {*<div class="pavigation"><a class="pa" href="/item/13193.html">上一页</a> <span>1</span> <a href="/item/13193_2.html">2</a> <a href="/item/13193_3.html">3</a> <a href="/item/13193_4.html">4</a> ..<a href="/item/13193_34.html">10</a> <a class="pa" href="/item/13193_2.html">下一页</a></div>*}
    </div>
    <!--底部-->
    {*<div class="page-foot">*}
        {*<div class="foot-log"><img src="/templates/frontend/frontend-jiucao/m/av/avAcotr/images/logo.png"></div>*}
        {*<div class="foot-body">*}
            {*<div class="right-body">*}
                {*<div class="line"><img style="width:65%;" src="/templates/frontend/frontend-jiucao/m/av/avAcotr/images/yellow.jpg"></div>*}
            {*</div>*}
        {*</div>*}
    {*</div>*}
    {*<div class="foot-d"><a style="color:#f0ff00;" href="http://tb.53kf.com/code/client/10140693/1" target="_blank">7X24小时点击咨询</a></div>*}
    {include file="footer.tpl"}
</body>

</html>