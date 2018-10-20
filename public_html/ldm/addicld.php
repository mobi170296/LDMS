<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	$CNF['HEADER']['TITLE'] = 'Đăng ký công văn đến';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	require_once $CNF['PATHS']['LIBRARY'].'/word/mword.php';
	require_once $CNF['PATHS']['LIBRARY'].'/datachecker/datachecker.php';
	require_once $CNF['PATHS']['LIBRARY'].'/datetime/mdatetime.php';
	require_once $CNF['PATHS']['TEMPLATES'].'/dbinit.php';
	
	try{
		$user = new User($mcon);
		$user->dangNhap();
	}catch(Exception $e){
		
	}
	$CNF['BODY']['CURRENT_SCRIPT'] = '/ldm/addicld.php';
	require_once $CNF['BODY']['MAIN_TEMPLATE'];
?>