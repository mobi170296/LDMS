<?php
	try{
		if(!$user->isDangNhap()){
			throw new Exception('Bạn chưa đăng nhập!');
		}
		if(!$user->getQuyen()->contain(PRIVILEGES['THEM_NHOM'])){
			throw new Exception('Bạn không có quyền thêm nhóm người dùng');
		}
		echo '<div id="page-title">Thêm nhóm người dùng</div>';
		try{
			if(isset($_POST['addgroup'])){
				$data_error = [];
				if(!isset($_POST['manhom']) || !is_string($_POST['manhom']) || !preg_match('/^\w{1,10}$/i', $_POST['manhom'])){
					$data_error[] = 'Mã nhóm không hợp lệ, mã nhóm phải ít hơn hoặc bằng 10 ký tự, chỉ chứa chỉ chữ số, chữ cái và _';
				}
				if(!isset($_POST['tennhom']) || !is_string($_POST['tennhom']) || mb_strlen($_POST['tennhom'], 'UTF-8')==0 || mb_strlen($_POST['tennhom'], 'UTF-8')>100){
				$data_error[] = 'Tên nhóm không hợp lệ, tên nhóm không được trống và không nhiều hơn 100 ký tự';
				}
				if(count($data_error)){
					throw new NotValidFormDataException($data_error);
				}
				$user->themNhomNguoiDung(new GroupInfo($_POST['manhom'], $_POST['tennhom'], null));
				echo '<div class="success-message-box">Thêm thành công nhóm người dùng '. $_POST['tennhom'] .'</div>'; 
			}
		}catch(NotValidFormDataException $e){
			echo '<div class="error-message-box">';
			for($i=0;$i<count($e->getErrors())-1; $i++){
				echo '<div>'.$e->getErrors()[$i].'</div>';
			}
			echo '<div>'.$e->getErrors()[$i].'</div>';
			echo '</div>';
		}catch(Exception $e){
			echo '<div class="error-message-box">'.$e->getMessage().'</div>'; 
		}
?>
<div id="add-group-form-wrapper">
	<div id="add-group-form">
		<form action="" method="post" enctype="application/x-www-form-urlencoded">
			<div>Mã nhóm</div>
			<div><input type="text" name="manhom" value="<?php echo isset($_POST['manhom']) ? $_POST['manhom'] : ''; ?>"/></div>
			<div>Tên nhóm</div>
			<div><input type="text" name="tennhom" value="<?php echo isset($_POST['tennhom']) ? $_POST['tennhom'] : ''; ?>"/></div>
			<div><button type="submit" name="addgroup" value="addgroup">Thêm nhóm</button></div>
		</form>
	</div>
</div>
<?php
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>