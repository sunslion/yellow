function createA(options){
	var ops = getStyleStr(options);
	var a = $('<a />');
	a.attr(ops);
	return a;
}
function createP(options){
    var ops = getStyleStr(options);
    var a = $('<p />');
    a.attr(ops);
    return a;
}
function createImg(options){
	var ops = getStyleStr(options);
	var img = $('<img />');
	img.attr(ops);
	return img;
}
function getStyleStr(options){
	var ops = {style:{}};
	$.extend(ops,options);
	var styleStr = '';
	if(ops && ops.style){
		$.each(ops.style,function(i,j){
			styleStr += i+':'+j+';';
		});
		ops.style = styleStr;
	}
	return ops;
}
function showAds(ps){
	if(ps){
		$.each(ps,function(i,j){
			var adsObj = $('.ps_'+i);
			var fragment = document.createDocumentFragment();
			//选择实例化的标签
			if(adsObj && adsObj.length > 0){
				//json样式---主要%比的样式
				var style = {};
				if($.trim(j.position) != ''){
					var width = 0;
					if(j.width.indexOf('%')>=0 || j.width=='auto'){
						width = j.width;
					}else{
						width = j.width+'px';
					}
					var height = 0;
					if(j.height.indexOf('%') >= 0 || j.height =='auto'){
						height = j.height;
					}else{
						height = j.height+'px';
					}
					style = {
						'position':'fixed',
						'z-index':999999,
						'width':width,
						'height':height
					};
					if(j.position_top != ''){
						style.top = (j.position_top.indexOf('%') >= 0) ? j.position_top : j.position_top+'px';
					}else if(j.position_bottom != ''){
						style.bottom = (j.position_bottom.indexOf('%') >= 0) ? j.position_bottom : j.position_bottom+'px';
					}else{
						style.top = 0;
					}
					if(j.position == 'left'){
						style.left = (j.position_left_right.indexOf('%') >= 0) ? j.position_left_right : j.position_left_right+'px';
					}else if(j.position == 'right'){
						style.right = (j.position_left_right.indexOf('%') >= 0) ? j.position_left_right : j.position_left_right+'px';
					}
					style.float = j.position;
					var o = getStyleStr({'style':style});
					//alert(JSON.stringify(o))---
					adsObj.attr(o);
				}
				var width = adsObj.width();
				var mcounts = Math.floor(width / j.width);
				if(j.ads && j.ads.length > 0){
					$.each(j.ads,function(si,sj){
						var tmps = sj.margin.split(' ');
						var tmpsLen = tmps.length;
						var margin = '';
						for(var f=0;f<tmpsLen;f++){
							if(tmps[f].indexOf('%') < 0 && parseInt(tmps[f]) > 0){
								margin += parseInt(tmps[f])+'px ';
							}else{
								margin += tmps[f]+' ';
							}
						}
						var ops = {
							'display':'block',
							'float':'left',
							'margin':margin
						};
						var xa = null;
						if(sj.isbtn == 1){
							ops.position = 'relative';
							var xaops = {'display':'block','position':'absolute','top':'5%','right':'3%','width':'auto','height':'auto','margin':0,'background':'#192332','color':'white','padding':'2px 5px','font-size':'50%','line-height':'100%'};
							xa = createP({'style':xaops});
							xa.html('X');
							xa.click(function(){
								$(this).parent().hide();
								return false;
							});
						}
						var a = createA({'style':ops,'title':sj.name,'href':sj.url,'target':'_blank'});
						if(xa){
							a.append(xa);
						}
						/*var imgops = {
						   'width':(j.width.indexOf('%') >= 0 || j.width=='auto')? j.width : j.width+'px',
						   'height':(j.height.indexOf('%')>=0 || j.height=='auto')? j.height : j.height+'px'
						};*/
                        //APP顶部-底部广告去除宽度
                        var imgops = '';
                        // var isApp = ["8","9","10","11","12","13","14","15","16","17","18","19","21"];
                        // if(isApp.indexOf(i)>=0){
                        //     var imgops = {
                        //         'width':(j.width.indexOf('%') >= 0 || j.width.indexOf('auto') >= 0) ? j.width : j.width+'px',
                        //         'height':(j.height.indexOf('%')>=0 || j.height.indexOf('auto') >= 0) ? j.height  : j.height+'px'
                        //     };
                        //  //APP浮动广告
                        // }else 
                        if(i==23){
                            var imgops = {
                                'width':$(window).width()+'px',
                                'height':'auto'
                            };
						}
						var src = sj.media ? sj.media : sj.relogopic;
						var img = createImg({'style':imgops,'alt':sj.name,'src':src});
						a.append(img);
						fragment.appendChild(a[0]);
					});
					adsObj.append(fragment);
				}
			}
		});
	}
}