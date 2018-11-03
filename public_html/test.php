<form action="" method="post" enctype="application/x-www-form-urlencode">
<textarea name="s"></textarea>
<input type="submit">
</form>

<?php
	if(isset($_POST['s'])){
		$l = strlen($_POST['s']);
		for($i=0;$i<$l; $i++){
			echo ord($_POST['s'][$i]) . ' ';
		}
	}