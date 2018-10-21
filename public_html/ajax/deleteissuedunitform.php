<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	header('content-type: text/html');
	try{
		$mcon = new MDatabase(DATABASE['HOST'], DATABASE['USERNAME'], DATABASE['PASSWORD'], DATABASE['DB_NAME']);
		$user = new User($mcon);
		$user->dangNhap();
		
		if(!$user->getQuyen()->contain(PRIVILEGES['XOA_DON_VI_BAN_HANH'])){
			throw new Exception('Bạn không có quyền xóa đơn vị ban hành');
		}
		if(isset($_POST['madonvi'])){
			$issuedunit = $user->getDonViBanHanh($_POST['madonvi']);
?>

			<form>
			<div>Bạn có muốn xóa đơn vị <?php echo $issuedunit->getTenDonVi(); ?> (<?php echo $issuedunit->getMaDonVi(); ?>)?</div>
			<div><button type="button">Xóa đơn vị ban hành</button></div>
			</form>

<?php
		}else{
			throw new Exception('Yêu cầu không hợp lệ');
		}
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>