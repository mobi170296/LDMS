<?php
	try{
		if(!$user->isDangNhap()){
			throw new Exception('Bạn chưa đăng nhập');
		}
		if(!$user->getQuyen()->contain(PRIVILEGES['THEM_LOAI_VAN_BAN'])){
			throw new Exception('Bạn không có quyền liệt kê danh sách loại văn bản');
		}
		echo '<div id="page-title">Danh sách Loại văn bản</div>';
		if(isset($_GET['p'])){
			if(is_numeric($_GET['p']) && intval($_GET['p'])>0){
				$pp_cp = intval($_GET['p']);
			}else{
				$pp_cp = 1;
			}
		}else{
			$pp_cp = 1;
		}
		$doctypes = $user->getDanhSachLoaiVanBan(10*($pp_cp-1), 10);
		if(count($doctypes)==0){
			throw new Exception('Không có loại văn bản nào ở trang này');
		}
?>
<div id="doctype-list">
	<table class="list-table">
		<tr><th>Mã loại</th><th>Tên loại</th><th>Thời gian thêm</th><th>Thao tác</th></tr>
		<?php
			foreach($doctypes as $doctype){
				echo '<tr>';
				echo '<td>'.$doctype->getMaLoai().'</td>';
				echo '<td>'.$doctype->getTenLoai().'</td>';
				echo '<td>'.MDateTime::parseDateTime($doctype->getThoiGianThem())->getDateTimeString().'</td>';
				echo '<td><a class="action-btn positive edit" onclick="showFormPopup(\'/ajax/editdoctypeform.php\', [[\'maloai\', \''.$doctype->getMaLoai().'\']])" title="Sửa thông tin loại văn bản"></a><a class="action-btn negative delete" onclick="showFormPopup(\'/ajax/deletedoctypeform.php\', [[\'maloai\', \''.$doctype->getMaLoai().'\']]);" title="Xóa loại văn bản"></a></td>';
				echo '</tr>';
			}
		?>
	</table>
	<?php
		try{
			$pp_pt = ceil($user->countRecordsInTable('loaivanban') / 10);
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