<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	require_once $CNF['PATHS']['TEMPLATES'].'/dbinit.php';

	$user = new User($mcon);
	try{
		$user->dangNhap();
	}catch(Exception $e){
		
	}

	$CNF['HEADER']['TITLE'] = 'Danh sách công văn đến';
	$CNF['BODY']['CURRENT_SCRIPT'] = '/ldm/icldlist.php';
	require_once $CNF['BODY']['MAIN_TEMPLATE'];
?>