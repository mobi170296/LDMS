<?php
	session_start();
	try{
		if(!isset($_POST['deleteuser'])||!isset($_POST['id'])||!is_numeric($_POST['id'])){
			throw new Exception('Yêu cầu không hợp lệ');
		}
		require_once __DIR__.'/../../config/config.php';
		require_once $CNF['PATHS']['CLASSES'].'/user.php';
		require_once $CNF['PATHS']['CLASSES'].'/ajaxeditresult.php';
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		$user = new User($mcon);
		$user->dangNhap();
		if(!$user->getQuyen()->contain(PRIVILEGES['XOA_NGUOI_DUNG'])){
			throw new Exception('Bạn không có quyền xóa người dùng');
		}
		$user->xoaNguoiDung($_POST['id']);
		echo json_encode(new AJAXEditResult(1, ['Xóa người dùng thành công']), JSON_UNESCAPED_UNICODE);
	}catch(Exception $e){
		echo json_encode(new AJAXEditResult(0, [$e->getMessage()]), JSON_UNESCAPED_UNICODE);
	}
?>