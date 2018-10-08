<?php
	#namespace m\resources\classes;
	## Thuộc tính đặt tên theo lược đồ cơ sở dữ liệu
	$CNF['RUNNING'] = '';
	require_once(__DIR__.'/../../config/config.php');
	require_once $CNF['PATHS']['LIBRARY'] . '/database/mdatabase.php';
	require_once $CNF['PATHS']['LIBRARY'] . '/datetime/mdatetime.php';
	require_once $CNF['PATHS']['LIBRARY'] . '/collection/mset.php';
	
	require_once __DIR__ . '/userinfo.php';
	require_once __DIR__ . '/exceptions.php';
	class User{
		private $id, $maso, $matkhau, $ho, $ten, $ngaysinh, $email, $sodienthoai, $diachi, $madonvi, $manhom, $tinhtrang, $thoigianthem, $quyen, $dbcon;
		public function __construct($connection){
			$this->dbcon = $connection;
			$this->quyen = new MSet();
		}
		public function getDBConnection(){
			return $this->dbcon;
		}
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
				$result = $this->dbcon->startTransactionRW();
				if(!$result){
					$error = $this->dbcon->getError();
					throw new DatabaseErrorException($error);
				}
				
				$result = $this->dbcon->lockRow('SELECT * FROM nhom WHERE manhom=\''.$this->dbcon->realEscapeString($userinfo->getMaNhom()).'\'');
				if(!$result){
					$error = $this->dbcon->getError();
					$this->dbcon->rollback();
					throw new DatabaseErrorException($error);
				}
				if($result->num_rows==0){
					$this->dbcon->rollback();
					throw new NotExistedGroupException('Nhóm '.$userinfo->getMaNhom().' không tồn tại không thể thêm người dùng');
				}
				
				$result = $this->dbcon->lockRow('SELECT * FROM donvi WHERE madonvi=\''.$this->dbcon->realEscapeString($userinfo->getMaDonVi()).'\'');
				if(!$result){
					$error = $this->dbcon->getError();
					$this->dbcon->rollback();
					throw new DatabaseErrorException($error);
				}
				if($result->num_rows==0){
					$this->dbcon->rollback();
					throw new NotExistedGroupException('Đơn vị '.$userinfo->getMaDonVi().' không tồn tại không thể thêm người dùng');
				}
				
				$result = $this->dbcon->lockRow('SELECT * FROM nguoidung WHERE maso=\''.$this->dbcon->realEscapeString($userinfo->maso).'\'');
				if(!$result){
					$error = $this->dbcon->getError();
					$this->dbcon->rollback();
					throw new DatabaseErrorException($error);
				}
				if($result->num_rows>0){
					$row = $result->fetch_assoc();
					$fullname = $row['ho'] . ' ' . $row['ten'];
					$this->dbcon->rollback();
					throw new ExistedUserException('Mã số người dùng này đã tồn tại với tên '. $fullname. '. Xin vui lòng kiểm tra lại!');
				}else{
					$result = $this->dbcon->query('INSERT INTO nguoidung(maso, matkhau, ho, ten, ngaysinh, email, sodienthoai, diachi, madonvi, manhom) VALUES(\''.$this->dbcon->realEscapeString($userinfo->getMaSo()).'\', aes_encrypt(\''.$this->dbcon->realEscapeString($userinfo->getMatKhau()).'\', \''.DATABASE['AES_KEY'].'\'), \''.$this->dbcon->realEscapeString($userinfo->getHo()).'\', \''.$this->dbcon->realEscapeString($userinfo->getTen()).'\', \''.$this->dbcon->realEscapeString(MDateTime::parseDate($userinfo->getNgaySinh())->getDate('-')).'\', \''.$this->dbcon->realEscapeString($userinfo->getEmail()).'\', \''.$this->dbcon->realEscapeString($userinfo->getSoDienThoai()).'\', \''.$this->dbcon->realEscapeString(htmlentities($userinfo->getDiaChi())).'\', \''.$this->dbcon->realEscapeString($userinfo->getMaDonVi()).'\', \''.$this->dbcon->realEscapeString($userinfo->getMaNhom()).'\')');
					if(!$result){
						$error = $this->dbcon->getError();
						$this->dbcon->rollback();
						throw new DatabaseErrorException($error);
					}else{
						$result = $this->dbcon->commit();
						if(!$result){
							$error = $this->dbcon->getError();
							$this->dbcon->rollback();
							throw new DatabaseErrorException($error);
						}
					}
				}
			}else{
				throw new MissingPrivilegeException('Bạn không đủ quyền để thực hiện thao tác thêm người dùng!');
			}
		}
		public function suaNguoiDung($id, $userinfo){
			#data checked outside
			if($this->quyen->contain(PRIVILEGES['SUA_NGUOI_DUNG'])){
				$result = $this->dbcon->startTransactionRW();
				if(!$result){
					$error = $this->dbcon->getError();
					throw new DatabaseErrorException($error);
				}
				
				$result = $this->dbcon->lockRow('SELECT * FROM nhom WHERE manhom=\''.$this->dbcon->realEscapeString($userinfo->getMaNhom()).'\'');
				if(!$result){
					$error = $this->dbcon->getError();
					$this->dbcon->rollback();
					throw new DatabaseErrorException($error);
				}
				if($result->num_rows==0){
					$this->dbcon->rollback();
					throw new NotExistedGroupException('Nhóm '.$userinfo->getMaNhom().' không tồn tại không thể sửa thông tin người dùng');
				}
				
				$result = $this->dbcon->lockRow('SELECT * FROM donvi WHERE madonvi=\''.$this->dbcon->realEscapeString($userinfo->getMaDonVi()).'\'');
				if(!$result){
					$error = $this->dbcon->getError();
					$this->dbcon->rollback();
					throw new DatabaseErrorException($error);
				}
				if($result->num_rows==0){
					$this->dbcon->rollback();
					throw new NotExistedGroupException('Đơn vị '.$userinfo->getMaDonVi().' không tồn tại không thể sửa thông tin người dùng');
				}
				
				$result = $this->dbcon->lockRow('SELECT * FROM nguoidung WHERE id='.$id);
				if(!$result){
					$error = $this->dbcon->getError();
					$this->dbcon->rollback();
					throw new DatabaseErrorException($error);
				}
				
				if($result->num_rows){
					$sql = 'UPDATE nguoidung SET ';
					$sql .= 'matkhau=AES_ENCRYPT(\''.$this->dbcon->realEscapeString($userinfo->getMatKhau()).'\', \''.DATABASE['AES_KEY'].'\'),';
					$sql .= 'ho=\''.$userinfo->getHo().'\',';
					$sql .= 'ten=\''.$userinfo->getTen().'\',';
					$sql .= 'ngaysinh=\''.$userinfo->getNgaySinh().'\',';
					$sql .= 'email=\''.$userinfo->getEmail().'\',';
					$sql .= 'sodienthoai=\''.$userinfo->getSoDienThoai().'\',';
					$sql .= 'diachi=\''.$this->dbcon->realEscapeString(htmlentities($userinfo->getDiaChi())).'\',';
					$sql .= 'madonvi=\''.$userinfo->getMaDonVi().'\',';
					$sql .= 'manhom=\''.$userinfo->getMaNhom().'\',';
					$sql .= 'tinhtrang='.$userinfo->getTinhTrang(). ' WHERE id='.$id;
					$result = $this->dbcon->query($sql);
					if($result){
						$result = $this->dbcon->commit();
						if(!$result){
							$error = $this->dbcon->getError();
							$this->dbcon->rollback();
							throw new DatabaseErrorException($error);
						}
					}else{
						$error = $this->dbcon->getError();
						$this->dbcon->rollback();
						throw new DatabaseErrorException($error);
					}
				}else{
					$this->dbcon->rollback();
					throw new NotExistedUserException('ID người dùng không tồn tại!');
				}
			}else{
				throw new MissingPrivilegeException('Bạn không đủ quyền để thực hiện thao tác sửa thông tin người dùng!');
			}
		}
		public function xoaNguoiDung($id){
			#data checked outside
			if($this->quyen->contain(PRIVILEGES['XOA_NGUOI_DUNG'])){
				$result = $this->dbcon->query('SELECT * FROM nguoidung WHERE id='.$id);
				if(!$result){
					throw new DatabaseErrorException($this->dbcon->getError());
				}
				
				if($result->num_rows){
					$result = $this->dbcon->query('SELECT EXISTS(SELECT id FROM congvanden WHERE idnguoinhap='.$id.')');
					if(!$result){
						throw new DatabaseErrorException($this->dbcon->getError());
					}
					$row = $result->fetch_row();
					if($row[0]){
						throw new ExistedLegalDocumentException('Đã tồn tại công văn do người này nhập không thể xóa người dùng này được!');
					}else{
						$result = $this->dbcon->query('DELETE FROM nguoidung WHERE id='.$id);
						if(!$result){
							throw new DatabaseErrorException($this->dbcon->getError());
						}
					}
				}else{
					throw new NotExistedUserException('Người dùng không tồn tại không thể thực hiện thao tác xóa!');
				}
			}else{
				throw new MissingPrivilegeException('Bạn không đủ quyền để thực hiện thao tác xóa người dùng!');
			}
		}
		public function capQuyenNguoiDung($id, $quyen){
			if(!$this->quyen->contain(PRIVILEGES['CAP_QUYEN']))
		}
		#
		# Quản lý nhóm người dùng
		#
		public function themNhomNguoiDung($groupinfo){
			if($this->quyen->contain(PRIVILEGES['THEM_NHOM'])){
				$result = $this->dbcon->query('SELECT * FROM nhom WHERE manhom=\''.$groupinfo->getMaNhom().'\'');
				if(!$result){
					throw new DatabaseErrorException($this->dbcon->getError());
				}
				
				if($result->num_rows){
					throw new ExistedGroupException('Nhóm người dùng \''. $groupinfo->getMaNhom(). '\' đã tồn tại!');
				}else{
					$result = $this->dbcon->query('INSERT INTO nhom(manhom, tennhom) VALUES(\''.$groupinfo->getMaNhom().'\', \''.$groupinfo->getTenNhom().'\')');
					if(!$result){
						throw new DatabaseErrorException($this->dbcon->getError());
					}
				}
			}else{
				throw new MissingPrivilegeException('Bạn không có quyền thêm nhóm người dùng');
			}
		}
		public function suaNhomNguoiDung($manhom, $groupinfo){
			if(!$this->quyen->contain(PRIVILEGES['SUA_NHOM'])){
				throw new MissingPrivilegeException('Bạn không có quyền sửa nhóm người dùng');
			}
			$result = $this->dbcon->query('SELECT * FROM nhom WHERE manhom=\''.$manhom.'\'');
			if(!$result){
				throw new DatabaseErrorException($this->dbcon->getError());
			}
			if($result->num_rows){
				$result = $this->query('UPDATE nhom SET manhom=\''.$groupinfo->getMaNhom().'\', tennhom=\''.$groupinfo->getTenNhom().'\' WHERE manhom=\''.$manhom.'\'');
				if(!$result){
					throw new DatabaseErrorException($this->dbcon->getError());
				}
			}else{
				throw new NotExistGroupException('Nhóm người dùng không tồn tại không thể thực hiện thao tác sửa thông tin nhóm');
			}
		}
		public function xoaNhomNguoiDung($manhom){
			if(!$this->contain(PRIVILEGES['XOA_NHOM'])){
				throw new MissingPrivilegeException('Bạn không có quyền xóa nhóm người dùng');
			}
			$result = $this->dbcon->query('SELECT * FROM nhom WHERE manhom=\''.$manhom.'\'');
			if(!$result){
				throw new DatabaseErrorException($this->dbcon->getError());
			}
			$result = $this->dbcon->query('SELECT EXISTS(SELECT id FROM nguoidung WHERE manhom=\''.$manhom.'\')');
			if(!$result){
				throw new DatabaseErrorException($this->dbcon->getError());
			}
			$row = $result->fetch_row();
			if($row[0]){
				throw new ExistedUserException('Đã có người dùng thuộc nhóm này không thể xóa nhóm');
			}else{
				$result = $this->dbcon->query('DELETE FROM nhom WHERE manhom=\''.$manhom.'\'');
				if(!$result){
					throw new DatabaseErrorException($this->dbcon->getError());
				}
			}
		}
		
		#
		# Quản lý đơn vị
		#
		public function themDonVi($departmentinfo){
			if($this->quyen->contain(PRIVILEGES['THEM_DON_VI'])){
				$result = $this->dbcon->startTransactionRW();
				if(!$result){
					$error = $this->dbcon->getError();
					throw new DatabaseErrorException($error);
				}
				
				$result = $this->dbcon->lockRow('SELECT * FROM nguoidung WHERE madonvi=\''.$departmentinfo->getMaDonVi().'\'');
				if(!$result){
					$error = $this->dbcon->getError();
					$this->dbcon->rollback();
					throw new DatabaseErrorException($error);
				}
				
				if($result->num_rows){
					$this->dbcon->rollback();
					throw new ExistedDepartmentException('Đơn vị '. $departmentinfo->getMaDonVi(). ' đã tồn tại!');
				}else{
					$result = $this->dbcon->query('INSERT INTO donvi(madonvi, tendonvi) VALUES(\''.$departmentinfo->getMaDonVi().'\', \''.$departmentinfo->getTenDonVi().'\')');
					if(!$result){
						$error = $this->dbcon->getError();
						$this->dbcon->rollback();
						throw new DatabaseErrorException($error);
					}
					
					$result = $this->dbcon->commit();
					if(!$result){
						$error = $this->dbcon->getError();
						$this->dbcon->rollback();
						throw new DatabaseErrorException($error);
					}
				}
			}else{
				throw new MissingPrivilegeException('Bạn không có quyền thực hiện thao tác thêm đơn vị!');
			}
		}
		public function suaDonVi($madonvi, $departmentinfo){
			if($this->quyen->contain(PRIVILEGES['SUA_DON_VI'])){
				$result = $this->dbcon->startTransactionRW();
				if(!$result){
					$error = $this->dbcon->getError();
					#Không cần rollback vì start transaction read write not working
					throw new DatabaseErrorException($error);
				}
				
				$result = $this->dbcon->lockRow('SELECT * FROM donvi WHERE id=\''.$madonvi.'\'');
				if(!$result){
					$error = $this->dbcon->getError();
					$this->dbcon->rollback();
					throw new DatabaseErrorException($error);
				}
				if($result->num_rows){
					$result = $this->dbcon->lockRow('SELECT * FROM donvi WHERE id=\''.$departmentinfo->getMaDonVi().'\'');
					if(!$result){
						$error = $this->dbcon->getError();
						$this->dbcon->rollback();
						throw new DatabaseErrorException($error);
					}
					if($result->num_rows){
						$this->rollback();
						throw new ExistedDepartmentException('Mã đơn vị bạn định chuyển đổi sang '. $departmentinfo->getMaDonVi().' đã tồn tại rồi!');
					}
					$result = $this->dbcon->query('UPDATE donvi SET madonvi=\''.$departmentinfo->getMaDonVi().'\', tendonvi=\''.$departmentinfo->getTenDonVi().'\' WHERE madonvi=\''.$madonvi.'\'');
					if(!$result){
						$error = $this->dbcon->getError();
						$this->dbcon->rollback();
						throw new DatabaseErrorException($error);
					}
					$result = $this->dbcon->commit();
					if(!$result){
						$error = $this->dbcon->getError();
						$this->dbcon->rollback();
						throw new DatabaseErrorException($error);
					}
				}else{
					$this->dbcon->rollback();
					throw new NotExistedDepartmentException('Đơn vị này không tồn tại không thể thực hiện tao tác sửa thông tin đơn vị!');
				}
			}else{
				throw new MissingPrivilegeException('Bạn không có quyền sửa thông tin đơn vị!');
			}
		}
		public function xoaDonVi($madonvi){
			if($this->quyen->contain(PRIVILEGES['XOA_DON_VI'])){
				$result = $this->dbcon->query('SELECT * FROM donvi WHERE madonvi=\''.$madonvi.'\'');
				if(!$result){
					$error = $this->dbcon->getError();
					throw new DatabaseErrorException($error);
				}
				if($result->num_rows){
					$result = $this->dbcon->query('SELECT EXISTS(SELECT id FROM nguoidung WHERE madonvi=\''.$madonvi.'\')');
					if(!$result){
						$error = $this->dbcon->getError();
						throw new DatabaseErrorException($error);
					}
					$row = $result->fetch_row();
					if($row[0]){
						throw new ExistedUserException('Người dùng ở đơn vị \''. $madonvi .'\' này đã có không thể xóa đơn vị này!');
					}else{
						$result = $this->dbcon->query('DELETE FROM donvi WHERE madonvi=\''.$madonvi.'\'');
						if(!$result){
							throw new DatabaseErrorException($this->dbcon->getError());
						}
					}
				}else{
					throw new NotExistedDepartmentException('Đơn vị \''. $madonvi. '\' không tồn tại không thể xóa');
				}
			}else{
				throw new MissingPrivilegeException('Bạn không đủ quyền để thực hiện chức năng xóa người dùng!');
			}
		}
		#
		# Danh mục loại văn bản
		#
		public function themLoaiVanBan($doctypeinfo){
			if(!$this->quyen->contain(PRIVILEGES['THEM_LOAI_VAN_BAN'])){
				throw new MissingPrivilegeException('Bạn không có quyền thực hiện thao tác thêm loại công văn');
			}
			$result = $this->dbcon->query('SELECT * FROM loaivanban WHERE maloai=\''.$doctypeinfo->getMaLoai().'\'');
			if(!$result){
				throw new DatabaseErrorException($this->dbcon->getError());
			}
			if($result->num_rows){
				throw new ExistedDocTypeException('Loại công văn \''.$doctypeinfo->getMaLoai().'\' đã tồn tại không thể thêm!');
			}else{
				$result = $this->dbcon->query('INSERT INTO loaivanban(maloai, tenloai) VALUES(\''.$doctypeinfo->getMaLoai().'\', \''.$doctypeinfo->getTenLoai().'\')');
				if(!$result){
					throw new DatabaseErrorException($this->dbcon->getError());
				}
			}
		}
		public function suaLoaiVanBan($maloai, $doctypeinfo){
			if(!$this->quyen->contain(PRIVILEGES['SUA_LOAI_VAN_BAN'])){
				throw new MissingPrivilegeException('Bạn không có quyền sửa loại công văn');
			}
			$result = $this->dbcon->query('SELECT * FROM loaivanban WHERE maloai=\''.$maloai.'\'');
			if(!$result){
				throw new DatabaseErrorException($this->dbcon->getError());
			}
			if($result->num_rows){
				$result = $this->dbcon->query('SELECT * FROM loaivanban WHERE maloai=\''.$doctypeinfo->getMaLoai().'\'');
				if(!$result){
					throw new DatabaseErrorException($this->dbcon->getError());
				}
				if($result->num_rows){
					throw new ExistedDocTypeException('Loại văn bản \''.$doctypeinfo->getMaLoai().'\' đã tồn tại không thể sửa loại văn bản!');
				}
				$result = $this->dbcon->query('UPDATE loaivanban SET maloai=\''.$doctypeinfo->getMaLoai().'\', tenloai=\''.$doctypeinfo->getTenLoai().'\' WHEER maloai=\''.$maloai.'\'');
				if(!$result){
					throw new DatabaseErrorException($this->dbcon->getError());
				}
			}else{
				throw new NotExistedDocTypeException('Loại văn bản \''.$maloai.'\' không tồn tại không thể sửa thông tin');
			}
		}
		public function xoaLoaiVanBan($maloai){
			if(!$this->quyen->contain(PRIVILEGES['XOA_LOAI_VAN_BAN'])){
				throw new MissingPrivilegeException('Bạn không có quyền xóa loại văn bản');
			}
			$result = $this->dbcon->query('SELECT * FROM loaivanban WHERE maloai=\''.$maloai.'\'');
			if(!$result){
				throw new DatabaseErrorException($this->dbcon->getError());
			}
			if($result->num_rows){
				$result = $this->dbcon->query('SELECT EXISTS(SELECT id FROM congvanden WHERE maloaivanban=\''.$maloai.'\')');
				if(!$result){
					throw new DatabaseErrorException($this->dbcon->getError());
				}
				$row = $result->fetch_row();
				if($row[0]){
					throw new ExistedLegalDocumentException('Đã có công văn có mã loại văn bản này, bạn không thể xóa mã loại này!');
				}else{
					$result = $this->dbcon->query('DELETE FROM loaivanban WHERE maloai=\''.$maloai.'\'');
					if(!$result){
						throw new DatabaseErrorException($this->dbcon->getError());
					}
				}
			}else{
				throw new NotExistedDocTypeException('Loại văn bản \''.$maloai.'\' không tồn tại không thể thực hiện thao tác xóa');
			}
		}
		
		#
		# Danh mục đơn vị ban hành
		#
		public function themDonViBanHanh($issuedunit){
			if(!$this->quyen->contain(PRIVILEGES['THEM_DON_VI_BAN_HANH'])){
				throw new MissingPrivilegeException('Bạn không có quyền thêm đơn vị ban hành!');
			}
			
			$result = $this->dbcon->query('SELECT * FROM donvibanhanh WHERE madonvi=\''.$issuedunit->getMaDonVi().'\'');
			if(!$result){
				throw new DatabaseErrorException($this->dbcon->getError());
			}
			if($result->num_rows){
				throw new ExistedIssuedUnit('Đơn vị ban hành \''.$issuedunit->getMaDonVi().'\' không thể thêm');
			}else{
				$result = $this->dbcon->query('INSERT INTO donvibanhanh(madonvi, tendonvi, benngoai, diachi) VALUES(\''.$issuedunit->getMaDonVi().'\', \''.$issuedunit->getTenDonVi().'\', '.$issuedunit->getBenNgoai().', \''.$issuedunit->getDiaChi().'\')');
				if(!$result){
					throw new DatabaseErrorException($this->dbcon->getError());
				}
			}
		}
		public function suaDonViBanHanh($madonvi, $issuedunit){
			if(!$this->quyen->contain(PRIVILEGES['SUA_DON_VI_BAN_HANH'])){
				throw new MissingPrivilegeException('Bạn không có quyền thực hiện sửa đơn vị ban hành');
			}
			$result = $this->dbcon->query('SELECT * FROM donvibanhanh WHERE madonvi=\''.$madonvi.'\'');
			if(!$result){
				throw new DatabaseErrorException($this->dbcon->getError());
			}
			if($result->num_rows){
				$result = $this->dbcon->query('SELECT * FROM donvibanhanh WHERE madonvi=\''.$issuedunit->getMaDonVi().'\'');
				if(!$result){
					throw new DatabaseErrorException($this->dbcon->getError());
				}
				if($result->num_rows){
					throw new ExistedIssuedUnit('Đơn vị ban hành \''.$issuedunit->getMaDonVi().'\' đã tồn tại không thể sửa thông tin đơn vị');
				}
				$result = $this->dbcon->query('UPDATE donvibanhanh SET madonvi=\''.$issuedunit->getMaDonVi().'\', tendonvi=\''.$issuedunit->getTenDonVi().'\', benngoai='.$issuedunit->getBenNgoai().', diachi=\'\' WHERE madonvi=\''.$madonvi.'\'');
				if(!$result){
					throw new DatabaseErrorException($this->dbcon->getError());
				}
			}else{
				throw new NotExistedIssuedUnit('Đơn vị ban hành không tồn tại không thể sửa thông tin');
			}
		}
		public function xoaDonViBanHanh($madonvi){
			if(!$this->quyen->contain(PRIVILEGES['XOA_DON_VI_BAN_HANH'])){
				throw new MissingPrivilegeException('Bạn không có quyền xóa đơn vị ban hành');
			}
			$result = $this->dbcon->query('SELECT * FROM donvibanhanh WHERE madonvi=\''.$madonvi.'\'');
			if(!$result){
				throw new DatabaseErrorException($this->dbcon->getError());
			}
			if($result->num_rows){
				$result = $this->dbcon->query('SELECT EXISTS(SELECT * FROM congvanden WHERE madonvibanhanh=\''.$madonvi.'\')');
				if(!$result){
					throw new DatabaseErrorException($this->dbcon->getError());
				}
				$row = $result->fetch_row();
				if($row[0]){
					throw new ExistedLegalDocumentException('Đã có công văn của đơn vị ban hành này không thể thực hiện thao tác xóa đơn vị ban hành này được!');
				}else{
					$result = $this->dbcon->query('DELETE FROM donvibanhanh WHERE madonvi=\''.$madonvi.'\'');
					if(!$result){
						throw new DatabaseErrorException($this->dbcon->getError());
					}
				}
			}else{
				throw new NotExistedIssuedUnit('Đơn vị bàn hành \''.$madonvi.'\' không tồn tại không thể xóa!');
			}
		}
		
		#
		# Quản lý công văn đến
		# ~ danh mục người dùng
		# ~ danh mục đơn vị ban hành
		# ~ danh mục loại văn bản
		#
		
		public function themCongVanDen($docinfo){
			if(!$this->quyen->contain(PRIVILEGES['THEM_CONG_VAN'])){
				throw new MissingPrivilegeException('Bạn không có quyền thêm công văn đến!');
			}
			$error = '';
			$result = $this->dbcon->query('SELECT * FROM donvibanhanh WHERE madonvi=\''.$docinfo->getMaDonViBanHanh().'\'');
			if(!$result){
				throw new DatabaseErrorException($this->dbcon->getError);
			}
			if($result->num_rows==0){
				$error .= 'Đơn vị ban hành văn bản không tồn tại!';
			}
			
			$result = $this->dbcon->query('SELECT * FROM loaivanban WHERE maloai=\''.$docinfo->getMaLoaiVanBan().'\'');
			if(!$result){
				throw new DatabaseErrorException($this->dbcon->getError);
			}
			if($result->num_rows==0){
				$error .= 'Loại văn bản không tồn tại!';
			}
			
			$result = $this->dbcon->query('SELECT * FROM congvanden WHERE soden='.$docinfo->getSoDen(). ' and year(thoigianden)=year(cast(\''.$docinfo->getThoiGianDen().'\' as datetime))');
			if(!$result){
				throw new DatabaseErrorException($this->dbcon->getError);
			}
			if($result->num_rows){
				$error .= 'Số đến công văn này đã có trong năm nay!';
			}
			
			if($error == ''){
				$sql = <<<SQL
				INSERT INTO congvanden(soden, kyhieu, thoigianden, ngayvanban, madonvibanhanh, trichyeu, nguoiky, maloaivanban, thoihangiaiquyet, tentaptin, trangthai, idnguoinhap) VALUES
				({$docinfo->getSoDen()}, {$docinfo->getKyHieu()}, {$docinfo->getThoiGianDen()}, {$docinfo->getNgayVanBan()}, {$docinfo->getMaDonViBanHanh()}, {$docinfo->getTrichYeu()}, {$docinfo->getNguoiKy()}, {$docinfo->getMaLoaiVanBan()}, {$docinfo->getThoiHanGiaiQuyet()}, {$docinfo->getTenTapTin()}, {$docinfo->getTrangThai()}, {$docinfo->getIDNguoiNhap()}
SQL;
			}else{
				throw new MultipleErrorException($error);
			}
		}
		public function suaCongVanDen(){
			
		}
		public function xoaCongVanDen(){
			
		}
		
		#
		# Quản lý người dùng
		#
		#
		public function getNguoiDung($id){
			$thongtinnguoidung = null;
			return $thongtinnguoidung;
		}
	}
?>