<?php
	class DepartmentInfo{
		private $madonvi, $tendonvi, $email, $thoigianthem;
		public function __construct($madonvi, $tendonvi, $email, $thoigianthem=null){
			$this->madonvi = $madonvi;
			$this->tendonvi = $tendonvi;
			$this->email = $email;
			$this->thoigianthem = $thoigianthem;
		}
		public function getMaDonVi(){
			return $this->madonvi;
		}
		public function getTenDonVi(){
			return $this->tendonvi;
		}
		public function getEmail(){
			return $this->email;
		}
		public function getThoiGianThem(){
			return $this->thoigianthem;
		}
	}
?>