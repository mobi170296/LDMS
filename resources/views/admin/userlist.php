<?php
	try{
		if(!$user->isDangNhap()){
			throw new Exception('Bạn chưa đăng nhập');
		}
		if(!$user->getQuyen()->contains([PRIVILEGES['THEM_NGUOI_DUNG'],PRIVILEGES['SUA_NGUOI_DUNG'],PRIVILEGES['XOA_NGUOI_DUNG'],PRIVILEGES['CAP_QUYEN_NGUOI_DUNG']])){
			throw new Exception('Bạn không có quyền xem danh sách người dùng');
		}
		
		echo '<div id="page-title">Danh sách nhóm người dùng</div>';
		
		
		if(isset($_GET['p'])){
			if(is_numeric($_GET['p']) && intval($_GET['p'])>0){
				$pp_cp = intval($_GET['p']);
			}else{
				$pp_cp = 1;
			}
		}else{
			$pp_cp = 1;
		}
		
		$userinfos = $user->getDanhSachNguoiDung(10*($pp_cp-1), 10);
		if(count($userinfos)==0){
			throw new Exception('Không có người dùng nào ở trang này');
		}
?>

<div id="doctype-list">
	<table class="list-table">
		<tr><th>Mã số</th><th>Họ</th><th>Tên</th><th>Ngày Sinh</th><th>Email</th><th>Số điện thoại</th><th>Trạng thái</th><th>Thao tác</th></tr>
		<?php
			foreach($userinfos as $userinfo){
				echo '<tr>';
				echo '<td>'.$userinfo->getMaSo().'</td>';
				echo '<td>'.$userinfo->getHo().'</td>';
				echo '<td>'.$userinfo->getTen().'</td>';
				echo '<td>'.MDateTime::parseDate($userinfo->getNgaySinh())->getDateString().'</td>';
				echo '<td>'.$userinfo->getEmail().'</td>';
				echo '<td>'.$userinfo->getSoDienThoai().'</td>';
				echo '<td>'.($userinfo->getTinhTrang()?'<font color="green">Bình thường</font>':'<font color="red">Đã khóa</font>').'</td>';
				echo '<td>';
				if($user->getQuyen()->contains([PRIVILEGES['THEM_NGUOI_DUNG'],PRIVILEGES['SUA_NGUOI_DUNG'],PRIVILEGES['XOA_NGUOI_DUNG'],PRIVILEGES['CAP_QUYEN_NGUOI_DUNG']])){
					echo '<a class="action-btn positive detail" onclick="showFormPopup(\'/ajax/showuserdetail.php\', [[\'id\', '.$userinfo->getID().']])" title="Xem chi tiết người dùng"></a>';
				}
				if($user->getQuyen()->contain(PRIVILEGES['SUA_NGUOI_DUNG'])){
					echo '<a class="action-btn positive edit" onclick="showFormPopup(\'/ajax/edituserform.php\', [[\'id\', '.$userinfo->getID().']])" title="Sửa thông tin người dùng"></a>';
				}
				if($user->getQuyen()->contain(PRIVILEGES['CAP_QUYEN_NGUOI_DUNG'])){
					echo '<a class="action-btn positive grant-privilege" onclick="showFormPopup(\'/ajax/grantuserprivilegesform.php\', [[\'id\', '.$userinfo->getID().']])" title="Cấp quyền cho người dùng"></a>';
				}
				if($user->getQuyen()->contain(PRIVILEGES['XOA_NGUOI_DUNG'])){
					echo '<a class="action-btn negative delete" onclick="showFormPopup(\'/ajax/deleteuserform.php\', [[\'id\', '.$userinfo->getID().']])" title="Xóa người dùng"></a>';
				}
				echo '</td>';
				echo '</tr>';
			}
		?>
	</table>
	<?php
		try{
			$pp_pt = ceil($user->countRecordsInTable('nguoidung') / 10);
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