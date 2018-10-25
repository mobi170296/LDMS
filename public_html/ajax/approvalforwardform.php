<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	header('content-type: text/html');
	try{
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		$user = new User($mcon);
		$user->dangNhap();
		if(!$user->getQuyen()->contain(PRIVILEGES['THEM_CONG_VAN_DEN'])){
			throw new Exception('Bạn không có quyền chuyển phê duyệt công văn cho người khác');
		}
		
		if(!isset($_POST['id']) || !is_numeric($_POST['id'])){
			throw new Exception('Yêu cầu không hợp lệ');
		}
		
		$legaldocument = $user->getCongVanDen($_POST['id']);
		if($legaldocument->getTrangThai()!=LEGALDOCUMENT_STATUS['DA_KIEM_DUYET']){
			throw new Exception('Công văn này không thể chuyển phê duyệt được!');
		}
		$validusers = $user->getDanhSachNguoiDungByQuyen(PRIVILEGES['PHE_DUYET_CONG_VAN_DEN']);
?>
<div id="page-title">Thực hiện chuyển phê duyệt công văn</div>
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
	<form action="/ajax/approvalforward.php" method="post" onSubmit="ajaxSubmitEdit(this);">
		<div>Chọn người phê duyệt</div>
		<div>
			<select name="idnguoikiemduyet">
				<?php
					foreach($validusers as $u){
						echo '<option value="'.$u->getID().'">'.$u->getMaSo().' - '.$u->getHo(). ' ' .$u->getTen().' - '. $u->getDonVi()->getTenDonVi() .'</option>';
					}
				?>
			</select>
		</div>
		<div><input type="hidden" name="idcongvan" value="<?php $legaldocument->getID(); ?>" /></div>
		<div><input type="hidden" name="approvalicld" value="approvalicld"/></div>
		<div><button type="submit">Chuyển kiểm duyệt</button></div>
	</form>
</div>
<?php
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>