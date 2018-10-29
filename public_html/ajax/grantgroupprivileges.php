<?php
	header('content-type: application/json');
	try{
		if(!isset($_POST['grantgroupprivileges'])||!isset($_POST['manhom'])||!is_string($_POST['manhom'])){
			throw new Exception('Yêu cầu không hợp lệ');
		}
		session_start();
		require_once __DIR__.'/../../config/config.php';
		require_once $CNF['PATHS']['CLASSES'].'/user.php';
		require_once $CNF['PATHS']['CLASSES'].'/ajaxeditresult.php';
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		$user = new User($mcon);
		$user->dangNhap();
		if(!$user->getQuyen()->contain(PRIVILEGES['CAP_QUYEN_NHOM'])){
			throw new Exception('Bạn không có quyền thực hiện cấp quyền cho nhóm người dùng');
		}
		
		$max = count(PRIVILEGES);
		if(isset($_POST['quyen'])){
			if(is_array($_POST['quyen'])){
				foreach($_POST['quyen'] as $v){
					if(!is_numeric($v)||$v<1||$v>$max){
						throw new Exception('Quyền không hợp lệ');
					}
				}
			}else{
				throw new Exception('Quyền không hợp lệ');
			}
			$user->capQuyenNhomNguoiDung($_POST['manhom'], new MSet($_POST['quyen']));
		}else{
			$user->capQuyenNhomNguoiDung($_POST['manhom'], new MSet());
		}
		echo json_encode(new AJAXEditResult(1, ['Đã cấp quyền thành công cho nhóm người dùng']), JSON_UNESCAPED_UNICODE);
	}catch(Exception $e){
		echo json_encode(new AJAXEditResult(0, [$e->getMessage()]), JSON_UNESCAPED_UNICODE);
	}