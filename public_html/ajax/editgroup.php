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
		if(!$user->getQuyen()->contain(PRIVILEGES['SUA_NHOM'])){
			throw new Exception('Bạn không có quyền sửa nhóm');
		}
		try{
			if(isset($_POST['editgroup'])){
				$data_error = [];
				if(!isset($_POST['manhom']) || !is_string($_POST['manhom']) || !preg_match('/^\w{1,10}$/i', $_POST['manhom'])){
					$data_error[] = 'Mã nhóm không hợp lệ, mã nhóm phải ít hơn hoặc bằng 10 ký tự, chỉ chứa chỉ chữ số, chữ cái và _';
				}
				if(!isset($_POST['newmanhom']) || !is_string($_POST['newmanhom']) || !preg_match('/^\w{1,10}$/i', $_POST['newmanhom'])){
					$data_error[] = 'Mã nhóm không hợp lệ, mã nhóm phải ít hơn hoặc bằng 10 ký tự, chỉ chứa chỉ chữ số, chữ cái và _';
				}
				if(!isset($_POST['tennhom']) || !is_string($_POST['tennhom']) || mb_strlen(DataChecker::trim($_POST['tennhom']), 'UTF-8')==0 || mb_strlen($_POST['tennhom'], 'UTF-8')>100){
					$data_error[] = 'Tên nhóm không hợp lệ, tên nhóm không được trống và không nhiều hơn 100 ký tự';
				}
				if(count($data_error)){
					throw new NotValidFormDataException($data_error);
				}
				$user->suaNhom($_POST['manhom'], new GroupInfo($_POST['newmanhom'], $_POST['tennhom'], null));
				echo json_encode(new AJAXEditResult(1, ['Sửa thành công nhóm người dùng ' . $_POST['manhom']]), JSON_UNESCAPED_UNICODE);
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