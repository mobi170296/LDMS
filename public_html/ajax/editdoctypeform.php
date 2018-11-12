<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	header('content-type: text/html');
	try{
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		$user = new User($mcon);
		$user->dangNhap();
		if(!$user->getQuyen()->contain(PRIVILEGES['SUA_LOAI_VAN_BAN'])){
			throw new Exception('Bạn không có quyền sửa công văn');
		}
		if(isset($_POST['maloai'])){
			$doctypeinfo = $user->getLoaiVanBan($_POST['maloai']);
?>
			<div id="page-title">Sửa thông tin loại văn bản</div>
			<form action="/ajax/editdoctype.php" onsubmit="ajaxSubmitEdit(this);return false;">
			<div>Mã loại</div>
			<div><input type="text" size="30" name="newmaloai" value="<?php echo $doctypeinfo->getMaLoai(); ?>"/></div>
			<div>Tên loại</div>
			<div><input type="text" size="30" name="tenloai" value="<?php echo $doctypeinfo->getTenLoai(); ?>"/></div>
			<div><input type="hidden" name="maloai" value="<?php echo $doctypeinfo->getMaLoai(); ?>"/></div>
			<div><input type="hidden" name="editdoctype" value="editdoctype"/></div>
			<div><button type="submit">Lưu thông tin</button></div>
			</form>
<?php
		}else{
			throw new Exception('Yêu cầu không hợp lệ!');
		}
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>