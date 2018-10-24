<?php
	session_start();
	require_once __DIR__.'/../../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	require_once $CNF['PATHS']['TEMPLATES'].'/dbinit.php';

	try{
		if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
			throw new Exception('Yêu cầu không hợp lệ');
		}
		$user = new User($mcon);
		$user->dangnhap();
		$legaldocumentinfo = $user->getCongVanDen($_GET['id']);
		
		$filename = $CNF['PATHS']['LEGALDOCUMENT_DIR'].'/'.$legaldocumentinfo->getTenTapTin();
		
		if(file_exists($filename)){
			if(isset($_GET['action']) && $_GET['action']=='download'){
				header('Content-Description: File Transfer');
				header('Content-Type: application/pdf');
				header('Content-Disposition: attachment; filename="'.$legaldocumentinfo->getTenTapTin().'"');
				header('Expires: 0');
				header('Cache-control: must-revalidate');
				header('pragma: public');
				header('content-length: ' . filesize($filename));
			}else{
				header('content-type: application/pdf');
			}
			readfile($filename);
		}else{
			throw new Exception('Tập tin đã gặp sự cố hiển thị, có thể tập tin này không tồn tại. Vui lòng kiểm tra lại công văn. Hoặc liên hệ với Quản trị hệ thống để được giúp đỡ!');
		}
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>