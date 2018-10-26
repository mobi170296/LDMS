<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	try{
		if(!isset($_POST['id'])||!is_numeric($_POST['id'])){
			throw new Exception('Không thể xử lý yêu cầu này');
		}
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		$user = new User($mcon);
		$user->dangNhap();
		if(!$user->getQuyen()->contain(PRIVILEGES['KIEM_DUYET_CONG_VAN_DEN'])){
			throw new Exception('Bạn không có quyền kiểm duyệt công văn');
		}
		$legaldocument = $user->getCongVanDen($_POST['id']);
?>
		<div id="verify-censorship-form">
			<div>Bạn có muốn xác nhận ý kiến phê duyệt <font color="blue"><?php echo $legaldocument->getKiemDuyet()->getYKienKiemDuyet();?></font> cho công văn có ký hiệu <font color="blue"><?php echo $legaldocument->getKyHieu();?></font>?</div>
			<form action="/ajax/verifycensorship.php" method="post" onSubmit="ajaxSubmitEdit(this);return false;">
				<div><input type="hidden" name="id" value="<?php echo $legaldocument->getID();?>"/></div>
				<div><input type="hidden" name="verifycensorship" value="verifycensorship"/></div>
				<button type="submit">Xác nhận</button>
			</form>
		</div>
<?php
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>