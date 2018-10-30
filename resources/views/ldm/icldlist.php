<?php
	try{
		if(!$user->isDangNhap()){
			throw new Exception('Bạn chưa đăng nhập');
		}
		if(!$user->getQuyen()->contains([PRIVILEGES['THEM_CONG_VAN_DEN'], PRIVILEGES['SUA_CONG_VAN_DEN'], PRIVILEGES['XOA_CONG_VAN_DEN'], PRIVILEGES['KIEM_DUYET_CONG_VAN_DEN'], PRIVILEGES['PHE_DUYET_CONG_VAN_DEN']])){
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
		<tr><th>Số đến</th><th>Ký hiệu</th><th>Đơn vị phát hành</th><th>Trích yếu</th><th>Tình trạng</th><th>Thao tác</th></tr>
		<?php
			foreach($legaldocuments as $legaldocument){
				echo '<tr>';
				echo '<td>'.$legaldocument->getSoDen().'</td>';
				echo '<td>'.$legaldocument->getKyHieu().'</td>';
				echo '<td><div class="abstract-wrapper w10">'.$legaldocument->getDonViBanHanh()->getTenDonVi().'</div></td>';
				echo '<td><div class="abstract-wrapper w10">'.$legaldocument->getTrichYeu().'</div></td>';
				echo '<td>'.$legaldocument->getTrangThaiString().'</td>';
				echo '<td>';
				if($user->getQuyen()->contains([PRIVILEGES['THEM_CONG_VAN_DEN'],PRIVILEGES['SUA_CONG_VAN_DEN'],PRIVILEGES['XOA_CONG_VAN_DEN'],PRIVILEGES['KIEM_DUYET_CONG_VAN_DEN'],PRIVILEGES['PHE_DUYET_CONG_VAN_DEN']])){
					echo '<a class="action-btn positive detail" onclick="showFormPopup(\'/ajax/showiclddetail.php\', [[\'id\', '.$legaldocument->getID().']])" title="Chi tiết công văn"></a>';
				}
				if($user->getQuyen()->contain(PRIVILEGES['SUA_CONG_VAN_DEN'])){
					echo '<a class="action-btn positive edit" onclick="showFormPopup(\'/ajax/editicldform.php\', [[\'id\', '.$legaldocument->getID().']])" title="Sửa công văn"></a>';
				}
				if($user->getQuyen()->contain(PRIVILEGES['XOA_CONG_VAN_DEN'])){
					echo '<a class="action-btn negative delete" onclick="showFormPopup(\'/ajax/deleteicldform.php\', [[\'id\', '.$legaldocument->getID().']]);" title="Xóa công văn"></a>';
				}
				echo '</td>';
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