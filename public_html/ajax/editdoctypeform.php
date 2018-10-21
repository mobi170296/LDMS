<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	header('content-type: text/html');
	try{
		$mcon = new MDatabase(DATABASE['HOST'], DATABASE['USERNAME'], DATABASE['PASSWORD'], DATABASE['DB_NAME']);
		$user = new User($mcon);
		$user->dangNhap();
		if(!$user->getQuyen()->contain(PRIVILEGES['SUA_LOAI_VAN_BAN'])){
			throw new Exception('Bạn không có quyền sửa công văn');
		}
		if(isset($_POST['maloai'])){
			$doctypeinfo = $user->getLoaiVanBan($_POST['maloai']);
?>

			<form>
			<div>Mã loại</div>
			<div><input type="text" name="maloai" value="<?php echo $doctypeinfo->getMaLoai(); ?>"/></div>
			<div>Tên loại</div>
			<div><input type="text" name="tenloai" value="<?php echo $doctypeinfo->getTenLoai(); ?>"/></div>
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