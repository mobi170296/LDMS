<?php
	session_start();
	try{
		if(!isset($_POST['id'])||!is_numeric($_POST['id'])){
			throw new Exception('Yêu cầu không hợp lệ');
		}
		require_once __DIR__.'/../../config/config.php';
		require_once $CNF['PATHS']['CLASSES'].'/user.php';
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		$user = new User($mcon);
		$user->dangNhap();
		if(!$user->getQuyen()->contain(PRIVILEGES['XOA_NGUOI_DUNG'])){
			throw new Exception('Bạn không có quyền xóa người dùng');
		}
		$userinfo = $user->getNguoiDung($_POST['id']);
?>
	<div>Bạn có muốn xóa người dùng <font color="red">"<?php echo $userinfo->getFullName(); ?>"</font> có mã số <font color="red">"<?php echo $userinfo->getMaSo();?>"</font>?</div>
	<form action="/ajax/deleteuser.php" method="post" onsubmit="ajaxSubmitEdit(this);return false;">
	<div><input type="hidden" name="id" value="<?php echo $userinfo->getID(); ?>"/></div>
	<div><input type="hidden" name="deleteuser" value="deleteuser"/></div>
	<div><button type="submit">Xóa người dùng</button></div>
	</form>
<?php
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
	
	