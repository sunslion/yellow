//设置播放器容器打下
var _width = '100%';
var _height = '100%';
$('#a1').attr("style","width:"+_width+';height:'+_height+';');
var adPauseStr  = '/templates/frontend/frontend-jiucao/img/pauseAds.gif';//ck广告属性
var pauseLink = 'http://52.119.1.5/picture/ssx/94s.html';//ck广告属性
function init(){
    var videoObject = {
        container: '#a1',//“#”代表容器的ID，“.”或“”代表容器的class
        variable: 'player',//该属性必需设置，值等于下面的new chplayer()的对象
        flashplayer:false,//如果强制使用flashplayer则设置成true
        loop: true, //播放结束是否循环播放
        autoplay: true, //是否自动播放
        adpause: adPauseStr,
        adpauselink:pauseLink,
        adpausetime: '100000000',
        loaded:'loadedHandler',
        video:url//视频地址
    };
    player=new ckplayer(videoObject);
}
function loadedHandler(){
    if(player && player.html5Video){
        player.addListener('pause',pauseHandler);
        player.addListener('play',playHandler);
    }

}
var adDiv = null;
function pauseHandler(){
    var parentDiv = $('#a1');
    adDiv = createAdsDiv(parentDiv);
    var a = $('<a />');
    a.css('display','block').attr({'href':pauseLink,'target':'_blank'});
    var width = 0;
    var height = 0;
    if( parentDiv ){
        height = parentDiv.height() * 0.7;
    }
    var img = $('<img />');
    img.css({'width':'100%','height':height+'px'}).attr('src',adPauseStr);

    a.append(img);
    adDiv.append(a);
    parentDiv.append(adDiv);
}
function playHandler(){
    if(adDiv)
        adDiv.remove();
}
function createAdsDiv(obj){
    var div = $('<div />');
    var width = 0;
    var height = 0;
    var top = 0;
    var left = 0;
    if( obj ){
        width = obj.width() * 0.7;
        height = obj.height() * 0.7;
        top = (obj.height() - height) / 2,2;
        left = (obj.width() - width) / 1.8;

    }
    div.css({'position':'absolute','left':left+'px','top':top+'px','width':width+'px','height':height+'px','display':'block','text-align':'center','z-index':'99999999'});
    return div;
}
//--优播播放器end
//--优播播放器start
function ybInit(){
       window.open(ybUrl);
       $str='<div style="text-align:center"><a href="http://tutu356.gz.bcebos.com/YBPlayer1.0.1.apk"><img src="/templates/frontend/frontend-jiucao/m/img/ubplayAppDown.jpg" alt="优播APP下载引导"></a></div>';
       $("#a1").html($str);
}
