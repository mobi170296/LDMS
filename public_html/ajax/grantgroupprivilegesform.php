<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	try{
		if(!isset($_POST['manhom'])||!is_string($_POST['manhom'])){
			throw new Exception('Yêu cầu không hợp lệ');
		}
		require_once $CNF['PATHS']['CLASSES'].'/user.php';
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		$user = new User($mcon);
		$user->dangNhap();
		if(!$user->getQuyen()->contain(PRIVILEGES['CAP_QUYEN_NHOM'])){
			throw new Exception('Bạn không có quyền cấp quyền cho nhóm người dùng');
		}
		$groupinfo = $user->getNhom($_POST['manhom']);
?>
	<div id="page-title">Cấp quyền cho nhóm người dùng</div>
	<div id="grant-privileges">
		<form action="/ajax/grantgroupprivileges.php" method="post" enctype="application/x-www-form-urlencoded" onSubmit="ajaxSubmitEdit(this);return false;">
			<?php
				foreach(PRIVILEGES as $v){
					echo '<div>';
					echo '<input type="checkbox" id="privilege-'.$v.'" name="quyen[]" value="'.$v.'" '.($groupinfo->getQuyen()->contain($v)?'checked="checked"':'').'/>';
					echo '<label for="privilege-'.$v.'">'.PRIVILEGE_LABELS[$v].'</label>';
					echo '</div>';
				}
			?>
			<div><input type="hidden" name="manhom" value="<?php echo $_POST['manhom'];?>"/></div>
			<div><input type="hidden" name="grantgroupprivileges" value="grantgroupprivileges"></div>
			<div><button type="submit">Cấp quyền cho nhóm</button></div>
		</form>
	</div>
<?php
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}