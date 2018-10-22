-- MySQL dump 10.13  Distrib 8.0.12, for Win64 (x86_64)
--
-- Host: localhost    Database: ldmsdb
-- ------------------------------------------------------
-- Server version	8.0.12

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `congvanden`
--

DROP TABLE IF EXISTS `congvanden`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `congvanden` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `soden` int(10) unsigned NOT NULL,
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
  `idnguoinhap` int(10) unsigned NOT NULL,
  `madonvi` varchar(10) NOT NULL,
  `thoigianthem` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_congvanden_donvibanhanh_idx` (`madonvibanhanh`),
  KEY `fk_congvanden_loaivanban_idx` (`maloaivanban`),
  KEY `fk_nguoinhapcongvan_idx` (`idnguoinhap`),
  KEY `fk_congvanden_don` (`madonvi`),
  CONSTRAINT `fk_congvanden_don` FOREIGN KEY (`madonvi`) REFERENCES `donvi` (`madonvi`) ON UPDATE CASCADE,
  CONSTRAINT `fk_congvanden_donvibanhanh` FOREIGN KEY (`madonvibanhanh`) REFERENCES `donvibanhanh` (`madonvi`) ON UPDATE CASCADE,
  CONSTRAINT `fk_congvanden_loaivanban` FOREIGN KEY (`maloaivanban`) REFERENCES `loaivanban` (`maloai`) ON UPDATE CASCADE,
  CONSTRAINT `fk_nguoinhapcongvan` FOREIGN KEY (`idnguoinhap`) REFERENCES `nguoidung` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `congvanden`
--

LOCK TABLES `congvanden` WRITE;
/*!40000 ALTER TABLE `congvanden` DISABLE KEYS */;
INSERT INTO `congvanden` VALUES (6,1,'35/STTT','2016-01-13 00:00:00','2016-01-13','DV_ABC','vv thông tin báo dân trí phản ánh','Nguyen Ba Hao','VB_CV','2016-01-15','6_1_congvan.pdf',1,16,'DV_CNTT','2018-10-17 15:16:57'),(8,375,'12/KHCT','2018-10-20 19:44:13','2018-10-18','DV_ABC','Hội thảo khoa học kỹ thuật','Hà Thành Toàn','VB_CD',NULL,'8_375_An In Depth Guide to mod_rewrite for Apache _ Nettuts+.pdf',1,16,'DV_CNTT','2018-10-20 19:58:06'),(9,378,'12/DHCT','2018-10-20 20:00:28','2018-10-01','DV_KTNMT','Cho Sinh Viên giao lưu tiếng anh với các Sinh Viên trường Đại học Hàn Quốc','Nguyễn Đức Bình','VB_ND','2018-10-22','9_378_Quytrinhtiepnhancv.pdf',1,16,'DV_CNTT','2018-10-20 20:05:37');
/*!40000 ALTER TABLE `congvanden` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `donvi`
--

DROP TABLE IF EXISTS `donvi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `donvi` (
  `madonvi` varchar(10) NOT NULL,
  `tendonvi` varchar(100) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `thoigianthem` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`madonvi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `donvi`
--

LOCK TABLES `donvi` WRITE;
/*!40000 ALTER TABLE `donvi` DISABLE KEYS */;
INSERT INTO `donvi` VALUES ('DV_CNTT','Khoa Công Nghệ Thông Tin Và Truyền Thông','cit@ctu.edu.vn','2018-10-17 11:20:56'),('DV_CTSV','Phòng Công Tác Sinh Viên','dsa@ctu.edu.vn','2018-10-19 11:40:15'),('DV_DBDT','Khoa Dự bị dân tộc','dubi@gmail.com','2018-10-22 22:48:20'),('DV_GDTC','Khoa Giáo dục Thể chất','gdtc@gmail.com','2018-10-22 23:15:42'),('DV_KCT','Khoa Khoa học Chính Trị','kct@gmail.com','2018-10-22 22:49:00'),('DV_KKT','Khoa Kinh Tế','kkt@ctu.edu.vn','2018-10-22 22:49:57'),('DV_KL','Khoa Luật ĐHCT','khoaluat@gmail.com','2018-10-17 13:27:20'),('DV_KNN','Khoa ngoại ngữ','kng@ctu.edu.vn','2018-10-22 22:50:28'),('DV_KPTNT','Khoa Phát triển nông thôn','kptnt@ctu.edu.vn','2018-10-22 22:51:00'),('DV_KSDH','Khoa Sau đại học','ksdh@gmail.com','2018-10-22 22:51:23'),('DV_KSP','Khoa Sư phạm','khoasp@gmail.com','2018-10-22 23:10:14'),('DV_KTS','Khoa Thủy sản','khoats@gmail.com','2018-10-22 23:10:58'),('DV_KXHNV','Khoa Khoa học Xã hội & Nhân Văn','kxhnv@ctu.edu.vn','2018-10-22 22:49:36'),('DV_PDT','Phòng Đào Tạo','pdt@ctu.edu.vn','2018-10-22 23:16:41'),('KCN','Khoa Công Nghệ','kcn@ctu.edu.vn','2018-10-22 22:47:32');
/*!40000 ALTER TABLE `donvi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `donvibanhanh`
--

DROP TABLE IF EXISTS `donvibanhanh`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `donvibanhanh` (
  `madonvi` varchar(10) NOT NULL,
  `tendonvi` varchar(100) NOT NULL,
  `benngoai` tinyint(4) NOT NULL,
  `diachi` varchar(100) NOT NULL,
  `thoigianthem` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`madonvi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `donvibanhanh`
--

LOCK TABLES `donvibanhanh` WRITE;
/*!40000 ALTER TABLE `donvibanhanh` DISABLE KEYS */;
INSERT INTO `donvibanhanh` VALUES ('DV_ABC','CÔNG TY A.B.C',1,'Bến Nghé, TP Hồ Chí Minh','2018-10-17 13:52:45'),('DV_ABCD','Công ty A.B.C.D',1,'Bến Nghé TP. Hồ Chí Minh','2018-10-19 15:18:05'),('DV_FPTS','Công ty phần mềm FPT Software',1,'TP. Hồ Chí Minh','2018-10-21 17:00:48'),('DV_KTNMT','Khoa Tài Nguyên và Môi Trường - Đại Học Cần Thơ',0,'Đại Học Cần Thơ, đường 3/2 phường Xuân Khánh, quận Ninh Kiều, TP. Cần Thơ','2018-10-19 15:19:16'),('DV_PDT','Phòng Đào Tạo ĐHCT',0,'Đại Học Cần Thơ, đường 3/2, Phường Xuân Khánh, Quận Ninh Kiều, TP. Cần Thơ','2018-10-17 14:18:45');
/*!40000 ALTER TABLE `donvibanhanh` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kiemduyet`
--

DROP TABLE IF EXISTS `kiemduyet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `kiemduyet` (
  `idcongvanden` int(10) unsigned NOT NULL,
  `idnguoikiemduyet` int(10) unsigned NOT NULL,
  `ykienkiemduyet` varchar(200) DEFAULT NULL,
  `thoigiankiemduyet` datetime DEFAULT NULL,
  PRIMARY KEY (`idcongvanden`),
  KEY `fk_nguoikiemduyet` (`idnguoikiemduyet`),
  CONSTRAINT `fk_kiemduyetcongvan` FOREIGN KEY (`idcongvanden`) REFERENCES `congvanden` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_nguoikiemduyet` FOREIGN KEY (`idnguoikiemduyet`) REFERENCES `nguoidung` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kiemduyet`
--

LOCK TABLES `kiemduyet` WRITE;
/*!40000 ALTER TABLE `kiemduyet` DISABLE KEYS */;
/*!40000 ALTER TABLE `kiemduyet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loaivanban`
--

DROP TABLE IF EXISTS `loaivanban`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `loaivanban` (
  `maloai` varchar(10) NOT NULL,
  `tenloai` varchar(50) NOT NULL,
  `thoigianthem` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`maloai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loaivanban`
--

LOCK TABLES `loaivanban` WRITE;
/*!40000 ALTER TABLE `loaivanban` DISABLE KEYS */;
INSERT INTO `loaivanban` VALUES ('VB_CD','CHỈ ĐẠO','2018-10-19 14:47:13'),('VB_CV','Công Văn','2018-10-17 14:46:44'),('VB_ND','Nghị Định','2018-10-17 14:42:32');
/*!40000 ALTER TABLE `loaivanban` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nguoidung`
--

DROP TABLE IF EXISTS `nguoidung`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `nguoidung` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
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
  `thoigianthem` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `maso_UNIQUE` (`maso`),
  KEY `fk_nguoidung_donvi_idx` (`madonvi`),
  KEY `fk_nguoidung_nhom_idx` (`manhom`),
  CONSTRAINT `fk_nguoidung_donvi` FOREIGN KEY (`madonvi`) REFERENCES `donvi` (`madonvi`) ON UPDATE CASCADE,
  CONSTRAINT `fk_nguoidung_nhom` FOREIGN KEY (`manhom`) REFERENCES `nhom` (`manhom`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nguoidung`
--

LOCK TABLES `nguoidung` WRITE;
/*!40000 ALTER TABLE `nguoidung` DISABLE KEYS */;
INSERT INTO `nguoidung` VALUES (12,'20181018',_binary '��\��\�\0\�A��V��','Trịnh Văn','Linh','1996-02-18','mobi170296@gmail.com','01215759696','Đồng Tháp','DV_CNTT','N_QTHT',1,'2018-10-17 11:21:48'),(16,'20171017',_binary 'k��ePr+0/��n@\�\�]u�D�?(��S9�\�','NGUYỄN THỊ THÚY','HẰNG','1997-02-19','thuyhang@gmail.com','0988111222','Cần Thơ','DV_CNTT','N_CBVTCC',1,'2018-10-17 13:50:35'),(17,'20191019',_binary '��\��\�\0\�A��V��','Trinh','Linh','2010-01-01','linh17021996@gmail.com','01215759696','DONG THAP','DV_CNTT','N_QTHT',1,'2018-10-19 01:31:07'),(18,'20181020',_binary 'S�(\�����s�<�\�\�','Nguyễn Thị','Yến','1988-10-09','nguyenthiyen@gmail.com','01669334569','TP. Hồ Chí Minh','DV_KL','N_CBVTCC',1,'2018-10-19 10:50:36'),(19,'20171020',_binary '�`\�\�\�\�\�\0\�\�\�\�A','Đào Như','Trúc','1996-05-08','daonhutruc@gmail.com','01218989999','Đồng Tháp','DV_KL','N_CBVTCC',0,'2018-10-19 11:09:52'),(22,'B1400702',_binary '��\��\�\0\�A��V��','Trịnh Văn','Linh','1996-04-09','trinhvanlinh@gmail.com','01218989998','Đồng Tháp','DV_CNTT','N_QTHT',1,'2018-10-19 11:18:18');
/*!40000 ALTER TABLE `nguoidung` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nhom`
--

DROP TABLE IF EXISTS `nhom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `nhom` (
  `manhom` varchar(10) NOT NULL,
  `tennhom` varchar(100) NOT NULL,
  `thoigianthem` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`manhom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nhom`
--

LOCK TABLES `nhom` WRITE;
/*!40000 ALTER TABLE `nhom` DISABLE KEYS */;
INSERT INTO `nhom` VALUES ('N_BGH','Nhóm Ban Giám Hiệu','2018-10-17 11:46:27'),('N_CBVTCC','Nhóm Cán Bộ Văn Thư Các Cấp','2018-10-17 11:50:38'),('N_QTHT','Quản Trị Hệ Thống','2018-10-17 11:19:48'),('N_TK','Nhóm Thư Ký','2018-10-21 23:12:33');
/*!40000 ALTER TABLE `nhom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pheduyet`
--

DROP TABLE IF EXISTS `pheduyet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `pheduyet` (
  `idcongvanden` int(10) unsigned NOT NULL,
  `idnguoipheduyet` int(10) unsigned NOT NULL,
  `ykienpheduyet` varchar(200) DEFAULT NULL,
  `thoigianpheduyet` datetime DEFAULT NULL,
  PRIMARY KEY (`idcongvanden`),
  KEY `fk_duyetchocongvan_idx` (`idcongvanden`),
  KEY `fk_nguoipheduyet` (`idnguoipheduyet`),
  CONSTRAINT `fk_nguoipheduyet` FOREIGN KEY (`idnguoipheduyet`) REFERENCES `nguoidung` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_pheduyetcongvan` FOREIGN KEY (`idcongvanden`) REFERENCES `congvanden` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pheduyet`
--

LOCK TABLES `pheduyet` WRITE;
/*!40000 ALTER TABLE `pheduyet` DISABLE KEYS */;
/*!40000 ALTER TABLE `pheduyet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quyennguoidung`
--

DROP TABLE IF EXISTS `quyennguoidung`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `quyennguoidung` (
  `idnguoidung` int(10) unsigned NOT NULL,
  `quyen` tinyint(4) NOT NULL,
  `thoigianthem` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idnguoidung`,`quyen`),
  CONSTRAINT `fk_quyennguoidung` FOREIGN KEY (`idnguoidung`) REFERENCES `nguoidung` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quyennguoidung`
--

LOCK TABLES `quyennguoidung` WRITE;
/*!40000 ALTER TABLE `quyennguoidung` DISABLE KEYS */;
INSERT INTO `quyennguoidung` VALUES (12,1,'2018-10-17 22:10:20'),(12,2,'2018-10-17 22:10:20'),(12,3,'2018-10-17 22:10:21'),(12,4,'2018-10-17 22:10:21'),(12,5,'2018-10-17 22:10:21'),(12,6,'2018-10-17 22:10:21'),(12,7,'2018-10-17 22:10:21'),(12,8,'2018-10-17 22:10:21'),(12,9,'2018-10-17 22:10:21'),(12,10,'2018-10-17 22:10:21'),(12,11,'2018-10-17 22:10:21');
/*!40000 ALTER TABLE `quyennguoidung` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quyennhomnguoidung`
--

DROP TABLE IF EXISTS `quyennhomnguoidung`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `quyennhomnguoidung` (
  `manhom` varchar(10) NOT NULL,
  `quyen` tinyint(4) NOT NULL,
  `thoigianthem` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`quyen`,`manhom`),
  KEY `fk_quyencuanhom_idx` (`manhom`),
  CONSTRAINT `fk_quyencuanhom` FOREIGN KEY (`manhom`) REFERENCES `nhom` (`manhom`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quyennhomnguoidung`
--

LOCK TABLES `quyennhomnguoidung` WRITE;
/*!40000 ALTER TABLE `quyennhomnguoidung` DISABLE KEYS */;
INSERT INTO `quyennhomnguoidung` VALUES ('N_QTHT',1,'2018-10-17 11:32:38'),('N_QTHT',2,'2018-10-17 11:32:38'),('N_QTHT',3,'2018-10-17 11:32:38'),('N_QTHT',4,'2018-10-17 11:32:38'),('N_QTHT',5,'2018-10-17 11:32:38'),('N_QTHT',6,'2018-10-17 11:32:38'),('N_QTHT',7,'2018-10-17 11:32:38'),('N_QTHT',8,'2018-10-17 11:32:38'),('N_QTHT',9,'2018-10-17 11:32:38'),('N_QTHT',10,'2018-10-17 11:32:38'),('N_QTHT',11,'2018-10-17 11:32:38'),('N_CBVTCC',12,'2018-10-17 11:53:42'),('N_CBVTCC',13,'2018-10-17 11:53:42'),('N_CBVTCC',14,'2018-10-17 11:53:42'),('N_CBVTCC',15,'2018-10-17 11:54:39'),('N_CBVTCC',16,'2018-10-17 11:54:56'),('N_CBVTCC',17,'2018-10-17 11:54:56'),('N_CBVTCC',18,'2018-10-17 11:54:56'),('N_CBVTCC',19,'2018-10-17 11:54:56'),('N_CBVTCC',20,'2018-10-17 11:54:56');
/*!40000 ALTER TABLE `quyennhomnguoidung` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-10-22 23:18:45
