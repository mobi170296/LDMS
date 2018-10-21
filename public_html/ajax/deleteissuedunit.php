<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	require_once $CNF['PATHS']['CLASSES'].'/ajaxeditresult.php';
	header('content-type: application/json');
	try{
		$mcon = new MDatabase(DATABASE['HOST'], DATABASE['USERNAME'], DATABASE['PASSWORD'], DATABASE['DB_NAME']);
		$user = new User($mcon);
		$user->dangNhap();
		if(!$user->getQuyen()->contain(PRIVILEGES['XOA_DON_VI'])){
			throw new Exception('Bạn không có quyền xóa đơn vị');
		}
		try{
			if(isset($_POST['deleteissuedunit'])){
				$data_error = [];
				if(!isset($_POST['madonvi']) || !is_string($_POST['madonvi']) || !preg_match('/^\w{1,10}$/i', $_POST['madonvi'])){
					$data_error[] = 'Mã đơn vị không hợp lệ, mã đơn vị phải ít hơn hoặc bằng 10 ký tự, chỉ chứa chỉ chữ số, chữ cái và _';
				}
				if(count($data_error)){
					throw new NotValidFormDataException($data_error);
				}
				$user->xoaDonViBanHanh($_POST['madonvi']);
				echo json_encode(new AJAXEditResult(1, ['Xóa đơn vị ban hành '.$_POST['madonvi'].' thành công!']), JSON_UNESCAPED_UNICODE);
				exit();
			}else{
				throw new Exception('Yêu cầu không hợp lệ'); 
				exit();
			}
		}catch(NotValidFormDataException $e){
			echo json_encode(new AJAXEditResult(0, $e->getErrors()), JSON_UNESCAPED_UNICODE);
			exit();
		}catch(Exception $e){
			echo json_encode(new AJAXEditResult(0, $e->getMessage()), JSON_UNESCAPED_UNICODE);
			exit();
		}
	}catch(Exception $e){
		echo json_encode(new AJAXEditResult(0, $e->getMessage()), JSON_UNESCAPED_UNICODE);
		exit();
	}
?>