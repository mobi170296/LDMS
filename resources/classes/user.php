<?php
	#namespace m\resources\classes;
	## Thuộc tính đặt tên theo lược đồ cơ sở dữ liệu
	$CNF['RUNNING'] = '';
	require_once(__DIR__.'/../../config/config.php');
	require_once $CNF['PATHS']['LIBRARY'] . '/database/mdatabase.php';
	require_once $CNF['PATHS']['LIBRARY'] . '/datetime/mdatetime.php';
	require_once $CNF['PATHS']['LIBRARY'] . '/collection/mset.php';
	
	require_once __DIR__ . '/legaldocument.php';
	require_once __DIR__ . '/userinfo.php';
	require_once __DIR__ . '/exceptions.php';
	require_once __DIR__ . '/groupinfo.php';
	require_once __DIR__ . '/issuedunitinfo.php';
	require_once __DIR__ . '/legaldocument.php';
	require_once __DIR__ . '/legaldocumentinfo.php';
	require_once __DIR__ . '/doctypeinfo.php';
	require_once __DIR__ . '/departmentinfo.php';

	class User{
		public $id, $maso, $matkhau, $ho, $ten, $ngaysinh, $email, $sodienthoai, $diachi, $madonvi, $manhom, $tinhtrang, $thoigianthem, $quyen, $dbcon;
		public function __construct($connection){
			$this->dbcon = $connection;
			$this->quyen = new MSet();
		}
		public function getDBConnection(){
			return $this->dbcon;
		}
		public function dangNhap($maso=null, $matkhau=null){
			if($maso){
				#đăng nhập theo thông tin người dùng đã đưa
				try{
					
					$result = $this->dbcon->query("SELECT * FROM nguoidung WHERE maso='{$this->dbcon->realEscapeString($maso)}' AND matkhau=".((new MDBPasswordData($this->dbcon->realEscapeString($matkhau)))->toDBValueString()));
					if($result->num_rows){
						$info = $result->fetch_assoc();
						if($info['tinhtrang']==0){
							throw new BlockedUserException('Bạn đã bị khóa tài khoản vui lòng liên hệ với Quản trị viên');
						}
						foreach($info as $k => $v){
							$this->$k = $v;
						}
						$sql = "SELECT quyennguoidung.quyen FROM quyennguoidung INNER JOIN nguoidung ON nguoidung.id=quyennguoidung.idnguoidung WHERE nguoidung.id={$this->id} UNION SELECT quyennhomnguoidung.quyen FROM quyennhomnguoidung JOIN nguoidung ON nguoidung.manhom=quyennhomnguoidung.manhom WHERE nguoidung.id={$this->id}";
						$result = $this->dbcon->query($sql);
						while($row = $result->fetch_assoc()){
							$this->quyen->addElement($row['quyen']);
						}
						$_SESSION['maso'] = $maso;
						$_SESSION['matkhau'] = $matkhau;
					}else{
						throw new LoginFailedException('Tên đăng nhập hoặc mật khẩu không đúng');
					}
				}catch(DBException $e){
					throw $e;
				}catch(LoginFailedException $e){
					throw $e;
				}
			}else{
				#đăng nhập theo dữ liệu có trong session
				try{
					if(isset($_SESSION['maso']) && isset($_SESSION['matkhau'])){
						$maso = $_SESSION['maso'];
						$matkhau = $_SESSION['matkhau'];
					}else{
						throw new Exception('Bạn chưa đăng nhập');
					}
					$result = $this->dbcon->query("SELECT * FROM nguoidung WHERE maso='{$this->dbcon->realEscapeString($maso)}' AND matkhau=".((new MDBPasswordData($this->dbcon->realEscapeString($matkhau)))->toDBValueString()));
					if($result->num_rows){
						$info = $result->fetch_assoc();
						if($info['tinhtrang']==0){
							throw new BlockedUserException('Bạn đã bị khóa tài khoản vui lòng liên hệ với Quản trị viên');
						}
						foreach($info as $k => $v){
							$this->$k = $v;
						}
						$sql = "SELECT quyennguoidung.quyen FROM quyennguoidung INNER JOIN nguoidung ON nguoidung.id=quyennguoidung.idnguoidung WHERE nguoidung.id={$this->id} UNION SELECT quyennhomnguoidung.quyen FROM quyennhomnguoidung JOIN nguoidung ON nguoidung.manhom=quyennhomnguoidung.manhom WHERE nguoidung.id={$this->id}";
						$result = $this->dbcon->query($sql);
						while($row = $result->fetch_assoc()){
							$this->quyen->addElement($row['quyen']);
						}
					}else{
						throw new LoginFailedException('Tên đăng nhập hoặc mật khẩu không đúng có thể do bị đổi bởi người dùng khác');
					}
				}catch(DBException $e){
					throw $e;
				}catch(LoginFailedException $e){
					unset($_SESSION['maso']);
					unset($_SESSION['matkhau']);
					throw $e;
				}catch(Exception $e){
					throw $e;
				}
			}
		}
		#Deprecated
		public function login($maso='', $matkhau=''){
			if($maso==''){
				#đăng nhập theo dữ liệu trong session
				if(isset($_SESSION['maso']) && $_SESSION['maso']!=''){
					#nếu đã đặt thông tin đăng nhập trong session thì phải đăng nhập thử
					$result = $this->dbcon->query("select id, maso, aes_decrypt(matkhau, '". DATABASE['AES_KEY'] ."') as matkhau, ho, ten, ngaysinh, email, sodienthoai, diachi, madonvi, manhom, tinhtrang, thoigianthem from nguoidung where maso='". $this->dbcon->realEscapeString($_SESSION['maso']) . "' and matkhau=aes_encrypt('" . $this->dbcon->realEscapeString($_SESSION['matkhau']) . "', '" . DATABASE['AES_KEY'] ."')");
					if($this->dbcon->getErrno()){
						#Truy vấn DB thất bại
						return false;
					}else{
						#Truy vấn DB thành công
						if($result->num_rows>0){
							#Đăng nhập thành công
							$row = $result->fetch_assoc();
							foreach($row as $k => $v){
								$this->$k = $v;
							}
							#Thêm quyền cho người dùng
							$sql = "select quyennguoidung.quyen from quyennguoidung join nguoidung on nguoidung.id=quyennguoidung.idnguoidung where nguoidung.id={$this->id} union select quyennhomnguoidung.quyen from quyennhomnguoidung join nguoidung on nguoidung.manhom=quyennhomnguoidung.manhom where nguoidung.id={$this->id}";
							if($result = $this->dbcon->query($sql)){
								while($row = $result->fetch_assoc()){
									$this->quyen->addElement($row['quyen']);
								}
								return true;
							}else{
								return false;
							}
						}else{
							#Đăng nhập thất bại
							unset($_SESSION['maso']);
							unset($_SESSION['matkhau']);
							return false;
						}
					}
				}
			}else{
				#đăng nhập theo thông tin đăng nhập mới
				$result = $this->dbcon->query("select id, maso, aes_decrypt(matkhau, '". DATABASE['AES_KEY'] ."') as matkhau, ho, ten, ngaysinh, email, sodienthoai, diachi, madonvi, manhom, tinhtrang, thoigianthem from nguoidung where maso='". $this->dbcon->realEscapeString($maso) . "' and matkhau=aes_encrypt('" . $this->dbcon->realEscapeString($matkhau) . "', '" . DATABASE['AES_KEY'] ."')");
				if($this->dbcon->getErrno()){
					#Truy vấn DB thất bại
					return false;
				}else{
					#Truy vấn DB thành công
					if($result->num_rows>0){
						#Đăng nhập thành công
						$row = $result->fetch_assoc();
						foreach($row as $k => $v){
							$this->$k = $v;
						}
						$_SESSION['maso'] = $maso;
						$_SESSION['matkhau'] = $matkhau;
						#Thêm quyền cho người dùng
						$sql = "select quyennguoidung.quyen from quyennguoidung join nguoidung on nguoidung.id=quyennguoidung.idnguoidung where nguoidung.id={$this->id} union select quyennhomnguoidung.quyen from quyennhomnguoidung join nguoidung on nguoidung.manhom=quyennhomnguoidung.manhom where nguoidung.id={$this->id}";
						if($result = $this->dbcon->query($sql)){
							while($row = $result->fetch_assoc()){
								$this->quyen->addElement($row['quyen']);
							}
							return true;
						}else{
							return false;
						}
					}else{
						return false;
					}
				}
			}
			return false;
		}
		public function isLogin(){
			return isset($this->id);
		}
		public function isDangNhap(){
			return isset($this->id);
		}
		public function getID(){
			return $this->id;
		}
		public function getMaSo(){
			return $this->maso;
		}
		public function getHo(){
			return $this->ho;
		}
		public function getTen(){
			return $this->ten;
		}
		public function getNgaySinh(){
			return $this->ngaysinh;
//			$date = [];
//			$result = preg_match('/^(\d{1,4})-(\d{1,2})-(\d{1,2})$/', $this->ngaysinh, $date);
//			if($result){
//				return new MDateTime($date[3], $date[2], $date[1]);
//			}else{
//				return null;
//			}
		}
		public function getEmail(){
			return $this->email;
		}
		public function getSoDienThoai(){
			return $this->sodienthoai();
		}
		public function getDiaChi(){
			return $this->diachi;
		}
		public function getMaDonVi(){
			return $this->madonvi;
		}
		public function getMaNhom(){
			return $this->manhom;
		}
		public function getTinhTrang(){
			return $this->tinhtrang;
		}
		public function getThoiGianThem(){
			return $this->thoigianthem;
//			$date = [];
//			$result = preg_match('/^(\d{1,4})-(\d{1,2})-(\d{1,2}) (\d{1,2})-(\d{1,2})-(\d{1,2})$/', $this->ngaysinh, $date);
//			if($result){
//				return new MDateTime($date[3], $date[2], $date[1], $date[4], $date[5], $date[6]);
//			}else{
//				return null;
//			}
		}
		public function getQuyen(){
			return $this->quyen;
		}
		#
		# Quản lý người dùng
		#
		public function themNguoiDung($userinfo){
			#data checked outside
			if($this->quyen->contain(PRIVILEGES['THEM_NGUOI_DUNG'])){
				try{
					$this->dbcon->startTransactionRW();

					$result = $this->dbcon->lockRow('SELECT * FROM nhom WHERE manhom=\''.$this->dbcon->realEscapeString($userinfo->getMaNhom()).'\'');
					
					if($result->num_rows==0){
						throw new NotExistedGroupException('Nhóm '.$userinfo->getMaNhom().' không tồn tại không thể thêm người dùng');
					}

					$result = $this->dbcon->lockRow('SELECT * FROM donvi WHERE madonvi=\''.$this->dbcon->realEscapeString($userinfo->getMaDonVi()).'\'');
					
					if($result->num_rows==0){
						throw new NotExistedDepartmentException('Đơn vị '.$userinfo->getMaDonVi().' không tồn tại không thể thêm người dùng');
					}

					$result = $this->dbcon->lockRow("SELECT * FROM nguoidung WHERE maso='{$this->dbcon->realEscapeString($userinfo->getMaSo())}'");
					
					if($result->num_rows>0){
						$row = $result->fetch_assoc();
						$fullname = $row['ho'] . ' ' . $row['ten'];
						throw new ExistedUserException('Mã số người dùng này đã tồn tại với tên '. $fullname. '. Xin vui lòng kiểm tra lại!');
					}else{
						$this->dbcon->insert('nguoidung', ['maso', 'matkhau', 'ho', 'ten', 'ngaysinh', 'email', 'sodienthoai', 'diachi', 'madonvi', 'manhom', 'tinhtrang'], [$this->dbcon->realEscapeString($userinfo->getMaSo()), (new MDBPasswordData($this->dbcon->realEscapeString($userinfo->getMatKhau()))), $this->dbcon->realEscapeString($userinfo->getHo()), $this->dbcon->realEscapeString($userinfo->getTen()), $this->dbcon->realEscapeString($userinfo->getNgaySinh()), $this->dbcon->realEscapeString($userinfo->getEmail()), $this->dbcon->realEscapeString($userinfo->getSoDienThoai()), htmlspecialchars($this->dbcon->realEscapeString($userinfo->getDiaChi())), $this->dbcon->realEscapeString($userinfo->getMaDonVi()), $this->dbcon->realEscapeString($userinfo->getMaNhom()), $userinfo->getTinhTrang()]);
						
						$this->dbcon->commit();
					}
				}catch(Exception $e){
					$this->dbcon->rollback();
					throw $e;
				}
			}else{
				throw new MissingPrivilegeException('Bạn không đủ quyền để thực hiện thao tác thêm người dùng!');
			}
		}
		public function suaNguoiDung($id, $newuserinfo){
			#data checked outside
			if($this->quyen->contain(PRIVILEGES['SUA_NGUOI_DUNG'])){
				try{
					$this->dbcon->startTransactionRW();
					$result = $this->dbcon->lockRow('SELECT * FROM nguoidung WHERE id='.$id);
					if($result->num_rows==0){
						throw new NotExistedUserException('ID người dùng không tồn tại!');
					}
					$row = $result->fetch_assoc();
					$userinfo = new UserInfo(null, null, null, null, null, null, null, null, null, null, null, null);
					foreach($row as $k => $v){
						$userinfo->$k = $v;
					}
					$result = $this->dbcon->lockRow('SELECT * FROM nhom WHERE manhom=\''.$this->dbcon->realEscapeString($newuserinfo->getMaNhom()).'\'');
					
					if($result->num_rows==0){
						throw new NotExistedGroupException('Nhóm '.$newuserinfo->getMaNhom().' không tồn tại không thể chuyển người dùng đến nhóm này');
					}

					$result = $this->dbcon->lockRow('SELECT * FROM donvi WHERE madonvi=\''.$this->dbcon->realEscapeString($newuserinfo->getMaDonVi()).'\'');
					
					if($result->num_rows==0){
						throw new NotExistedGroupException('Đơn vị '.$newuserinfo->getMaDonVi().' không tồn tại không thể chuyển người dùng đến đơn vị này');
					}
					if($userinfo->getMaSo() != $newuserinfo->getMaSo()){
						$result = $this->dbcon->query('SELECT * FROM nguoidung WHERE maso=\''.$this->dbcon->realEscapeString($newuserinfo->getMaSo()).'\'');
					
						if($result->num_rows){
							$info = $result->fetch_assoc();
							throw new ExistedUserException('Người dùng có mã số '.$newuserinfo->getMaSo().' đã tồn tại với tên ' . $info['ho']. ' ' . $info['ten']);
						}
					}
					$sql = 'UPDATE nguoidung SET ';
					$sql .= 'maso=\''.$newuserinfo->getMaSo().'\',';
					$sql .= 'matkhau='. (new MDBPasswordData($this->dbcon->realEscapeString($newuserinfo->getMatKhau())))->toDBValueString().',';
					$sql .= 'ho=\''.$newuserinfo->getHo().'\',';
					$sql .= 'ten=\''.$newuserinfo->getTen().'\',';
					$sql .= 'ngaysinh=\''.$newuserinfo->getNgaySinh().'\',';
					$sql .= 'email=\''.$newuserinfo->getEmail().'\',';
					$sql .= 'sodienthoai=\''.$newuserinfo->getSoDienThoai().'\',';
					$sql .= 'diachi=\''.$this->dbcon->realEscapeString(htmlspecialchars($newuserinfo->getDiaChi())).'\',';
					$sql .= 'madonvi=\''.$newuserinfo->getMaDonVi().'\',';
					$sql .= 'manhom=\''.$newuserinfo->getMaNhom().'\',';
					$sql .= 'tinhtrang='.$newuserinfo->getTinhTrang(). ' WHERE id='.$id;
					
					$this->dbcon->query($sql);
					
					$this->dbcon->commit();
				}catch(Exception $e){
					$this->dbcon->rollback();
					throw $e;
				}
			}else{
				throw new MissingPrivilegeException('Bạn không đủ quyền để thực hiện thao tác sửa thông tin người dùng!');
			}
		}
		public function xoaNguoiDung($id){
			#data checked outside
			if($this->quyen->contain(PRIVILEGES['XOA_NGUOI_DUNG'])){
				try{
					$result = $this->dbcon->query('SELECT * FROM nguoidung WHERE id='.$id);
				
					if($result->num_rows){
						$result = $this->dbcon->query('SELECT EXISTS(SELECT id FROM congvanden WHERE idnguoinhap='.$id.')');

						$row = $result->fetch_row();

						if($row[0]){
							throw new ExistedLegalDocumentException('Đã tồn tại công văn do người này nhập không thể xóa người dùng này được!');
						}else{
							$result = $this->dbcon->query('DELETE FROM nguoidung WHERE id='.$id);
						}
					}else{
						throw new NotExistedUserException('Người dùng không tồn tại không thể thực hiện thao tác xóa!');
					}
				}catch(Exception $e){
					throw $e;
				}
				
			}else{
				throw new MissingPrivilegeException('Bạn không đủ quyền để thực hiện thao tác xóa người dùng!');
			}
		}
		public function capQuyenNguoiDung($id, $quyen){
			if(!$this->quyen->contain(PRIVILEGES['CAP_QUYEN_NGUOI_DUNG'])){
				throw new MissingPrivilegeException('Bạn không có quyền để thực hiện cấp quyền cho người dùng khác!');
			}
			
			if($this->id==$id){
				throw new Exception('Bạn không thể tự cấp quyền cho mình');
			}
			
			try{
				$result = $this->dbcon->startTransactionRW();

				$result = $this->dbcon->query('SELECT * FROM nguoidung WHERE id='.$id);

				if($result->num_rows){
					$result = $this->dbcon->lockRow('SELECT * FROM quyennguoidung WHERE idnguoidung='.$id);

					$currentPriveleges = new MSet();
					while($row = $result->fetch_assoc()){
						$currentPriveleges->addElement($row['quyen']);
					}

					$newSet = $currentPriveleges->getNewValues($quyen);
					$oldSet = $currentPriveleges->getOldValues($quyen);

					foreach($oldSet as $v){
						$result = $this->dbcon->query('DELETE FROM quyennguoidung WHERE idnguoidung='.$id . ' and quyen='.$v);
					}


					foreach($newSet as $v){
						$result = $this->dbcon->query('INSERT INTO quyennguoidung(idnguoidung, quyen) VALUES('.$id.', '.$v.')');
					}

					$result = $this->dbcon->commit();
				}else{
					$this->dbcon->rollback();
					throw new NotExistedUserException('Người dùng không tồn tại không thể được cấp quyền!');
				}
			}catch(Exception $e){
				$this->dbcon->rollback();
				throw $e;
			}
			
		}
		#
		# Quản lý nhóm người dùng
		#
		public function themNhom($groupinfo){
			if(!$this->quyen->contain(PRIVILEGES['THEM_NHOM'])){
				throw new MissingPrivilegeException('Bạn không có quyền thêm nhóm người dùng');
			}
			try{
				$this->dbcon->startTransactionRW();
				$result = $this->dbcon->lockRow('SELECT * FROM nhom WHERE manhom=\''.$this->dbcon->realEscapeString($groupinfo->getMaNhom()).'\'');
				
				if($result->num_rows){
					throw new ExistedGroupException('Nhóm người dùng \''. $groupinfo->getMaNhom(). '\' đã tồn tại!');
				}else{
					$this->dbcon->insert('nhom', ['manhom', 'tennhom'], [$this->dbcon->realEscapeString($groupinfo->getMaNhom()), $this->dbcon->realEscapeString($groupinfo->getTenNhom())]);
					$this->dbcon->commit();
				}
			}catch(Exception $e){
				$this->dbcon->rollback();
				throw $e;
			}
		}
		public function suaNhom($manhom, $groupinfo){
			if(!$this->quyen->contain(PRIVILEGES['SUA_NHOM'])){
				throw new MissingPrivilegeException('Bạn không có quyền sửa nhóm người dùng');
			}
			try{
				$result = $this->dbcon->query('SELECT * FROM nhom WHERE manhom=\''.$this->dbcon->realEscapeString($manhom).'\'');
				if($result->num_rows){
					if($manhom!=$groupinfo->getMaNhom()){
						$result = $this->dbcon->query('SELECT * FROM nhom WHERE manhom=\''.$this->dbcon->realEscapeString($groupinfo->getMaNhom()).'\'');
						if($result->num_rows){
							throw new ExistedGroupException('Nhóm người dùng ' . $groupinfo->getMaNhom() .' đã tồn tại không thể sửa thông tin nhóm');
						}
					}
					$this->dbcon->query('UPDATE nhom SET manhom=\''.$this->dbcon->realEscapeString($groupinfo->getMaNhom()).'\', tennhom=\''.$this->dbcon->realEscapeString($groupinfo->getTenNhom()).'\' WHERE manhom=\''.$this->dbcon->realEscapeString($manhom).'\'');
				}else{
					throw new NotExistGroupException('Nhóm người dùng không tồn tại không thể thực hiện thao tác sửa thông tin nhóm');
				}
			}catch(Exception $e){
				throw $e;
			}
		}
		public function xoaNhom($manhom){
			if(!$this->quyen->contain(PRIVILEGES['XOA_NHOM'])){
				throw new MissingPrivilegeException('Bạn không có quyền xóa nhóm người dùng');
			}
			try{
				$result = $this->dbcon->query('SELECT EXISTS(SELECT id FROM nguoidung WHERE manhom=\''.$this->dbcon->realEscapeString($manhom).'\')');
				$row = $result->fetch_row();
				if($row[0]){
					throw new ExistedUserException('Đã có người dùng thuộc nhóm này nên không thể xóa nhóm');
				}else{
					$this->dbcon->query('DELETE FROM nhom WHERE manhom=\''.$this->dbcon->realEscapeString($manhom).'\'');
				}
			}catch(Exception $e){
				throw $e;
			}
		}
		public function capQuyenNhomNguoiDung($manhom, $quyen){
			if(!$this->quyen->contain(PRIVILEGES['CAP_QUYEN_NHOM'])){
				throw new MissingPrivilegeException('Bạn không có quyền để thực hiện cấp quyền cho nhóm người dùng');
			}
			
			try{
				$result = $this->dbcon->startTransactionRW();

				$result = $this->dbcon->lockRow('SELECT * FROM nhom WHERE manhom=\''.$this->dbcon->realEscapeString($manhom).'\'');

				if($result->num_rows){
					$result = $this->dbcon->lockRow('SELECT * FROM quyennhomnguoidung WHERE manhom=\''.$this->dbcon->realEscapeString($manhom).'\'');

					$currentPriveleges = new MSet();
					while($row = $result->fetch_assoc()){
						$currentPriveleges->addElement($row['quyen']);
					}

					$newSet = $currentPriveleges->getNewValues($quyen);
					$oldSet = $currentPriveleges->getOldValues($quyen);

					foreach($oldSet as $v){
						$result = $this->dbcon->query('DELETE FROM quyennhomnguoidung WHERE manhom=\''.$this->dbcon->realEscapeString($manhom). '\' and quyen='.$v);
					}


					foreach($newSet as $v){
						$result = $this->dbcon->query('INSERT INTO quyennhomnguoidung(manhom, quyen) VALUES(\''.$this->dbcon->realEscapeString($manhom).'\', '.$v.')');
					}

					$result = $this->dbcon->commit();
				}else{
					throw new NotExistedGroupException('Nhóm không tồn tại không thể cấp quyền');
				}
			}catch(Exception $e){
				$this->dbcon->rollback();
				throw $e;
			}
		}
		#
		# Quản lý đơn vị
		#
		public function themDonVi($departmentinfo){
			if(!$this->quyen->contain(PRIVILEGES['THEM_DON_VI'])){
				throw new MissingPrivilegeException('Bạn không có quyền thực hiện thao tác thêm đơn vị!');
			}
			try{
				$this->dbcon->startTransactionRW();
				
				$result = $this->dbcon->lockRow('SELECT * FROM donvi WHERE madonvi=\''.$this->dbcon->realEscapeString($departmentinfo->getMaDonVi()).'\'');
				
				if($result->num_rows){
					throw new ExistedDepartmentException('Đơn vị '. $departmentinfo->getMaDonVi(). ' đã tồn tại không thể thêm đơn vị này');
				}else{
					$this->dbcon->insert('donvi', ['madonvi', 'tendonvi', 'email'], [$this->dbcon->realEscapeString($departmentinfo->getMaDonVi()), $this->dbcon->realEscapeString($departmentinfo->getTenDonVi()), $this->dbcon->realEscapeString($departmentinfo->getEmail())]);
					$this->dbcon->commit();
				}
			}catch(Exception $e){
				$this->dbcon->rollback();
				throw $e;
			}
		}
		public function suaDonVi($madonvi, $departmentinfo){
			if(!$this->quyen->contain(PRIVILEGES['SUA_DON_VI'])){
				throw new MissingPrivilegeException('Bạn không có quyền sửa thông tin đơn vị!');
			}
			try{
				$this->dbcon->startTransactionRW();
				
				$result = $this->dbcon->lockRow('SELECT * FROM donvi WHERE madonvi=\''.$this->dbcon->realEscapeString($madonvi).'\'');
				
				if($result->num_rows){
					if($madonvi!=$departmentinfo->getMaDonVi()){
						$result = $this->dbcon->lockRow('SELECT * FROM donvi WHERE madonvi=\''.$this->dbcon->realEscapeString($departmentinfo->getMaDonVi()).'\'');

						if($result->num_rows){
							throw new ExistedDepartmentException('Mã đơn vị bạn định chuyển đổi sang '. $departmentinfo->getMaDonVi().' đã tồn tại không thể thực hiện sửa đơn vị');
						}
					}
					
					$this->dbcon->query('UPDATE donvi SET madonvi=\''.$this->dbcon->realEscapeString($departmentinfo->getMaDonVi()).'\', tendonvi=\''.$this->dbcon->realEscapeString($departmentinfo->getTenDonVi()).'\', email=\''.$departmentinfo->getEmail().'\' WHERE madonvi=\''.$this->dbcon->realEscapeString($madonvi).'\'');
					
					$this->dbcon->commit();
				}else{
					throw new NotExistedDepartmentException('Đơn vị này không tồn tại không thể thực hiện tao tác sửa thông tin đơn vị!');
				}
			}catch(Exception $e){
				$this->dbcon->rollback();
				throw $e;
			}
		}
		public function xoaDonVi($madonvi){
			if(!$this->quyen->contain(PRIVILEGES['XOA_DON_VI'])){
				throw new MissingPrivilegeException('Bạn không đủ quyền để thực hiện chức năng xóa người dùng!');
			}
			try{
				$result = $this->dbcon->query('SELECT * FROM donvi WHERE madonvi=\''.$this->dbcon->realEscapeString($madonvi).'\'');
				if($result->num_rows){
					$result = $this->dbcon->query('SELECT EXISTS(SELECT id FROM nguoidung WHERE madonvi=\''.$this->dbcon->realEscapeString($madonvi).'\')');
					$row = $result->fetch_row();
					if($row[0]){
						throw new ExistedUserException('Đã có người dùng ở đơn vị \''. $madonvi .'\' này không thể xóa đơn vị này!');
					}
					
					$result = $this->dbcon->query('SELECT EXISTS(SELECT id FROM congvanden WHERE madonvi=\''.$this->dbcon->realEscapeString($madonvi).'\')');
					$row = $result->fetch_row();
					if($row[0]){
						throw new ExistedLegalDocumentException('Hệ thống đã tồn tại công văn đến của đơn vị \''.$madonvi.'\' này không thể xóa đơn vị này!');
					}
					$this->dbcon->query('DELETE FROM donvi WHERE madonvi=\''.$this->dbcon->realEscapeString($madonvi).'\'');
				}else{
					throw new NotExistedDepartmentException('Đơn vị \''. $madonvi. '\' không tồn tại không thể xóa');
				}
			}catch(Exception $e){
				throw $e;
			}
		}
		#
		# Danh mục loại văn bản
		#
		public function themLoaiVanBan($doctypeinfo){
			if(!$this->quyen->contain(PRIVILEGES['THEM_LOAI_VAN_BAN'])){
				throw new MissingPrivilegeException('Bạn không có quyền thực hiện thao tác thêm loại công văn');
			}
			try{
				$result = $this->dbcon->query('SELECT * FROM loaivanban WHERE maloai=\''.$this->dbcon->realEscapeString($doctypeinfo->getMaLoai()).'\'');
				if($result->num_rows){
					throw new ExistedDocTypeException('Loại văn bản \''.$doctypeinfo->getMaLoai().'\' đã tồn tại không thể thêm!');
				}else{
					$this->dbcon->insert('loaivanban', ['maloai', 'tenloai'], [$this->dbcon->realEscapeString($doctypeinfo->getMaLoai()), $this->dbcon->realEscapeString($doctypeinfo->getTenLoai())]);
				}
			}catch(Exception $e){
				throw $e;
			}
		}
		public function suaLoaiVanBan($maloai, $doctypeinfo){
			if(!$this->quyen->contain(PRIVILEGES['SUA_LOAI_VAN_BAN'])){
				throw new MissingPrivilegeException('Bạn không có quyền sửa loại công văn');
			}
			try{
				$result = $this->dbcon->query('SELECT * FROM loaivanban WHERE maloai=\''.$this->dbcon->realEscapeString($maloai).'\'');
				if($result->num_rows){
					if($maloai!=$doctypeinfo->getMaLoai()){
						$result = $this->dbcon->query('SELECT * FROM loaivanban WHERE maloai=\''.$this->dbcon->realEscapeString($doctypeinfo->getMaLoai()).'\'');
						if($result->num_rows){
							throw new ExistedDocTypeException('Mã loại văn bản \''.$doctypeinfo->getMaLoai().'\' đã tồn tại không thể sửa loại văn bản');
						}
					}
					
					$this->dbcon->query('UPDATE loaivanban SET maloai=\''.$this->dbcon->realEscapeString($doctypeinfo->getMaLoai()).'\', tenloai=\''.$this->dbcon->realEscapeString($doctypeinfo->getTenLoai()).'\' WHERE maloai=\''.$this->dbcon->realEscapeString($maloai).'\'');
				}else{
					throw new NotExistedDocTypeException('Loại văn bản \''.$maloai.'\' không tồn tại không thể sửa thông tin');
				}
			}catch(Exception $e){
				throw $e;
			}
		}
		public function xoaLoaiVanBan($maloai){
			if(!$this->quyen->contain(PRIVILEGES['XOA_LOAI_VAN_BAN'])){
				throw new MissingPrivilegeException('Bạn không có quyền xóa loại văn bản');
			}
			try{
				$result = $this->dbcon->query('SELECT * FROM loaivanban WHERE maloai=\''.$this->dbcon->realEscapeString($maloai).'\'');
				if($result->num_rows){
					$result = $this->dbcon->query('SELECT EXISTS(SELECT id FROM congvanden WHERE maloaivanban=\''.$this->dbcon->realEscapeString($maloai).'\')');
					$row = $result->fetch_row();
					if($row[0]){
						throw new ExistedLegalDocumentException('Đã có công văn có mã loại văn bản này, bạn không thể xóa mã loại này!');
					}else{
						$this->dbcon->query('DELETE FROM loaivanban WHERE maloai=\''.$this->dbcon->realEscapeString($maloai).'\'');
					}
				}else{
					throw new NotExistedDocTypeException('Loại văn bản \''.$maloai.'\' không tồn tại không thể thực hiện thao tác xóa');
				}
			}catch(Exception $e){
				throw $e;
			}
		}
		
		#
		# Danh mục đơn vị ban hành
		#
		public function themDonViBanHanh($issuedunit){
			if(!$this->quyen->contain(PRIVILEGES['THEM_DON_VI_BAN_HANH'])){
				throw new MissingPrivilegeException('Bạn không có quyền thêm đơn vị ban hành!');
			}
			try{
				$result = $this->dbcon->query('SELECT * FROM donvibanhanh WHERE madonvi=\''.$this->dbcon->realEscapeString($issuedunit->getMaDonVi()).'\'');
				if($result->num_rows){
					throw new ExistedIssuedUnitException('Đơn vị ban hành \''.$issuedunit->getMaDonVi().'\' đã tồn tại không thể thêm');
				}else{
					$this->dbcon->insert('donvibanhanh', ['madonvi', 'tendonvi', 'benngoai', 'diachi'], [$this->dbcon->realEscapeString($issuedunit->getMaDonVi()), $this->dbcon->realEscapeString($issuedunit->getTenDonVi()), $issuedunit->getBenNgoai(), $this->dbcon->realEscapeString($issuedunit->getDiaChi())]);
				}
			}catch(Exception $e){
				throw $e;
			}
		}
		public function suaDonViBanHanh($madonvi, $issuedunit){
			if(!$this->quyen->contain(PRIVILEGES['SUA_DON_VI_BAN_HANH'])){
				throw new MissingPrivilegeException('Bạn không có quyền thực hiện sửa đơn vị ban hành');
			}
			try{
				$result = $this->dbcon->query('SELECT * FROM donvibanhanh WHERE madonvi=\''.$this->dbcon->realEscapeString($madonvi).'\'');
				if($result->num_rows){
					if($madonvi!=$issuedunit->getMaDonVi()){
						$result = $this->dbcon->query('SELECT * FROM donvibanhanh WHERE madonvi=\''.$this->dbcon->realEscapeString($issuedunit->getMaDonVi()).'\'');

						if($result->num_rows){
							throw new ExistedIssuedUnitException('Đơn vị ban hành \''.$issuedunit->getMaDonVi().'\' đã tồn tại không thể sửa thông tin đơn vị');
						}
					}
					
					$this->dbcon->query('UPDATE donvibanhanh SET madonvi=\''.$this->dbcon->realEscapeString($issuedunit->getMaDonVi()).'\', tendonvi=\''.$this->dbcon->realEscapeString($issuedunit->getTenDonVi()).'\', benngoai='.$issuedunit->getBenNgoai().', diachi=\''.$this->dbcon->realEscapeString($issuedunit->getDiaChi()).'\' WHERE madonvi=\''.$this->dbcon->realEscapeString($madonvi).'\'');
				}else{
					throw new NotExistedIssuedUnitException('Đơn vị ban hành không tồn tại không thể sửa thông tin');
				}
			}catch(Exception $e){
				throw $e;
			}
		}
		public function xoaDonViBanHanh($madonvi){
			if(!$this->quyen->contain(PRIVILEGES['XOA_DON_VI_BAN_HANH'])){
				throw new MissingPrivilegeException('Bạn không có quyền xóa đơn vị ban hành');
			}
			try{
				$result = $this->dbcon->query('SELECT * FROM donvibanhanh WHERE madonvi=\''.$this->dbcon->realEscapeString($madonvi).'\'');
				if($result->num_rows){
					$result = $this->dbcon->query('SELECT EXISTS(SELECT * FROM congvanden WHERE madonvibanhanh=\''.$this->dbcon->realEscapeString($madonvi).'\')');
					
					$row = $result->fetch_row();
					if($row[0]){
						throw new ExistedLegalDocumentException('Đã có công văn của đơn vị ban hành này không thể thực hiện thao tác xóa đơn vị ban hành này được!');
					}else{
						$result = $this->dbcon->query('DELETE FROM donvibanhanh WHERE madonvi=\''.$this->dbcon->realEscapeString($madonvi).'\'');
					}
				}else{
					throw new NotExistedIssuedUnitException('Đơn vị bàn hành \''.$madonvi.'\' không tồn tại không thể xóa!');
				}
			}catch(Exception $e){
				throw $e;
			}
		}
		
		#
		# Quản lý công văn đến
		# ~ danh mục người dùng
		# ~ danh mục đơn vị ban hành
		# ~ danh mục loại văn bản
		# ~ đơn vị nhận công văn
		#
		
		public function themCongVanDen($docinfo, $srcfile, $destfile){
			if(!$this->quyen->contain(PRIVILEGES['THEM_CONG_VAN_DEN'])){
				throw new MissingPrivilegeException('Bạn không có quyền thêm công văn đến!');
			}
			try{
				$this->dbcon->startTransactionRW();
				$result = $this->dbcon->query('SELECT * FROM donvibanhanh WHERE madonvi=\''.$this->dbcon->realEscapeString($docinfo->getMaDonViBanHanh()).'\'');
				if($result->num_rows==0){
					throw new NotExistedIssuedUnitException('Đơn vị ban hành không tồn tại không thể thêm văn bản này');
				}
				$result = $this->dbcon->query('SELECT * FROM loaivanban WHERE maloai=\''.$this->dbcon->realEscapeString($docinfo->getMaLoaiVanBan()).'\'');
				if($result->num_rows==0){
					throw new NotExistedDocTypeException('Loại văn bản không tồn tại không thể thêm văn bản này');
				}
				#Kiểm tra thử
				#Nếu người dùng này đang nhập công văn thì chắc chắn rằng đơn vị nhập công văn sẽ tồn tại
				$result = $this->dbcon->query('SELECT * FROM donvi WHERE madonvi=\''.$this->dbcon->realEscapeString($docinfo->getMaDonVi()).'\'');
				if($result->num_rows==0){
					throw new NotExistedDepartmentException('Đơn vị nhận không tồn tại không thể thêm văn bản');
				}
				$result = $this->dbcon->query('SELECT * FROM congvanden WHERE soden='.$docinfo->getSoDen() .' AND madonvi=\''.$this->dbcon->realEscapeString($docinfo->getMaDonVi()).'\' AND year(thoigianden)=year(\''.$this->dbcon->realEscapeString($docinfo->getThoiGianDen()).'\')');
				
				if($result->num_rows){
					throw new ExistedLegalDocumentException('Công văn đến có số đến #'. $docinfo->getSoDen() .' đã tồn tại');
				}else{
					$basename = pathinfo($destfile)['basename'];
					$this->dbcon->insert('congvanden', ['soden', 'kyhieu', 'thoigianden', 'ngayvanban', 'madonvibanhanh', 'trichyeu', 'nguoiky', 'maloaivanban', 'thoihangiaiquyet', 'tentaptin', 'trangthai', 'idnguoinhap', 'madonvi'], [$docinfo->getSoDen(), $docinfo->getKyHieu(), $docinfo->getThoiGianDen(), $docinfo->getNgayVanBan(), $docinfo->getMaDonViBanHanh(), $docinfo->getTrichYeu(), $docinfo->getNguoiKy(), $docinfo->getMaLoaiVanBan(), $docinfo->getThoiHanGiaiQuyet(), '', $docinfo->getTrangThai(), $docinfo->getIDNguoiNhap(), $docinfo->getMaDonVi()]);
					
					$id = $this->dbcon->getInsertID();
					$filename = $id . '_' . $docinfo->getSoDen() . '_' . $basename;
					
					if(move_uploaded_file($srcfile, dirname($destfile).'/'. $filename)){
						$this->dbcon->query('UPDATE congvanden SET tentaptin=\''.$this->dbcon->realEscapeString($filename).'\' WHERE id='.$id);
					}else{
						throw new Exception('Xử lý tập tin lỗi!');
					}
					$this->dbcon->commit();
				}
			}catch(Exception $e){
				$this->dbcon->rollback();
				throw $e;
			}
		}
		public function suaCongVanDen($id, $newdocinfo, $srcfile, $destfile){
			if(!$this->quyen->contain(PRIVILEGES['SUA_CONG_VAN_DEN'])){
				throw new MissingPrivilegeException('Bạn không có quyền sửa công văn đến');
			}
			try{
				$this->dbcon->startTransactionRW();
				
				$legaldocument = new LegalDocument($this->dbcon);
				
				$docinfo = $legaldocument->getLegalDocumentByID($id);
				# Không có ngoại lệ tức là công văn đã tồn tại có thể sửa thông tin
				if($docinfo->getMaDonVi()!=$this->getMaDonVi()){
					throw new Exception('Bạn không thể cập nhật công văn của đơn vị khác');
				}
				$result = $this->dbcon->lockRow('SELECT * FROM donvibanhanh WHERE madonvi=\''.$this->dbcon->realEscapeString($newdocinfo->getMaDonViBanHanh()).'\'');
				if($result->num_rows==0){
					throw new NotExistedIssuedUnitException('Đơn vị ban hành không tồn tại không thể thay đổi thông tin công văn');
				}
				
				$result = $this->dbcon->lockRow('SELECT * FROM loaivanban WHERE maloai=\''.$this->dbcon->realEscapeString($newdocinfo->getMaLoaiVanBan()).'\'');
				if($result->num_rows==0){
					throw new NotExistedDocTypeException('Loại văn bản không tồn tại không thể thay đổi thông tin công văn');
				}
				
				#Kiểm tra thử
				#Nếu người dùng này đang nhập công văn thì chắc chắn rằng đơn vị nhập công văn sẽ tồn tại
				$result = $this->dbcon->lockRow('SELECT * FROM donvi WHERE madonvi=\''.$this->dbcon->realEscapeString($newdocinfo->getMaDonVi()).'\'');
				if($result->num_rows==0){
					throw new NotExistedDepartmentException('Đơn vị nhận văn bản không tồn tại không thể thay đổi thông tin');
				}
				
				$result = $this->dbcon->lockRow('SELECT * FROM congvanden WHERE id!='.$id.' AND soden='.$newdocinfo->getSoDen().' AND madonvi= \''.$this->dbcon->realEscapeString($newdocinfo->getMaDonVi()).'\' AND year(thoigianden)=year(\''.$newdocinfo->getThoiGianDen().'\')');
				
				if($result->num_rows){
					throw new ExistedLegalDocumentException('Đã có công văn có số đến này trong danh mục công văn của năm không thể sửa thông tin công văn');
				}
				if($srcfile!=null){
					#Xóa file cũ
					unlink(dirname($destfile).'/'.$docinfo->getTenTapTin());
					#Thêm file mới
					$basename = pathinfo($destfile)['basename'];
					$filename = $id . '_' . $newdocinfo->getSoDen() . '_' . $basename;
					if(!move_uploaded_file($srcfile, dirname($destfile).'/'. $filename)){
						throw new Exception('Xử lý tập tin lỗi!');
					}else{
						$this->dbcon->query('UPDATE congvanden SET soden='.$newdocinfo->getSoDen().
										   ', kyhieu=\''.$this->dbcon->realEscapeString($newdocinfo->getKyHieu()).'\''.
										   ', thoigianden=\''.$this->dbcon->realEscapeString($newdocinfo->getThoiGianDen()).'\''.
										   ', ngayvanban=\''.$this->dbcon->realEscapeString($newdocinfo->getNgayVanBan()).'\''.
										   ', madonvibanhanh=\''.$this->dbcon->realEscapeString($newdocinfo->getMaDonViBanHanh()).'\''.
										   ', trichyeu=\''.$this->dbcon->realEscapeString($newdocinfo->getTrichYeu()).'\''.
										   ', nguoiky=\''.$this->dbcon->realEscapeString($newdocinfo->getNguoiKy()).'\''.
										   ', maloaivanban=\''.$this->dbcon->realEscapeString($newdocinfo->getMaLoaiVanBan()).'\''.
										   ', thoihangiaiquyet='.MDatabase::toDBValueString($newdocinfo->getThoiHanGiaiQuyet()).
										   ', tentaptin=\''.$this->dbcon->realEscapeString($filename).'\''.
										   ', trangthai='.$newdocinfo->getTrangThai().
										   ', idnguoinhap='.$newdocinfo->getIDNguoiNhap().
										   ', madonvi=\''.$newdocinfo->getMaDonVi().'\''.
										   ' WHERE id='.$id);
					}
				}
				$this->dbcon->query('UPDATE congvanden SET soden='.$newdocinfo->getSoDen().
										   ', kyhieu=\''.$this->dbcon->realEscapeString($newdocinfo->getKyHieu()).'\''.
										   ', thoigianden=\''.$this->dbcon->realEscapeString($newdocinfo->getThoiGianDen()).'\''.
										   ', ngayvanban=\''.$this->dbcon->realEscapeString($newdocinfo->getNgayVanBan()).'\''.
										   ', madonvibanhanh=\''.$this->dbcon->realEscapeString($newdocinfo->getMaDonViBanHanh()).'\''.
										   ', trichyeu=\''.$this->dbcon->realEscapeString($newdocinfo->getTrichYeu()).'\''.
										   ', nguoiky=\''.$this->dbcon->realEscapeString($newdocinfo->getNguoiKy()).'\''.
										   ', maloaivanban=\''.$this->dbcon->realEscapeString($newdocinfo->getMaLoaiVanBan()).'\''.
										   ', thoihangiaiquyet='.MDatabase::toDBValueString($newdocinfo->getThoiHanGiaiQuyet()).
										   ', trangthai='.$newdocinfo->getTrangThai().
										   ', idnguoinhap='.$newdocinfo->getIDNguoiNhap().
										   ', madonvi=\''.$newdocinfo->getMaDonVi().'\''.
										   ' WHERE id='.$id);
				$this->dbcon->commit();
			}catch(Exception $e){
				$this->dbcon->rollback();
				throw $e;
			}
		}
		public function xoaCongVanDen($id, $destfile){
			if(!$this->dbcon->contain($PRIVILEGES['XOA_CONG_VAN_DEN'])){
				throw new MissingPrivilegeException('Bạn không có quyền xóa công văn');
			}
			try{
				$this->dbcon->startTransactionRW();
				
				$legaldocument = new LegalDocument($this->dbcon);
				$docinfo = $legaldocument->getLegalDocumentByID($id);
				
				if(unlink(dirname($destfile).'/'.$docinfo->getTenTapTin())){
					$this->dbcon->query('DELETE FROM congvanden WHERE id='.$id);
					$this->dbcon->commit();
				}else{
					throw Exception('Xử lý tập tin lỗi!');
				}
			}catch(Exception $e){
				$this->dbcon->rollback();
				throw $e;
			}
		}
		#
		# Quản lý người dùng
		#
		#
		public function getNguoiDung($id){
			$userinfo = new UserInfo(null, null, null, null, null, null, null, null, null, null, null, null);
			$result = $this->dbcon->query('SELECT * FROM nguoidung WHERE id='.$id);
			if($result->num_rows){
				$row = $result->fetch_assoc();
				foreach($row as $k => $v){
					$userinfo->$k = $v;
				}
				$sql = "SELECT quyennguoidung.quyen FROM quyennguoidung INNER JOIN nguoidung ON nguoidung.id=quyennguoidung.idnguoidung WHERE nguoidung.id={$id} UNION SELECT quyennhomnguoidung.quyen FROM quyennhomnguoidung JOIN nguoidung ON nguoidung.manhom=quyennhomnguoidung.manhom WHERE nguoidung.id={$id}";
				$quyen = new MSet();
				$result = $this->dbcon->query($sql);
				while($row = $result->fetch_assoc()){
					$quyen->addElement($row['quyen']);
				}
				$userinfo->setQuyen($quyen);
				return $userinfo;
			}else{
				throw new NotExistedUserException('Người dùng không tồn tại');
			}
		}
		public function getDanhSachNhom($start=null, $length=null){
			try{
				if($start===null){
					$result = $this->dbcon->query('SELECT * FROM nhom ORDER BY thoigianthem DESC');
					$groups = [];
					while($row = $result->fetch_assoc()){
						$groups[] = new GroupInfo($row['manhom'], $row['tennhom'], $row['thoigianthem']);
					}
					return $groups;
				}else{
					$result = $this->dbcon->query('SELECT * FROM nhom ORDER BY thoigianthem DESC LIMIT ' . $start .', ' . $length);
					$groups = [];	
					while($row = $result->fetch_assoc()){
						$groups[] = new GroupInfo($row['manhom'], $row['tennhom'], $row['thoigianthem']);
					}
					return $groups;
				}
			}catch(Exception $e){
				throw $e;
			}
		}
		public function getDanhSachDonVi($start=null, $length=null){
			try{
				if($start===null){
					$result = $this->dbcon->query('SELECT * FROM donvi ORDER BY thoigianthem DESC');
					$departments = [];
					while($row = $result->fetch_assoc()){
						$departments[] = new DepartmentInfo($row['madonvi'], $row['tendonvi'], $row['email'], $row['thoigianthem']);
					}
					return $departments;
				}else{
					$result = $this->dbcon->query('SELECT * FROM donvi ORDER BY thoigianthem DESC LIMIT ' . $start .', ' . $length);
					$departments = [];
					while($row = $result->fetch_assoc()){
						$departments[] = new DepartmentInfo($row['madonvi'], $row['tendonvi'], $row['email'], $row['thoigianthem']);
					}
					return $departments;
				}
			}catch(Exception $e){
				throw $e;
			}
		}
		public function getDanhSachDonViBanHanh($start=null, $length=null){
			try{
				if($start===null){
					$result = $this->dbcon->query('SELECT * FROM donvibanhanh ORDER BY thoigianthem DESC');
					$issuedunits = [];
					while($row = $result->fetch_assoc()){
						$issuedunits[] = new IssuedUnitInfo($row['madonvi'], $row['tendonvi'], $row['benngoai'], $row['diachi'], $row['thoigianthem']);
					}
				}else{
					$result = $this->dbcon->query('SELECT * FROM donvibanhanh ORDER BY thoigianthem DESC LIMIT '.$start .', '.$length);
					$issuedunits = [];
					while($row = $result->fetch_assoc()){
						$issuedunits[] = new IssuedUnitInfo($row['madonvi'], $row['tendonvi'], $row['benngoai'], $row['diachi'], $row['thoigianthem']);
					}
				}
				return $issuedunits;
			}catch(Exception $e){
				throw $e;
			}
		}
		public function getDanhSachLoaiVanBan($start=null, $length=null){
			try{
				$doctypes = [];
				if($start===null){
					$result = $this->dbcon->query('SELECT * FROM loaivanban ORDER BY thoigianthem DESC');
					while($row = $result->fetch_assoc()){
						$doctypes[] = new DocTypeInfo($row['maloai'], $row['tenloai'], $row['thoigianthem']);
					}
				}else{
					$result = $this->dbcon->query('SELECT * FROM loaivanban ORDER BY thoigianthem DESC LIMIT ' . $start .',' .$length);
					while($row = $result->fetch_assoc()){
						$doctypes[] = new DocTypeInfo($row['maloai'], $row['tenloai'], $row['thoigianthem']);
					}
				}
				return $doctypes;
			}catch(Exception $e){
				throw $e;
			}
		}
		public function getLoaiVanBan($maloai){
			try{
				$result = $this->dbcon->query('SELECT * FROM loaivanban WHERE maloai=\''.$this->dbcon->realEscapeString($maloai).'\'');
				if($result->num_rows){
					$row = $result->fetch_assoc();
					return new DocTypeInfo($row['maloai'], $row['tenloai'], $row['thoigianthem']);
				}else{
					throw new Exception('Không tồn tại mã loại văn bản ' . $maloai);
				}
			}catch(Exception $e){
				throw $e;
			}
		}
		public function getDonViBanHanh($madonvi){
			try{
				$result = $this->dbcon->query('SELECT * FROM donvibanhanh WHERE madonvi=\''.$this->dbcon->realEscapeString($madonvi).'\'');
				if($result->num_rows){
					$row = $result->fetch_assoc();
					return new IssuedUnitInfo($row['madonvi'], $row['tendonvi'], $row['benngoai'], $row['diachi'], $row['thoigianthem']);
				}else{
					throw new Exception('Không tồn tại đơn vị ban hành ' . $madonvi);
				}
			}catch(Exception $e){
				throw $e;
			}
		}
		public function getNhom($manhom){
			try{
				$result = $this->dbcon->query('SELECT * FROM nhom WHERE manhom=\''.$this->dbcon->realEscapeString($manhom).'\'');
				if($result->num_rows){
					$row = $result->fetch_assoc();
					return new GroupInfo($row['manhom'], $row['tennhom'], $row['thoigianthem']);
				}else{
					throw new Exception('Không tồn tại nhóm ' . $manhom);
				}
			}catch(Exception $e){
				throw $e;
			}
		}
		public function getDonVi($madonvi){
			try{
				$result = $this->dbcon->query('SELECT * FROM donvi WHERE madonvi=\''.$this->dbcon->realEscapeString($madonvi).'\'');
				if($result->num_rows){
					$row = $result->fetch_assoc();
					return new DepartmentInfo($row['madonvi'], $row['tendonvi'], $row['email'], $row['thoigianthem']);
				}else{
					throw new Exception('Không tồn tại đơn vị ' . $madonvi);
				}
			}catch(Exception $e){
				throw $e;
			}
		}
		public function countRecordsInTable($tablename){
			try{
				$result = $this->dbcon->query('SELECT COUNT(*) FROM ' . $tablename);
				return $result->fetch_row()[0];
			}catch(Exception $e){
				throw $e;
			}
		}
	}
?>