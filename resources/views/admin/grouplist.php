<?php
	try{
		if(!$user->isDangNhap()){
			throw new Exception('Bạn chưa đăng nhập');
		}
		if(!$user->getQuyen()->contain(PRIVILEGES['THEM_NHOM'])){
			throw new Exception('Bạn không có quyền xem danh sách nhóm');
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
		
		$groups = $user->getDanhSachNhom(10*($pp_cp-1), 10);
		if(count($groups)==0){
			throw new Exception('Không có nhóm nào ở trang này');
		}
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
				echo '<td><a class="action-btn positive edit" onclick="showFormPopup(\'/ajax/editgroupform.php\', [[\'manhom\', \''.$group->getMaNhom().'\']])"></a><a class="action-btn negative delete" onclick="showFormPopup(\'/ajax/deletegroupform.php\', [[\'manhom\', \''.$group->getMaNhom().'\']])"></a></td>';
				echo '</tr>';
			}
		?>
	</table>
	<?php
		try{
			$pp_pt = ceil($user->countRecordsInTable('nhom') / 10);
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