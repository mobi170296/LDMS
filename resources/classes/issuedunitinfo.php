<?php
	class IssuedUnitInfo{
		private $madonvi, $tendonvi, $benngoai, $diachi, $thoigianthem;
		public function __construct($madonvi, $tendonvi, $email, $sodienthoai, $benngoai, $diachi, $thoigianthem=null){
			$this->madonvi = $madonvi;
			$this->tendonvi = $tendonvi;
			$this->email = $email;
			$this->sodienthoai = $sodienthoai;
			$this->benngoai = $benngoai;
			$this->diachi = $diachi;
			$this->thoigianthem = $thoigianthem;
		}
		public function getMaDonVi(){
			return $this->madonvi;
		}
		public function getTenDonVi(){
			return $this->tendonvi;
		}
		public function getBenNgoai(){
			return $this->benngoai;
		}
		public function getDiaChi(){
			return $this->diachi;
		}
		public function getThoiGianThem(){
			return $this->thoigianthem;
		}
		public function getEmail(){
			return $this->email;
		}
		public function getSoDienThoai(){
			return $this->sodienthoai;
		}
	}
?>