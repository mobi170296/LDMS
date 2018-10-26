<?php
	if($user->isDangNhap()){
		if($user->getQuyen()->contain(PRIVILEGES['THEM_NGUOI_DUNG'])){
			echo '<div id="page-title">Thêm người dùng vào hệ thống</div>';
			try{
				if(isset($_POST['adduser'])){
					$data_error = [];
					
					if(!isset($_POST['maso']) || !is_string($_POST['maso']) || !preg_match('/^[a-cA-C]?[0-9]{1,8}$/', $_POST['maso'])){
						$data_error[] = 'Mã số cán bộ không hợp lệ';
					}
					if(isset($_POST['matkhau'][0]) && is_string($_POST['matkhau'][0]) && isset($_POST['matkhau'][1]) && is_string($_POST['matkhau'][1]) && strlen($_POST['matkhau'][0])){
						if($_POST['matkhau'][0] != $_POST['matkhau'][1]){
							$data_error[] = 'Mật khẩu không trùng';
						}
					}else{
						$data_error[] = 'Mật khẩu không hợp lệ';
					}
					if(!isset($_POST['ho']) || !is_string($_POST['ho']) || !preg_match('/^[\p{L}\s]{1,40}$/u', $_POST['ho'])){
						$data_error[] = 'Họ và tên lót không hợp lệ độ dài họ phải dưới 40';
					}
					if(!isset($_POST['ho']) || !is_string($_POST['ho']) || !preg_match('/^[\p{L}\s]{1,20}$/u', $_POST['ho'])){
						$data_error[] = 'Tên không hợp lệ độ dài họ phải dưới 20';
					}
					if(isset($_POST['ngay']) && is_numeric($_POST['ngay']) && isset($_POST['thang']) && is_numeric($_POST['thang']) && isset($_POST['nam']) && is_numeric($_POST['nam'])){
						if(!checkdate(intval($_POST['thang']), intval($_POST['ngay']), intval($_POST['nam']))){
							$data_error[] = 'Không tồn tại ngày sinh này';
						}
					}else{
						$data_error[] = 'Ngày sinh phải là số';
					}
					if(!isset($_POST['email']) || !is_string($_POST['email']) || strlen($_POST['email']) > 50 ||!preg_match('/^(\w+\.)*\w+@(\w+\.)+[a-z]{2,3}$/i', $_POST['email'])){
						$data_error[] = 'Địa chỉ email không hợp lệ, địa chỉ email phải dưới 50 ký tự và phải theo định dạng email';
					}
					if(!isset($_POST['sodienthoai']) || !is_string($_POST['sodienthoai']) || !preg_match('/^0[0-9]{9,10}$/', $_POST['sodienthoai'])){
						$data_error[] = 'Số điện thoại không hợp lệ';
					}
					if(!isset($_POST['diachi']) || !is_string($_POST['diachi']) || mb_strlen($_POST['diachi'], 'UTF-8')==0 || mb_strlen($_POST['diachi'], 'UTF-8') > 100){
						$data_error[] = 'Địa chỉ không hợp lệ, độ dài địa chỉ từ 1 đến 100 ký tự';
					}
					if(count($data_error)!=0){
						throw new NotValidFormDataException($data_error);
					}
					$user->themNguoiDung(new UserInfo(null, $_POST['maso'], $_POST['matkhau'][0], $_POST['ho'], $_POST['ten'], $_POST['nam'] .'-'.$_POST['thang']. '-'.$_POST['ngay'], $_POST['email'], $_POST['sodienthoai'], $_POST['diachi'], $_POST['madonvi'], $_POST['manhom'], isset($_POST['tinhtrang']) ? 1 : 0));
					echo '<div class="success-message-box">Thêm người dùng thành công</div>';
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
			
			try{
				$groups = $user->getDanhSachNhom();
				$departments = $user->getDanhSachDonVi();
?>
	<div id="add-user-form-wrapper">
		<div id="add-user-form">
		<form action="" method="post" enctype="application/x-www-form-urlencoded" name="add-user">
		<div>Mã số cán bộ</div>
		<div><input type="text" name="maso" value="<?php if(isset($_POST['maso'])) echo $_POST['maso'];?>"/></div>
		<div>Mật khẩu</div>
		<div><input type="password" name="matkhau[]"/></div>
		<div>Nhập lại mật khẩu</div>
		<div><input type="password" name="matkhau[]"/></div>
		<div>Họ</div>
		<div><input type="text" name="ho" value="<?php if(isset($_POST['ho'])) echo $_POST['ho'];?>"/></div>
		<div>Tên</div>
		<div><input type="text" name="ten" value="<?php if(isset($_POST['ten'])) echo $_POST['ten'];?>"/></div>
		<div>Ngày tháng năm sinh</div>
		<div>
			<select name="ngay">
				<?php
				for($i=1; $i<=MCalendar::getMaxDayOfMonth(1, 2010); $i++){
					echo '<option value="'.$i.'" '.(isset($_POST['ngay']) && $_POST['ngay']==$i ? 'selected="selected"' : '').'>'.$i.'</option>';
				}
				?>
			</select>/
			<select name="thang" onChange="updateDaySelect(this.form['ngay'],this,this.form['nam'])">
				<?php
				for($i=1; $i<=12; $i++){
					echo '<option value="'.$i.'" '.(isset($_POST['thang']) && $_POST['thang']==$i ? 'selected="selected"' : '').'>'.$i.'</option>';
				}
				?>
			</select>/
			<select name="nam" onChange="updateDaySelect(this.form['ngay'],this.form['thang'],this)">
				<?php
				for($i=2010; $i>=1950; $i--){
					echo '<option value="'.$i.'" '.(isset($_POST['nam']) && $_POST['nam']==$i ? 'selected="selected"' : '') .'>'.$i.'</option>';
				}
				?>
			</select>
		</div>
		<div>Email</div>
		<div><input type="text" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>"/></div>
		<div>Số điện thoại</div>
		<div><input type="text" name="sodienthoai" value="<?php if(isset($_POST['sodienthoai'])) echo $_POST['sodienthoai']; ?>"/></div>
		<div>Địa chỉ</div>
		<div><input type="text" name="diachi" value="<?php if(isset($_POST['diachi'])) echo $_POST['diachi']; ?>"/></div>
		<div>Mã đơn vị</div>
		<div>
			<select name="madonvi">
				<?php
				foreach($departments as $department){
					echo '<option value="' . $department->getMaDonVi() . '" '.(isset($_POST['madonvi']) && $_POST['madonvi']==$department->getMaDonVi() ? 'selected="selected"' : '').'>' . $department->getTenDonVi() . '</option>';
				}
				?>
			</select>
		</div>
		<div>Mã nhóm</div>
		<div>
			<select name="manhom">
				<?php
				foreach($groups as $group){
					echo '<option value="' . $group->getMaNhom() . '" '.(isset($_POST['manhom']) && $_POST['manhom']==$group->getMaNhom() ? 'selected="selected"' : '').'>' . $group->getTenNhom() . '</option>';
				}
				?>
			</select>
		</div>
		<div>Tình trạng tài khoản</div>
		<div><input type="checkbox" id="ckb-add-user-tinhtrang" name="tinhtrang" value="1" <?php echo isset($_POST['tinhtrang']) ? 'checked="checked"' : ''; ?>/><label for="ckb-add-user-tinhtrang">Kích hoạt</label></div>
		<div><button type="submit" name="adduser" value="adduser">Thêm người dùng</button></div>
		</form>
		</div>
	</div>
<!--
	<script type="text/javascript">
		document.forms['add-user']['thang'].onchange = function(e){
			var vm = this.value;
			var vy = this.form['nam'].value;
			var sd = this.form['ngay'];
			while(sd.options.length){
				sd.options.remove(0);
			}
			for(d=1; d<=getMaxDayOfMonth(vm, vy); d++){
				var option = $create('option');
				option.value = option.innerHTML = d;
				sd.options.add(option);
			}
		}
		document.forms['add-user']['nam'].onchange = function(e){
			var vm = this.form['thang'].value;
			var vy = this.value;
			var sd = this.form['ngay'];
			while(sd.options.length){
				sd.options.remove(0);
			}
			for(d=1; d<=getMaxDayOfMonth(vm, vy); d++){
				var option = $create('option');
				option.value = option.innerHTML = d;
				sd.options.add(option);
			}
		}
	</script>
-->
<?php
			}catch(Exception $e){
				echo $e->getMessage();
			}

		}else{
			echo '<div class="error-message-box">Bạn không có quyền thêm người dùng</div>';
		}
	}else{
		echo '<div class="error-message-box">Bạn chưa đăng nhập!</div>';
	}
?>