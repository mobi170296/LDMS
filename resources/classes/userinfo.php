<?php
	require_once(__DIR__ . '/../library/datetime/mdatetime.php');
	class UserInfo{
		public $id, $maso, $matkhau, $ho, $ten, $ngaysinh, $email, $sodienthoai, $diachi, $madonvi, $manhom, $tinhtrang, $quyen, $thoigianthem;
		public $donvi;
		public function __construct($id, $maso, $matkhau, $ho, $ten, $ngaysinh, $email, $sodienthoai, $diachi, $madonvi, $manhom, $tinhtrang, $thoigianthem=null){
			$this->id = $id;
			$this->maso = $maso;
			$this->matkhau = $matkhau;
			$this->ho = $ho;
			$this->ten = $ten;
			$this->ngaysinh = $ngaysinh;
			$this->email = $email;
			$this->sodienthoai = $sodienthoai;
			$this->diachi = $diachi;
			$this->madonvi = $madonvi;
			$this->manhom = $manhom;
			$this->tinhtrang = $tinhtrang;
			$this->thoigianthem = $thoigianthem;
		}
		public function getID(){
			return $this->id;
		}
		public function getMaSo(){
			return $this->maso;
		}
		public function getMatKhau(){
			return $this->matkhau;
		}
		public function getHo(){
			return $this->ho;
		}
		public function getTen(){
			return $this->ten;
		}
		public function getFullName(){
			return $this->ho . ' ' . $this->ten;
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
			return $this->sodienthoai;
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
		public function getQuyen(){
			return $this->quyen;
		}
		public function setQuyen($quyen){
			$this->quyen = $quyen;
		}
		public function setDonVi($d){
			$this->donvi = $d;
		}
		public function getDonVi(){
			return $this->donvi;
		}
		public function getThoiGianThem(){
			return $this->thoigianthem;
		}
	}
?>