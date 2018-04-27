$(function(){
	reset();
	window.onresize=reset();
	$("#searchOpen").click(function(){$("#search").show()});
	$("#searchClose").click(function(){$("#search").hide()});
	
	var navWidht=0;
	$("#nav .nav-item").each(function(){
		navWidht=navWidht+$(this).outerWidth()+5;
	})
	$("#nav").width(navWidht)
})
function reset(){
	var bWidth=document.body.clientWidth;//获取 屏幕的宽度
	//bWidth = bWidth>640 ? 640 : bWidth;//如果宽度大于640那么就给他复制为640
	var size=bWidth/320*20;
	document.getElementsByTagName('html')[0].style.fontSize=size+'px';
}