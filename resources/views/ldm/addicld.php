<?php
try{
	if(!$user->isDangNhap()){
		throw new Exception('Bạn chưa đăng nhập');
	}
	if(!$user->getQuyen()->contain(PRIVILEGES['THEM_CONG_VAN_DEN'])){
		throw new Exception('Bạn không có quyền đăng ký công văn đến');
	}
	echo '<div id="page-title">Đăng ký công văn đến cho đơn vị &lt;'.$user->getMaDonVi().'&gt;</div>';
	
?>
<div id="add-icld-form-wrapper">
	<div id="add-icld-form">
		<div>Số đến</div>
		<div><input type="text" name="soden" value=""/></div>
		<div>Ký hiệu</div>
		<div><input type="text" name="kyhieu" value=""/></div>
		<div>Thời gian đến</div>
		<div>Ngày văn bản</div>
		<div>Đơn vị ban hành</div>
		<div>Trích yếu</div>
		<div>Người ký</div>
		<div>Loại văn bản</div>
		<div>Thời hạn giải quyết</div>
		<div>Tập tin đính kèm</div>
	</div>
</div>
<?php
}catch(Exception $e){
	echo '<div class="error-message-box">'.$e->getMessage().'</div>';
}
?>