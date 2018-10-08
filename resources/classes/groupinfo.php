<?php
	class GroupInfo{
		private $manhom, $tennhom, $thoigianthem;
		public function __construct($manhom, $tennhom, $thoigianthem=null){
			$this->manhom = $manhom;
			$this->tennhom = $tennhom;
			$this->thoigianthem = $thoigianthem;
		}
		public function getMaNhom(){
			return $this->manhom;
		}
		public function getTenNhom(){
			return $this->tennhom;
		}
	}
?>