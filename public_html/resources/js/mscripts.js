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