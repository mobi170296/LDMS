<?php
	session_start();
	require_once __DIR__.'/../../config/config.php';
	require_once $CNF['PATHS']['CLASSES'].'/user.php';
	require_once $CNF['PATHS']['LIBRARY'].'/word/mword.php';
	require_once $CNF['PATHS']['LIBRARY'].'/datachecker/datachecker.php';
	require_once $CNF['PATHS']['CLASSES'].'/ajaxeditresult.php';
	header('content-type: application/json');
	try{
		if(!isset($_POST['editicld'])){
			throw new Exception('Yêu cầu không hợp lệ!');
		}
		if(!isset($_POST['id'])||!is_numeric($_POST['id'])){
			throw new Exception('Không thể cập nhật thông tin cho công văn này');
		}
		require_once $CNF['PATHS']['TEMPLATES'].'/dbinitnoheader.php';
		$user=new User($mcon);
		
		$user->dangNhap();
		
		
		if(!$user->getQuyen()->contain(PRIVILEGES['SUA_CONG_VAN_DEN'])){
			throw new Exception('Bạn không có quyền sửa công văn đến');
		}
		
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
		if(!isset($_POST['ngayden']) || !isset($_POST['thangden']) || !isset($_POST['namden']) || !is_numeric($_POST['ngayden']) || !is_numeric($_POST['thangden']) || !is_numeric($_POST['namden']) || !checkdate($_POST['thangden'], $_POST['ngayden'], $_POST['namden']) || !isset($_POST['gioden']) || !isset($_POST['phutden']) || !isset($_POST['giayden']) || !is_numeric($_POST['gioden']) || !is_numeric($_POST['phutden']) || !is_numeric($_POST['giayden']) || !DataChecker::checkTime($_POST['gioden'], $_POST['phutden'], $_POST['giayden'])){
			$data_error[] = 'Thời gian văn bản đến không hợp lệ';
		}
		if(!isset($_POST['ngayvanban']) || !isset($_POST['thangvanban']) || !isset($_POST['namvanban']) || !is_numeric($_POST['ngayvanban']) || !is_numeric($_POST['thangvanban']) || !is_numeric($_POST['namvanban'])){
			$data_error[] = 'Ngày của văn bản không hợp lệ';
		}

		$b_thoihangiaiquyet = false;
		if(isset($_POST['thoihangiaiquyet'])){
			if(!isset($_POST['ngaygiaiquyet']) || !isset($_POST['thanggiaiquyet']) || !isset($_POST['namgiaiquyet']) || !is_numeric($_POST['ngaygiaiquyet']) || !is_numeric($_POST['thanggiaiquyet']) || !is_numeric($_POST['namgiaiquyet']) || !checkdate($_POST['thanggiaiquyet'], $_POST['ngaygiaiquyet'], $_POST['namgiaiquyet'])){
				$data_error[] = 'Thời hạn giải quyết không hợp lệ!';
			}
			$b_thoihangiaiquyet = true;
		}

		if(!isset($_POST['madonvibanhanh']) || $_POST['madonvibanhanh'] == ''){
			$data_error[] = 'Mã đơn vị ban hành không được để trống';
		}
		if(!isset($_POST['maloaivanban']) || $_POST['maloaivanban'] == ''){
			$data_error[] = 'Mã loại văn bản không được để trống';
		}
		
		$b_taptindinhkem = false;
		if(isset($_FILES['taptindinhkem']['error']) && is_numeric($_FILES['taptindinhkem']['error']) && $_FILES['taptindinhkem']['error']==0){
			$ext = UploadedFile::getExtension(UploadedFile::getMimeType($_FILES['taptindinhkem']['tmp_name']));
			if(!DataChecker::valueInArray($ext, ['pdf'])){
				$data_error[] = 'Hiện tại chỉ hỗ trợ định dạng tập tin \'pdf\'';
			}
			$b_taptindinhkem = true;
		}
		if(count($data_error)){
			throw new NotValidFormDataException($data_error);
		}
		
		$user->suaCongVanDen($_POST['id'], new LegalDocumentInfo(null,
							  $_POST['soden'],
							  $_POST['kyhieu'],
							  (new MDateTime($_POST['ngayden'], $_POST['thangden'], $_POST['namden'], $_POST['gioden'], $_POST['phutden'], $_POST['giayden']))->getDateTimeDBString('-', ':'),
							  (new MDateTime($_POST['ngayvanban'], $_POST['thangvanban'], $_POST['namvanban']))->getDateDBString('-'),
							  $_POST['madonvibanhanh'],
							  $_POST['trichyeu'],
							  $_POST['nguoiky'],
							  $_POST['maloaivanban'],
							  $b_thoihangiaiquyet ? (new MDateTime($_POST['ngaygiaiquyet'], $_POST['thanggiaiquyet'], $_POST['namgiaiquyet']))->getDateDBString('-'):null,null,null,null,null,
							  null), $b_taptindinhkem?$_FILES['taptindinhkem']['tmp_name']:null, $b_taptindinhkem?$CNF['PATHS']['LEGALDOCUMENT_DIR'].'/'.$_FILES['taptindinhkem']['name']:null);
		
		echo json_encode(new AJAXEditResult(1, ['Cập nhật thông tin cho công văn thành công!']), JSON_UNESCAPED_UNICODE);
	}catch(NotValidFormDataException $e){
		echo json_encode(new AJAXEditResult(0, $e->getErrors()), JSON_UNESCAPED_UNICODE);
	}catch(Exception $e){
		echo json_encode(new AJAXEditResult(0, [$e->getMessage()]), JSON_UNESCAPED_UNICODE);
	}
?>