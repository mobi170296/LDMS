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
		if(isset($_POST['madonvi'])){
			$issuedunit = $user->getDonViBanHanh($_POST['madonvi']);
?>

			<form>
			<div>Mã đơn vị</div>
			<div><input type="text" size="30" name="madonvi" value="<?php echo $issuedunit->getMaDonVi(); ?>"/></div>
			<div>Tên đơn vị</div>
			<div><input type="text" size="30" name="tendonvi" value="<?php echo $issuedunit->getTenDonVi(); ?>"/></div>
			<div>Loại đơn vị</div>
			<div><input type="radio" id="rad-benngoai" name="benngoai" value="1" <?php echo $issuedunit->getBenNgoai() ?'checked="checked"' : ''; ?> />
				<label for="rad-benngoai">Bên ngoài</label>
				<input type="radio" id="rad-bentrong" name="benngoai" value="0" <?php echo $issuedunit->getBenNgoai() ? '' : 'checked="checked"' ?> />
				<label for="rad-bentrong">Bên trong</label>
			</div>
			<div>Địa chỉ</div>
			<div><textarea name="diachi" rows="4" cols="30" spellcheck="false"><?php echo $issuedunit->getDiaChi(); ?></textarea></div>
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