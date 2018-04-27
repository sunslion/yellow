//设置播放器初始属性
var player = '';//优播属性
var ffhd_weburl = unescape(window.location.href);
var _width = '662px';
var _height = '370px';
$('#a1').attr("style","width:"+_width+';height:'+_height+';');
var adPauseStr  = '/templates/frontend/frontend-jiucao/img/pauseAds.gif';//ck广告属性
var pauseLink = 'http://52.119.1.5/picture/ssx/94s.html';//ck广告属性
//ck播放器
function init(){
	$('#a1').attr("style","width:"+_width+';height:'+_height+';');
	var videoObject = {
                    container: '#a1',//“#”代表容器的ID，“.”或“”代表容器的class
                    variable: 'player',//该属性必需设置，值等于下面的new chplayer()的对象
                    flashplayer:false,//如果强制使用flashplayer则设置成true
                    loop: true, //播放结束是否循环播放
                    autoplay: true, //是否自动播放
                    adpause: adPauseStr,
                    adpauselink:pauseLink,
                    adpausetime: '100000000',
                    video:url//视频地址
            };
    var player=new ckplayer(videoObject);
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
    var img = $('<img />');
    img.css({'width':'100%','height':'100%'}).attr('src',adPauseStr);

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
        top = (obj.height() - height) / 2;
        left = (obj.width() - width) / 1.3;

    }
    div.css({'position':'absolute','left':left+'px','top':top+'px','width':'auto','height':'auto','display':'block','text-align':'center','z-index':'99999999'});
    return div;
}
//--优播播放器start
function ybInit(){
    var ffhd_weburl = unescape(window.location.href);//当前页面
    $('#a1').attr("style","width:"+_width+';height:'+_height+';');
    if(!isIE()){
        var player = PlayerNt();
        $('#a1').html(player);
    }else{
        var player = PlayerIe();
        $('#a1').html(player);
    }
}
function isIE() {
    if (!!window.ActiveXObject || "ActiveXObject" in window)
        return true;
    else
        return false;
}
function PlayerNt(){
    if (navigator.plugins) {
        var install = true;
        for (var i=0;i<navigator.plugins.length;i++) {
            if(navigator.plugins[i].name == 'YBPlayer Plug-In'){
                install = false;break;
            }
        }
        if(!install){
            player = '<object id="ybhd_player" name="ybhd_player" type="application/npYBPlayer" width="100%" height="'+_height+'" progid="XLIB.YBPlayer.1" url="'+ybUrl+'" CurWebPage="'+ffhd_weburl+'"></object>';
            return player;
        }
    }
    return Install();
}
function PlayerIe(){
    player = '<object classid="clsid:111271BC-EF7A-41CB-AC70-D03C98182B95" width="100%" height="'+_height+'" id="ybhd_player" name="ybhd_player" onerror="Install();"><param name="url" value="'+ybUrl+'"/><param name="CurWebPage" value="'+ffhd_weburl+'"/></object>';
    return player;
}
function Install(){
    player = '<iframe border="0" src="/templates/frontend/frontend-jiucao/ybhd_hint.html" marginwidth="0" framespacing="0" marginheight="0" frameborder="0" noresize="" scrolling="no" width="100%" height="'+_height+'" vspale="0"></iframe>';
    return player;
}
//--优播播放器end
