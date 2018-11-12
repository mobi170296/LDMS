<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	header('content-type: text/html');
	try{
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		$user = new User($mcon);
		$user->dangNhap();
		if(!$user->getQuyen()->contain(PRIVILEGES['SUA_NHOM'])){
			throw new Exception('Bạn không có quyền sửa nhóm');
		}
		if(isset($_POST['manhom'])){
			$group = $user->getNhom($_POST['manhom']);
?>
		<div id="page-title">Sửa thông tin nhóm người dùng</div>
			<form action="/ajax/editgroup.php" method="post" onsubmit="ajaxSubmitEdit(this); return false;">
			<div>Mã loại</div>
			<div><input type="text" size="30" name="newmanhom" value="<?php echo $group->getMaNhom(); ?>"/></div>
			<div>Tên loại</div>
			<div><input type="text" size="30" name="tennhom" value="<?php echo $group->getTenNhom(); ?>"/></div>
			<div><button type="submit">Lưu thông tin</button></div>
			<input type="hidden" name="editgroup" value="editgroup"/>
			<input type="hidden" name="manhom" value="<?php echo $group->getMaNhom(); ?>"/>
			</form>
<?php
		}else{
			throw new Exception('Yêu cầu không hợp lệ!');
		}
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>