<?php
	try{
		if(!$user->isDangNhap()){
			throw new Exception('Bạn chưa đăng nhập');
		}
		if(!$user->getQuyen()->contain(PRIVILEGES['THEM_LOAI_VAN_BAN'])){
			throw new Exception('Bạn không có quyền thêm loại văn bản');
		}
		echo '<div id="page-title">Thêm loại văn bản</div>';
		try{
			if(isset($_POST['adddoctype'])){
				$data_error = [];
				if(!isset($_POST['maloai']) || !is_string($_POST['maloai']) || !preg_match('/^\w{1,10}$/i', $_POST['maloai'])){
					$data_error[] = 'Mã loại văn bản không hợp lệ, mã loại có dộ dài tối đa là 10 không được rỗng, chỉ chứa chữ cái, chữ số và _';
				}
				if(!isset($_POST['tenloai']) || !is_string($_POST['tenloai']) || mb_strlen($_POST['tenloai'], 'UTF-8')==0 || mb_strlen($_POST['tenloai'], 'UTF-8') > 50){
					$data_error[] = 'Tên loại văn bản không hợp lệ, tên loại phải có đọ dài từ 1 đén 50 ký tự';
				}
				
				if(count($data_error)){
					throw new NotValidFormDataException($data_error);
				}
				
				$user->themLoaiVanBan(new DocTypeInfo($_POST['maloai'], $_POST['tenloai'], null));
				echo '<div class="success-message-box">Đã thêm thành công loại văn bản '.$_POST['tenloai'].'</div>';
			}
		}catch(NotValidFormDataException $e){
			echo '<div class="error-message-box">';
			foreach($e->getErrors() as $error){
				echo '<div>'.$error.'</div>';
			}
			echo '</div>';
		}catch(Exception $e){
			echo '<div class="error-message-box">'.$e->getMessage().'x</div>';
		}
?>
<div id="add-doctype-form-wrapper">
	<div id="add-doctype-form">
		<form action="" method="post" enctype="application/x-www-form-urlencoded">
		<div>Mã loại văn bản</div>
		<div><input type="text" name="maloai"/></div>
		<div>Tên loại văn bản</div>
		<div><input type="text" name="tenloai"</div>
		<div><button type="submit" name="adddoctype" value="adddoctype">Thêm loại văn bản</button></div>
		</form>
	</div>
</div>
<?php
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>