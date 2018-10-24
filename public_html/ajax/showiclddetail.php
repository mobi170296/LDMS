<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	require_once $CNF['PATHS']['TEMPLATES'].'/dbinit.php';

	try{
		$user = new User($mcon);
		$user->dangNhap();
		if(!isset($_POST['id']) && !is_numeric($_POST['id'])){
			throw new Exception('Yêu cầu không hợp lệ');
		}
		
		$legaldocument = $user->getCongVanDen($_POST['id']);
		
?>
<div class="legaldocument-info">
	<div>
		<iframe style="border:none; width: 800px; height: 100vh;" src="<?php echo $CNF['BODY']['LEGALDOCUMENT_URL'].'/icld.php?id='.$legaldocument->getID();?>"></iframe>
	</div>
	<div><a href="<?php echo $CNF['BODY']['LEGALDOCUMENT_URL'].'/icld.php?action=download&id='.$legaldocument->getID();?>">Tải công văn về</a></div>
	<div class="data-title">Số đến</div>
	<div class="data-content"><?php echo $legaldocument->getSoDen(); ?></div>
	<div class="data-title">Ký hiệu</div>
	<div class="data-content"><?php echo $legaldocument->getKyHieu(); ?></div>
	<div class="data-title">Thời gian đến</div>
	<div class="data-content"><?php echo $legaldocument->getThoiGianDen(); ?></div>
	<div class="data-title">Ngày văn bản</div>
	<div class="data-content"><?php echo $legaldocument->getNgayVanBan(); ?></div>
	<div class="data-title">Đơn vị ban hành</div>
	<div class="data-content"><?php echo $legaldocument->getDonViBanHanh()->getTenDonVi(); ?></div>
	<div class="data-title">Trích yếu</div>
	<div class="data-content"><?php echo $legaldocument->getTrichYeu(); ?></div>
	<div class="data-title">Người ký</div>
	<div class="data-content"><?php echo $legaldocument->getNguoiKy(); ?></div>
	<div class="data-title">Loại văn bản</div>
	<div class="data-content"><?php echo $legaldocument->getLoaiVanBan()->getTenLoai(); ?></div>
	<div class="data-title">Thời hạn giải quyết</div>
	<div class="data-content"><?php echo $legaldocument->getThoiHanGiaiQuyet(); ?></div>
	<div class="data-title">Trạng thái</div>
	<div class="data-content"><?php echo $legaldocument->getTrangThaiString(); ?></div>
	<div class="data-title">Người nhập</div>
	<div class="data-content"><?php echo $legaldocument->getNguoiNhap()->getHo(). ' ' .$legaldocument->getNguoiNhap()->getTen(); ?></div>
	<div class="data-title">Đơn vị nhận văn bản</div>
	<div class="data-content"><?php echo $legaldocument->getDonVi()->getTenDonVi(); ?></div>
	<div class="data-title">Thời gian nhập</div>
	<div class="data-content"><?php echo $legaldocument->getThoiGianThem(); ?></div>
</div>
<?php
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>