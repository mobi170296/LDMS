		</div>
	</body>
</html>
<?php
	if(isset($mcon) && $mcon->getConnectErrno()==0){
		$mcon->close();
	}
?>