<?php
	try{
		if(!$user->isDangNhap()){
			throw new Exception('Bạn chưa đăng nhập không thể truy cập trang này');
		}
		if(!$user->getQuyen()->contains([PRIVILEGES['THEM_CONG_VAN_DEN'],PRIVILEGES['SUA_CONG_VAN_DEN'],PRIVILEGES['XOA_CONG_VAN_DEN'],PRIVILEGES['PHE_DUYET_CONG_VAN_DEN']])){
			throw new Exception('Bạn không có quyền xem danh sách công văn chờ phê duyệt');
		}
		if(isset($_GET['p'])){
			if(is_numeric($_GET['p']) && intval($_GET['p'])>0){
				$pp_cp = intval($_GET['p']);
			}else{
				$pp_cp = 1;
			}
		}else{
			$pp_cp = 1;
		}
		
		$legaldocuments = $user->getDanhSachCongVanDenChoPheDuyet(($pp_cp-1)*10, 10);
		if(!count($legaldocuments)){
			throw new Exception('Không có công văn nào chờ phê duyệt ở trang này');
		}
		echo '<div id="page-title">DANH SÁCH CÔNG VĂN ĐẾN CHỜ PHÊ DUYỆT</div>';
		
?>
<div id="legaldocument-list">
	<table class="list-table">
		<tr><th>Số đến</th><th>Ký hiệu</th><th>Đơn vị phát hành</th><th>Trích yếu</th><th>Ý kiến phê duyệt</th><th>Tình trạng</th><th>Thao tác</th></tr>
		<?php
			foreach($legaldocuments as $legaldocument){
				echo '<tr>';
				echo '<td>'.$legaldocument->getSoDen().'</td>';
				echo '<td>'.$legaldocument->getKyHieu().'</td>';
				echo '<td><div class="abstract-wrapper w10">'.$legaldocument->getDonViBanHanh()->getTenDonVi().'</div></td>';
				echo '<td><div class="abstract-wrapper w10">'.$legaldocument->getTrichYeu().'</div></td>';
				echo '<td><div class="abstract-wrapper w10">'.($legaldocument->getPheDuyet()->getYKienPheDuyet()?$legaldocument->getPheDuyet()->getYKienPheDuyet():'<font color="red">Chưa có ý kiến</font>').'</div></td>';
				echo '<td>'.$legaldocument->getTrangThaiString().'</td>';
				echo '<td>';
				echo '<a class="action-btn positive detail" onclick="showFormPopup(\'/ajax/showiclddetail.php\', [[\'id\', '.$legaldocument->getID().']])" title="Chi tiết công văn"></a>';
				if($user->getQuyen()->contain(PRIVILEGES['PHE_DUYET_CONG_VAN_DEN'])){
					echo '<a class="action-btn positive add-censorship" onclick="showFormPopup(\'/ajax/addapprovalform.php\', [[\'id\', '.$legaldocument->getID().']])" title="Thực hiện cho ý kiến phê duyệt"></a>';
				}
				if($user->getQuyen()->contain(PRIVILEGES['PHE_DUYET_CONG_VAN_DEN'])){
					echo '<a class="action-btn positive delete-censorship" onclick="showFormPopup(\'/ajax/deleteapprovalform.php\', [[\'id\', '.$legaldocument->getID().']])" title="Thực hiện xóa ý kiến phê duyệt"></a>';
				}
				if($user->getQuyen()->contain(PRIVILEGES['PHE_DUYET_CONG_VAN_DEN'])){
					echo '<a class="action-btn positive verify-censorship" onclick="showFormPopup(\'/ajax/verifyapprovalform.php\', [[\'id\', '.$legaldocument->getID().']])" title="Thực hiện xác nhận ý kiến phê duyệt"></a>';
				}
				if($user->getQuyen()->contain(PRIVILEGES['PHE_DUYET_CONG_VAN_DEN'])){
					echo '<a class="action-btn negative delete" onclick="showFormPopup(\'/ajax/deleteicldform.php\', [[\'maloai\', '.$legaldocument->getID().']]);" title="Xóa công văn"></a>';
				}
				echo '</td>';
CONTROLBTN;
				echo '</tr>';
			}
		?>
	</table>
	<?php
		try{
			$pp_pt = ceil($user->countWAICLD() / 10);
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