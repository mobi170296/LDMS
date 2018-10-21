<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	header('content-type: text/html');
	try{
		$mcon = new MDatabase(DATABASE['HOST'], DATABASE['USERNAME'], DATABASE['PASSWORD'], DATABASE['DB_NAME']);
		$user = new User($mcon);
		$user->dangNhap();
		if(!$user->getQuyen()->contain(PRIVILEGES['XOA_NHOM'])){
			throw new Exception('Bạn không có quyền xóa nhóm');
		}
		if(isset($_POST['manhom'])){
			$group = $user->getNhom($_POST['manhom']);
?>

			<form>
			<div>Bạn có muốn xóa nhóm <?php echo $group->getTenNhom(); ?> (<?php echo $group->getMaNhom(); ?>)?</div>
			<div><button type="button">Xóa nhóm người dùng</button></div>
			</form>

<?php
		}else{
			throw new Exception('Yêu cầu không hợp lệ!');
		}
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>