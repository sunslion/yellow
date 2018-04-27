<link rel="stylesheet" href="/templates/frontend/frontend-jiucao/higSuggest/css/normalize.css">
<link rel="stylesheet" href="/templates/frontend/frontend-jiucao/higSuggest/css/reset.css">
<!--轮播图插件-->
<link rel="stylesheet" href="/templates/frontend/frontend-jiucao/higSuggest/css/owl.carousel.css">
<link rel="stylesheet" href="/templates/frontend/frontend-jiucao/higSuggest/css/owl.theme.css">
<!--自定义css-->
<link rel="stylesheet" href="/templates/frontend/frontend-jiucao/higSuggest/css/style.css"/>
<!--极品推荐-->
<div class="ad-recommend">

<div class="ad-reco-head clearfix">
  <!-- <div class="icon-play float-left"></div> -->
       <!--<span class="float-left" style="font-size: ">极品推荐</span> -->
    <h3><span class="ad-reco-head-icon">极品推荐</span></h3>
</div>
<div id="owl-demo">
    <div class="item"><a href="http://www.qcy15.com?rf=gdgg" ><img src="/templates/frontend/frontend-jiucao/higSuggest/img/1.jpg" alt="1"></a></div>
    <div class="item"><a href="http://www.qczx1.com?rf=gdgg" ><img src="/templates/frontend/frontend-jiucao/higSuggest/img/2.jpg" alt="1"></a></div>
    <div class="item"><a href="http://www.qczx2.com?rf=gdgg" ><img src="/templates/frontend/frontend-jiucao/higSuggest/img/3.jpg" alt="1"></a></div>
    <div class="item"><a href="http://www.qcsp2.com?rf=gdgg" ><img src="/templates/frontend/frontend-jiucao/higSuggest/img/4.jpg" alt="1"></a></div>
    <div class="item"><a href="http://www.qczx3.com?rf=gdgg" ><img src="/templates/frontend/frontend-jiucao/higSuggest/img/5.jpg" alt="1"></a></div>
    <div class="item"><a href="http://www.qcsp3.com?rf=gdgg" ><img src="/templates/frontend/frontend-jiucao/higSuggest/img/6.jpg" alt="1"></a></div>
    <div class="item"><a href="http://www.ai520.co?rf=gdgg" ><img src="/templates/frontend/frontend-jiucao/higSuggest/img/7.jpg" alt="1"></a></div>
    <div class="item"><a href="http://www.qcyl1.com?rf=gdgg" ><img src="/templates/frontend/frontend-jiucao/higSuggest/img/8.jpg" alt="1"></a></div>
</div>
</div>
<script src="/templates/frontend/frontend-jiucao/higSuggest/js/jquery-3.2.1.min.js"></script>
<script src="/templates/frontend/frontend-jiucao/higSuggest/js/owl.carousel.min.js"></script>
<script>
{literal}		
$(document).ready(function() {
    $("#owl-demo").owlCarousel({
        autoPlay: 3000, //Set AutoPlay to 3 seconds
        loop:true,
        dots: false ,
        items : 4,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,3]

    });
});
{/literal}
</script>
