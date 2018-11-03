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
		if(!$user->getQuyen()->contains([PRIVILEGES['THEM_NGUOI_DUNG'],PRIVILEGES['SUA_NGUOI_DUNG'],PRIVILEGES['XOA_NGUOI_DUNG'],PRIVILEGES['CAP_QUYEN_NGUOI_DUNG']])){
			throw new Exception('Bạn không có quyền xem thông tin người dùng');
		}
		$userinfo = $user->getNguoiDung($_POST['id']);
?>
		<div id="userdetail">
			<div id="page-title">Thông tin người dùng</div>
			<div id="user-avatar"><img width="100%" src="/resources/avatars/avatar.php?nc=<?php echo $userinfo->getMaSo(); ?>"/></div>
			<style type="text/css">
				div#user-avatar{
					height: 100px;
					width: 100px;
					margin: 0px auto;
					overflow: none;
					border-radius: 50%;
					border: 3px solid #099FB1;
				}
				table th{
					padding-right: 2em;
					vertical-align: text-top;
				}
				table th::after{
					content: ':';
				}
				table td{
					font-family: Cambria, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", "serif";
				}
			</style>
			<table>
				<tr>
					<th>ID</th>
					<td><?php echo $userinfo->getID(); ?></td>
				</tr>
				<tr>
					<th>Mã số</th>
					<td><?php echo $userinfo->getMaSo(); ?></td>
				</tr>
				<tr>
					<th>Họ</th>
					<td><?php echo $userinfo->getHo(); ?></td>
				</tr>
				<tr>
					<th>Tên</th>
					<td><?php echo $userinfo->getTen(); ?></td>
				</tr>
				<tr>
					<th>Ngày sinh</th>
					<td><?php echo MDateTime::parseDate($userinfo->getNgaySinh())->getDateString(); ?></td>
				</tr>
				<tr>
					<th>Email</th>
					<td><?php echo $userinfo->getEmail(); ?></td>
				</tr>
				<tr>
					<th>Số điện thoại</th>
					<td><?php echo $userinfo->getSoDienThoai(); ?></td>
				</tr>
				<tr>
					<th>Địa chỉ</th>
					<td><?php echo $userinfo->getDiaChi(); ?></td>
				</tr>
				<tr>
					<th>Mã đơn vị</th>
					<td><?php echo $userinfo->getMaDonVi(); ?></td>
				</tr>
				<tr>
					<th>Mã nhóm</th>
					<td><?php echo $userinfo->getMaNhom(); ?></td>
				</tr>
				<tr>
					<th>Tình trạng</th>
					<td><?php echo $userinfo->getTinhTrang()?'<font color="green">Hoạt động</font>':'<font color="red">Đã khóa</font>'; ?></td>
				</tr>
				<tr>
					<th>Thời gian thêm</th>
					<td><?php echo MDateTime::parseDateTime($userinfo->getThoiGianThem())->getDateTimeString(); ?></td>
				</tr>
				<tr>
					<th>Quyền</th>
					<td>
						<?php
							$privileges = $userinfo->getQuyen();
							$length = $privileges->getLength();
							if($length){
								for($i=0; $i<$length-1; $i++){
									echo PRIVILEGE_LABELS[$privileges->getAt($i)].'<br/>';
								}
								echo PRIVILEGE_LABELS[$privileges->getAt($length-1)];
							}else{
								echo '<font color="red">Không có quyền</font>';
							}
						?>
					</td>
				</tr>
			</table>
		</div>
<?php
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>