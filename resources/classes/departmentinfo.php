<?php
	class DepartmentInfo{
		private $madonvi, $tendonvi, $thoigianthem;
		public function __construct($madonvi, $tendonvi, $thoigianthem=null){
			$this->madonvi = $madonvi;
			$this->tendonvi = $tendonvi;
			$this->thoigianthem = $thoigianthem;
		}
		public function getMaDonVi(){
			return $this->madonvi;
		}
		public function getTenDonVi(){
			return $this->tendonvi;
		}
		public function getThoiGianThem(){
			return $this->thoigianthem;
		}
	}
?>