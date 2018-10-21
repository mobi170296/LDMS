// JavaScript Document
(function(){
	var p = $get('div#popup');
	if(p!=null){
		p.onclick = function(e){
			$get('div#popup-content').$css('top', '-100%');
			window.setTimeout(function(e){e.$css('display', 'none')}, 500, this);
		}
	}
	var pc = $get('div#popup-content');
	if(pc!=null){
		pc.onclick = function(e){
			e.stopPropagation();
		}
	}
	var mt = $gets('div.menu-l1-title');
	if(mt!=null){
		for(var i=0;i<mt.length;i++){
			var cc = mt[i].nextElementSibling.children;
			var h = 0;
			for(var j=0; j<cc.length; j++){
				h+=parseInt(getComputedStyle(cc[j]).height);
			}
			mt[i].nextElementSibling.$css('height', h+'px');
			
			mt[i].onclick = function(e){
				var c = this.nextElementSibling;
				if(c!=null){
					var ch = getComputedStyle(c).height;
					if(ch=='0px'){
						var cc = c.children;
						var h = 0;
						for(var j=0; j<cc.length; j++){
							h+=parseInt(getComputedStyle(cc[j]).height);
						}
						c.$css('height', h+'px');
					}else{
						c.$css('height', '0px');
						
					}
				}
			}
		}
	}
})();
