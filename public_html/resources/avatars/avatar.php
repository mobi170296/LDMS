<?php
	session_start();
	require_once __DIR__.'/../../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	
	try{
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		$user = new User($mcon);
		$user->dangNhap();
		header('content-type: image/png');
		$filename = $CNF['PATHS']['AVATAR_DIR'].'/'.$_GET['nc'].'.png';
		if(file_exists($filename)){
			readfile($filename);
		}else{
			readfile($CNF['PATHS']['AVATAR_DIR'].'/default.png');
		}
	}catch(Exception $e){
		header('Content-type: text/plain');
		echo 'Bạn muốn xem gì???';
	}