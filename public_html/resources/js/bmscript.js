// JavaScript Document
function adjustHeightMenu(){
	var p=$get('#left-panel');
	var m=$get('#menu');
	if(p&&m){
		var mh=p.clientHeight;
		var h=0;
		for(var i=0;i<p.children.length;i++){
			if(p.children[i]!=m){
				h+=p.children[i].clientHeight;
			}
		}
		if(mh-h>0){
			m.$css('height',mh-h+'px');
		}else{
			m.$css('height','0px;');
		}
	}
}
(function(){
	var mb=$get('#menu-btn');
	if(mb){
		mb.onclick=function(e){
			var l=$get('#left-panel');
			if(l){
				if(getComputedStyle(l).display=='none'){
					l.$css('display', 'block');
				}else{
					l.$css('display', 'none');
				}
			}
		}
	}
	adjustHeightMenu();
	window.onresize=function(e){
		if(window.innerWidth>=800){
			var l=$get('#left-panel');
			if(l){
				l.$css('display','block');
			}
		}else{
			var l=$get('#left-panel');
			if(l){
				l.$css('display',null);
			}
		}
		adjustHeightMenu();
	}
	document.body.onload=function(e){var s=$get('#splash');if(s)s.$css('display','none');}
	var p = $get('div#popup');
	if(p!=null){
		p.onclick = function(e){
			$get('div#popup-content').$css('top', '-'+$get('div#popup-content').clientHeight+'px');
			
			window.setTimeout(function(e){e.$css('display', 'none');$get('div#left-panel').$css('filter', 'none');
			$get('div#content').$css('filter', 'none');}, 500, this);
		}
	}
	var pc = $get('div#popup-content');
	if(pc!=null){
		pc.onclick = function(e){
			e.stopPropagation();
		}
	}
//	var mt = $gets('div.menu-l1-title');
//	if(mt!=null){
//		for(var i=0;i<mt.length;i++){
//			var cc = mt[i].nextElementSibling.children;
//			var h = 0;
//			for(var j=0; j<cc.length; j++){
//				h+=cc[i].clientHeight;
//			}
//			mt[i].nextElementSibling.$css('height', h+'px');
//			
//			mt[i].onclick = function(e){
//				var c = this.nextElementSibling;
//				if(c!=null){
//					var ch = getComputedStyle(c).height;
//					if(ch=='0px'){
//						var cc = c.children;
//						var h = 0;
//						for(var j=0; j<cc.length; j++){
//							h+=parseInt(getComputedStyle(cc[j]).height);
//						}
//						c.$css('height', h+'px');
//					}else{
//						c.$css('height', '0px');
//						
//					}
//				}
//			}
//		}
//	}
	var mt=$gets('div.menu-l1-title');
	if(mt){
		for(var i=0;i<mt.length;i++){
			mt[i].nextElementSibling.realHeight=mt[i].nextElementSibling.clientHeight;
			mt[i].nextElementSibling.$css('height', mt[i].nextElementSibling.realHeight+'px');
			mt[i].onclick=function(e){
				var m=this.nextElementSibling;
				if(m.clientHeight){
					m.$css('height', '0px');
				}else{
					m.$css('height', m.realHeight+'px');
				}
			}
		}
	}
	var page_btns = $gets('button.page-btn');
	if(page_btns!=null){
		for(var i=0; i<page_btns.length; i++){
			page_btns[i].onclick = function(e){
				var uri=document.location.href;
				if(/p=\d+/i.test(uri)){
					uri=uri.replace(/p=\d+/, 'p='+parseInt(this.innerHTML));
					console.log(this.innerHTML);
				}else{
					if(uri.indexOf('?')>=0){
						uri+='&p=' + parseInt(this.innerHTML);
					}else{
						uri+='?p=' + parseInt(this.innerHTML);
					}
				}
				document.location.href=uri;
			}
		}
	}
})();
