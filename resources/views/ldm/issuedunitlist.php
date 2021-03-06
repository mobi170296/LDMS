<?php
	try{
		if(!$user->isDangNhap()){
			throw new Exception('Bạn chưa đăng nhập');
		}
		if(!$user->getQuyen()->contain(PRIVILEGES['THEM_DON_VI_BAN_HANH'])){
			throw new Exception('Bạn không có quyền xem đơn vị ban hành');
		}
		
		echo '<div id="page-title">Danh sách đơn vị ban hành</div>';
		if(isset($_GET['p'])){
			if(is_numeric($_GET['p']) && intval($_GET['p'])>0){
				$pp_cp = intval($_GET['p']);
			}else{
				$pp_cp = 1;
			}
		}else{
			$pp_cp = 1;
		}
		$issuedunits = $user->getDanhSachDonViBanHanh(($pp_cp-1)*10, 10);
		if(count($issuedunits)==0){
			throw new Exception('Không có đơn vị ban hành nào ở trang này');
		}
?>

<div id="doctype-list">
	<table class="list-table">
		<tr><th>Mã đơn vị</th><th>Tên đơn vị</th><th>Bên ngoài</th><th>Địa chỉ</th><th>Thời gian thêm</th><th>Thao tác</th></tr>
		<?php
			foreach($issuedunits as $issuedunit){
				echo '<tr>';
				echo '<td>'.$issuedunit->getMaDonVi().'</td>';
				echo '<td>'.$issuedunit->getTenDonVi().'</td>';
				echo '<td>'.$issuedunit->getEmail().'</td>';
				echo '<td>'.$issuedunit->getSoDienThoai().'</td>';
				echo '<td>'.($issuedunit->getBenNgoai()?'x':'').'</td>';
				echo '<td>'.$issuedunit->getDiaChi().'</td>';
				echo '<td>'.MDateTime::parseDateTime($issuedunit->getThoiGianThem())->getDateTimeString().'</td>';
				echo '<td>';
				if($user->getQuyen()->contain(PRIVILEGES['SUA_DON_VI_BAN_HANH'])){
					echo '<a class="action-btn positive edit" onclick="showFormPopup(\'/ajax/editissuedunitform.php\', [[\'madonvi\', \''.$issuedunit->getMaDonVi().'\']])" title="Sửa thông tin đơn vị ban hành"></a>';
				}
				if($user->getQuyen()->contain(PRIVILEGES['XOA_DON_VI_BAN_HANH'])){
					echo '<a class="action-btn negative delete" onclick="showFormPopup(\'/ajax/deleteissuedunitform.php\', [[\'madonvi\', \''.$issuedunit->getMaDonVi().'\']])" title="Xóa đơn vị ban hành"></a>';
				}
				echo '</td>';
				echo '</tr>';
			}
		?>
	</table>
	<?php
		try{
			$pp_pt = ceil($user->countRecordsInTable('donvibanhanh') / 10);
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