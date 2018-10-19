<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	require_once $CNF['PATHS']['TEMPLATES'].'/dbinit.php';
	$CNF['HEADER']['TITLE'] = 'Thêm Khoa - Đơn vị';
	$user = new User($mcon);
	try{
		$user->dangNhap();
	}catch(Exception $e){
		
	}
	$CNF['BODY']['CURRENT_SCRIPT'] = '/admin/adddepartment.php';
	require_once($CNF['BODY']['MAIN_TEMPLATE']);
?>