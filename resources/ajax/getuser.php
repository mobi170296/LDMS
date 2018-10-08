<?php
	$conn = new MySQLi('localhost', 'root', 'nguyenthithuyhang', 'ldmsdb');
	header('content-type: application/json');
	if(isset($_POST['maso']) && $conn->errno==0){
		$result = $conn->query('select * from nguoidung where maso=\''.$conn->real_escape_string($_POST['maso']).'\'');
		if($result && $result->num_rows > 0){
			$user = $result->fetch_assoc();
			$user['matkhau'] = utf8_encode($user['matkhau']);
			$json_user = json_encode($user, JSON_UNESCAPED_UNICODE);
			echo '{"error":{"code":0, "message":""},"result":'.$json_user.'}';
		}else{
			echo '{"error":{"code":2, "message":"Không tồn tại người dùng này! ' . $_POST['maso'] . '"}}';
		}
	}else{
		echo '{"error": {"code": 1, "message": "Không thể thực hiện yêu cầu này!"}}';
	}
?>