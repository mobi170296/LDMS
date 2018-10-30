<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	require_once $CNF['PATHS']['TEMPLATES'].'/dbinit.php';

	try{
		$user = new User($mcon);
		$user->dangNhap();
	}catch(Exception $e){
		
	}
	$CNF['HEADER']['TITLE'] = 'Tìm kiếm công văn đến';
	$CNF['BODY']['CURRENT_SCRIPT'] = '/ldm/searchicld.php';

	require_once($CNF['BODY']['MAIN_TEMPLATE']);
?>