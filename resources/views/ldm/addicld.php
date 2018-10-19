<?php
try{
	if(!$user->isDangNhap()){
		throw new Exception('Bạn chưa đăng nhập');
	}
	if(!$user->getQuyen()->contain(PRIVILEGES['THEM_CONG_VAN_DEN'])){
		throw new Exception('Bạn không có quyền đăng ký công văn đến');
	}
	echo '<div id="page-title">Đăng ký công văn đến cho đơn vị &lt;'.$user->getMaDonVi().'&gt;</div>';
	try{
		if(isset($_POST['addicld'])){
			$data_error = [];
			if(isset($_POST['soden']) && is_numeric($_POST['soden'])){
				if(intval($_POST['soden'])<=0 || intval($_POST['soden']) > 0xffffffff){
					$data_error[] = 'Số đến này vượt ngưỡng cho phép, số đến từ 0 -> 0xFFFFFFFF';
				}
			}else{
				$data_error[] = 'Số đến không hợp lệ, số đến phải là số';
			}
			if(!isset($_POST['kyhieu']) || !is_string($_POST['kyhieu']) || mb_strlen($_POST['kyhieu'], 'UTF-8')==0 || mb_strlen($_POST['kyhieu'], 'UTF-8')>20){
				$data_error[] = 'Ký hiệu văn bản không hợp lệ';
			}
			require_once $CNF['PATHS']['LIBRARY'].'/word/mword.php';
			if(!isset($_POST['trichyeu']) || !is_string($_POST['trichyeu']) || mb_strlen($_POST['trichyeu'], 'UTF-8')==0 || mb_strlen($_POST['trichyeu'], 'UTF-8')>200){
				$data_error[] = 'Trích yếu không hợp lệ, độ dài trích yếu phải từ 1 đến 200 ký tự';
			}else{
				if(MWord::count($_POST['trichyeu'])<3){
					$data_error[] = 'Trích yếu phải có từ 3 từ trở lên!';
				}
			}
			if(!isset($_POST['nguoiky']) || !is_string($_POST['nguoiky']) || mb_strlen($_POST['nguoiky'], 'UTF-8')==0 || mb_strlen($_POST['nguoiky'], 'UTF-8')>50){
				$data_error[] = 'Tên người không hợp lệ, phải có từ 1 đến 50 ký tự';
			}
			if(count($data_error)){
				throw new NotValidFormDataException($data_error);
			}
			$user->themCongVanDen();
			echo '<div class="success-message-box">Đăng ký thành công, công văn đến có số đến '.$_POST['soden'].'</div>';
		}
	}catch(NotValidFormDataException $e){
		echo '<div class="error-message-box">';
		foreach($e->getErrors() as $error){
			echo '<div>'.$error.'</div>';
		}
		echo '</div>';
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
?>
<div id="add-icld-form-wrapper">
	<div id="add-icld-form">
		<form action="" method="post" enctype="multipart/form-data">
		<div>Số đến</div>
		<div><input type="text" name="soden" value=""/></div>
		<div>Ký hiệu</div>
		<div><input type="text" name="kyhieu" value=""/></div>
		<div>Thời gian đến</div>
		<div>
			<select name="ngay">
				<?php 
					for($i=1;$i<=31;$i++){
						echo '<option value="'.$i.'" '.(getdate()['mday']==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select> /
			<select name="thang">
				<?php 
					for($i=1;$i<=12;$i++){
						echo '<option value="'.$i.'" '.(getdate()['mon']==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select> /
			<select name="nam">
				<?php 
					for($i=getdate()['year'] - 5;$i<=getdate()['year'] + 5;$i++){
						echo '<option value="'.$i.'" '.(getdate()['year']==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select><br/>
			<select name="gio">
				<?php 
					for($i=0;$i<=23;$i++){
						echo '<option value="'.$i.'" '.(getdate()['hours']==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select> :
			<select name="phut">
				<?php 
					for($i=0;$i<=59;$i++){
						echo '<option value="'.$i.'" '.(getdate()['minutes']==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select> :
			<select name="giay">
				<?php 
					for($i=0;$i<=59;$i++){
						echo '<option value="'.$i.'" '.(getdate()['seconds']==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select>
		</div>
		<div>Ngày văn bản</div>
		<div>
			<select name="ngay">
				<?php 
					for($i=1;$i<=31;$i++){
						echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
			</select> /
			<select name="thang">
				<?php 
					for($i=1;$i<=12;$i++){
						echo '<option value="'.$i.'" '.(getdate()['mon']==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select> /
			<select name="nam">
				<?php 
					for($i=getdate()['year'] - 5;$i<=getdate()['year'] + 5;$i++){
						echo '<option value="'.$i.'" '.(getdate()['year']==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select>
		</div>
		<div>Đơn vị ban hành</div>
		<div>
			<select name="madonvibanhanh">
				<?php
					$issuedunits = $user->getDanhSachDonViBanHanh();
					foreach($issuedunits as $issuedunit){
						echo '<option value="'.$issuedunit->getMaDonVi().'">'.$issuedunit->getTenDonVi() . ' ' . ($issuedunit->getBenNgoai()?' (Bên ngoài)':' (Bên trong)') .'</option>';
					}
				?>
			</select>
		</div>
		<div>Trích yếu</div>
		<div>
			<textarea name="trichyeu" spellcheck="false" cols="40" rows="8"></textarea>
		</div>
		<div>Người ký</div>
		<div><input type="text" name="nguoiky" value=""/></div>
		<div>Loại văn bản</div>
		<div>
			<select name="maloaivanban">
				<?php
					$doctypes = $user->getDanhSachLoaiVanBan();
					foreach($doctypes as $doctype){
						echo '<option value="'.$doctype->getMaLoai().'">'.$doctype->getTenLoai() .'</option>';
					}
				?>
			</select>
		</div>
		<div>Thời hạn giải quyết</div>
		<div>
			<select name="ngay">
				<?php 
					for($i=1;$i<=31;$i++){
						echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
			</select> /
			<select name="thang">
				<?php 
					for($i=1;$i<=12;$i++){
						echo '<option value="'.$i.'" '.(getdate()['mon']==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select> /
			<select name="nam">
				<?php 
					for($i=getdate()['year'] - 5;$i<=getdate()['year'] + 5;$i++){
						echo '<option value="'.$i.'" '.(getdate()['year']==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select>
		</div>
		<div>Tập tin đính kèm</div>
		<div><input type="file" name="taptindinhkem" accept="application/pdf"/></div>
		<div><button type="submit" name="addicld">Thêm công văn đến</button></div>
		</form>
	</div>
</div>
<?php
}catch(Exception $e){
	echo '<div class="error-message-box">'.$e->getMessage().'</div>';
}
?>