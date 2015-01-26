/*
*@requrie banner.less
*/
var $ = require('../core/core.js');
function banner(args){
	var template = __inline('bannerTpl.tpl');
	var el = template(args);
	$.page.ready(function(){
		var interval;
		var curId;
		var target = $('#common_banner');
		function start(){
			target.find('ul.images li').removeClass();
			target.find('ul.images li').addClass('right');
			target.find('ul.points li').removeClass();
			target.find('ul.images li:first-child').addClass('center');
			target.find('ul.points li:first-child').addClass('active');
			curId = 0;
			interval = setInterval(nextImage,args.interval);
		}
		function nextImage(){
			var prevId = ( curId + args.images.length - 1 )%args.images.length;
			var nextId = ( curId + 1 )%args.images.length;
			//������һ��
			target.find('ul.images li[data='+prevId+']').removeClass();
			target.find('ul.images li[data='+prevId+']').addClass('right');
			//���ñ���
			target.find('ul.images li[data='+curId+']').removeClass();
			target.find('ul.images li[data='+curId+']').addClass('left');
			target.find('ul.points li[data='+curId+']').removeClass();
			//������һ��
			target.find('ul.images li[data='+nextId+']').removeClass();
			target.find('ul.images li[data='+nextId+']').addClass('center');
			target.find('ul.points li[data='+nextId+']').addClass('active');
			//����id
			curId = nextId;
		}
		start();
	});
	return {
		el:el
	}
}
return banner;