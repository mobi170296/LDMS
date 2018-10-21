<?php
	try{
		if(!$user->isDangNhap()){
			throw new Exception('Bạn chưa đăng nhập');
		}
		if(!$user->getQuyen()->contain(PRIVILEGES['THEM_NHOM'])){
			throw new Exception('Bạn không có quyền xem danh sách nhóm');
		}
		$groups = $user->getDanhSachNhom();
		echo '<div id="page-title">Danh sách nhóm người dùng</div>';
?>

<div id="doctype-list">
	<table class="list-table">
		<tr><th>Tên nhóm</th><th>Mã nhóm</th><th>Thời gian thêm</th><th>Thao tác</th></tr>
		<?php
			foreach($groups as $group){
				echo '<tr>';
				echo '<td>'.$group->getMaNhom().'</td>';
				echo '<td>'.$group->getTenNhom().'</td>';
				echo '<td>'.MDateTime::parseDateTime($group->getThoiGianThem())->getDateTimeString().'</td>';
				echo '<td><a class="action-btn" onclick="showFormPopup(\'/ajax/editgroupform.php\', [[\'manhom\', \''.$group->getMaNhom().'\']])">Sửa</a><a class="action-btn" onclick="showFormPopup(\'/ajax/deletegroupform.php\', [[\'manhom\', \''.$group->getMaNhom().'\']])">Xóa</a></td>';
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