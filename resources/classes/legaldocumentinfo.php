<?php
	class LagalDocumentInfo{
		private $id, $soden, $kyhieu, $thoigianden, $ngayvanban, $madonvibanhanh, $trichyeu, $nguoiky, $maloaivanban, $thoihangiaiquyet, $tentaptin, $trangthai, $idnguoinhap, $madonvi, $thoigianthem;
		public function __construct($id, $soden, $kyhieu, $thoigianden, $ngayvanban, $madonvibanhanh, $trichyeu, $nguoiky, $maloaivanban, $thoihangiaiquyet, $tentaptin, $trangthai, $idnguoinhap, $madonvi, $thoigianthem=null){
			$this->id = $id;
			$this->soden = $soden;
			$this->thoigianden = $thoigianden;
			$this->ngayvanban = $ngayvanban;
			$this->madonvibanhanh = $madonvibanhanh;
			$this->trichyeu = $trichyeu;
			$this->nguoiky = $nguoiky;
			$this->maloaivanban = $maloaivanban;
			$this->thoihangiaiquyet = $thoihangiaiquyet;
			$this->tentaptin = $tentaptin;
			$this->trangthai = $trangthai;
			$this->idnguoinhap = $idnguoinhap;
			$this->madonvi = $madonvi;
			$this->thoigianthem = $thoigianthem;
		}
		public function getID(){
			return $this->id;
		}
		public function getSoDen(){
			return $this->soden;
		}
		public function getKyHieu(){
			return $this->kyhieu;
		}
		#Thời gian công văn đến datetime được định dạng ở format: leading zero
		public function getThoiGianDen(){
			return $this->thoigianden;
		}
		#Ngày ghi ở công văn đến date format: leading zero
		public function getNgayVanBan(){
			return $this->ngayvanban;
		}
		# FOREIGN KEY donvibanhanh table
		public function getMaDonViBanHanh(){
			return $this->madonvibanhanh;
		}
		public function getTrichYeu(){
			return $this->trichyeu;
		}
		public function getNguoiKy(){
			return $this->nguoiky;
		}
		# FOREIGN KEY loaivanban table
		public function getMaLoaiVanBan(){
			return $this->maloaivanban;
		}
		# Thời hạn giải quyết văn bản đến nếu có
		public function getThoiHanGiaiQuyet(){
			return $this->thoihangiaiquyet;
		}
		# $_FILES[nameofitem][name]
		public function getTenTapTin(){
			return $this->tentaptin;
		}
		public function getTrangThai(){
			return $this->trangthai;
		}
		public function getIDNguoiNhap(){
			return $this->idnguoinhap;
		}
		public function getMaDonVi(){
			return $this->madonvi;
		}
		public function getThoiGianThem(){
			
		}
	}
?>