<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	try{
		if(!isset($_POST['id']) || !is_numeric($_POST['id'])){
			throw new Exception('Yêu cầu không hợp lệ');
		}
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		$user = new User($mcon);
		$user->dangNhap();
		if(!$user->getQuyen()->contain(PRIVILEGES['CAP_QUYEN_NGUOI_DUNG'])){
			throw new Exception('Bạn không có quyền cấp quyền cho người dùng khác!');
		}
		$userinfo = $user->getNguoiDung($_POST['id']);
?>
	<div id="page-title">Cấp quyền cho người dùng</div>
	<div id="grant-privileges-form">
		<form action="/ajax/grantuserprivileges.php" method="post" enctype="application/x-www-form-urlencoded" onSubmit="ajaxSubmitEdit(this);return false;">
			<?php
				foreach(PRIVILEGES as $k => $v){
					echo '<div>';
					echo '<input type="checkbox" id="privilege-'.$v.'" name="quyen[]" value="'.$v.'" '.($userinfo->getQuyen()->contain($v)?'checked="checked"':'').'/>';
					echo '<label for="privilege-'.$v.'">'.PRIVILEGE_LABELS[$v].'</label>';
					echo '</div>';
				}
			?>
			<div><input type="hidden" name="id" value="<?php echo $_POST['id']; ?>"/></div>
			<div><input type="hidden" name="grantuserprivileges" value="grantuserprivileges"/></div>
			<div><button type="submit">Cấp quyền cho người dùng</button></div>
		</form>
	</div>
<?php
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>