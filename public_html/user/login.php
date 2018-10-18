<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	$CNF['HEADER']['TITLE'] = 'Đăng nhập - Quản lý công văn';

	$CNF['BODY']['CURRENT_SCRIPT'] = '/user/login.php';
	# Xử lý ở đây với những yêu cầu trước khi gửi content
	
	require_once $CNF['PATHS']['TEMPLATES'].'/dbinit.php';


	$error = '';

	$user = new User($mcon);
	try{
		$user->dangNhap();
		#dang nhap thanh cong
		#khong duoc vao trang nay
		header('location: /');
		exit();
	}catch(Exception $e){
		#dang nhap that bai co the chua co session
	}
	
	if(isset($_POST['login'])){
		if(isset($_POST['maso']) && is_string($_POST['maso']) && preg_match('/^[a-cA-C]?[0-9]{1,8}$/', $_POST['maso'])){
			
		}else{
			$error .= 'Mã số cán bộ không hợp lệ<br/>';
		}
		
		if(isset($_POST['matkhau']) && is_string($_POST['matkhau']) && strlen($_POST['matkhau']) >= 6){
			
		}else{
			$error .= 'Mật khẩu không hợp lệ phải dài hơn 6 ký tự<br/>';
		}
		
		if($error == ''){
			try{
				$user->dangNhap($_POST['maso'], $_POST['matkhau']);
				header('location: /');
			}catch(Exception $e){
				$error .= $e->getMessage() .'<br/>';
			}
		}
	}
	
	# Bắt đầu output ở đây
	# Trang đăng nhập được xử lý khác so với các trang khác
	require_once($CNF['PATHS']['TEMPLATES'] . '/header.php');
	#chèn thêm title hay link ở đây
	
	if($error != ''){
		echo '<div class="error-message-box">'.$error.'</div>';
	}
	require_once $CNF['PATHS']['VIEWS'].'/user/login.php';
	
	require_once($CNF['PATHS']['TEMPLATES'] . '/footer.php');
?>