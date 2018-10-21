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
		if(!$user->getQuyen()->contain(PRIVILEGES['SUA_LOAI_VAN_BAN'])){
			throw new Exception('Bạn không có quyền sửa loại văn bản');
		}
		try{
			if(isset($_POST['editdoctype'])){
				$data_error = [];
				if(!isset($_POST['maloai']) || !is_string($_POST['maloai']) || !preg_match('/^\w{1,10}$/i', $_POST['maloai'])){
					$data_error[] = 'Mã loại văn bản không hợp lệ, mã loại có dộ dài tối đa là 10 không được rỗng, chỉ chứa chữ cái, chữ số và _';
				}
				if(!isset($_POST['newmaloai']) || !is_string($_POST['newmaloai']) || !preg_match('/^\w{1,10}$/i', $_POST['newmaloai'])){
					$data_error[] = 'Mã loại văn bản không hợp lệ, mã loại có dộ dài tối đa là 10 không được rỗng, chỉ chứa chữ cái, chữ số và _';
				}
				if(!isset($_POST['tenloai']) || !is_string($_POST['tenloai']) || mb_strlen($_POST['tenloai'], 'UTF-8')==0 || mb_strlen($_POST['tenloai'], 'UTF-8') > 50){
					$data_error[] = 'Tên loại văn bản không hợp lệ, tên loại phải có đọ dài từ 1 đén 50 ký tự';
				}
				if(count($data_error)){
					throw new NotValidFormDataException($data_error);
				}
				$user->suaLoaiVanBan($_POST['maloai'], new DocTypeInfo($_POST['newmaloai'], $_POST['tenloai'], null));
				echo json_encode(new AJAXEditResult(1, ['Sửa thông tin loại văn bản \''.$_POST['maloai'].'\' thành công']), JSON_UNESCAPED_UNICODE);
				exit();
			}else{
				throw new Exception('Yêu cầu không hợp lệ');
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