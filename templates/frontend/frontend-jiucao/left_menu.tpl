<ul>
    <li>
        <h3>栏目导航<span></span></h3>
        <ol class="block">
            <li {if $CHID == 0}class="select"{/if}>
                <a href="/">首页</a>
                <span></span>
            </li>
            <li>
                <a href="/avActor/Avlist" target="__blank">av女优画册</a>
            </li>
            <li>
                <a href="/avActor" target="__blank">av女优一览</a>
                <span>{$avNum}</span>
            </li>
            {section name=i loop=$channels}
            <li {if $channels[i].CHID == $CHID}class="select"{/if}>
                <a href="{surl url=video/index/cid id=$channels[i].CHID}">{$channels[i].name}</a>
                <span>{$channels[i].total_videos}</span>
            </li>
            {/section}
        </ol>
    </li>
</ul>
<div><a href="http://cy.sougaga.com/yzmw/" target="_blank">加入赚钱计划</a></div>
<div class="div1"><a href="http://cy.sougaga.com/yechajian/" target="_blank">站长采集插件</a></div>
<div><a href="/ads/Android.apk" target="_blank">点击下载安卓APP</a></div>
<div class="div3"><a href="http://djcm888.com/" target="_blank">广告合作</a></div>
<!-- <div class="cash-ad"><a href="http://www.f2dfc.com" target="_blank">现金广告赞助</a></div> -->
<!--<div class="div2"><a href="">推广赚金币</a></div>-->
<div class="div5" style="display:none"><a href="">汤不热网盘短视频</a></div>
<p style="margin-top:20px;text-align:center;" class="ps_24"></p>
