<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	try{
		if(!isset($_POST['id'])||!is_numeric($_POST['id'])){
			throw new Exception('Yêu cầu không hợp lệ');
		}
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		$user = new User($mcon);
		$user->dangNhap();
		
		if(!$user->getQuyen()->contain(PRIVILEGES['SUA_NGUOI_DUNG'])){
			throw new Exception('Bạn không có quyền thực hiện sửa người dùng');
		}
		
		$userinfo = $user->getNguoiDung($_POST['id']);
		$groups = $user->getDanhSachNhom();
		$departments = $user->getDanhSachDonVi();
?>
		<div id="page-title">Sửa thông tin người dùng</div>
		<div id="edituser-form">
			<form action="/ajax/edituser.php" method="post" onsubmit="ajaxSubmitEdit(this);return false;">
				<div>Mã số cán bộ</div>
				<div><input type="text" name="maso" value="<?php echo $userinfo->getMaSo();?>"/></div>
				<div>Mật khẩu</div>
				<div><input type="password" name="matkhau[]"/></div>
				<div>Nhập lại mật khẩu</div>
				<div><input type="password" name="matkhau[]"/></div>
				<div>Họ</div>
				<div><input type="text" name="ho" value="<?php echo $userinfo->getHo();?>"/></div>
				<div>Tên</div>
				<div><input type="text" name="ten" value="<?php echo $userinfo->getTen();?>"/></div>
				<div>Ngày tháng năm sinh</div>
				<div>
					<select name="ngay">
						<?php
						for($i=1; $i<=MCalendar::getMaxDayOfMonth(1, 2010); $i++){
							echo '<option value="'.$i.'" '.(MDateTime::parseDate($userinfo->getNgaySinh())->getDay()==$i ? 'selected="selected"' : '').'>'.$i.'</option>';
						}
						?>
					</select>/
					<select name="thang" onChange="updateDaySelect(this.form['ngay'],this,this.form['nam'])">
						<?php
						for($i=1; $i<=12; $i++){
							echo '<option value="'.$i.'" '.(MDateTime::parseDate($userinfo->getNgaySinh())->getMonth()==$i ? 'selected="selected"' : '').'>'.$i.'</option>';
						}
						?>
					</select>/
					<select name="nam" onChange="updateDaySelect(this.form['ngay'],this.form['thang'],this)">
						<?php
						for($i=2010; $i>=1950; $i--){
							echo '<option value="'.$i.'" '.(MDateTime::parseDate($userinfo->getNgaySinh())->getYear()==$i ? 'selected="selected"' : '') .'>'.$i.'</option>';
						}
						?>
					</select>
				</div>
				<div>Email</div>
				<div><input type="text" name="email" value="<?php echo $userinfo->getEmail(); ?>"/></div>
				<div>Số điện thoại</div>
				<div><input type="text" name="sodienthoai" value="<?php echo $userinfo->getSoDienThoai(); ?>"/></div>
				<div>Địa chỉ</div>
				<div><input type="text" name="diachi" value="<?php echo $userinfo->getDiaChi(); ?>"/></div>
				<div>Mã đơn vị</div>
				<div>
					<select name="madonvi">
						<?php
						foreach($departments as $department){
							echo '<option value="' . $department->getMaDonVi() . '" '.($userinfo->getMaDonVi()==$department->getMaDonVi() ? 'selected="selected"' : '').'>' . $department->getTenDonVi() . '</option>';
						}
						?>
					</select>
				</div>
				<div>Mã nhóm</div>
				<div>
					<select name="manhom">
						<?php
						foreach($groups as $group){
							echo '<option value="' . $group->getMaNhom() . '" '.($userinfo->getMaNhom()==$group->getMaNhom() ? 'selected="selected"' : '').'>' . $group->getTenNhom() . '</option>';
						}
						?>
					</select>
				</div>
				<div>Tình trạng tài khoản</div>
				<div><input type="checkbox" id="ckb-add-user-tinhtrang" name="tinhtrang" value="1" <?php echo $userinfo->getTinhTrang() ? 'checked="checked"' : ''; ?>/><label for="ckb-add-user-tinhtrang">Kích hoạt</label></div>
				<div><input type="hidden" name="edituser" value="edituser"/></div>
				<div><input type="hidden" name="id" value="<?php echo $userinfo->getID(); ?>"/></div>
				<div><button type="submit">Lưu thông tin</button></div>
			</form>
		</div>
<?php
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}