		</div>
	<script type="text/javascript">
		var popup = $get('div#popup');
		if(popup!=null){
			popup.onclick = function(e){
				this.$css('opacity', '0');
				window.setTimeout(function(e){e.$css('display', 'none')}, 500, this);
			}
		}
		var popupcontent = $get('div#popup-content');
		if(popupcontent!=null){
			popupcontent.onclick = function(e){
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