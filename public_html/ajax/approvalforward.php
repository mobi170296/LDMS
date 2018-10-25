<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	require_once $CNF['PATHS']['CLASSES'].'/ajaxeditresult.php';
	header('content-type: application/json');
	try{
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		$user = new User($mcon);
		$user->dangNhap();
		if(!$user->getQuyen()->contain(PRIVILEGES['THEM_CONG_VAN_DEN'])){
			throw new Exception('Bạn không có quyền chuyển phê duyệt công văn đến');
		}
		if(!isset($_POST['approvalicld'])){
			throw new Exception('Yêu cầu không hợp lệ');
		}
		try{
			$data_error = [];
			if(!isset($_POST['idcongvan'])||!is_numeric($_POST['idcongvan'])){
				$data_error[] = 'Công văn không hợp lệ';
			}
			if(!isset($_POST['idnguoipheduyet'])||!is_numeric($_POST['idnguoipheduyet'])){
				$data_error[] = 'Người phê duyệt không hợp lệ';
			}
			if(count($data_error)){
				throw new NotValidFormDataException($data_error);
			}
			
			$user->chuyenPheDuyet($_POST['idcongvan'], $_POST['idnguoipheduyet']);
			echo json_encode(new AJAXEditResult(1, ['Chuyển phê duyệt công văn thành công']), JSON_UNESCAPED_UNICODE);
			exit();
		}catch(NotValidFormDataException $e){
			echo json_encode(new AJAXEditResult(0, [$e->getErrors()]), JSON_UNESCAPED_UNICODE);
			exit();
		}
	}catch(Exception $e){
		echo json_encode(new AJAXEditResult(0, [$e->getMessage()]), JSON_UNESCAPED_UNICODE);
		exit();
	}
?>