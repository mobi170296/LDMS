<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	try{
		if(!isset($_POST['id'])||!is_numeric($_POST['id'])){
			throw new Exception('Yêu cầu không hợp lệ');
		}
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		
		$user = new User($mcon);
		$user->dangNhap();
		if(!$user->getQuyen()->contain(PRIVILEGES['PHE_DUYET_CONG_VAN_DEN'])){
			throw new Exception('Bạn không có quyền phê duyệt công văn đến');
		}
		
		$legaldocument = $user->getCongVanDen($_POST['id']);
		if($legaldocument->getTrangThai()!=LEGALDOCUMENT_STATUS['DOI_PHE_DUYET']){
			throw new Exception('Công văn này không thể phê duyệt');
		}
?>
<div id="page-title">Thêm ý kiến phê duyệt</div>
	<div id="add-censorship-form">
		<form action="/ajax/addapproval.php" method="post" onSubmit="ajaxSubmitEdit(this);return false;">
			<div style="padding: 10px 0px;">Phê duyệt cho công văn "<?php echo $legaldocument->getKyHieu(); ?>" của đơn vị "<?php echo $legaldocument->getDonVi()->getTenDonVi(); ?>"</div>
			<div>Ý kiến phê duyệt</div>
			<div><textarea rows="5" cols="30" name="ykienpheduyet" spellcheck="false" placeholder="Cho ý kiển tại đây"><?php echo $legaldocument->getPheDuyet()->getYKienPheDuyet(); ?></textarea></div>
			<div><input type="hidden" name="id" value="<?php echo $legaldocument->getID(); ?>"/></div>
			<div><button type="submit">Lưu ý kiến</button></div>
		</form>
	</div>
<?php
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>