<div id="left-panel">
	<div id="logo">
		Logo here
	</div>
	<?php
	if(!$user->isDangNhap()){
	?>
	<div id="quick-login">
		<form action="/user/login.php" method="post" enctype="application/x-www-form-urlencoded">
			<div><input type="text" name="maso" placeholder="Mã số"/></div>
			<div><input type="password" name="matkhau" placeholder="Mật khẩu"/></div>
			<button type="submit" name="login" value="login"><span>Đăng nhập</span></button>
		</form>
	</div>
	<?php
	}else{
	?>
	<div id="basic-info">
		<div>Xin chào <?php echo $user->getHo() . ' ' . $user->getTen(); ?></div>
		<div style="text-align: center;"><a href="/user/logout.php">Thoát account</a></div>
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
				<a class="menu-item">Đăng ký công văn đến</a>
				<a class="menu-item">Danh sách công văn</a>
				<a class="menu-item">Danh sách công văn chờ kiểm duyệt</a>
				<a class="menu-item">Danh sách công văn chờ phê duyệt</a>
				<a class="menu-item">Thêm danh mục văn bản</a>
				<a class="menu-item">Danh sách danh mục văn bản</a>
				<a class="menu-item">Thêm đơn vị ban hành</a>
				<a class="menu-item">Danh sách đơn vị ban hành</a>
			</div>
		</div>
		<div class="menu-l1">
			<div class="menu-l1-title">Quản trị hệ thống</div>
			<div class="menu-l1-items">
				<a class="menu-item" href="/admin/adduser.php">Thêm người dùng</a>
				<a class="menu-item">Danh sách người dùng</a>
				<a class="menu-item">Thêm Khoa - Đơn vị</a>
				<a class="menu-item">Danh sách Khoa - Đơn vị</a>
				<a class="menu-item">Thêm nhóm</a>
				<a class="menu-item">Danh sách nhóm</a>
			</div>
		</div>
	</div>
	<?php
	}
	?>
</div>