<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	header('content-type: text/html');
	try{
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		$user = new User($mcon);
		$user->dangNhap();
		if(!$user->getQuyen()->contain(PRIVILEGES['XOA_LOAI_VAN_BAN'])){
			throw new Exception('Bạn không có quyền xóa công văn');
		}
		if(isset($_POST['maloai'])){
			$doctypeinfo = $user->getLoaiVanBan($_POST['maloai']);
?>
			<form action="/ajax/deletedoctype.php" onSubmit="ajaxSubmitDelete(this);return false;">
			<div>Bạn có muốn xóa loại văn bản <?php echo $doctypeinfo->getTenLoai(); ?> (<?php echo $doctypeinfo->getMaLoai(); ?>)?</div>
			<div><input type="hidden" name="maloai" value="<?php echo $doctypeinfo->getMaLoai(); ?>"/></div>
			<div><input type="hidden" name="deletedoctype" value="deletedoctype"/></div>
			<div><button type="submit">Xóa loại công văn</button></div>
			</form>
<?php
		}else{
			throw new Exception('Yêu cầu không hợp lệ');
		}
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>