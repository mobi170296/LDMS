<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	require_once $CNF['PATHS']['CLASSES'].'/ajaxeditresult.php';

	header('content-type: application/json');
	try{
		if(!isset($_POST['id'])||!is_numeric($_POST['id'])){
			throw new Exception('Yêu cầu không hợp lệ');
		}
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		$user = new User($mcon);
		$user->dangNhap();
		
		if(!$user->getQuyen()->contain(PRIVILEGES['XOA_CONG_VAN_DEN'])){
			throw new Exception('Bạn không có quyền xóa công văn');
		}
		
		$user->xoaCongVanDen($_POST['id'], $CNF['PATHS']['LEGALDOCUMENT_DIR'].'/tentaptin.pdf');
		echo json_encode(new AJAXEditResult(1, ['Xóa công văn này thành công!']), JSON_UNESCAPED_UNICODE);
	}catch(Exception $e){
		echo json_encode(new AJAXEditResult(0, [$e->getMessage()]), JSON_UNESCAPED_UNICODE);
	}
	