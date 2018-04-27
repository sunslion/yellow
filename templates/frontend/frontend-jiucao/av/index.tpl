{include file="header.tpl"}
<title>AV女忧列表</title>
<link rel="stylesheet" type="text/css" href="/templates/frontend/frontend-jiucao/av/css/style.css">
<div class="av_list">
    <div class="container" id="avs">
        {section name=i loop=$avactor}
            <a href="{$avactor[i].url}" target="_blank">
                  <span class="block">
                    <span class="avator">
                      <em class="icon ihot">
                        <img src="/templates/frontend/frontend-jiucao/av/images/hot.gif"></em>
                      <img src="{$avactor[i].avator_img}">
                    </span>
                    <span class="avator_img">
                      <img src="{$avactor[i].avdesc_img}">
                    </span>
                  </span>
                <span class="name"><b>{$avactor[i].name}</b>{$avactor[i].japan_name}</span>
            </a>
        {/section}
       <div class="clear">&nbsp;</div>
    </div>
</div>
<div class="btn_more">&nbsp;</div>
{literal}
    <script type="text/javascript">
        $(function(){
            var a= $(".av_list").height();
            var i = a / 1700;
            var j = 1;
            $(".av_list").css({
                "height": 1700,
                "overflow":"hidden"
            })
            $('.btn_more').click(function(){
                j=j+1;
                $(".av_list").css({
                    "height": 1700*j,
                    "overflow":"hidden"
                })
                if ( j > i ){
                    $(".av_list").css({
                        "height": "auto"
                    })
                    $(this).hide();
                }
            })
        })
    </script>
{/literal}
{include file="footer.tpl"}