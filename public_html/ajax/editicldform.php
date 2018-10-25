<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	require_once $CNF['PATHS']['LIBRARY'].'/datetime/mdatetime.php';

	header('content-type: text/html');
	try{
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		$user = new User($mcon);
		$user->dangNhap();
		if(!$user->getQuyen()->contain(PRIVILEGES['SUA_CONG_VAN_DEN'])){
			throw new Exception('Bạn không có quyền sưa công văn đến');
		}
		if(!isset($_POST['id'])||!is_numeric($_POST['id'])){
			throw new Exception('Yêu cầu không hợp lệ');
		}
		$legaldocument = $user->getCongVanDen($_POST['id']);
		$currentdate = getdate();
		$dtthoigianden = MDateTime::parseDateTime($legaldocument->getThoiGianDen());
		$dtngayvanban = MDateTime::parseDate($legaldocument->getThoiGianDen());
		$dtthoihangiaiquyet = MDateTime::parseDate($legaldocument->getThoiHanGiaiQuyet());
?>

<div id="add-icld-form-wrapper">
	<div id="add-icld-form">
		<form action="" method="post" enctype="multipart/form-data" name="add-icld">
		<div>Số đến</div>
		<div><input type="text" name="soden" value="<?php echo $legaldocument->getSoDen(); ?>"/></div>
		<div>Ký hiệu</div>
		<div><input type="text" name="kyhieu" value="<?php echo $legaldocument->getKyHieu(); ?>"/></div>
		<div>Thời gian đến</div>
		<div>
			<select name="ngayden">
				<?php 
					for($i=1;$i<=MCalendar::getMaxDayOfMonth($currentdate['mon'], $currentdate['year']);$i++){
						echo '<option value="'.$i.'" '.($dtthoigianden!=null&&$dtthoigianden->getDay()==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select> /
			<select name="thangden" onchange="updateDaySelect(this.form['ngayden'],this,this.form['namden']);">
				<?php 
					for($i=1;$i<=12;$i++){
						echo '<option value="'.$i.'" '.($dtthoigianden!=null&&$dtthoigianden->getMonth()==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select> /
			<select name="namden" onchange="updateDaySelect(this.form['ngayden'],this.form['thangden'],this);">
				<?php 
					for($i=$currentdate['year'] - 5;$i<=$currentdate['year'] + 5;$i++){
						echo '<option value="'.$i.'" '.($dtthoigianden!=null&&$dtthoigianden->getYear()==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select><br/>
			<select name="gioden">
				<?php 
					for($i=0;$i<=23;$i++){
						echo '<option value="'.$i.'" '.($dtthoigianden!=null&&$dtthoigianden->getHours()==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select> :
			<select name="phutden">
				<?php 
					for($i=0;$i<=59;$i++){
						echo '<option value="'.$i.'" '.($dtthoigianden!=null&&$dtthoigianden->getMinutes()==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select> :
			<select name="giayden">
				<?php 
					for($i=0;$i<=59;$i++){
						echo '<option value="'.$i.'" '.($dtthoigianden!=null&&$dtthoigianden->getSeconds()==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select>
		</div>
		<div>Ngày văn bản</div>
		<div>
			<select name="ngayvanban">
				<?php 
					for($i=1;$i<=MCalendar::getMaxDayOfMonth($currentdate['mon'], $currentdate['year']);$i++){
						echo '<option value="'.$i.'" '.($dtngayvanban!=null&&$dtngayvanban->getDay()==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select> /
			<select name="thangvanban" onchange="updateDaySelect(this.form['ngayvanban'],this,this.form['namvanban']);">
				<?php 
					for($i=1;$i<=12;$i++){
						echo '<option value="'.$i.'" '.($dtngayvanban!=null&&$dtngayvanban->getMonth()==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select> /
			<select name="namvanban" onchange="updateDaySelect(this.form['ngayvanban'],this.form['thangvanban'],this);">
				<?php 
					for($i=$currentdate['year'] - 5;$i<=$currentdate['year'] + 5;$i++){
						echo '<option value="'.$i.'" '.($dtngayvanban!=null&&$dtngayvanban->getYear()==$i?'selected="selected"':'').'>'.$i.'</option>';
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
						echo '<option value="'.$issuedunit->getMaDonVi().'" '.($issuedunit->getMaDonVi()==$legaldocument->getMaDonViBanHanh()?'selected="selected"':'').'>'.$issuedunit->getTenDonVi() . ' ' . ($issuedunit->getBenNgoai()?' (Bên ngoài)':' (Bên trong)') .'</option>';
					}
				?>
			</select>
		</div>
		<div>Trích yếu</div>
		<div>
			<textarea name="trichyeu" spellcheck="false" cols="40" rows="8"><?php echo $legaldocument->getTrichYeu(); ?></textarea>
		</div>
		<div>Người ký</div>
		<div><input type="text" name="nguoiky" value="<?php echo $legaldocument->getNguoiKy(); ?>"/></div>
		<div>Loại văn bản</div>
		<div>
			<select name="maloaivanban">
				<?php
					$doctypes = $user->getDanhSachLoaiVanBan();
					foreach($doctypes as $doctype){
						echo '<option value="'.$doctype->getMaLoai().'" '.($doctype->getMaLoai()==$legaldocument->getMaLoaiVanBan()?'selected="selected"':'').'>'.$doctype->getTenLoai() .'</option>';
					}
				?>
			</select>
		</div>
		<div>Thời hạn giải quyết</div>
		<div><input type="checkbox" onChange="this.form['ngaygiaiquyet'].disabled = this.form['thanggiaiquyet'].disabled = this.form['namgiaiquyet'].disabled = !this.checked;" <?php echo ($legaldocument->getThoiHanGiaiQuyet()!=''?'checked="checked"':'');?>/></div>
		<div>
			<select name="ngaygiaiquyet">
				<?php 
					for($i=1;$i<=MCalendar::getMaxDayOfMonth($currentdate['mon'], $currentdate['year']);$i++){
						echo '<option value="'.$i.'" '.($dtthoihangiaiquyet!=null&&$dtthoihangiaiquyet->getDay()==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select> /
			<select name="thanggiaiquyet" onchange="updateDaySelect(this.form['ngaygiaiquyet'],this,this.form['namgiaiquyet']);">
				<?php 
					for($i=1;$i<=12;$i++){
						echo '<option value="'.$i.'" '.($dtthoihangiaiquyet!=null&&$dtthoihangiaiquyet->getMonth()==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select> /
			<select name="namgiaiquyet" onchange="updateDaySelect(this.form['ngaygiaiquyet'],this.form['thanggiaiquyet'],this);">
				<?php 
					for($i=$currentdate['year'] - 5;$i<=$currentdate['year'] + 5;$i++){
						echo '<option value="'.$i.'" '.($dtthoihangiaiquyet!=null&&$dtthoihangiaiquyet->getYear()==$i?'selected="selected"':'').'>'.$i.'</option>';
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