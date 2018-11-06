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
					$data_error[] = 'Số đến này vượt ngưỡng cho phép, số đến từ 1 đến 0xFFFFFFFF';
				}
			}else{
				$data_error[] = 'Số đến không hợp lệ, số đến phải là số';
			}
			if(!isset($_POST['kyhieu']) || !is_string($_POST['kyhieu']) || mb_strlen(DataChecker::trim($_POST['kyhieu']), 'UTF-8')==0 || mb_strlen($_POST['kyhieu'], 'UTF-8')>20){
				$data_error[] = 'Ký hiệu văn bản không hợp lệ';
			}
			if(!isset($_POST['trichyeu']) || !is_string($_POST['trichyeu']) || mb_strlen($_POST['trichyeu'], 'UTF-8')==0 || mb_strlen($_POST['trichyeu'], 'UTF-8')>200){
				$data_error[] = 'Trích yếu không hợp lệ, độ dài trích yếu phải từ 1 đến 200 ký tự';
			}else{
				if(MWord::count($_POST['trichyeu'])<3){
					$data_error[] = 'Trích yếu phải có từ 3 từ trở lên!';
				}
			}
			if(!isset($_POST['nguoiky']) || !is_string($_POST['nguoiky']) || mb_strlen(DataChecker::trim($_POST['nguoiky']), 'UTF-8')==0 || mb_strlen($_POST['nguoiky'], 'UTF-8')>50){
				$data_error[] = 'Tên người ký không hợp lệ, phải có từ 1 đến 50 ký tự';
			}
			$b_ngayden = true;
			if(!isset($_POST['ngayden']) || !isset($_POST['thangden']) || !isset($_POST['namden']) || !is_numeric($_POST['ngayden']) || !is_numeric($_POST['thangden']) || !is_numeric($_POST['namden']) || !checkdate($_POST['thangden'], $_POST['ngayden'], $_POST['namden']) || !isset($_POST['gioden']) || !isset($_POST['phutden']) || !isset($_POST['giayden']) || !is_numeric($_POST['gioden']) || !is_numeric($_POST['phutden']) || !is_numeric($_POST['giayden']) || !DataChecker::checkTime($_POST['gioden'], $_POST['phutden'], $_POST['giayden'])){
				$data_error[] = 'Thời gian văn bản đến không hợp lệ';
				$b_ngayden = false;
			}
			$b_ngayvanban = true;
			if(!isset($_POST['ngayvanban']) || !isset($_POST['thangvanban']) || !isset($_POST['namvanban']) || !is_numeric($_POST['ngayvanban']) || !is_numeric($_POST['thangvanban']) || !is_numeric($_POST['namvanban'])){
				$data_error[] = 'Ngày của văn bản không hợp lệ';
				$b_ngayvanban = false;
			}
			if($b_ngayden && $b_ngayvanban){
				if((new MDateTime(intval($_POST['ngayden']), intval($_POST['thangden']), intval($_POST['namden'])))->compare(new MDateTime(intval($_POST['ngayvanban']), intval($_POST['thangvanban']), intval($_POST['namvanban'])))==-1){
					$data_error[] = 'Thời gian đến không thể sớm hơn ngày văn bản phát hành!';
				}
			}
			
			$b_thoihangiaiquyet = false;
			if(isset($_POST['thoihangiaiquyet'])){
				if(!isset($_POST['ngaygiaiquyet']) || !isset($_POST['thanggiaiquyet']) || !isset($_POST['namgiaiquyet']) || !is_numeric($_POST['ngaygiaiquyet']) || !is_numeric($_POST['thanggiaiquyet']) || !is_numeric($_POST['namgiaiquyet']) || !checkdate($_POST['thanggiaiquyet'], $_POST['ngaygiaiquyet'], $_POST['namgiaiquyet'])){
					$data_error[] = 'Thời hạn giải quyết không hợp lệ!';
				}
				$b_thoihangiaiquyet = true;
			}
			
			if(!isset($_POST['madonvibanhanh']) || DataChecker::trim($_POST['madonvibanhanh']) == ''){
				$data_error[] = 'Mã đơn vị ban hành không được để trống';
			}
			if(!isset($_POST['maloaivanban']) || DataChecker::trim($_POST['maloaivanban']) == ''){
				$data_error[] = 'Mã loại văn bản không được để trống';
			}
			if(isset($_FILES['taptindinhkem']['error']) && is_numeric($_FILES['taptindinhkem']['error']) && $_FILES['taptindinhkem']['error']==0){
				$ext = UploadedFile::getExtension(UploadedFile::getMimeType($_FILES['taptindinhkem']['tmp_name']));
				if(!DataChecker::valueInArray($ext, ['pdf'])){
					$data_error[] = 'Hiện tại chỉ hỗ trợ định dạng tập tin \'pdf\'';
				}
			}else{
				$data_error[] = 'Vui lòng chọn file công văn đính kèm, hoặc chọn tập tin có kích thước hợp lý';
			}
			if(count($data_error)){
				throw new NotValidFormDataException($data_error);
			}
			$user->themCongVanDen(new LegalDocumentInfo(null,
								  $_POST['soden'],
								  $_POST['kyhieu'],
								  (new MDateTime($_POST['ngayden'], $_POST['thangden'], $_POST['namden'], $_POST['gioden'], $_POST['phutden'], $_POST['giayden']))->getDateTimeDBString('-', ':'),
								  (new MDateTime($_POST['ngayvanban'], $_POST['thangvanban'], $_POST['namvanban']))->getDateDBString('-'),
								  $_POST['madonvibanhanh'],
								  $_POST['trichyeu'],
								  $_POST['nguoiky'],
								  $_POST['maloaivanban'],
								  $b_thoihangiaiquyet ? (new MDateTime($_POST['ngaygiaiquyet'], $_POST['thanggiaiquyet'], $_POST['namgiaiquyet']))->getDateDBString('-') : null,
								  null,
								  LEGALDOCUMENT_STATUS['DA_NHAP'],
								  $user->getID(), 
								  $user->getMaDonVi(),
								  null), $_FILES['taptindinhkem']['tmp_name'], $CNF['PATHS']['LEGALDOCUMENT_DIR'] . '/' . $_FILES['taptindinhkem']['name']);
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
	
	
	$currentdate = getdate();
