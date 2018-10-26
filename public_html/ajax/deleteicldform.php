<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	require_once $CNF['PATHS']['LIBRARY'].'/datetime/mdatetime.php';

	header('content-type: text/html');
	try{
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		$user = new User($mcon);
		$user->dangNhap();
		if(!$user->getQuyen()->contain(PRIVILEGES['SUA_CONG_VAN_DEN'])){
			throw new Exception('Bạn không có quyền sưa công văn đến');
		}
		if(!isset($_POST['id'])||!is_numeric($_POST['id'])){
			throw new Exception('Yêu cầu không hợp lệ');
		}
		$legaldocument = $user->getCongVanDen($_POST['id']);
		echo <<<FORM
		Bạn có thật sự muốn xóa công văn đến số "{$legaldocument->getSoDen()}", ký hiệu "{$legaldocument->getKyHieu()}"?
		<form action="/ajax/deleteicld.php" method="post" onsubmit="ajaxSubmitEdit(this);return false;">
			<input type="hidden" name="id" value="{$legaldocument->getID()}"/>
			<button type="submit" name="" value="">Xóa luôn đê</button>
		</form>
FORM;
?>
	
<?php
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>