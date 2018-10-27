<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	require_once $CNF['PATHS']['LIBRARY'].'/datetime/mdatetime.php';
	try{
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
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
	<div class="data-content"><?php echo MDateTime::parseDateTime($legaldocument->getThoiGianDen())->getDateTimeString('/', ':'); ?></div>
	<div class="data-title">Ngày văn bản</div>
	<div class="data-content"><?php echo MDateTime::parseDate($legaldocument->getNgayVanBan())->getDateString('/'); ?></div>
	<div class="data-title">Đơn vị ban hành</div>
	<div class="data-content"><?php echo $legaldocument->getDonViBanHanh()->getTenDonVi(); ?></div>
	<div class="data-title">Trích yếu</div>
	<div class="data-content"><?php echo $legaldocument->getTrichYeu(); ?></div>
	<div class="data-title">Người ký</div>
	<div class="data-content"><?php echo $legaldocument->getNguoiKy(); ?></div>
	<div class="data-title">Loại văn bản</div>
	<div class="data-content"><?php echo $legaldocument->getLoaiVanBan()->getTenLoai(); ?></div>
	<div class="data-title">Thời hạn giải quyết</div>
	<div class="data-content"><?php echo $legaldocument->getThoiHanGiaiQuyet()!=''?'<font color="red">'.MDateTime::parseDate($legaldocument->getThoiHanGiaiQuyet())->getDateString('/').'</font>':'<font color="blue">Không có thời hạn giải quyêt</font>'; ?></div>
	<div class="data-title">Trạng thái</div>
	<div class="data-content"><?php echo $legaldocument->getTrangThaiString(); ?></div>
	<div class="data-title">Người nhập</div>
	<div class="data-content"><?php echo $legaldocument->getNguoiNhap()->getHo(). ' ' .$legaldocument->getNguoiNhap()->getTen(); ?></div>
	<div class="data-title">Đơn vị nhận văn bản</div>
	<div class="data-content"><?php echo $legaldocument->getDonVi()->getTenDonVi(); ?></div>
	<div class="data-title">Thời gian nhập</div>
	<div class="data-content"><?php echo MDateTime::parseDateTime($legaldocument->getThoiGianThem())->getDateTimeString('/', ':'); ?></div>
	<div class="data-title">Ý kiến kiểm duyệt</div>
	<div class="data-content"><?php echo ($legaldocument->getKiemDuyet()!=null&&$legaldocument->getKiemDuyet()->getYKienKiemDuyet()!='')?'<font color="blue">'.$legaldocument->getKiemDuyet()->getYKienKiemDuyet().'</font>':'<font color="red">Chưa kiểm duyệt</font>'; ?></div>
	<div class="data-title">Người kiểm duyệt</div>
	<div class="data-content"><?php echo $legaldocument->getKiemDuyet()!=null?'<font color="#f70">'.$legaldocument->getKiemDuyet()->getNguoiKiemDuyet()->getFullName().' ('.$legaldocument->getKiemDuyet()->getNguoiKiemDuyet()->getMaDonVi().')</font>':'<font color="red">Chưa kiểm duyệt</font>'; ?></div>
	<div class="data-title">Ý kiến phê duyệt</div>
	<div class="data-content"><?php echo ($legaldocument->getPheDuyet()!=null&&$legaldocument->getPheDuyet()->getYKienPheDuyet()!='')?'<font color="blue">'.$legaldocument->getPheDuyet()->getYKienPheDuyet().'</font>':'<font color="red">Chưa phê duyệt</font>'; ?></div>
	<div class="data-title">Người phê duyệt</div>
	<div class="data-content"><?php echo $legaldocument->getPheDuyet()!=null?'<font color="#f70">'.$legaldocument->getPheDuyet()->getNguoiPheDuyet()->getFullName().' ('.$legaldocument->getPheDuyet()->getNguoiPheDuyet()->getMaDonVi().')</font>':'<font color="red">Chưa phê duyệt</font>'; ?></div>
	
	<div>
		<?php
			if($legaldocument->getTrangThai()==LEGALDOCUMENT_STATUS['DA_NHAP']&&$legaldocument->getIDNguoiNhap()==$user->getID()){
				echo <<<BUTTON
				<a class="text-image-btn censorship-forward" onClick="showFormPopup('/ajax/censorshipforwardform.php',[['id', '{$_POST['id']}']])">Chuyển kiểm duyệt</a>
BUTTON;
			}
			if($legaldocument->getTrangThai()==LEGALDOCUMENT_STATUS['DA_KIEM_DUYET']&&$legaldocument->getIDNguoiNhap()==$user->getID()){
				echo <<<BUTTON
				<a class="text-image-btn approval-forward" onClick="showFormPopup('/ajax/approvalforwardform.php',[['id', '{$_POST['id']}']])">Chuyển phê duyệt</a>
BUTTON;
			}
		?>
	</div>
</div>
<?php
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>