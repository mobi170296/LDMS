<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	require_once $CNF['PATHS']['CLASSES'].'/ajaxeditresult.php';
	header('content-type: application/json');
	try{
		if(!isset($_POST['edituser'])||!isset($_POST['id'])||!is_numeric($_POST['id'])){
			throw new Exception('Yêu cầu không hợp lệ');
		}
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		$user = new User($mcon);
		$user->dangNhap();
		if(!$user->getQuyen()->contain(PRIVILEGES['SUA_NGUOI_DUNG'])){
			throw new Exception('Bạn không có quyền sửa thông tin người dùng');
		}
		$data_error = [];
					
		if(!isset($_POST['maso']) || !is_string($_POST['maso']) || !preg_match('/^[a-cA-C]?[0-9]{1,8}$/', $_POST['maso'])){
			$data_error[] = 'Mã số cán bộ không hợp lệ';
		}
		$b_matkhau = false;
		if(isset($_POST['matkhau'][0]) && is_string($_POST['matkhau'][0]) && isset($_POST['matkhau'][1]) && is_string($_POST['matkhau'][1]) && strlen($_POST['matkhau'][0])){
			if(strlen($_POST['matkhau'][0])<6){
				$data_error[] = 'Độ dài mật khẩu không hợp lệ';
			}
			if($_POST['matkhau'][0] != $_POST['matkhau'][1]){
				$data_error[] = 'Mật khẩu không trùng';
			}
			
			$b_matkhau = true;
		}
		if(!isset($_POST['ho']) || !is_string($_POST['ho']) || !preg_match('/^[\p{L}\s]{1,40}$/u', $_POST['ho'])){
			$data_error[] = 'Họ và tên lót không hợp lệ độ dài họ phải dưới 40';
		}
		if(!isset($_POST['ho']) || !is_string($_POST['ho']) || !preg_match('/^[\p{L}\s]{1,20}$/u', $_POST['ho'])){
			$data_error[] = 'Tên không hợp lệ độ dài họ phải dưới 20';
		}
		if(isset($_POST['ngay']) && is_numeric($_POST['ngay']) && isset($_POST['thang']) && is_numeric($_POST['thang']) && isset($_POST['nam']) && is_numeric($_POST['nam'])){
			if(!checkdate(intval($_POST['thang']), intval($_POST['ngay']), intval($_POST['nam']))){
				$data_error[] = 'Không tồn tại ngày sinh này';
			}
		}else{
			$data_error[] = 'Ngày sinh phải là số';
		}
		if(!isset($_POST['email']) || !is_string($_POST['email']) || strlen($_POST['email']) > 50 ||!preg_match('/^(\w+\.)*\w+@(\w+\.)+[a-z]{2,3}$/i', $_POST['email'])){
			$data_error[] = 'Địa chỉ email không hợp lệ, địa chỉ email phải dưới 50 ký tự và phải theo định dạng email';
		}
		if(!isset($_POST['sodienthoai']) || !is_string($_POST['sodienthoai']) || !preg_match('/^0[0-9]{9,10}$/', $_POST['sodienthoai'])){
			$data_error[] = 'Số điện thoại không hợp lệ';
		}
		if(!isset($_POST['diachi']) || !is_string($_POST['diachi']) || mb_strlen($_POST['diachi'], 'UTF-8')==0 || mb_strlen($_POST['diachi'], 'UTF-8') > 100){
			$data_error[] = 'Địa chỉ không hợp lệ, độ dài địa chỉ từ 1 đến 100 ký tự';
		}
		$b_avatar = false;
		if(isset($_FILES['avatar']['name']) && $_FILES['avatar']['name']!=''){
			if($_FILES['avatar']['error']){
				$data_error[] = 'Tải ảnh lên bị lỗi. Có thể do tập tin quá lớn. Vui lòng thử lại';
			}else{
				if(!UploadedFile::checkFileExtensions($_FILES['avatar']['tmp_name'], ['png','gif','jpeg'])){
					$data_error[] = 'Chỉ hỗ trợ những định dạng ảnh .png, .gif, .jpeg';
				}
			}
			$b_avatar = true;
		}
		if(count($data_error)!=0){
			throw new NotValidFormDataException($data_error);
		}
		$user->suaNguoiDung($_POST['id'], new UserInfo(null, $_POST['maso'], $b_matkhau?$_POST['matkhau'][0]:null, $_POST['ho'], $_POST['ten'], $_POST['nam'] .'-'.$_POST['thang']. '-'.$_POST['ngay'], $_POST['email'], $_POST['sodienthoai'], $_POST['diachi'], $_POST['madonvi'], $_POST['manhom'], isset($_POST['tinhtrang']) ? 1 : 0), $b_avatar ? $_FILES['avatar']['tmp_name'] : NULL, $b_avatar ? $CNF['PATHS']['AVATAR_DIR'].'/tentaptin.png' : NULL);
		echo json_encode(new AJAXEditResult(1, ['Bạn đã sửa thông tin người dùng thành công']), JSON_UNESCAPED_UNICODE);
	}catch(NotValidFormDataException $e){
		echo json_encode(new AJAXEditResult(0, $e->getErrors()), JSON_UNESCAPED_UNICODE);
	}catch(Exception $e){
		echo json_encode(new AJAXEditResult(0, [$e->getMessage()]), JSON_UNESCAPED_UNICODE);
	}