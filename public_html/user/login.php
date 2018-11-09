<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	$CNF['HEADER']['TITLE'] = 'Đăng nhập - Quản lý công văn';

	$CNF['BODY']['CURRENT_SCRIPT'] = '/user/login.php';
	# Xử lý ở đây với những yêu cầu trước khi gửi content
	
	try{
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinit.php';
		$user = new User($mcon);
		try{
			#Thử đăng nhập bằng session hiện tại!
			$user->dangNhap();
			#Đăng nhập thành công yêu cầu không hợp lệ chuyển về homepage
			header('location: /');
			exit();
		}catch(Exception $e){
			
		}
		
		if(isset($_POST['login'])){
			if(!isset($_POST['captcha']) || strlen($_POST['captcha'])!=6){
				throw new Exception('Mã xác thực phiên không hợp lệ!');
			}else{
				if($_SESSION['captcha']!=$_POST['captcha']){
					throw new Exception('Mã xác thực phiên không đúng');
				}
			}
			if(!isset($_POST['maso'])||!is_string($_POST['maso'])||!preg_match('/^[a-cA-C]?[0-9]{1,8}$/', $_POST['maso'])||!isset($_POST['matkhau'])||!is_string($_POST['matkhau'])||strlen($_POST['matkhau'])<6){
				throw new Exception('Mã số hoặc mật khẩu không hợp lệ!');
			}
			$user->dangNhap($_POST['maso'], $_POST['matkhau']);
			header('location: /');
			exit();
		}
	}catch(Exception $e){
		$error=$e->getMessage();
	}
	
	# Bắt đầu output ở đây
	# Trang đăng nhập được xử lý khác so với các trang khác
	require_once($CNF['PATHS']['TEMPLATES'] . '/header.php');
	
	require_once $CNF['PATHS']['VIEWS'].'/user/login.php';
	
	require_once($CNF['PATHS']['TEMPLATES'] . '/footer.php');
?>