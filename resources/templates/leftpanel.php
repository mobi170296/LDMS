<div id="left-panel">
	<div id="logo">
		<a id="logo-link" href="/index.php">Quản lý Công Văn</a>
	</div>
	<?php
	if(!$user->isDangNhap()){
	?>
	<div id="quick-login">
		<form action="/user/login.php" method="post" enctype="application/x-www-form-urlencoded">
			<div><input type="text" name="maso" size="15" placeholder="Mã số" autocomplete="off" autofocus="autofocus"/></div>
			<div><input type="password" name="matkhau" size="15" placeholder="Mật khẩu" autocomplete="off"/></div>
			<div><input style="font-family: arial; text-align: center" type="text" name="captcha" placeholder="Chuỗi xác thực" autocomplete="off"/></div>
			<div><img src="/resources/captcha/captcha.php?t=<?php echo time();?>"/></div>
			<div><button type="submit" name="login" value="login"><span>Đăng nhập</span></button></div>
		</form>
	</div>
	<?php
	}else{
	?>
	<div id="basic-info">
		<div id="avatar-wrapper">
			<img src="/resources/avatars/avatar.php?nc=<?php echo $user->getMaSo(); ?>" alt="Hình đại diện" width="100%"/>
		</div>
		<div id="hello-user">Xin chào <?php echo $user->getHo() . ' ' . $user->getTen(); ?></div>
		<div style="text-align: center;"><a id="logout-btn" href="/user/logout.php">Thoát tài khoản</a></div>
	</div>
	<?php
	}
	?>
	<?php
	if($user->isDangNhap()){
	?>
	<div id="menu">
		<?php
		if($user->getQuyen()->contains([PRIVILEGES['THEM_CONG_VAN_DEN'],PRIVILEGES['SUA_CONG_VAN_DEN'],PRIVILEGES['XOA_CONG_VAN_DEN'],PRIVILEGES['THEM_LOAI_VAN_BAN'],PRIVILEGES['XOA_LOAI_VAN_BAN'],PRIVILEGES['SUA_LOAI_VAN_BAN'],PRIVILEGES['THEM_DON_VI_BAN_HANH'],PRIVILEGES['SUA_DON_VI_BAN_HANH'],PRIVILEGES['XOA_DON_VI_BAN_HANH'],PRIVILEGES['KIEM_DUYET_CONG_VAN_DEN'],PRIVILEGES['PHE_DUYET_CONG_VAN_DEN']])){
		
		echo '<div class="menu-l1">';
			echo '<div class="menu-l1-title">Quản lý công văn</div>';
			echo '<div class="menu-l1-items">';
					if($user->getQuyen()->contain(PRIVILEGES['THEM_CONG_VAN_DEN'])){
						echo '<a class="menu-item '.($_SERVER['SCRIPT_NAME']=='/ldm/addicld.php'?' selected-menu-item':'').'" href="/ldm/addicld.php">Đăng ký công văn đến</a>';
					}
					if($user->getQuyen()->contains([PRIVILEGES['THEM_CONG_VAN_DEN'],PRIVILEGES['SUA_CONG_VAN_DEN'],PRIVILEGES['XOA_CONG_VAN_DEN'],PRIVILEGES['KIEM_DUYET_CONG_VAN_DEN'],PRIVILEGES['PHE_DUYET_CONG_VAN_DEN']])){
						echo '<a class="menu-item '.($_SERVER['SCRIPT_NAME']=='/ldm/icldlist.php'?' selected-menu-item':'').'" href="/ldm/icldlist.php">Danh sách công văn <span>'.$user->getSoCongVanDen().'</span></a>';
					}
					if($user->getQuyen()->contains([PRIVILEGES['THEM_CONG_VAN_DEN'],PRIVILEGES['SUA_CONG_VAN_DEN'],PRIVILEGES['XOA_CONG_VAN_DEN'],PRIVILEGES['KIEM_DUYET_CONG_VAN_DEN']])){
						echo '<a class="menu-item '.($_SERVER['SCRIPT_NAME']=='/ldm/wcicldlist.php'?' selected-menu-item':'').'" href="/ldm/wcicldlist.php">Danh sách công văn chờ kiểm duyệt<span>'.$user->getSoCongVanDenChoKiemDuyet().'</span></a>';
					}
					if($user->getQuyen()->contains([PRIVILEGES['THEM_CONG_VAN_DEN'],PRIVILEGES['SUA_CONG_VAN_DEN'],PRIVILEGES['XOA_CONG_VAN_DEN'],PRIVILEGES['PHE_DUYET_CONG_VAN_DEN']])){
						echo '<a class="menu-item '.($_SERVER['SCRIPT_NAME']=='/ldm/waicldlist.php'?' selected-menu-item':'').'" href="/ldm/waicldlist.php">Danh sách công văn chờ phê duyệt<span>'.$user->getSoCongVanDenChoPheDuyet().'</span></a>';
					}
					if($user->getQuyen()->contains([PRIVILEGES['THEM_CONG_VAN_DEN'],PRIVILEGES['SUA_CONG_VAN_DEN'],PRIVILEGES['XOA_CONG_VAN_DEN'],PRIVILEGES['PHE_DUYET_CONG_VAN_DEN'],PRIVILEGES['KIEM_DUYET_CONG_VAN_DEN']])){
						echo '<a class="menu-item '.($_SERVER['SCRIPT_NAME']=='/ldm/searchicld.php'?' selected-menu-item':'').'" href="/ldm/searchicld.php">Tìm kiếm công văn</a>';
					}
					if($user->getQuyen()->contain(PRIVILEGES['THEM_LOAI_VAN_BAN'])){
						echo '<a class="menu-item '.($_SERVER['SCRIPT_NAME']=='/ldm/adddoctype.php'?' selected-menu-item':'').'" href="/ldm/adddoctype.php">Thêm loại văn bản</a>';
					}
					if($user->getQuyen()->contains([PRIVILEGES['THEM_LOAI_VAN_BAN'],PRIVILEGES['SUA_LOAI_VAN_BAN'],PRIVILEGES['XOA_LOAI_VAN_BAN']])){
						echo '<a class="menu-item '.($_SERVER['SCRIPT_NAME']=='/ldm/doctypelist.php'?' selected-menu-item':'').'" href="/ldm/doctypelist.php">Danh sách loại văn bản</a>';
					}
					if($user->getQuyen()->contain(PRIVILEGES['THEM_DON_VI_BAN_HANH'])){
						echo '<a class="menu-item '.($_SERVER['SCRIPT_NAME']=='/ldm/addissuedunit.php'?' selected-menu-item':'').'" href="/ldm/addissuedunit.php">Thêm đơn vị ban hành</a>';
					}
					if($user->getQuyen()->contains([PRIVILEGES['THEM_DON_VI_BAN_HANH'],PRIVILEGES['SUA_DON_VI_BAN_HANH'],PRIVILEGES['XOA_DON_VI_BAN_HANH']])){
						echo '<a class="menu-item '.($_SERVER['SCRIPT_NAME']=='/ldm/issuedunitlist.php'?' selected-menu-item':'').'" href="/ldm/issuedunitlist.php">Danh sách đơn vị ban hành</a>';
					}
			echo '</div>';
		echo '</div>';
		}
		?>
		<?php
		if($user->getQuyen()->contains([PRIVILEGES['THEM_NGUOI_DUNG'],PRIVILEGES['SUA_NGUOI_DUNG'],PRIVILEGES['XOA_NGUOI_DUNG'],PRIVILEGES['THEM_NHOM'],PRIVILEGES['SUA_NHOM'],PRIVILEGES['XOA_NHOM'],PRIVILEGES['CAP_QUYEN_NGUOI_DUNG'],PRIVILEGES['CAP_QUYEN_NHOM'],PRIVILEGES['THEM_DON_VI'],PRIVILEGES['SUA_DON_VI'],PRIVILEGES['XOA_DON_VI']])){
			echo '<div class="menu-l1">';
			echo '<div class="menu-l1-title">Quản trị hệ thống</div>';
			echo '<div class="menu-l1-items">';
					if($user->getQuyen()->contain(PRIVILEGES['THEM_NGUOI_DUNG'])){
						echo '<a class="menu-item '.($_SERVER['SCRIPT_NAME']=='/admin/adduser.php'?' selected-menu-item':'').'" href="/admin/adduser.php">Thêm người dùng</a>';
					}
					if($user->getQuyen()->contains([PRIVILEGES['THEM_NGUOI_DUNG'],PRIVILEGES['SUA_NGUOI_DUNG'],PRIVILEGES['XOA_NGUOI_DUNG'],PRIVILEGES['CAP_QUYEN_NGUOI_DUNG']])){
						echo '<a class="menu-item '.($_SERVER['SCRIPT_NAME']=='/admin/userlist.php'?' selected-menu-item':'').'" href="/admin/userlist.php">Danh sách người dùng</a>';
					}
					if($user->getQuyen()->contain(PRIVILEGES['THEM_DON_VI'])){
						echo '<a class="menu-item '.($_SERVER['SCRIPT_NAME']=='/admin/adddepartment.php'?' selected-menu-item':'').'" href="/admin/adddepartment.php">Thêm Khoa - Đơn vị</a>';
					}
					if($user->getQuyen()->contains([PRIVILEGES['THEM_DON_VI'],PRIVILEGES['SUA_DON_VI'],PRIVILEGES['XOA_DON_VI']])){
						echo '<a class="menu-item '.($_SERVER['SCRIPT_NAME']=='/admin/departmentlist.php'?' selected-menu-item':'').'" href="/admin/departmentlist.php">Danh sách Khoa - Đơn vị</a>';
					}
					if($user->getQuyen()->contain(PRIVILEGES['THEM_NHOM'])){
						echo '<a class="menu-item '.($_SERVER['SCRIPT_NAME']=='/admin/addgroup.php'?' selected-menu-item':'').'" href="/admin/addgroup.php">Thêm nhóm</a>';
					}
					if($user->getQuyen()->contains([PRIVILEGES['THEM_NHOM'],PRIVILEGES['SUA_NHOM'],PRIVILEGES['XOA_NHOM'],PRIVILEGES['CAP_QUYEN_NHOM']])){
						echo '<a class="menu-item '.($_SERVER['SCRIPT_NAME']=='/admin/grouplist.php'?' selected-menu-item':'').'" href="/admin/grouplist.php">Danh sách nhóm</a>';
					}
			echo '</div>';
			echo '</div>';
		}
		?>
	</div>
	<?php
	}
	?>
</div>