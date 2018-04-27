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
function createDiv(options){
    var ops = getStyleStr(options);
    var div = $('<div />');
    div.attr(ops);
    return div;
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
			var isFull = ["52","53"];//设置全屏固定广告
			var isApp = ["24","25","26"];//APP顶部-底部广告去除宽度
			var isPCfloat = ["3","4","44","5","6","45","47","48","49","50"];//设置PC端三排广告
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
					//设置全屏固定广告
                    if(isFull.indexOf(i)>=0){
                        style['margin-left'] = (j.width.indexOf('%') >= 0) ? j.width : '-'+parseInt(j.width)/2+'px';
                        style['margin-top'] = (j.height.indexOf('%') >= 0) ? j.height :'-'+parseInt(j.height)/2+'px';
                    }
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
							'margin':margin
						};
						//去除多余a标签多余的左浮动
                        if(parseInt(i)==1){
                            ops['float'] = 'left';
                        }
						var xa = null;
						if(sj.isbtn == 1){
							ops.position = 'relative';
							var xaops = {'display':'block','position':'absolute','top':'0px','right':'0px','width':'auto','height':'auto','margin':0,'background':'rgba(15,25,25,0.5)','color':'white','padding':'4px 5px','font-size':'50%','line-height':'100%'};
							xa = createP({'style':xaops});
							xa.html('关闭 X');
							xa.click(function(){
								$(this).parent().hide();
								if(isFull.indexOf(i)>=0) $(this).parent().parent().hide();//全屏固定广告关闭
								return false;
							});
						}
						//添加全屏遮罩层
						if(isFull.indexOf(i)>=0){
						  var xa_full = null;
						  var xaops_full = {'position':'fixed','width':'100%','height':'100%','background':'rgba(0,0,0,0.4)','left':'0px','top':'0px'};
						  xa_full = createDiv({'style':xaops_full});
                          adsObj.append(xa_full);
						}
						var a = createA({'style':ops,'title':sj.name,'href':sj.url,'target':'_blank'});
						if(xa){
							a.append(xa);
						}
                        //APP顶部-底部广告去除宽度
                        var imgops = '';
                        if(isApp.indexOf(i)>=0){
                            var imgops = {
                                'width':(j.width.indexOf('%') >= 0 || j.width.indexOf('auto') >= 0) ? j.width : j.width+'px',
                                'height':(j.height.indexOf('%')>=0 || j.height.indexOf('auto') >= 0) ? j.height  : j.height+'px'
                            };
						}
						//APP Banner广告
                        if(i==46){
                            var imgops = {
                                'width':(j.width.indexOf('%') >= 0 || j.width.indexOf('auto') >= 0) ? j.width : j.width+'px',
                                'height':(j.height.indexOf('%')>=0 || j.height.indexOf('auto') >= 0) ? j.height  : j.height+'px'
                            };
                        }
                        //APP浮动广告
                        if(i==22){
                            var imgops = {
                                'width':$(window).width()+'px',
                                'height':'auto'
                            };
						}
						//设置PC端三排广告
                        if(isPCfloat.indexOf(i)>=0){
                            var imgops = {
                                'max-width':(j.width.indexOf('%') >= 0 || j.width.indexOf('auto') >= 0) ? j.width : j.width+'px',
                                'max-height':(j.height.indexOf('%')>=0 || j.height.indexOf('auto') >= 0) ? j.height  : j.height+'px',
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