<?php
	if($user->isDangNhap()){
		if($user->getQuyen()->contain(PRIVILEGES['THEM_NGUOI_DUNG'])){
			echo '<div id="page-title">Thêm Khoa - Đơn vị vào hệ thống</div>';
			try{
				if(isset($_POST['adddepartment'])){
					$data_error = [];
					if(!isset($_POST['madonvi']) || !is_string($_POST['madonvi']) || !preg_match('/^\w{1,10}$/i', $_POST['madonvi'])){
						$data_error[] = 'Mã đơn vị không hợp lệ, mã đơn vị phải ít hơn hoặc bằng 10 ký tự, chỉ chứa chỉ chữ số, chữ cái và _';
					}
					if(!isset($_POST['tendonvi']) || !is_string($_POST['tendonvi']) || mb_strlen($_POST['tendonvi'], 'UTF-8')==0 || mb_strlen($_POST['tendonvi'], 'UTF-8')>100){
						$data_error[] = 'Tên đơn vị không hợp lệ, tên đơn vị không được trống và không nhiều hơn 100 ký tự';
					}
					if(!isset($_POST['email']) || !is_string($_POST['email']) || strlen($_POST['email']) > 50 ||!preg_match('/^(\w+\.)*\w+@(\w+\.)+[a-z]{2,3}$/i', $_POST['email'])){
							$data_error[] = 'Địa chỉ email không hợp lệ, địa chỉ email phải dưới 50 ký tự và phải theo định dạng email';
					}
					if(count($data_error)){
						throw new NotValidFormDataException($data_error);
					}
					$user->themDonVi(new DepartmentInfo($_POST['madonvi'], $_POST['tendonvi'], $_POST['email'], null));
					echo '<div class="success-message-box">Thêm thành công đơn vị '.$_POST['tendonvi'].'</div>';
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
			<div id="add-department-form-wrapper">
				<div id="add-department-form">
					<form action="" method="post" enctype="application/x-www-form-urlencoded">
						<div>Mã đơn vị</div>
						<div><input type="text" name="madonvi" placeholder="Nhập mã đơn vị" value="<?php echo isset($_POST['madonvi']) ?htmlspecialchars($_POST['madonvi']) :'';  ?>"/></div>
						<div>Tên đơn vị</div>
						<div><input type="text" name="tendonvi" placeholder="Nhập tên đơn vị" value="<?php echo isset($_POST['tendonvi']) ?htmlspecialchars($_POST['tendonvi']) : '' ; ?>"/></div>
						<div>Email</div>
						<div><input type="text" name="email" placeholder="Nhập Email đơn vị" value="<?php echo isset($_POST['email'])?htmlspecialchars($_POST['email']) :'';  ?>"/></div>
						<div><button type="submit" name="adddepartment" value="adddepartment">Thêm đơn vị</button></div>
					</form>
				</div>
			</div>
<?php
		}else{
			echo '<div class="error-message-box">Bạn không có quyền thêm đơn vị</div>';
		}
	}else{
		echo '<div class="error-message-box">Bạn chưa đăng nhập!</div>';
	}
?>