<?php
	try{
		if(!$user->isDangNhap()){
			throw new Exception('Bạn chưa đăng nhập');
		}
		if(!$user->getQuyen()->contain(PRIVILEGES['THEM_LOAI_VAN_BAN'])){
			throw new Exception('Bạn không có quyền liệt kê danh sách loại văn bản');
		}
		$doctypes = $user->getDanhSachLoaiVanBan();
		echo '<div id="page-title">Danh sách Loại văn bản</div>';
?>
<script type="text/javascript">
	function showEditDocTypeFormPopup(maloai){
		$get('div#popup').$css('display', 'block');
		$get('div#popup').$css('opacity', '1');
		var xhr = $ajax();
		xhr.open('post', '/ajax/editdoctypeform.php');
		xhr.onreadystatechange = function(e){
			if(this.readyState == this.DONE){
				if(this.status == 200){
					$get('div#popup-content').innerHTML = this.response;
				}else{
					$get('div#popup-content').innerHTML = 'Đã có lỗi xảy ra!';
				}
			}
		}
		var data = new FormData();
		data.append('maloai', maloai);
		xhr.send(data);
		
	}
</script>
<div id="doctype-list">
	<table class="list-table">
		<tr><th>Mã loại</th><th>Tên loại</th><th>Thời gian thêm</th><th>Thao tác</th></tr>
		<?php
			foreach($doctypes as $doctype){
				echo '<tr>';
				echo '<td>'.$doctype->getMaLoai().'</td>';
				echo '<td>'.$doctype->getTenLoai().'</td>';
				echo '<td>'.MDateTime::parseDateTime($doctype->getThoiGianThem())->getDateTimeString().'</td>';
				echo '<td><a class="action-btn" onclick="showEditDocTypeFormPopup(\''.$doctype->getMaLoai().'\')">Sửa</a><a class="action-btn">Xóa</a></td>';
				echo '</tr>';
			}
		?>
	</table>
</div>

<?php
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>