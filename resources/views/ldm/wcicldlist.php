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
		<tr><th>Số đến</th><th>Ký hiệu</th><th>Đơn vị phát hành</th><th>Trích yếu</th><th>Tình trạng</th><th>Thao tác</th></tr>
		<?php
			foreach($legaldocuments as $legaldocument){
				echo '<tr>';
				echo '<td>'.$legaldocument->getSoDen().'</td>';
				echo '<td>'.$legaldocument->getKyHieu().'</td>';
				echo '<td><div style="width: 10em; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">'.$legaldocument->getDonViBanHanh()->getTenDonVi().'</div></td>';
				echo '<td><div style="width: 15em; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">'.$legaldocument->getTrichYeu().'</div></td>';
				echo '<td>'.$legaldocument->getTrangThaiString().'</td>';
				echo '<td><a class="action-btn positive" onclick="showFormPopup(\'/ajax/showiclddetail.php\', [[\'id\', \''.$legaldocument->getID().'\']])">Chi tiết</a><a class="action-btn positive" onclick="showFormPopup(\'/ajax/editdoctypeform.php\', [[\'maloai\', \''.$legaldocument->getID().'\']])">Sửa</a><a class="action-btn negative" onclick="showFormPopup(\'/ajax/deletedoctypeform.php\', [[\'maloai\', \''.$legaldocument->getID().'\']]);">Xóa</a></td>';
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