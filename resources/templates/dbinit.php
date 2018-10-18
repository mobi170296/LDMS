<?php
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['LIBRARY'].'/database/mdatabase.php';
	try{
		$mcon = @new MDatabase(DATABASE['HOST'], DATABASE['USERNAME'], DATABASE['PASSWORD'], DATABASE['DB_NAME']);
	}catch(Exception $e){
		$error = 'Lỗi CSDL: ' . $e->getMessage();
		require_once $CNF['PATHS']['ERROR_PAGE'];
		exit();
	}
?>