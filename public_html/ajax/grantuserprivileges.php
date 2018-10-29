<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	require_once $CNF['PATHS']['CLASSES'].'/ajaxeditresult.php';

	header('content-type: application/json');
	try{
		if(!isset($_POST['grantuserprivileges'])){
			throw new Exception('Yêu cầu không hợp lệ');
		}
		if(!isset($_POST['id'])||!is_numeric($_POST['id'])){
			throw new Exception('Không tồn tại người dùng này');
		}
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		$user = new User($mcon);
		$user->dangNhap();
		if(!$user->getQuyen()->contain(PRIVILEGES['CAP_QUYEN_NGUOI_DUNG'])){
			throw new Exception('Bạn không có quyền cấp quyền cho người dùng');
		}
		
		$maxprivileges = count(PRIVILEGES);
		#check form data
		if(isset($_POST['quyen'])){
			if(is_array($_POST['quyen'])){
				foreach($_POST['quyen'] as $v){
					if(!is_numeric($v)||$v<1||$v>$maxprivileges){
						throw new Exception('Quyền không hợp lệ');
					}
				}
			}else{
				throw new Exception('Quyền không hợp lệ');
			}
			$user->capQuyenNguoiDung($_POST['id'], new MSet($_POST['quyen']));
		}else{
			#don't send privileges array so administrator want not grant any privileges to this user
			$user->capQuyenNguoiDung($_POST['id'], new MSet());
		}
		echo json_encode(new AJAXEditResult(1, ['Cấp quyền cho người dùng thành công!']), JSON_UNESCAPED_UNICODE);
	}catch(Exception $e){
		echo json_encode(new AJAXEditResult(0, [$e->getMessage()]), JSON_UNESCAPED_UNICODE);
	}