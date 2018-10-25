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
		if(!$user->getQuyen()->contain(PRIVILEGES['XOA_NHOM'])){
			throw new Exception('Bạn không có quyền xóa nhóm');
		}
		try{
			if(isset($_POST['deletegroup'])){
				$data_error = [];
				if(!isset($_POST['manhom']) || !is_string($_POST['manhom']) || !preg_match('/^\w{1,10}$/i', $_POST['manhom'])){
					$data_error[] = 'Mã nhóm không hợp lệ, mã nhóm phải ít hơn hoặc bằng 10 ký tự, chỉ chứa chỉ chữ số, chữ cái và _';
				}
				if(count($data_error)){
					throw new NotValidFormDataException($data_error);
				}
				$user->xoaNhom($_POST['manhom']);
				echo json_encode(new AJAXEditResult(1, ['Xóa thành công nhóm người dùng ' . $_POST['manhom']]), JSON_UNESCAPED_UNICODE);
				exit();
			}else{
				throw new Exception('Yêu cầu không hợp lệ'); 
				exit();
			}
		}catch(NotValidFormDataException $e){
			echo json_encode(new AJAXEditResult(0, $e->getErrors()), JSON_UNESCAPED_UNICODE);
			exit();
		}catch(Exception $e){
			echo json_encode(new AJAXEditResult(0, [$e->getMessage()]), JSON_UNESCAPED_UNICODE);
			exit();
		}
	}catch(Exception $e){
		echo json_encode(new AJAXEditResult(0, [$e->getMessage()]), JSON_UNESCAPED_UNICODE);
		exit();
	}
?>