?>
<div id="add-icld-form-wrapper">
	<div id="add-icld-form">
		<form action="" method="post" enctype="multipart/form-data" name="add-icld">
		<div>Số đến</div>
		<div><input type="text" name="soden" value=""/></div>
		<div>Ký hiệu</div>
		<div><input type="text" name="kyhieu" value=""/></div>
		<div>Thời gian đến</div>
		<div>
			<select name="ngayden">
				<?php 
					for($i=1;$i<=MCalendar::getMaxDayOfMonth($currentdate['mon'], $currentdate['year']);$i++){
						echo '<option value="'.$i.'" '.($currentdate['mday']==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select> /
			<select name="thangden" onchange="updateDaySelect(this.form['ngayden'],this,this.form['namden']);">
				<?php 
					for($i=1;$i<=12;$i++){
						echo '<option value="'.$i.'" '.($currentdate['mon']==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select> /
			<select name="namden" onchange="updateDaySelect(this.form['ngayden'],this.form['thangden'],this);">
				<?php 
					for($i=$currentdate['year'] - 5;$i<=$currentdate['year'] + 5;$i++){
						echo '<option value="'.$i.'" '.($currentdate['year']==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select><br/>
			<select name="gioden">
				<?php 
					for($i=0;$i<=23;$i++){
						echo '<option value="'.$i.'" '.($currentdate['hours']==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select> :
			<select name="phutden">
				<?php 
					for($i=0;$i<=59;$i++){
						echo '<option value="'.$i.'" '.($currentdate['minutes']==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select> :
			<select name="giayden">
				<?php 
					for($i=0;$i<=59;$i++){
						echo '<option value="'.$i.'" '.($currentdate['seconds']==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select>
		</div>
		<div>Ngày văn bản</div>
		<div>
			<select name="ngayvanban">
				<?php 
					for($i=1;$i<=MCalendar::getMaxDayOfMonth($currentdate['mon'], $currentdate['year']);$i++){
						echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
			</select> /
			<select name="thangvanban" onchange="updateDaySelect(this.form['ngayvanban'],this,this.form['namvanban']);">
				<?php 
					for($i=1;$i<=12;$i++){
						echo '<option value="'.$i.'" '.($currentdate['mon']==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select> /
			<select name="namvanban" onchange="updateDaySelect(this.form['ngayvanban'],this.form['thangvanban'],this);">
				<?php 
					for($i=$currentdate['year'] - 5;$i<=$currentdate['year'] + 5;$i++){
						echo '<option value="'.$i.'" '.($currentdate['year']==$i?'selected="selected"':'').'>'.$i.'</option>';
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
						echo '<option value="'.$issuedunit->getMaDonVi().'">'.$issuedunit->getTenDonVi() . ' ' . ($issuedunit->getBenNgoai()?'(Bên ngoài)':'(Bên trong)') .'</option>';
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
		<div><input type="checkbox" name="choosehangiaiquyet" onChange="this.form['ngaygiaiquyet'].disabled = this.form['thanggiaiquyet'].disabled = this.form['namgiaiquyet'].disabled = !this.checked;" checked="checked"/></div>
		<div>
			<select name="ngaygiaiquyet">
				<?php 
					for($i=1;$i<=MCalendar::getMaxDayOfMonth($currentdate['mon'], $currentdate['year']);$i++){
						echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
			</select> /
			<select name="thanggiaiquyet" onchange="updateDaySelect(this.form['ngaygiaiquyet'],this,this.form['namgiaiquyet']);">
				<?php 
					for($i=1;$i<=12;$i++){
						echo '<option value="'.$i.'" '.($currentdate['mon']==$i?'selected="selected"':'').'>'.$i.'</option>';
					}
				?>
			</select> /
			<select name="namgiaiquyet" onchange="updateDaySelect(this.form['ngaygiaiquyet'],this.form['thanggiaiquyet'],this);">
				<?php 
					for($i=$currentdate['year'] - 5;$i<=$currentdate['year'] + 5;$i++){
						echo '<option value="'.$i.'" '.($currentdate['year']==$i?'selected="selected"':'').'>'.$i.'</option>';
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
<!--
<script type="text/javascript">
	var addicldform = document.forms['add-icld'];
	addicldform['thangden'].onchange = function(e){
		var vm = this.value;
		var vy = this.form['namden'].value;
		var sd = this.form['ngayden'];
		while(sd.options.length){
			sd.options.remove(0);
		}
		var maxday = getMaxDayOfMonth(vm, vy);
		for(var d=1; d<=maxday; d++){
			var option = document.createElement('option');
			option.value = d;
			option.innerHTML = d;
			sd.options.add(option);
		}
	}
	addicldform['namden'].onchange = function(e){
		var vm = this.form['thangden'].value;
		var vy = this.value;
		var sd = this.form['ngayden'];
		while(sd.options.length){
			sd.options.remove(0);
		}
		var maxday = getMaxDayOfMonth(vm, vy);
		for(var d=1; d<=maxday; d++){
			var option = document.createElement('option');
			option.value = d;
			option.innerHTML = d;
			sd.options.add(option);
		}
	}
	addicldform['thangvanban'].onchange = function(e){
		var vm = this.value;
		var vy = this.form['namvanban'].value;
		var sd = this.form['ngayvanban'];
		while(sd.options.length){
			sd.options.remove(0);
		}
		var maxday = getMaxDayOfMonth(vm, vy);
		for(var d=1; d<=maxday; d++){
			var option = document.createElement('option');
			option.value = d;
			option.innerHTML = d;
			sd.options.add(option);
		}
	}
	addicldform['namvanban'].onchange = function(e){
		var vm = this.form['thangvanban'].value;
		var vy = this.value;
		var sd = this.form['ngayvanban'];
		while(sd.options.length){
			sd.options.remove(0);
		}
		var maxday = getMaxDayOfMonth(vm, vy);
		for(var d=1; d<=maxday; d++){
			var option = document.createElement('option');
			option.value = d;
			option.innerHTML = d;
			sd.options.add(option);
		}
	}
	addicldform['thanggiaiquyet'].onchange = function(e){
		var vm = this.value;
		var vy = this.form['namgiaiquyet'].value;
		var sd = this.form['ngaygiaiquyet'];
		while(sd.options.length){
			sd.options.remove(0);
		}
		var maxday = getMaxDayOfMonth(vm, vy);
		for(var d=1; d<=maxday; d++){
			var option = document.createElement('option');
			option.value = d;
			option.innerHTML = d;
			sd.options.add(option);
		}
	}
	addicldform['namgiaiquyet'].onchange = function(e){
		var vm = this.form['thanggiaiquyet'].value;
		var vy = this.value;
		var sd = this.form['ngaygiaiquyet'];
		while(sd.options.length){
			sd.options.remove(0);
		}
		var maxday = getMaxDayOfMonth(vm, vy);
		for(var d=1; d<=maxday; d++){
			var option = document.createElement('option');
			option.value = d;
			option.innerHTML = d;
			sd.options.add(option);
		}
	}
	addicldform['thoihangiaiquyet'].onchange = function(e){
		this.form['ngaygiaiquyet'].disabled = this.form['thanggiaiquyet'].disabled = this.form['namgiaiquyet'].disabled = !this.checked;
	}
</script>
-->
<?php
}catch(Exception $e){
	echo '<div class="error-message-box">'.$e->getMessage().'</div>';
}
?>