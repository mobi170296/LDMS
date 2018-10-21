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
		if(!$user->getQuyen()->contain(PRIVILEGES['SUA_DON_VI'])){
			throw new Exception('Bạn không có quyền sửa đơn vị');
		}
		try{
			if(isset($_POST['editdepartment'])){
				$data_error = [];
				if(!isset($_POST['madonvi']) || !is_string($_POST['madonvi']) || !preg_match('/^\w{1,10}$/i', $_POST['madonvi'])){
					$data_error[] = 'Mã đơn vị không hợp lệ, mã đơn vị phải ít hơn hoặc bằng 10 ký tự, chỉ chứa chỉ chữ số, chữ cái và _';
				}
				if(!isset($_POST['newmadonvi']) || !is_string($_POST['newmadonvi']) || !preg_match('/^\w{1,10}$/i', $_POST['newmadonvi'])){
					$data_error[] = 'Mã đơn vị không hợp lệ, mã đơn vị phải ít hơn hoặc bằng 10 ký tự, chỉ chứa chỉ chữ số, chữ cái và _';
				}
				if(!isset($_POST['tendonvi']) || !is_string($_POST['tendonvi']) || mb_strlen($_POST['tendonvi'], 'UTF-8')==0 || mb_strlen($_POST['tendonvi'], 'UTF-8')>100){
					$data_error[] = 'Tên đơn vị không hợp lệ, tên đơn vị không được trống và không nhiều hơn 100 ký tự';
				}
				if(!isset($_POST['email']) || !is_string($_POST['email']) || strlen($_POST['email']) > 50 ||!preg_match('/^(\w+\.)*\w+@(\w+\.)+[a-z]{2,3}$/i', $_POST['email'])){
						$data_error[] = 'Địa chỉ email không hợp lệ, địa chỉ email phải dưới 50 ký tự và phải theo định dạng email';
				}
				if(count($data_error)){
					throw new NotValidFormDataException($data_error);
				}
				$user->suaDonVi($_POST['madonvi'], new DepartmentInfo($_POST['newmadonvi'], $_POST['tendonvi'], $_POST['email'], null));
				echo json_encode(new AJAXEditResult(1, ['Sửa thông tin đơn vị '.$_POST['madonvi'].' thành công!']), JSON_UNESCAPED_UNICODE);
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