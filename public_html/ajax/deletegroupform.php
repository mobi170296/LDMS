<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	header('content-type: text/html');
	try{
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		$user = new User($mcon);
		$user->dangNhap();
		if(!$user->getQuyen()->contain(PRIVILEGES['XOA_NHOM'])){
			throw new Exception('Bạn không có quyền xóa nhóm');
		}
		if(isset($_POST['manhom'])){
			$group = $user->getNhom($_POST['manhom']);
?>
		<div id="page-title">Xóa nhóm người dùng</div>
			<form action="/ajax/deletegroup.php" method="post" onsubmit="ajaxSubmitDelete(this);return false;">
			<div>Bạn có muốn xóa nhóm <?php echo $group->getTenNhom(); ?> (<?php echo $group->getMaNhom(); ?>)?</div>
			<div><input type="hidden" name="manhom" value="<?php echo $group->getMaNhom(); ?>"/></div>
			<div><input type="hidden" name="deletegroup" value="deletegroup"/></div>
			<div><button type="submit">Xóa nhóm người dùng</button></div>
			</form>

<?php
		}else{
			throw new Exception('Yêu cầu không hợp lệ!');
		}
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>