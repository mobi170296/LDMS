-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 17, 2018 at 10:48 AM
-- Server version: 8.0.12
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ldmsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `congvanden`
--

CREATE TABLE `congvanden` (
  `id` int(10) UNSIGNED NOT NULL,
  `soden` int(10) UNSIGNED NOT NULL,
  `kyhieu` varchar(20) NOT NULL,
  `thoigianden` datetime NOT NULL,
  `ngayvanban` date NOT NULL,
  `madonvibanhanh` varchar(10) NOT NULL,
  `trichyeu` varchar(200) NOT NULL,
  `nguoiky` varchar(50) NOT NULL,
  `maloaivanban` varchar(10) NOT NULL,
  `thoihangiaiquyet` date DEFAULT NULL,
  `tentaptin` varchar(256) NOT NULL,
  `trangthai` tinyint(4) NOT NULL,
  `idnguoinhap` int(10) UNSIGNED NOT NULL,
  `madonvi` varchar(10) NOT NULL,
  `thoigianthem` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `congvanden`
--

INSERT INTO `congvanden` (`id`, `soden`, `kyhieu`, `thoigianden`, `ngayvanban`, `madonvibanhanh`, `trichyeu`, `nguoiky`, `maloaivanban`, `thoihangiaiquyet`, `tentaptin`, `trangthai`, `idnguoinhap`, `madonvi`, `thoigianthem`) VALUES
(1, 1, '35/STTTT', '2016-01-13 00:00:00', '2016-01-12', 'DV_STTTT', 'VV chuyển văn bản lý thông tin báo Dân trí phản ánh', 'Nguyễn Bá Hảo', 'VB_QD', NULL, '', 0, 2, 'DV_KCNTT', '2018-10-02 20:11:04'),
(2, 2, '2327/BTCTU', '2018-07-17 00:00:00', '2018-07-20', 'DV_SGD', 'Cán bộ đi nước ngoài', 'Lê Thành Trung', 'VB_CV', NULL, '', 0, 6, 'DV_KCNTT', '2018-10-02 20:11:04');

-- --------------------------------------------------------

--
-- Table structure for table `donvi`
--

CREATE TABLE `donvi` (
  `madonvi` varchar(10) NOT NULL,
  `tendonvi` varchar(100) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `thoigianthem` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `donvi`
--

INSERT INTO `donvi` (`madonvi`, `tendonvi`, `email`, `thoigianthem`) VALUES
('DV_KCNTT', 'Khoa Công nghệ thông tin và Truyền thông', 'dv_kcntt@gmail.com', '2018-10-02 20:11:04'),
('DV_KCT', 'Khoa Chính Trị', 'dv_kct@gmail.com', '2018-10-02 20:11:04'),
('DV_KL', 'Khoa Luật', 'dv_kl@gmail.com', '2018-10-02 20:11:04'),
('DV_KNN', 'Khoa Nông nghiệp', 'dv_knn@gmail.com', '2018-10-02 20:11:04'),
('DV_PCTSV', 'Phòng Công tác sinh viên', 'dv_pctsv@gmail.com', '2018-10-02 20:11:04'),
('DV_PKHTH', 'Phòng Kế hoạch Tổng hợp', 'dv_pkhth@gmail.com', '2018-10-02 20:11:04'),
('DV_PTC', 'Phòng Tài Chính', 'dv_ptc@gmail.com', '2018-10-02 20:11:04');

-- --------------------------------------------------------

--
-- Table structure for table `donvibanhanh`
--

CREATE TABLE `donvibanhanh` (
  `madonvi` varchar(10) NOT NULL,
  `tendonvi` varchar(100) NOT NULL,
  `benngoai` tinyint(4) NOT NULL,
  `diachi` varchar(100) NOT NULL,
  `thoigianthem` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `donvibanhanh`
--

INSERT INTO `donvibanhanh` (`madonvi`, `tendonvi`, `benngoai`, `diachi`, `thoigianthem`) VALUES
('DV_ABC', 'Công ty ABC', 1, 'Bến Nghé TP. Hồ Chí Minh', '2018-10-02 20:11:04'),
('DV_PDT', 'Phòng Đào Tạo', 0, 'Đại Học Cần Thơ, Đường 3/2, Phường Xuân Khánh, Quận Ninh Kiều, TP.Cần Thơ', '2018-10-02 20:11:04'),
('DV_SGD', 'Sở Giáo Dục', 1, 'Phường Xuân Khánh, Quận Ninh Kiều, TP. Cần Thơ', '2018-10-02 20:11:04'),
('DV_SKHCN', 'Sở Khoa học công nghệ', 1, 'Phường An Khánh, Quận Ninh Kiều, TP.Cần Thơ', '2018-10-02 20:11:04'),
('DV_STTTT', 'Sở Thông Tin và Truyền Thông', 1, 'Cần Thơ', '2018-10-02 20:11:04');

-- --------------------------------------------------------

--
-- Table structure for table `kiemduyet`
--

CREATE TABLE `kiemduyet` (
  `idcongvanden` int(10) UNSIGNED NOT NULL,
  `idnguoikiemduyet` int(10) UNSIGNED NOT NULL,
  `ykienkiemduyet` varchar(200) DEFAULT NULL,
  `thoigiankiemduyet` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `loaivanban`
--

CREATE TABLE `loaivanban` (
  `maloai` varchar(10) NOT NULL,
  `tenloai` varchar(50) NOT NULL,
  `thoigianthem` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loaivanban`
--

INSERT INTO `loaivanban` (`maloai`, `tenloai`, `thoigianthem`) VALUES
('VB_CV', 'Công Văn', '2018-10-02 20:11:04'),
('VB_ND', 'Nghị Định', '2018-10-02 20:11:04'),
('VB_QD', 'Quyết Định', '2018-10-02 20:11:04'),
('VB_TB', 'Thông Báo', '2018-10-02 20:11:04'),
('VB_TT', 'Thông Tư', '2018-10-02 20:11:04');

-- --------------------------------------------------------

--
-- Table structure for table `nguoidung`
--

CREATE TABLE `nguoidung` (
  `id` int(10) UNSIGNED NOT NULL,
  `maso` varchar(10) NOT NULL,
  `matkhau` blob NOT NULL,
  `ho` varchar(40) DEFAULT NULL,
  `ten` varchar(20) NOT NULL,
  `ngaysinh` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `sodienthoai` varchar(12) NOT NULL,
  `diachi` varchar(100) NOT NULL,
  `madonvi` varchar(10) NOT NULL,
  `manhom` varchar(10) NOT NULL,
  `tinhtrang` tinyint(4) NOT NULL DEFAULT '1',
  `thoigianthem` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nguoidung`
--

INSERT INTO `nguoidung` (`id`, `maso`, `matkhau`, `ho`, `ten`, `ngaysinh`, `email`, `sodienthoai`, `diachi`, `madonvi`, `manhom`, `tinhtrang`, `thoigianthem`) VALUES
(1, '20000111', 0xb473f39d45a2f21ab12ff420aaf0783e, 'Vũ Ngọc', 'Huỳnh', '1976-08-17', 'vungochuynh@gmail.com', '01689923263', 'Hà Nội', 'DV_PTC', 'N_BGH', 1, '2018-10-02 20:11:04'),
(2, '20010915', 0x2b0c5dbcfdc0eb04a37e310366ddb5ad, 'Vũ Thế', 'Phong', '1978-11-09', 'vuthephong@gmail.com', '01676921113', 'An Giang', 'DV_PKHTH', 'N_KHTH', 1, '2018-10-02 20:11:04'),
(3, '20020110', 0x28bf4b3b27a3e957e70493cb4828f608, 'Trần Xuân', 'Vương', '1978-11-09', 'tranxuanphuong@gmail.com', '0974013804', 'Hồ Chí Minh', 'DV_PTC', 'N_TDV', 1, '2018-10-02 20:11:04'),
(4, '19900109', 0xf76411fe12945a8db00b09999f9f70d4, 'Trần Thị', 'Nga', '1979-02-03', 'tranthinga@gmail.com', '0983838361', 'Đồng Tháp', 'DV_PTC', 'N_TDV', 1, '2018-10-02 20:11:04'),
(5, '20070109', 0x7512af3aa669fd0354a2db3967046c45, 'Phạm Thị', 'Hoài', '1970-12-04', 'phamthihoai@gmail.com', '0975539459', 'Hà Nội', 'DV_PTC', 'N_TDV', 1, '2018-10-02 20:11:04'),
(6, '19840109', 0x47c8ce503d8ef6a224e25e0e282c9870, 'Mai Quốc', 'Việt', '1957-10-10', 'maiquocviet@gmail.com', '0938598361', 'Tây Nguyên', 'DV_PKHTH', 'N_KHTH', 1, '2018-10-02 20:11:04'),
(7, '19950109', 0xf6e3e8f6ea4c76cedd17a367fab607f6, 'Hoàng Thị', 'Xuyến', '1974-12-21', 'hoangthixuyen@gmail.com', '0983838361', 'Hà Nội', 'DV_PTC', 'N_KHTH', 1, '2018-10-02 20:11:04'),
(9, '19960217', 0x8798e39ff2cf00e94193f9561e9915a5, 'Trịnh Văn', 'Linh', '2019-02-17', 'mobi170296@gmail.com', '01215759696', 'Đồng Tháp', 'DV_PKHTH', 'N_KHTH', 1, '2018-10-05 16:07:49'),
(10, '20181015', 0x8798e39ff2cf00e94193f9561e9915a5, 'Trinh', 'Linh', '1996-02-17', 'linhb1400702@student.ctu.edu.vn', '0965928981', 'Can Tho', 'DV_PKHTH', 'N_KHTH', 1, '2018-10-15 23:12:11'),
(11, '20181016', 0x6b8d816550722b302f87a06e40e312c85d75ab448d3f28a70816a0530739b1eb, 'Nguyen', 'Hang', '1997-05-06', 'thuyhang22@gmail.com', '0965928985', 'Cao Lanh Dong Thap', 'DV_PKHTH', 'N_KHTH', 1, '2018-10-16 00:38:14');

-- --------------------------------------------------------

--
-- Table structure for table `nhom`
--

CREATE TABLE `nhom` (
  `manhom` varchar(10) NOT NULL,
  `tennhom` varchar(100) NOT NULL,
  `thoigianthem` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nhom`
--

INSERT INTO `nhom` (`manhom`, `tennhom`, `thoigianthem`) VALUES
('N_BGH', 'Nhóm Ban Giám Hiệu', '2018-10-02 20:11:04'),
('N_GV', 'Nhóm Giảng Viên', '2018-10-02 20:11:04'),
('N_KHTH', 'Nhóm phòng KTTH', '2018-10-02 20:11:04'),
('N_SV', 'Nhóm Sinh Viên', '2018-10-02 20:11:04'),
('N_TBM', 'Nhóm các trưởng bộ môn', '2018-10-02 20:11:04'),
('N_TDV', 'Nhóm các trưởng Đơn vị', '2018-10-02 20:11:04');

-- --------------------------------------------------------

--
-- Table structure for table `pheduyet`
--

CREATE TABLE `pheduyet` (
  `idcongvanden` int(10) UNSIGNED NOT NULL,
  `idnguoipheduyet` int(10) UNSIGNED NOT NULL,
  `ykienpheduyet` varchar(200) DEFAULT NULL,
  `thoigianpheduyet` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `quyennguoidung`
--

CREATE TABLE `quyennguoidung` (
  `idnguoidung` int(10) UNSIGNED NOT NULL,
  `quyen` tinyint(4) NOT NULL,
  `thoigianthem` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quyennguoidung`
--

INSERT INTO `quyennguoidung` (`idnguoidung`, `quyen`, `thoigianthem`) VALUES
(1, 1, '2018-10-04 16:40:57'),
(1, 2, '2018-10-04 16:40:57'),
(1, 3, '2018-10-04 16:40:57'),
(1, 4, '2018-10-04 16:40:57'),
(2, 1, '2018-10-04 16:40:57'),
(2, 3, '2018-10-04 16:40:57'),
(3, 1, '2018-10-04 16:40:57');

-- --------------------------------------------------------

--
-- Table structure for table `quyennhomnguoidung`
--

CREATE TABLE `quyennhomnguoidung` (
  `manhom` varchar(10) NOT NULL,
  `quyen` tinyint(4) NOT NULL,
  `thoigianthem` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quyennhomnguoidung`
--

INSERT INTO `quyennhomnguoidung` (`manhom`, `quyen`, `thoigianthem`) VALUES
('N_BGH', 1, '2018-10-04 18:06:19'),
('N_KHTH', 2, '2018-10-04 18:06:19'),
('N_BGH', 3, '2018-10-04 18:06:19');

-- --------------------------------------------------------

--
-- Table structure for table `t`
--

CREATE TABLE `t` (
  `v` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t`
--

INSERT INTO `t` (`v`) VALUES
('trinh van linh'),
('NGUYEN THI KIM NGAN'),
('nguyen kim ngan'),
('van linh + thuy hang');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `ngay` date DEFAULT NULL,
  `ten` varchar(30) DEFAULT NULL,
  `so` int(11) DEFAULT NULL,
  `matkhau` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`ngay`, `ten`, `so`, `matkhau`) VALUES
('2018-02-10', 'Trinh Van Linh', 1996, 0x616263);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`) VALUES
(1, 'TRINH VAN LINH'),
(2, 'NGUYEN THI THUY HANG EM'),
(3, 'THANH NGA'),
(4, 'NGUYEN THI KIM NGAN'),
(5, 'TRAN THI NGOC TUYEN');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `congvanden`
--
ALTER TABLE `congvanden`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_congvanden_donvibanhanh_idx` (`madonvibanhanh`),
  ADD KEY `fk_congvanden_loaivanban_idx` (`maloaivanban`),
  ADD KEY `fk_nguoinhapcongvan_idx` (`idnguoinhap`),
  ADD KEY `fk_congvanden_don` (`madonvi`);

--
-- Indexes for table `donvi`
--
ALTER TABLE `donvi`
  ADD PRIMARY KEY (`madonvi`);

--
-- Indexes for table `donvibanhanh`
--
ALTER TABLE `donvibanhanh`
  ADD PRIMARY KEY (`madonvi`);

--
-- Indexes for table `kiemduyet`
--
ALTER TABLE `kiemduyet`
  ADD PRIMARY KEY (`idcongvanden`);

--
-- Indexes for table `loaivanban`
--
ALTER TABLE `loaivanban`
  ADD PRIMARY KEY (`maloai`);

--
-- Indexes for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `maso_UNIQUE` (`maso`),
  ADD KEY `fk_nguoidung_donvi_idx` (`madonvi`),
  ADD KEY `fk_nguoidung_nhom_idx` (`manhom`);

--
-- Indexes for table `nhom`
--
ALTER TABLE `nhom`
  ADD PRIMARY KEY (`manhom`);

--
-- Indexes for table `pheduyet`
--
ALTER TABLE `pheduyet`
  ADD PRIMARY KEY (`idcongvanden`),
  ADD KEY `fk_duyetchocongvan_idx` (`idcongvanden`),
  ADD KEY `fk_nguoipheduyet` (`idnguoipheduyet`);

--
-- Indexes for table `quyennguoidung`
--
ALTER TABLE `quyennguoidung`
  ADD PRIMARY KEY (`idnguoidung`,`quyen`);

--
-- Indexes for table `quyennhomnguoidung`
--
ALTER TABLE `quyennhomnguoidung`
  ADD PRIMARY KEY (`quyen`,`manhom`),
  ADD KEY `fk_quyencuanhom_idx` (`manhom`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `congvanden`
--
ALTER TABLE `congvanden`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `congvanden`
--
ALTER TABLE `congvanden`
  ADD CONSTRAINT `fk_congvanden_don` FOREIGN KEY (`madonvi`) REFERENCES `donvi` (`madonvi`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_congvanden_donvibanhanh` FOREIGN KEY (`madonvibanhanh`) REFERENCES `donvibanhanh` (`madonvi`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_congvanden_loaivanban` FOREIGN KEY (`maloaivanban`) REFERENCES `loaivanban` (`maloai`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nguoinhapcongvan` FOREIGN KEY (`idnguoinhap`) REFERENCES `nguoidung` (`id`);

--
-- Constraints for table `kiemduyet`
--
ALTER TABLE `kiemduyet`
  ADD CONSTRAINT `fk_kiemduyetcongvan` FOREIGN KEY (`idcongvanden`) REFERENCES `congvanden` (`id`),
  ADD CONSTRAINT `fk_nguoikiemduyet` FOREIGN KEY (`idcongvanden`) REFERENCES `nguoidung` (`id`);

--
-- Constraints for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD CONSTRAINT `fk_nguoidung_donvi` FOREIGN KEY (`madonvi`) REFERENCES `donvi` (`madonvi`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nguoidung_nhom` FOREIGN KEY (`manhom`) REFERENCES `nhom` (`manhom`) ON UPDATE CASCADE;

--
-- Constraints for table `pheduyet`
--
ALTER TABLE `pheduyet`
  ADD CONSTRAINT `fk_nguoipheduyet` FOREIGN KEY (`idnguoipheduyet`) REFERENCES `nguoidung` (`id`),
  ADD CONSTRAINT `fk_pheduyetcongvan` FOREIGN KEY (`idcongvanden`) REFERENCES `congvanden` (`id`);

--
-- Constraints for table `quyennguoidung`
--
ALTER TABLE `quyennguoidung`
  ADD CONSTRAINT `fk_quyennguoidung` FOREIGN KEY (`idnguoidung`) REFERENCES `nguoidung` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quyennhomnguoidung`
--
ALTER TABLE `quyennhomnguoidung`
  ADD CONSTRAINT `fk_quyencuanhom` FOREIGN KEY (`manhom`) REFERENCES `nhom` (`manhom`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
