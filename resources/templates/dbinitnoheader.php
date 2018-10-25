<?php
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['LIBRARY'].'/database/mdatabase.php';
	$mcon = @new MDatabase(DATABASE['HOST'], DATABASE['USERNAME'], DATABASE['PASSWORD'], DATABASE['DB_NAME']);
?>