<?php
	try{
		if(!$user->isDangNhap()){
			throw new Exception('Bạn chưa đăng nhập không thể truy cập trang này');
		}
		echo '<div id="page-title">DANH SÁCH CÔNG VĂN ĐẾN CHỜ KIỂM DUYỆT</div>';
		
		if(isset($_GET['p'])){
			if(is_numeric($_GET['p']) && intval($_GET['p'])>0){
				$pp_cp = intval($_GET['p']);
			}else{
				$pp_cp = 1;
			}
		}else{
			$pp_cp = 1;
		}
		$legaldocuments = $user->getDanhSachCongVanDenChoKiemDuyet(($pp_cp-1)*10, 10);
		if(!count($legaldocuments)){
			throw new Exception('Không có công văn nào chờ kiểm duyệt ở trang này');
		}
?>
<div id="legaldocument-list">
	<table class="list-table">
		<tr><th>Số đến</th><th>Ký hiệu</th><th>Đơn vị phát hành</th><th>Trích yếu</th><th>Ý kiến kiểm duyệt</th><th>Tình trạng</th><th>Thao tác</th></tr>
		<?php
			foreach($legaldocuments as $legaldocument){
				echo '<tr>';
				echo '<td>'.$legaldocument->getSoDen().'</td>';
				echo '<td>'.$legaldocument->getKyHieu().'</td>';
				echo '<td><div class="abstract-wrapper w10">'.$legaldocument->getDonViBanHanh()->getTenDonVi().'</div></td>';
				echo '<td><div class="abstract-wrapper w10">'.$legaldocument->getTrichYeu().'</div></td>';
				echo '<td><div class="abstract-wrapper w10">'.(($legaldocument->getKiemDuyet()!=null&&$legaldocument->getKiemDuyet()->getYKienKiemDuyet()!=null)?$legaldocument->getKiemDuyet()->getYKienKiemDuyet():'Chưa có ý kiến').'</div></td>';
				echo '<td>'.$legaldocument->getTrangThaiString().'</td>';
				echo <<<CONTROLBTN
				<td>
				<a class="action-btn positive detail" onclick="showFormPopup('/ajax/showiclddetail.php', [['id', '{$legaldocument->getID()}']])" title="Chi tiết công văn"></a>
				<a class="action-btn positive add-censorship" onclick="showFormPopup('/ajax/showiclddetail.php', [['id', '{$legaldocument->getID()}']])" title="Thực hiện cho ý kiến kiểm duyệt"></a>
				<a class="action-btn positive delete-censorship" onclick="showFormPopup('/ajax/showiclddetail.php', [['id', '{$legaldocument->getID()}']])" title="Thực hiện xóa ý kiến kiểm duyệt"></a>
				<a class="action-btn positive verify-censorship" onclick="showFormPopup('/ajax/showiclddetail.php', [['id', '{$legaldocument->getID()}']])" title="Thực hiện xác nhận ý kiến kiểm duyệt"></a>
				<a class="action-btn positive edit" onclick="showFormPopup('/ajax/editdoctypeform.php', [['maloai', '{$legaldocument->getID()}']])" title="Sửa công văn"></a>
				<a class="action-btn negative delete" onclick="showFormPopup('/ajax/deletedoctypeform.php', [['maloai', '{$legaldocument->getID()}']]);" title="Xóa công văn"></a>
				</td>
CONTROLBTN;
				echo '</tr>';
			}
		?>
	</table>
	<?php
		try{
			$pp_pt = ceil($user->countRecordsInTable('congvanden', 'idnguoinhap='.$user->getID()) / 10);
			$pp_cp = 1;
			require $CNF['PATHS']['TEMPLATES'].'/pagepartition.php';
		}catch(Exception $e){
			echo '<div class="error-message-box">'.$e->getMessage().'</div>';
		}
	?>
</div>
<?php
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>