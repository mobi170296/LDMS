<?php
	try{
		if(!$user->isDangNhap()){
			throw new Exception('Bạn chưa đăng nhập');
		}
		if(!$user->getQuyen()->contain(PRIVILEGES['THEM_DON_VI_BAN_HANH'])){
			throw new Exception('Bạn không có quyền xem đơn vị ban hành');
		}
		$issuedunits = $user->getDanhSachDonViBanHanh();
		echo '<div id="page-title">Danh sách đơn vị ban hành</div>';
?>

<div id="doctype-list">
	<table class="list-table">
		<tr><th>Mã đơn vị</th><th>Tên đơn vị</th><th>Bên ngoài</th><th>Địa chỉ</th><th>Thời gian thêm</th><th>Thao tác</th></tr>
		<?php
			foreach($issuedunits as $issuedunit){
				echo '<tr>';
				echo '<td>'.$issuedunit->getMaDonVi().'</td>';
				echo '<td>'.$issuedunit->getTenDonVi().'</td>';
				echo '<td>'.($issuedunit->getBenNgoai()?'x':'').'</td>';
				echo '<td>'.$issuedunit->getDiaChi().'</td>';
				echo '<td>'.MDateTime::parseDateTime($issuedunit->getThoiGianThem())->getDateTimeString().'</td>';
				echo '<td><a class="action-btn" onclick="showFormPopup(\'/ajax/editissuedunitform.php\', [[\'madonvi\', \''.$issuedunit->getMaDonVi().'\']])">Sửa</a><a class="action-btn" onclick="showFormPopup(\'/ajax/deleteissuedunitform.php\', [[\'madonvi\', \''.$issuedunit->getMaDonVi().'\']])">Xóa</a></td>';
				echo '</tr>';
			}
		?>
	</table>
</div>

<?php
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>