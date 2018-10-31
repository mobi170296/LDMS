<?php
	try{
		if(!$user->isDangNhap()){
			throw new Exception('Bạn chưa đăng nhập');
		}
		if(!$user->getQuyen()->contains([PRIVILEGES['THEM_CONG_VAN_DEN'],PRIVILEGES['SUA_CONG_VAN_DEN'],PRIVILEGES['XOA_CONG_VAN_DEN'],PRIVILEGES['KIEM_DUYET_CONG_VAN_DEN'],PRIVILEGES['PHE_DUYET_CONG_VAN_DEN']])){
			throw new Exception('Bạn không có quyền tìm kiếm công văn đến');
		}
?>

<style>
	label{
		user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
	}
</style>
<div id="page-title">Tìm kiếm công văn đến</div>
<form action="" method="get">
	<table>
		<tr>
			<th align="left">Lọc</th>
			<th align="left">Giá trị</th>
		</tr>
		<tr>
			<td><input type="checkbox" id="filter-soden" onChange="this.form['soden'].disabled=!this.checked;"/> <label for="filter-soden">Số đến</label></td>
			<td><input type="text" name="soden" value="" placeholder="Số đến văn bản" disabled="disabled"/></td>
		</tr>
		<tr>
			<td><input type="checkbox" id="filter-kyhieu" onChange="this.form['kyhieu'].disabled=!this.checked;"/> <label for="filter-kyhieu">Ký hiệu</label></td>
			<td><input type="text" name="kyhieu" value="" placeholder="Ký hiệu văn bản" disabled="disabled"/></td>
		</tr>
		<tr>
			<td><input type="checkbox" id="filter-trichyeu" onChange="this.form['trichyeu'].disabled=!this.checked;"/> <label for="filter-trichyeu">Trích yếu</label></td>
			<td><textarea type="text" name="trichyeu" rows="5" cols="30" spellcheck="false" placeholder="Trích yếu văn bản" disabled="disabled"></textarea></td>
		</tr>
		<tr>
			<td><input type="checkbox" id="filter-nguoiky" onchange="this.form['nguoiky'].disabled=!this.checked;"/> <label for="filter-nguoiky">Người ký</label></td>
			<td><input type="text" name="nguoiky" value="" placeholder="Người ký văn bản" disabled="disabled"/></td>
		</tr>
		<tr>
			<td><input type="checkbox" id="filter-trangthai" onchange="this.form['trangthai'].disabled=!this.checked;"/> <label for="filter-trangthai">Tình trạng</label></td>
			<td>
				<select name="trangthai" disabled="disabled">
					<option value="<?php echo LEGALDOCUMENT_STATUS['DA_NHAP']; ?>">Đã nhập</option>
					<option value="<?php echo LEGALDOCUMENT_STATUS['DOI_KIEM_DUYET']; ?>">Đợi kiểm duyệt</option>
					<option value="<?php echo LEGALDOCUMENT_STATUS['DA_KIEM_DUYET']; ?>">Đã kiểm duyệt</option>
					<option value="<?php echo LEGALDOCUMENT_STATUS['DOI_PHE_DUYET']; ?>">Đợi phê duyệt</option>
					<option value="<?php echo LEGALDOCUMENT_STATUS['DA_PHE_DUYET']; ?>">Đã kiểm duyệt</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><input type="checkbox" id="filter-donvibanhanh" onchange="this.form['madonvibanhanh'].disabled=!this.checked;"/> <label for="filter-donvibanhanh">Đơn vị ban hành</label></td>
			<td>
				<select name="madonvibanhanh" disabled="disabled">
					<?php
						$issuedunits = $user->getDanhSachDonViBanHanh();
						foreach($issuedunits as $issuedunit){
							echo "<option value=\"{$issuedunit->getMaDonVi()}\">{$issuedunit->getTenDonVi()}</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td><input type="checkbox" id="filter-loaivanban" onchange="this.form['maloaivanban'].disabled=!this.checked;"/> <label for="filter-loaivanban">Loại văn bản</label></td>
			<td>
				<select name="maloaivanban" disabled="disabled">
					<?php
						$doctypes = $user->getDanhSachLoaiVanBan();
						foreach($doctypes as $doctype){
							echo "<option value=\"{$doctype->getMaLoai()}\">{$doctype->getTenLoai()}</option>";
						}
					?>
				</select>
			</td>
		</tr>
		
		<tr>
			<td><input type="checkbox" id="filter-fromngayvanban" onchange="var es=this.form['fromngayvanban[]']; for(var i=0;i<es.length;i++) es[i].disabled=!this.checked;"/> <label for="filter-fromngayvanban">Ngày văn bản (từ)</label></td>
			<td>
				<?php
					$min = $user->getMinYearInCongVanDen('ngayvanban');
					$max = $user->getMaxYearInCongVanDen('ngayvanban');
				?>
				<select name="fromngayvanban[]" disabled="disabled">
					<?php
						for($i=1;$i<=31;$i++){
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
				<select name="fromngayvanban[]" disabled="disabled" onChange="updateDaySelect(this.form['fromngayvanban[]'][0],this,this.form['fromngayvanban[]'][2])">
					<?php
						for($i=1;$i<=12;$i++){
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
				<select name="fromngayvanban[]" disabled="disabled" onChange="updateDaySelect(this.form['fromngayvanban[]'][0],this.form['fromngayvanban[]'][1],this)">
					<?php
						for($i=$min;$i<=$max;$i++){
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td><input type="checkbox" id="filter-tongayvanban" onchange="var es=this.form['tongayvanban[]']; for(var i=0;i<es.length;i++) es[i].disabled=!this.checked;"/> <label for="filter-tongayvanban">Ngày văn bản (đến)</label></td>
			<td>
				<select name="tongayvanban[]" disabled="disabled">
					<?php
						for($i=1;$i<=31;$i++){
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
				<select name="tongayvanban[]" disabled="disabled" onChange="updateDaySelect(this.form['tongayvanban[]'][0],this,this.form['tongayvanban[]'][2])">
					<?php
						for($i=1;$i<=12;$i++){
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
				<select name="tongayvanban[]" disabled="disabled" onChange="updateDaySelect(this.form['tongayvanban[]'][0],this.form['tongayvanban[]'][1],this)">
					<?php
						for($i=$min;$i<=$max;$i++){
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td><input type="checkbox" id="filter-fromthoigianden" onchange="var es=this.form['fromthoigianden[]']; for(var i=0;i<es.length;i++) es[i].disabled=!this.checked;"/> <label for="filter-fromthoigianden">Ngày đến (từ)</label></td>
			<td>
				<?php
					$min = $user->getMinYearInCongVanDen('thoigianden');
					$max = $user->getMaxYearInCongVanDen('thoigianden');
				?>
				<select name="fromthoigianden[]" disabled="disabled">
					<?php
						for($i=1;$i<=31;$i++){
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
				<select name="fromthoigianden[]" disabled="disabled" onChange="updateDaySelect(this.form['fromthoigianden[]'][0],this,this.form['fromthoigianden[]'][2])">
					<?php
						for($i=1;$i<=12;$i++){
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
				<select name="fromthoigianden[]" disabled="disabled" onChange="updateDaySelect(this.form['fromthoigianden[]'][0],this.form['fromthoigianden[]'][1],this)">
					<?php
						for($i=$min;$i<=$max;$i++){
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td><input type="checkbox" id="filter-tothoigianden" onchange="var es=this.form['tothoigianden[]']; for(var i=0;i<es.length;i++) es[i].disabled=!this.checked;"/> <label for="filter-tothoigianden">Ngày đến (đến)</label></td>
			<td>
				<select name="tothoigianden[]" disabled="disabled">
					<?php
						for($i=1;$i<=31;$i++){
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
				<select name="tothoigianden[]" disabled="disabled" onChange="updateDaySelect(this.form['tothoigianden[]'][0],this,this.form['tothoigianden[]'][2])">
					<?php
						for($i=1;$i<=12;$i++){
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
				<select name="tothoigianden[]" disabled="disabled" onchange="updateDaySelect(this.form['tothoigianden[]'][0],this.form['tothoigianden[]'][1],this)">
					<?php
						for($i=$min;$i<=$max;$i++){
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td><input type="checkbox" id="filter-fromthoihangiaiquyet" onchange="var es=this.form['fromthoihangiaiquyet[]']; for(var i=0;i<es.length;i++) es[i].disabled=!this.checked;"/> <label for="filter-fromthoihangiaiquyet">Thời hạn giải quyết (từ)</label></td>
			<td>
				<?php
					$min = $user->getMinYearInCongVanDen('thoigianden');
					$max = $user->getMaxYearInCongVanDen('thoigianden');
				?>
				<select name="fromthoihangiaiquyet[]" disabled="disabled">
					<?php
						for($i=1;$i<=31;$i++){
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
				<select name="fromthoihangiaiquyet[]" disabled="disabled" onChange="updateDaySelect(this.form['fromthoihangiaiquyet[]'][0],this,this.form['fromthoihangiaiquyet[]'][2])">
					<?php
						for($i=1;$i<=12;$i++){
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
				<select name="fromthoihangiaiquyet[]" disabled="disabled" onChange="updateDaySelect(this.form['fromthoihangiaiquyet[]'][0],this.form['fromthoihangiaiquyet[]'][2],this)">
					<?php
						for($i=$min;$i<=$max;$i++){
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td><input type="checkbox" id="filter-tothoihangiaiquyet" onchange="var es=this.form['tothoihangiaiquyet[]']; for(var i=0;i<es.length;i++) es[i].disabled=!this.checked;"/> <label for="filter-tothoihangiaiquyet">Thời hạn giải quyết (đến)</label></td>
			<td>
				<select name="tothoihangiaiquyet[]" disabled="disabled">
					<?php
						for($i=1;$i<=31;$i++){
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
				<select name="tothoihangiaiquyet[]" disabled="disabled" onChange="updateDaySelect(this.form['tothoihangiaiquyet[]'][0],this,this.form['tothoihangiaiquyet[]'][2])">
					<?php
						for($i=1;$i<=12;$i++){
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
				<select name="tothoihangiaiquyet[]" disabled="disabled" onChange="updateDaySelect(this.form['tothoihangiaiquyet[]'][0],this.form['tothoihangiaiquyet[]'][2],this)">
					<?php
						for($i=$min;$i<=$max;$i++){
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
			</td>
		</tr>
	</table>
	<div><button type="submit" name="searchicld" value="searchicld">Tìm kiếm</button></div>
</form>

<?php
		if(isset($_GET['searchicld'])){
			#search button was clicked
			$data_errors = [];
			$where_clause = '';
			if(isset($_GET['soden'])){
				if(is_numeric($_GET['soden'])){
					$where_clause .= 'soden='.$_GET['soden'].' and ';
				}else{
					$data_errors[] = 'Số đến không hợp lệ';
				}
			}
			if(isset($_GET['kyhieu'])){
				if(is_string($_GET['kyhieu'])){
					$where_clause .= 'kyhieu like \'%'.$user->getDBConnection()->realEscapeString($_GET['kyhieu']).'%\' and ';
				}else{
					$data_errors[] = 'Ký hiệu không hợp lệ';
				}
			}
			if(isset($_GET['trichyeu'])){
				if(is_string($_GET['trichyeu'])){
					$where_clause .= 'trichyeu like \'%'.$user->getDBConnection()->realEscapeString($_GET['trichyeu']).'%\' and ';
				}else{
					$data_errors[] = 'Trích yếu không hợp lệ';
				}
			}
			if(isset($_GET['nguoiky'])){
				if(is_string($_GET['nguoiky'])){
					$where_clause .= 'nguoiky like \'%'.$user->getDBConnection()->realEscapeString($_GET['nguoiky']).'%\' and ';
				}else{
					$data_errors[] = 'Tên người ký không hợp lệ';
				}
			}
			if(isset($_GET['trangthai'])){
				if(is_numeric($_GET['trangthai'])){
					$where_clause .= 'trangthai='.$_GET['trangthai'].' and ';
				}else{
					$data_errors[] = 'Trạng thái không hợp lệ';
				}
			}
			if(isset($_GET['madonvibanhanh'])){
				if(is_string($_GET['madonvibanhanh'])){
					$where_clause .= 'madonvibanhanh=\''.$user->getDBConnection()->realEscapeString($_GET['madonvibanhanh']).'\' and ';
				}else{
					$data_errors[] = 'Mã đơn vị ban hành không hợp lệ';
				}
			}
			if(isset($_GET['maloaivanban'])){
				if(is_string($_GET['maloaivanban'])){
					$where_clause .= 'maloaivanban=\''.$user->getDBConnection()->realEscapeString($_GET['maloaivanban']).'\' and ';
				}else{
					$data_errors[] = 'Mã đơn vị ban hành không hợp lệ';
				}
			}
			if(isset($_GET['fromngayvanban'])){
				if(is_array($_GET['fromngayvanban'])&&is_numeric($_GET['fromngayvanban'][0])&&is_numeric($_GET['fromngayvanban'][1])&&is_numeric($_GET['fromngayvanban'][2])){
					if(checkdate($_GET['fromngayvanban'][1], $_GET['fromngayvanban'][0], $_GET['fromngayvanban'][2])){
						$where_clause .= 'cast(ngayvanban as date)>=\''.(new MDateTime($_GET['fromngayvanban'][0],$_GET['fromngayvanban'][1],$_GET['fromngayvanban'][2]))->getDateDBString().'\' and ';
					}else{
						$data_errors[] = 'Ngày văn bản không hợp lệ';
					}
				}else{
					$data_errors[] = 'Ngày văn bản không hợp lệ';
				}
			}
			if(isset($_GET['tongayvanban'])){
				if(is_array($_GET['tongayvanban'])&&is_numeric($_GET['tongayvanban'][0])&&is_numeric($_GET['tongayvanban'][1])&&is_numeric($_GET['tongayvanban'][2])){
					if(checkdate($_GET['tongayvanban'][1], $_GET['tongayvanban'][0], $_GET['tongayvanban'][2])){
						$where_clause .= 'cast(ngayvanban as date)<=\''.(new MDateTime($_GET['tongayvanban'][0],$_GET['tongayvanban'][1],$_GET['tongayvanban'][2]))->getDateDBString().'\' and ';
					}else{
						$data_errors[] = 'Ngày văn bản không hợp lệ';
					}
				}else{
					$data_errors[] = 'Ngày văn bản không hợp lệ';
				}
			}
			if(isset($_GET['fromthoigianden'])){
				if(is_array($_GET['fromthoigianden'])&&is_numeric($_GET['fromthoigianden'][0])&&is_numeric($_GET['fromthoigianden'][1])&&is_numeric($_GET['fromthoigianden'][2])){
					if(checkdate($_GET['fromthoigianden'][1], $_GET['fromthoigianden'][0], $_GET['fromthoigianden'][2])){
						$where_clause .= 'cast(thoigianden as date)>=\''.(new MDateTime($_GET['fromthoigianden'][0],$_GET['fromthoigianden'][1],$_GET['fromthoigianden'][2]))->getDateDBString().'\' and ';
					}else{
						$data_errors[] = 'Ngày đến không hợp lệ';
					}
				}else{
					$data_errors[] = 'Ngày đến không hợp lệ';
				}
			}
			if(isset($_GET['tothoigianden'])){
				if(is_array($_GET['tothoigianden'])&&is_numeric($_GET['tothoigianden'][0])&&is_numeric($_GET['tothoigianden'][1])&&is_numeric($_GET['tothoigianden'][2])){
					if(checkdate($_GET['tothoigianden'][1], $_GET['tothoigianden'][0], $_GET['tothoigianden'][2])){
						$where_clause .= 'cast(thoigianden as date)<=\''.(new MDateTime($_GET['tothoigianden'][0],$_GET['tothoigianden'][1],$_GET['tothoigianden'][2]))->getDateDBString().'\' and ';
					}else{
						$data_errors[] = 'Ngày đến không hợp lệ';
					}
				}else{
					$data_errors[] = 'Ngày đến không hợp lệ';
				}
			}
			if(isset($_GET['fromthoihangiaiquyet'])){
				if(is_array($_GET['fromthoihangiaiquyet'])&&is_numeric($_GET['fromthoihangiaiquyet'][0])&&is_numeric($_GET['fromthoihangiaiquyet'][1])&&is_numeric($_GET['fromthoihangiaiquyet'][2])){
					if(checkdate($_GET['fromthoihangiaiquyet'][1], $_GET['fromthoihangiaiquyet'][0], $_GET['fromthoihangiaiquyet'][2])){
						$where_clause .= 'cast(thoihangiaiquyet as date)>=\''.(new MDateTime($_GET['fromthoihangiaiquyet'][0],$_GET['fromthoihangiaiquyet'][1],$_GET['fromthoihangiaiquyet'][2]))->getDateDBString().'\' and ';
					}else{
						$data_errors[] = 'Thời hạn giải quyết không hợp lệ';
					}
				}else{
					$data_errors[] = 'Thời hạn giải quyết không hợp lệ';
				}
			}
			if(isset($_GET['tothoihangiaiquyet'])){
				if(is_array($_GET['tothoihangiaiquyet'])&&is_numeric($_GET['tothoihangiaiquyet'][0])&&is_numeric($_GET['tothoihangiaiquyet'][1])&&is_numeric($_GET['tothoihangiaiquyet'][2])){
					if(checkdate($_GET['tothoihangiaiquyet'][1], $_GET['tothoihangiaiquyet'][0], $_GET['tothoihangiaiquyet'][2])){
						$where_clause .= 'cast(thoihangiaiquyet as date)<=\''.(new MDateTime($_GET['tothoihangiaiquyet'][0],$_GET['tothoihangiaiquyet'][1],$_GET['tothoihangiaiquyet'][2]))->getDateDBString().'\' and ';
					}else{
						$data_errors[] = 'Thời hạn giải quyết không hợp lệ';
					}
				}else{
					$data_errors[] = 'Thời hạn giải quyết không hợp lệ';
				}
			}
			
			
			if(count($data_errors)){
				throw new NotValidFormDataException($data_errors);
			}
			if($where_clause==''){
				$where_clause = '1';
			}else{
				$where_clause .= '1';
			}
			
			if(isset($_GET['p']) && is_numeric($_GET['p']) && intval($_GET['p'])>0){
				$pp_cp = intval($_GET['p']);
			}else{
				$pp_cp = 1;
			}
			
			$legaldocuments = $user->timKiemCongVanDen($where_clause, ($pp_cp-1)*10, 10);
			if(count($legaldocuments)){
?>
<div id="legaldocument-list">
	<table class="list-table">
		<tr><th>Số đến</th><th>Ký hiệu</th><th>Đơn vị phát hành</th><th>Trích yếu</th><th>Tình trạng</th><th>Thao tác</th></tr>
		<?php
			foreach($legaldocuments as $legaldocument){
				echo '<tr>';
				echo '<td>'.$legaldocument->getSoDen().'</td>';
				echo '<td>'.$legaldocument->getKyHieu().'</td>';
				echo '<td><div class="abstract-wrapper w10">'.$legaldocument->getDonViBanHanh()->getTenDonVi().'</div></td>';
				echo '<td><div class="abstract-wrapper w10">'.$legaldocument->getTrichYeu().'</div></td>';
				echo '<td>'.$legaldocument->getTrangThaiString().'</td>';
				echo '<td>';
				if($user->getQuyen()->contains([PRIVILEGES['THEM_CONG_VAN_DEN'],PRIVILEGES['SUA_CONG_VAN_DEN'],PRIVILEGES['XOA_CONG_VAN_DEN'],PRIVILEGES['KIEM_DUYET_CONG_VAN_DEN'],PRIVILEGES['PHE_DUYET_CONG_VAN_DEN']])){
					echo '<a class="action-btn positive detail" onclick="showFormPopup(\'/ajax/showiclddetail.php\', [[\'id\', '.$legaldocument->getID().']])" title="Chi tiết công văn"></a>';
				}
				if($user->getQuyen()->contain(PRIVILEGES['SUA_CONG_VAN_DEN'])){
					echo '<a class="action-btn positive edit" onclick="showFormPopup(\'/ajax/editicldform.php\', [[\'id\', '.$legaldocument->getID().']])" title="Sửa công văn"></a>';
				}
				if($user->getQuyen()->contain(PRIVILEGES['XOA_CONG_VAN_DEN'])){
					echo '<a class="action-btn negative delete" onclick="showFormPopup(\'/ajax/deleteicldform.php\', [[\'id\', '.$legaldocument->getID().']]);" title="Xóa công văn"></a>';
				}
				echo '</td>';
				echo '</tr>';
			}
		?>
	</table>
	<?php
		try{
			$pp_pt = ceil($user->countSearchResult($where_clause) / 10);
			$pp_cp = 1;
			require $CNF['PATHS']['TEMPLATES'].'/pagepartition.php';
		}catch(Exception $e){
			echo '<div class="error-message-box">'.$e->getMessage().'</div>';
		}
	?>
</div>
<?php
			}else{
				echo '<div class="success-message-box">Không tìm thấy công văn nào</div>';
			}
		}
	}catch(NotValidFormDataException $e){
		
	}catch(Exception $e){
		echo '<div class="error-message-box">'.$e->getMessage().'</div>';
	}
		
?>
