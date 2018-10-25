<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	header('content-type: text/html');
	try{
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		$user = new User($mcon);
		$user->dangNhap();
		
		if(!$user->getQuyen()->contain(PRIVILEGES['SUA_DON_VI'])){
			throw new Exception('Bạn không có quyền sửa Khoa - Đơn vị');
		}
		if(isset($_POST['madonvi'])){
			$department = $user->getDonVi($_POST['madonvi']);
?>
			<form action="/ajax/editdepartment.php" method="post" onsubmit="ajaxSubmitEdit(this); return false;">
			<div>Mã đơn vị</div>
			<div><input type="text" size="30" name="newmadonvi" value="<?php echo $department->getMaDonVi(); ?>"/></div>
			<div>Tên đơn vị</div>
			<div><input type="text" size="30" name="tendonvi" value="<?php echo $department->getTenDonVi(); ?>"/></div>
			<div>Email</div>
			<div><input type="text" size="30" name="email" value="<?php echo $department->getEmail();?>"/></div>
			<div><input type="hidden" name="madonvi" value="<?php echo $department->getMaDonVi(); ?>"/></div>
			<div><input type="hidden" name="editdepartment" value="editdepartment"/></div>
			<div><button type="submit">Lưu thông tin</button></div>
			</form>
<?php
		}else{
			throw new Exception('Yêu cầu không hợp lệ');
		}
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>