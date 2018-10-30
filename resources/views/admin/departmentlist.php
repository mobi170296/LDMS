<?php
	try{
		if(!$user->isDangNhap()){
			throw new Exception('Bạn chưa đăng nhập');
		}
		if(!$user->getQuyen()->contains([PRIVILEGES['THEM_DON_VI'],PRIVILEGES['SUA_DON_VI'],PRIVILEGES['XOA_DON_VI']])){
			throw new Exception('Bạn không có quyền xem đơn vị');
		}
		echo '<div id="page-title">Danh sách Khoa - Đơn vị</div>';
		
		if(isset($_GET['p'])){
			if(is_numeric($_GET['p']) && intval($_GET['p'])>0){
				$pp_cp = intval($_GET['p']);
			}else{
				$pp_cp = 1;
			}
		}else{
			$pp_cp = 1;
		}
		
		
		$departments = $user->getDanhSachDonVi(10*($pp_cp-1), 10);
		if(count($departments)==0){
			throw new Exception('Không có Khoa - Đơn vị nào ở trang này');
		}
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
				echo '<td>';
				if($user->getQuyen()->contain(PRIVILEGES['SUA_DON_VI'])){
					echo '<a class="action-btn positive edit" onclick="showFormPopup(\'/ajax/editdepartmentform.php\', [[\'madonvi\', \''.$department->getMaDonVi().'\']])"></a>';
				}
				if($user->getQuyen()->contain(PRIVILEGES['XOA_DON_VI'])){
					echo '<a class="action-btn negative delete" onclick="showFormPopup(\'/ajax/deletedepartmentform.php\', [[\'madonvi\', \''.$department->getMaDonVi().'\']])"></a>';
				}
				echo '</td>';
				echo '</tr>';
			}
		?>
	</table>
		<?php
			try{
				$pp_pt = ceil($user->countRecordsInTable('donvi') / 10);
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