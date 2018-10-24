<?php
	class Censorship{
		public $idcongvan, $nguoikiemduyet, $ykienkiemduyet, $thoigiankiemduyet;
		public function __construct($idcongvan, $nguoikiemduyet, $ykiemkiemduyet, $thoigiankiemduyet, $thoigianthem=null){
			$this->idcongvan = $idcongvan;
			$this->nguoikiemduyet = $nguoikiemduyet;
			$this->ykienkiemduyet = $ykiemkiemduyet;
			$this->thoigiankiemduyet = $thoigiankiemduyet;
			$this->thoigianthem = $thoigianthem;
		}
		public function getIDCongVan(){
			return $this->idcongvan;
		}
		public function getNguoiKiemDuyet(){
			return $this->nguoikiemduyet;
		}
		public function getYKienKiemDuyet(){
			return $this->ykienkiemduyet;
		}
		public function getThoiGianKiemDuyet(){
			return $this->thoigiankiemduyet;
		}
		public function getThoiGianThem(){
			return $this->thoigianthem;
		}
	}
	class Approved{
		public $idcongvan, $nguoipheduyet, $ykienpheduyet, $thoigianpheduyet;
		public function __construct($idcongvan, $nguoipheduyet, $ykienpheduyet, $thoigianpheduyet, $thoigianthem){
			$this->idcongvan = $idcongvan;
			$this->nguoipheduyet = $nguoipheduyet;
			$this->ykienpheduyet = $ykienpheduyet;
			$this->thoigianpheduyet = $thoigianpheduyet;
			$this->thoigianthem = $thoigianthem;
		}
		public function getIDCongVan(){
			return $this->idcongvan;
		}
		public function getNguoiPheDuyet(){
			return $this->nguoipheduyet;
		}
		public function getYKienPheDuyet(){
			return $this->ykienpheduyet;
		}
		public function getThoiGianPheDuyet(){
			return $this->thoigianpheduyet;
		}
		public function getThoiGianThem(){
			return $this->thoigianthem;
		}
	}
	class LegalDocumentInfo{
		public $id, $soden, $kyhieu, $thoigianden, $ngayvanban, $madonvibanhanh, $trichyeu, $nguoiky, $maloaivanban, $thoihangiaiquyet, $tentaptin, $trangthai, $idnguoinhap, $madonvi, $thoigianthem;
		public $donvi, $donvibanhanh, $loaivanban, $nguoinhap, $kiemduyet, $pheduyet; 
		public function __construct($id, $soden, $kyhieu, $thoigianden, $ngayvanban, $madonvibanhanh, $trichyeu, $nguoiky, $maloaivanban, $thoihangiaiquyet, $tentaptin, $trangthai, $idnguoinhap, $madonvi, $thoigianthem=null){
			$this->id = $id;
			$this->soden = $soden;
			$this->kyhieu = $kyhieu;
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
			return $this->thoigianthem;
		}
		public function getDonVi(){
			return $this->donvi;
		}
		public function setDonVi($di){
			$this->donvi = $di;
		}
		public function getDonViBanHanh(){
			return $this->donvibanhanh;
		}
		public function setDonViBanHanh($ii){
			$this->donvibanhanh = $ii;
		}
		public function getLoaiVanBan(){
			return $this->loaivanban;
		}
		public function setLoaiVanBan($dti){
			$this->loaivanban = $dti;
		}
		public function getNguoiNhap(){
			return $this->nguoinhap;
		}
		public function setNguoiNhap($nguoinhap){
			$this->nguoinhap = $nguoinhap;
		}
		public function getKiemDuyet(){
			return $this->kiemduyet;
		}
		public function setKiemDuyet($kiemduyet){
			$this->kiemduyet = $kiemduyet;
		}
		public function getPheDuyet(){
			return $this->pheduyet;
		}
		public function setPheDuyet($pheduyet){
			$this->pheduyet = $pheduyet;
		}
		public function getTrangThaiString(){
			switch($this->trangthai){
				case LEGALDOCUMENT_STATUS['DA_NHAP']:
					return 'Đã nhập, chưa xử lý';
				case LEGALDOCUMENT_STATUS['DOI_KIEM_DUYET']:
					return 'Đã nhập, chưa xử lý';
				case LEGALDOCUMENT_STATUS['DA_PHE_DUYET']:
					return 'Đã nhập, chưa xử lý';
				case LEGALDOCUMENT_STATUS['DOI_PHE_DUYET']:
					return 'Đã nhập, chưa xử lý';
				case LEGALDOCUMENT_STATUS['DA_PHE_DUYET']:
					return 'Đã nhập, chưa xử lý';
			}
			return 'Không rõ trạng thái';
		}
	}
?>