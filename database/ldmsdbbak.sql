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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `congvanden`
--

LOCK TABLES `congvanden` WRITE;
/*!40000 ALTER TABLE `congvanden` DISABLE KEYS */;
INSERT INTO `congvanden` VALUES (13,2,'2018/DHCT','2018-10-26 22:52:26','2018-10-01','DV_FPTS','Tìm ý tưởng sáng tạo cho thành phố Thông Minh Cần Thơ','Hà Thanh Toàn','DT_CV','2018-11-20','13_2_Crypto9_1p.pdf',2,16,'DV_CNTT','2018-10-26 22:53:26'),(14,3,'12/DHCT','2018-10-26 23:36:28','2018-10-01','DV_FPTS','trich yeu cong van','Hà Thanh Toàn','DT_CV',NULL,'14_3_web_2014_1_30_40065.pdf',1,16,'DV_CNTT','2018-10-26 23:36:58'),(15,4,'1996/DHCT','2018-10-28 10:30:19','2018-10-01','DV_FPTS','Nghỉ lễ 2/9','Trịnh Văn Linh','DT_CV',NULL,'15_4_web_2014_1_30_40065.pdf',1,16,'DV_CNTT','2018-10-28 10:31:20');
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
INSERT INTO `donvi` VALUES ('DV_CNTT','Khoa Công Nghệ Thông Tin Và Truyền Thông','cit@ctu.edu.vn','2018-10-17 11:20:56'),('DV_KL','Khoa Luật ĐHCT','khoaluat@gmail.com','2018-10-17 13:27:20');
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
INSERT INTO `donvibanhanh` VALUES ('DV_FPTS','Công ty phần mềm FPT Software',1,'Ninh Kiều, Cần Thơ.','2018-10-26 14:42:28');
/*!40000 ALTER TABLE `donvibanhanh` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kiemduyet`
--

DROP TABLE IF EXISTS `kiemduyet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `kiemduyet` (
  `idcongvan` int(10) unsigned NOT NULL,
  `idnguoikiemduyet` int(10) unsigned NOT NULL,
  `ykienkiemduyet` varchar(200) DEFAULT NULL,
  `thoigiankiemduyet` datetime DEFAULT NULL,
  `thoigianthem` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcongvan`),
  KEY `fk_nguoikiemduyet` (`idnguoikiemduyet`),
  CONSTRAINT `fk_kiemduyetcongvan` FOREIGN KEY (`idcongvan`) REFERENCES `congvanden` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_nguoikiemduyet` FOREIGN KEY (`idnguoikiemduyet`) REFERENCES `nguoidung` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kiemduyet`
--

LOCK TABLES `kiemduyet` WRITE;
/*!40000 ALTER TABLE `kiemduyet` DISABLE KEYS */;
INSERT INTO `kiemduyet` VALUES (13,24,NULL,NULL,'2018-10-28 13:47:39');
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
INSERT INTO `loaivanban` VALUES ('DT_CD','Chỉ Đạo','2018-10-26 14:41:06'),('DT_CV','Công Văn','2018-10-26 14:41:16');
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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nguoidung`
--

LOCK TABLES `nguoidung` WRITE;
/*!40000 ALTER TABLE `nguoidung` DISABLE KEYS */;
INSERT INTO `nguoidung` VALUES (16,'20171017',_binary 'k��ePr+0/��n@\�\�]u�D�?(��S9�\�','Nguyễn Thị Thúy','Hằng','1997-02-19','thuyhang@gmail.com','0988111222','Cần Thơ','DV_CNTT','N_CBVTCC',1,'2018-10-17 13:50:35'),(24,'20181018',_binary '��\��\�\0\�A��V��','Trịnh','Linh','1996-02-17','linh17021996@gmail.com','0795759696','Đồng Tháp','DV_CNTT','N_QTHT',1,'2018-10-28 13:45:46');
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
INSERT INTO `nhom` VALUES ('N_CBVTCC','Nhóm Cán Bộ Văn Thư Các Cấp','2018-10-17 11:50:38'),('N_QTHT','Quản Trị Hệ Thống','2018-10-17 11:19:48');
/*!40000 ALTER TABLE `nhom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pheduyet`
--

DROP TABLE IF EXISTS `pheduyet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `pheduyet` (
  `idcongvan` int(10) unsigned NOT NULL,
  `idnguoipheduyet` int(10) unsigned NOT NULL,
  `ykienpheduyet` varchar(200) DEFAULT NULL,
  `thoigianpheduyet` datetime DEFAULT NULL,
  `thoigianthem` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcongvan`),
  KEY `fk_duyetchocongvan_idx` (`idcongvan`),
  KEY `fk_nguoipheduyet` (`idnguoipheduyet`),
  CONSTRAINT `fk_nguoipheduyet` FOREIGN KEY (`idnguoipheduyet`) REFERENCES `nguoidung` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_pheduyetcongvan` FOREIGN KEY (`idcongvan`) REFERENCES `congvanden` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
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
INSERT INTO `quyennguoidung` VALUES (16,21,'2018-10-24 23:10:05'),(16,22,'2018-10-24 23:20:15'),(24,21,'2018-10-28 13:47:28');
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

-- Dump completed on 2018-10-28 21:00:49
