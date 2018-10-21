"use strict";

(function(){
	Node.prototype.$css = function(p, v){
		this.style[p] = v;
		return this;
	}
	Node.prototype.$get = function(query){
		return this.querySelector(query);
	}
	Node.prototype.$gets = function(query){
		return this.querySelectorAll(query);
	}
})();

function $get(query){
	return document.querySelector(query);
}
function $gets(query){
	return document.querySelectorAll(query);
}
function $create(name){
	return document.createElement(name);
}
function $ajax(){
	if(typeof ActiveXObject == 'function'){
		return new ActiveXObject("Microsoft.XMLHTTP");
	}else if(typeof XMLHttpRequest == 'function'){
		return new XMLHttpRequest();
	}else{
		return null;
	}
}
function getMaxDayOfMonth(month, year){
	if(month<=0 || month > 12 || year <= 0) return 0;
	var m4 = (year % 4) == 0;
	var m100 = (year % 100) == 0;
	var m400 = (year % 400) == 0;
	var maxday = [31, (m4 & !(m100 ^ m400)) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
	return maxday[month - 1];
}
function createEID(name, id){
	var e = $create(name);
	e.id = id;
	return e;
}
function createEC(name, cls){
	var e = $create(name);
	e.className = cls;
	return e;
}
function showFormPopup(desturl, aid){
	var popup = $get('div#popup');
	var pc = $get('div#popup-content');
	popup.$css('display', 'block');
	pc.innerHTML = '';
	pc.append(createEID('div', 'loading-icon'));
	//pc.$css('top', '0px');
	var xhr = $ajax();
	xhr.open('post', desturl);
	xhr.onreadystatechange = function(e){
		if(this.readyState==this.DONE){
			var pc = $get('div#popup-content');
			pc.$css('top', '0px');
			if(this.status==200){
				pc.innerHTML = this.response;
			}else{
				pc.innerHTML = '<div class="error-message-box">Đã xảy ra lỗi</div>';
			}
		}
	}
	var d = new FormData();
	for(var i=0; i<aid.length; i++){
		d.append(aid[i][0], aid[i][1]);
	}
	xhr.send(d);
}