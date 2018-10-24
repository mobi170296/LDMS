<?php
	try{
		if(!$user->isDangNhap()){
			throw new Exception('Bạn chưa đăng nhập');
		}
		if(!$user->getQuyen()->contain(PRIVILEGES['THEM_CONG_VAN_DEN'])){
			throw new Exception('Bạn không có quyền liệt kê danh sách loại văn bản');
		}
		echo '<div id="page-title">Danh sách công văn đến</div>';
		if(isset($_GET['p'])){
			if(is_numeric($_GET['p']) && intval($_GET['p'])>0){
				$pp_cp = intval($_GET['p']);
			}else{
				$pp_cp = 1;
			}
		}else{
			$pp_cp = 1;
		}
		$legaldocuments = $user->getDanhSachCongVanDen(10*($pp_cp-1), 10);
		if(count($legaldocuments)==0){
			throw new Exception('Không có công văn đến nào ở trang này');
		}
?>
<div id="legaldocument-list">
	<table class="list-table">
		<tr><th>Số đến</th><th>Ký hiệu</th><th>Đơn vị phát hành</th><th>Trích yếu</th><th>Thao tác</th></tr>
		<?php
			foreach($legaldocuments as $legaldocument){
				echo '<tr>';
				echo '<td>'.$legaldocument->getSoDen().'</td>';
				echo '<td>'.$legaldocument->getKyHieu().'</td>';
				echo '<td>'.$legaldocument->getDonViBanHanh()->getTenDonVi().'</td>';
				echo '<td>'.$legaldocument->getTrichYeu().'</td>';
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