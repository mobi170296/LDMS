<?php
	class GroupInfo{
		private $manhom, $tennhom, $thoigianthem, $quyen;
		public function __construct($manhom, $tennhom, $thoigianthem=null, $quyen=null){
			$this->manhom = $manhom;
			$this->tennhom = $tennhom;
			$this->thoigianthem = $thoigianthem;
			$this->quyen = $quyen;
		}
		public function getMaNhom(){
			return $this->manhom;
		}
		public function getTenNhom(){
			return $this->tennhom;
		}
		public function getThoiGianThem(){
			return $this->thoigianthem;
		}
		public function getQuyen(){
			return $this->quyen;
		}
		public function setQuyen($quyen){
			$this->quyen = $quyen;
		}
	}
?>