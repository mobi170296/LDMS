<?php
	class IssuedUnit{
		private $madonvi, $tendonvi, $benngoai, $diachi, $thoigianthem;
		public function __construct($madonvi, $tendonvi, $benngoai, $diachi, $thoigianthem=null){
			$this->madonvi = $madonvi;
			$this->tendonvi = $tendonvi;
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
	}
?>