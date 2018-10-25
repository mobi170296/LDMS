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
		if(!$user->getQuyen()->contain(PRIVILEGES['XOA_LOAI_VAN_BAN'])){
			throw new Exception('Bạn không có quyền xóa loại văn bản');
		}
		try{
			if(isset($_POST['deletedoctype'])){
				$data_error = [];
				if(!isset($_POST['maloai']) || !is_string($_POST['maloai']) || !preg_match('/^\w{1,10}$/i', $_POST['maloai'])){
					$data_error[] = 'Mã loại văn bản không hợp lệ, mã loại có dộ dài tối đa là 10 không được rỗng, chỉ chứa chữ cái, chữ số và _';
				}
				if(count($data_error)){
					throw new NotValidFormDataException($data_error);
				}
				$user->xoaLoaiVanBan($_POST['maloai']);
				echo json_encode(new AJAXEditResult(1, ['Xóa thành công loại văn bản ' . $_POST['maloai']]), JSON_UNESCAPED_UNICODE);
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