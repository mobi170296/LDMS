<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	header('content-type: text/html');
	try{
		$mcon = new MDatabase(DATABASE['HOST'], DATABASE['USERNAME'], DATABASE['PASSWORD'], DATABASE['DB_NAME']);
		$user = new User($mcon);
		$user->dangNhap();
		
		if(!$user->getQuyen()->contain(PRIVILEGES['SUA_DON_VI'])){
			throw new Exception('Bạn không có quyền sửa Khoa - Đơn vị');
		}
		if(isset($_POST['madonvi'])){
			$department = $user->getDonVi($_POST['madonvi']);
?>

			<form>
			<div>Mã đơn vị</div>
			<div><input type="text" size="30" name="madonvi" value="<?php echo $department->getMaDonVi(); ?>"/></div>
			<div>Tên đơn vị</div>
			<div><input type="text" size="30" name="tendonvi" value="<?php echo $department->getTenDonVi(); ?>"/></div>
			<div>Email</div>
			<div><input type="text" size="30" name="email" value="<?php echo $department->getEmail();?>"/></div>
			<div><button type="button">Lưu thông tin</button></div>
			</form>

<?php
		}else{
			throw new Exception('Yêu cầu không hợp lệ');
		}
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>