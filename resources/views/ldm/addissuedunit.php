<?php
	try{
		if(!$user->isDangNhap()){
			throw new Exception('Bạn chưa đăng nhập');
		}
		if(!$user->getQuyen()->contain(PRIVILEGES['THEM_DON_VI_BAN_HANH'])){
			throw new Exception('Bạn không có quyền thêm đơn vị ban hành');
		}
		echo '<div id="page-title">Thêm đơn vị ban hành</div>';
		try{
			$data_error = [];
			if(isset($_POST['addissuedunit'])){
				if(!isset($_POST['madonvi']) || !is_string($_POST['madonvi']) || !preg_match('/^\w{1,10}$/i', $_POST['madonvi'])){
					$data_error[] = 'Mã đơn vị không hợp lệ, mã đơn vị phải ít hơn hoặc bằng 10 ký tự, chỉ chứa chỉ chữ số, chữ cái và _';
				}
				if(!isset($_POST['tendonvi']) || !is_string($_POST['tendonvi']) || mb_strlen($_POST['tendonvi'], 'UTF-8')==0 || mb_strlen($_POST['tendonvi'], 'UTF-8')>100){
					$data_error[] = 'Tên đơn vị không hợp lệ, tên đơn vị không được trống và không nhiều hơn 100 ký tự';
				}
				if(!isset($_POST['benngoai']) || !is_numeric($_POST['benngoai'])){
					$data_error[] = 'Loại đơn vị không hợp lệ';
				}
				if(!isset($_POST['diachi']) || !is_string($_POST['diachi']) || mb_strlen($_POST['diachi'], 'UTF-8')==0 || mb_strlen($_POST['diachi'], 'UTF-8')>100){
					$data_error[] = 'Địa chỉ đơn vị không hợp lệ';
				}
				if(count($data_error)){
					throw new NotValidFormDataException($data_error);
				}
				$user->themDonViBanHanh(new IssuedUnitInfo($_POST['madonvi'], $_POST['tendonvi'], $_POST['benngoai'] ? 1 : 0, $_POST['diachi'], null));
				echo '<div class="success-message-box">Thêm đơn vị ban hành thành công</div>';
			}
		}catch(NotValidFormDataException $e){
			echo '<div class="error-message-box">';
			foreach($e->getErrors() as $error){
				echo '<div>'.$error.'</div>';
			}
			echo '</div>';
		}catch(Exception $e){
			echo '<div class="error-message-box">'.$e->getMessage().'</div>';
		}
?>
<div id="add-issuedunit-form-wrapper">
	<div id="add-issuedunit-form">
		<form action="" method="post" enctype="application/x-www-form-urlencoded">
			<div>Mã đơn vị</div>
			<div><input type="text" name="madonvi" value=""/></div>
			<div>Tên đơn vị</div>
			<div><input type="text" name="tendonvi" value=""/></div>
			<div>Loại đơn vị</div>
			<div><input type="radio" name="benngoai" id="rad-add-issuedunit-benngoai" value="1" checked="checked"/><label for="rad-add-issuedunit-benngoai">Bên ngoài</label><input type="radio" name="benngoai" id="rad-add-issuedunit-bentrong" value="0"/><label for="rad-add-issuedunit-bentrong">Bên trong</label></div>
			<div>Địa chỉ</div>
			<div><input type="text" name="diachi" value=""/></div>
			<div><button type="submit" name="addissuedunit" value="addissuedunit">Thêm đơn vị ban hành</button></div>
		</form>
	</div>
</div>
<?php
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>