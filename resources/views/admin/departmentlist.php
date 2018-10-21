<?php
	try{
		if(!$user->isDangNhap()){
			throw new Exception('Bạn chưa đăng nhập');
		}
		if(!$user->getQuyen()->contain(PRIVILEGES['THEM_DON_VI'])){
			throw new Exception('Bạn không có quyền xem đơn vị');
		}
		$departments = $user->getDanhSachDonVi();
		echo '<div id="page-title">Danh sách Khoa - Đơn vị</div>';
?>

<div id="doctype-list">
	<table class="list-table">
		<tr><th>Mã đơn vị</th><th>Tên đơn vị</th><th>Email</th><th>Thời gian thêm</th><th>Thao tác</th></tr>
		<?php
			foreach($departments as $department){
				echo '<tr>';
				echo '<td>'.$department->getMaDonVi().'</td>';
				echo '<td>'.$department->getTenDonVi().'</td>';
				echo '<td>'.$department->getEmail().'</td>';
				echo '<td>'.MDateTime::parseDateTime($department->getThoiGianThem())->getDateTimeString().'</td>';
				echo '<td><a class="action-btn" onclick="showFormPopup(\'/ajax/editdepartmentform.php\', [[\'madonvi\', \''.$department->getMaDonVi().'\']])">Sửa</a><a class="action-btn" onclick="showFormPopup(\'/ajax/deletedepartmentform.php\', [[\'madonvi\', \''.$department->getMaDonVi().'\']])">Xóa</a></td>';
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