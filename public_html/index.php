<?php
	session_start();
	require_once __DIR__.'/../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	require_once $CNF['PATHS']['TEMPLATES'].'/dbinit.php';
	$user = new User($mcon);
	try{
		$user->dangNhap();
	}catch(Exception $e){
		
	}
	$CNF['HEADER']['TITLE'] = 'Trang chủ - Quản lý công văn';
	
	$CNF['BODY']['CURRENT_SCRIPT'] = '/index.php';
	# Xử lý ở đây với những yêu cầu trước khi gửi content
	# Bắt đầu output ở đây
	require_once($CNF['BODY']['MAIN_TEMPLATE']);
?>