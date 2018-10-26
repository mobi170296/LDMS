<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	require_once $CNF['PATHS']['CLASSES'].'/ajaxeditresult.php';

	try{
		if(!isset($_POST['verifyapproval'])){
			throw new Exception('Yêu cầu không hợp lệ');
		}
		if(!isset($_POST['id'])||!is_numeric($_POST['id'])){
			throw new Exception('Công văn này không tồn tại');
		}
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		$user = new User($mcon);
		$user->dangNhap();
		if(!$user->getQuyen()->contain(PRIVILEGES['PHE_DUYET_CONG_VAN_DEN'])){
			throw new Exception('Bạn không có quyền phê duyệt công văn');
		}
		$user->xacNhanYKienPheDuyet($_POST['id']);
		echo json_encode(new AJAXEditResult(1, ['Đã phê duyệt công văn thành công']), JSON_UNESCAPED_UNICODE);
	}catch(Exception $e){
		echo json_encode(new AJAXEditResult(0, [$e->getMessage()]), JSON_UNESCAPED_UNICODE);
	}
?>