		</div>
	<script type="text/javascript" src="/resources/js/bmscript.js">
	</script>
	</body>
</html>
<?php
	if(isset($mcon) && $mcon->getConnectErrno()==0){
		$mcon->close();
	}
?>