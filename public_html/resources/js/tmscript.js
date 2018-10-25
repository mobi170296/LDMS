"use strict";

(function(){
	Element.prototype.$css = function(p, v){
		this.style[p] = v;
		return this;
	}
	Node.prototype.$css = function(p, v){
		this.style[p] = v;
		return this;
	}
	Element.prototype.$gcss = function(p){
		return this.style[p];
	}
	Node.prototype.$gcss = function(p){
		return this.style[p];
	}
	Element.prototype.$get = function(query){
		return this.querySelector(query);
	}
	Node.prototype.$get = function(query){
		return this.querySelector(query);
	}
	Element.prototype.$gets = function(query){
		return this.querySelectorAll(query);
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
	$get('div#left-panel').$css('filter', 'blur(1px)');
	$get('div#content').$css('filter', 'blur(1px)');
	pc.innerHTML = '';
	pc.append(createEID('div', 'loading-icon'));
	pc.$css('top', '0px');
	var xhr = $ajax();
	xhr.open('post', desturl);
	xhr.onreadystatechange = function(e){
		if(this.readyState==this.DONE){
			var pc = $get('div#popup-content');
			pc.$css('top', '0px');
			if(this.status==200){
				pc.innerHTML = this.response;
			}else{
				pc.innerHTML = '<div class="error-message-box">Đã xảy ra lỗi ' + this.status + '</div>';
			}
		}
	}
	var d = new FormData();
	for(var i=0; i<aid.length; i++){
		d.append(aid[i][0], aid[i][1]);
	}
	xhr.send(d);
}
function ajaxSubmitEdit(form){
	var p = $get('div#popup');
	var pc = $get('div#popup-content');
	pc.innerHTML = '';
	pc.append(createEID('div', 'loading-icon'));
	var xhr = $ajax();
	xhr.open('post', form.action);
	xhr.onreadystatechange = function(e){
		if(this.readyState == this.DONE){
			var pc = $get('div#popup-content');
			pc.$css('top', '0px');
			if(this.status==200){
				var result = JSON.parse(this.response);
				if(result.success){
					var s = '<div class="success-message-box">';
					for(var i=0; i<result.messages.length; i++){
						s += result.messages[i];
					}
					s += '</div>';
					pc.innerHTML = s;
					window.setTimeout(function(){document.location.reload();}, 1000);
				}else{
					var s = '<div class="error-message-box">';
					for(var i=0; i<result.messages.length; i++){
						s += result.messages[i];
					}
					s += '</div>';
					pc.innerHTML = s;
				}
			}else{
				pc.innerHTML = '<div class="error-message-box">Đã xảy ra lỗi ' + this.status + '</div>';
			}
		}
	}
	var d = new FormData(form);
	xhr.send(d);
}
function ajaxSubmitDelete(form){
	var p = $get('div#popup');
	var pc = $get('div#popup-content');
	pc.innerHTML = '';
	pc.append(createEID('div', 'loading-icon'));
	var xhr = $ajax();
	xhr.open('post', form.action);
	xhr.onreadystatechange = function(e){
		if(this.readyState == this.DONE){
			var pc = $get('div#popup-content');
			pc.$css('top', '0px');
			if(this.status==200){
				var result = JSON.parse(this.response);
				if(result.success){
					var s = '<div class="success-message-box">';
					for(var i=0; i<result.messages.length; i++){
						s += result.messages[i];
					}
					s += '</div>';
					pc.innerHTML = s;
					window.setTimeout(function(){document.location.reload();}, 1000);
				}else{
					var s = '<div class="error-message-box">';
					for(var i=0; i<result.messages.length; i++){
						s += result.messages[i];
					}
					s += '</div>';
					pc.innerHTML = s;
				}
			}else{
				pc.innerHTML = '<div class="error-message-box">Đã xảy ra lỗi ' + this.status + '</div>';
			}
		}
	}
	var d = new FormData(form);
	xhr.send(d);
}