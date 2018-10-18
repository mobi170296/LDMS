<?php
	class DocTypeInfo{
		private $maloai, $tenloai, $thoigianthem;
		public function __construct($maloai, $tenloai, $thoigianthem=null){
			$this->maloai = $maloai;
			$this->tenloai = $tenloai;
			$this->thoigianthem = $thoigianthem;
		}
		public function getMaLoai(){
			return $this->maloai;
		}
		public function getTenLoai(){
			return $this->tenloai;
		}
	}
?>