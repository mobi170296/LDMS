<div id="left-panel">
	<div id="logo">
		<a id="logo-link" href="/index.php">Quản lý Công Văn</a>
	</div>
	<?php
	if(!$user->isDangNhap()){
	?>
	<div id="quick-login">
		<form action="/user/login.php" method="post" enctype="application/x-www-form-urlencoded">
			<div><input type="text" name="maso" placeholder="Mã số"/></div>
			<div><input type="password" name="matkhau" placeholder="Mật khẩu"/></div>
			<div><button type="submit" name="login" value="login"><span>Đăng nhập</span></button></div>
		</form>
	</div>
	<?php
	}else{
	?>
	<div id="basic-info">
		<div>Xin chào <?php echo $user->getHo() . ' ' . $user->getTen(); ?></div>
		<div style="text-align: center;"><a href="/user/logout.php">Thoát tài khoản</a></div>
	</div>
	<?php
	}
	?>
	<?php
	if($user->isDangNhap()){
	?>
	<div id="menu">
		<div class="menu-l1">
			<div class="menu-l1-title">Quản lý công văn</div>
			<div class="menu-l1-items">
				<a class="menu-item<?php if($_SERVER['SCRIPT_NAME']=='/ldm/addicld.php') echo ' selected-menu-item'; ?>" href="/ldm/addicld.php">Đăng ký công văn đến</a>
				<a class="menu-item<?php if($_SERVER['SCRIPT_NAME']=='/ldm/icldlist.php') echo ' selected-menu-item'; ?>" href="/ldm/icldlist.php">Danh sách công văn</a>
				<a class="menu-item<?php if($_SERVER['SCRIPT_NAME']=='') echo ' selected-menu-item'; ?>" href="/ldm/wcicldlist.php">Danh sách công văn chờ kiểm duyệt</a>
				<a class="menu-item<?php if($_SERVER['SCRIPT_NAME']=='') echo ' selected-menu-item'; ?>" href="/ldm/waicldlist.php">Danh sách công văn chờ phê duyệt</a>
				<a class="menu-item<?php if($_SERVER['SCRIPT_NAME']=='') echo ' selected-menu-item'; ?>" href="">Tìm kiếm công văn</a>
				<a class="menu-item<?php if($_SERVER['SCRIPT_NAME']=='/ldm/adddoctype.php') echo ' selected-menu-item'; ?>" href="/ldm/adddoctype.php">Thêm loại văn bản</a>
				<a class="menu-item<?php if($_SERVER['SCRIPT_NAME']=='/ldm/doctypelist.php') echo ' selected-menu-item'; ?>" href="/ldm/doctypelist.php">Danh sách loại văn bản</a>
				<a class="menu-item<?php if($_SERVER['SCRIPT_NAME']=='/ldm/addissuedunit.php') echo ' selected-menu-item'; ?>" href="/ldm/addissuedunit.php">Thêm đơn vị ban hành</a>
				<a class="menu-item<?php if($_SERVER['SCRIPT_NAME']=='/ldm/issuedunitlist.php') echo ' selected-menu-item'; ?>" href="/ldm/issuedunitlist.php">Danh sách đơn vị ban hành</a>
			</div>
		</div>
		<div class="menu-l1">
			<div class="menu-l1-title">Quản trị hệ thống</div>
			<div class="menu-l1-items">
				<a class="menu-item<?php if($_SERVER['SCRIPT_NAME']=='/admin/adduser.php') echo ' selected-menu-item'; ?>" href="/admin/adduser.php">Thêm người dùng</a>
				<a class="menu-item<?php if($_SERVER['SCRIPT_NAME']=='/admin/userlist.php') echo ' selected-menu-item'; ?>" href="/admin/userlist.php">Danh sách người dùng</a>
				<a class="menu-item<?php if($_SERVER['SCRIPT_NAME']=='/admin/adddepartment.php') echo ' selected-menu-item'; ?>" href="/admin/adddepartment.php">Thêm Khoa - Đơn vị</a>
				<a class="menu-item<?php if($_SERVER['SCRIPT_NAME']=='/admin/departmentlist.php') echo ' selected-menu-item'; ?>" href="/admin/departmentlist.php">Danh sách Khoa - Đơn vị</a>
				<a class="menu-item<?php if($_SERVER['SCRIPT_NAME']=='/admin/addgroup.php') echo ' selected-menu-item'; ?>" href="/admin/addgroup.php">Thêm nhóm</a>
				<a class="menu-item<?php if($_SERVER['SCRIPT_NAME']=='/admin/grouplist.php') echo ' selected-menu-item'; ?>" href="/admin/grouplist.php">Danh sách nhóm</a>
			</div>
		</div>
	</div>
	<?php
	}
	?>
</div>