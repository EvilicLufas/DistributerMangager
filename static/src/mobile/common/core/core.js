/*
*@require /fishstrap/lib/fastclick.js
*@require core.less
*/
var $ = require('/fishstrap/core/global.js');
var dialog = require('../dialog/dialog.js');
//����FastClick��չ
window.FastClick.attach(document.body);
//�޸�ajax�����������Զ�ת�ջ����Զ�ת��json���Զ���׽json������������Ĺ��ܡ�
var _dialogAjax = $.ajax;
$.ajax = function(opt){
	dialog.loadingBegin();
	var tempComplete = opt.complete;
	opt.complete = function(XMLHttpRequest,textStatus){
		dialog.loadingEnd();
		if( tempComplete )
			tempComplete(XMLHttpRequest,textStatus);
	}
	var tempSuccess = opt.success;
	opt.success = function(data){
		try{
			data = $.JSON.parse(data);
			$.log.debug(data);
		}catch(e){
			data = {
				'code':1,
				'msg':'JSON��������',
				'data':''
			};
		}
		tempSuccess(data);
	}
	var tempError = opt.error;
	opt.error = function(XMLHttpRequest, textStatus, errorThrown){
		data = {
			'code':1,
			'msg':'',
			'data':''
		};
		data.msg = '����������Ժ����ԣ����������'+XMLHttpRequest.status;
		tempSuccess(data);
		if( tempError )
			tempError(XMLHttpRequest, textStatus, errorThrown);
	}
	_dialogAjax(opt);
};
//��ҳ�����
(function(){
	var body = $('#body');
	var readyFun = [];
	function start(html){
		body.empty();
		body.append(html);
		for( var i in readyFun ){
			readyFun[i]();
		}
		readyFun = [];
	}
	function ready(fun){
		readyFun.push(fun);
	}
	$.page = {
		start:start,
		ready:ready
	};
}());
module.exports = $;