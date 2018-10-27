<div id="login-form-wrapper">
	<div id="page-title">
		Đăng nhập vào hệ thống
	</div>
	<div style=""><a href="/"><img src="/resources/images/icons/icon.png" width="66" title="Trang chủ hệ thống"/></a></div>
	<?php
		if(isset($error)){
			echo '<div class="error-message-box">'.$error.'</div>';
		}
	?>
	<div id="login-form">
	<form action="" method="post" enctype="application/x-www-form-urlencoded">
		<div><input type="text" name="maso" placeholder="Mã số người dùng"/></div>
		<div><input type="password" name="matkhau" placeholder="Mật khẩu"/></div>
		<div style="text-align: center"><button type="submit" name="login" value="login">Đăng nhập</button></div>
	</form>
	</div>
</div>