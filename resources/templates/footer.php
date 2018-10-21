		</div>
	<script type="text/javascript">
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
	</script>
	</body>
</html>
<?php
	if(isset($mcon) && $mcon->getConnectErrno()==0){
		$mcon->close();
	}
?>