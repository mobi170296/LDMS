<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	require_once $CNF['PATHS']['LIBRARY'].'/word/mword.php';
	require_once $CNF['PATHS']['CLASSES'].'/ajaxeditresult.php';
	header('content-type: application/json');
	try{
		if(!isset($_POST['id'])||!is_numeric($_POST['id'])){
			throw new Exception('Yêu cầu không hợp lệ');
		}
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		$user = new User($mcon);
		$user->dangNhap();
		if(!$user->getQuyen()->contain(PRIVILEGES['PHE_DUYET_CONG_VAN_DEN'])){
			throw new Exception('Bạn không có quyền phê duyệt công văn');
		}
		$data_errors = [];
		if(isset($_POST['ykienpheduyet'])&&is_string($_POST['ykienpheduyet'])){
			if(MWord::count($_POST['ykienpheduyet'])<3){
				$data_errors[] = 'Ý kiển phê duyệt ít nhất phải có 3 ký tự!';
			}
		}else{
			$data_errors[]='Vui lòng cho ý kiển phê duyệt cho công văn này';
		}
		if(count($data_errors)){
			throw new NotValidFormDataException($data_errors);
		}
		$user->themYKienPheDuyet($_POST['id'], $_POST['ykienpheduyet']);
		echo json_encode(new AJAXEditResult(1, ['Đã thêm thành công ý kiến phê duyệt']), JSON_UNESCAPED_UNICODE);
	}catch(NotValidFormDataException $e){
		echo json_encode(new AJAXEditResult(0, $e->getErrors(), JSON_UNESCAPED_UNICODE));
	}catch(Exception $e){
		echo json_encode(new AJAXEditResult(0, [$e->getMessage()]), JSON_UNESCAPED_UNICODE);
	}