/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.13-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: triupasedanahouse
-- ------------------------------------------------------
-- Server version	10.11.13-MariaDB-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Comments`
--

DROP TABLE IF EXISTS `Comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `Comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Comments`
--

LOCK TABLES `Comments` WRITE;
/*!40000 ALTER TABLE `Comments` DISABLE KEYS */;
INSERT INTO `Comments` VALUES
(1,1,'Tempatnya sangat nyaman, recommended!','2025-06-18 15:59:50'),
(2,2,'Pemandangan dari kamar sangat indah.','2025-06-18 15:59:50'),
(3,5,'kamarnya kurang dibersihkan \r\n','2025-06-25 10:06:10'),
(4,5,'abangkusuperman','2025-06-25 10:07:21'),
(5,5,'2019 - 2030','2025-06-25 10:09:39'),
(8,4,'abangku superman','2025-06-26 18:35:19'),
(9,4,'abangku superman1','2025-06-26 18:39:17'),
(14,9,'Kamarnya sangat ramai dan menyenangkan\r\n','2025-07-01 18:47:35'),
(19,11,'fresh and plong\r\n','2025-07-25 09:10:38'),
(22,8,'aku','2025-07-25 17:06:53'),
(23,8,'<script>alert(1)</script>\r\n','2025-07-26 16:53:42');
/*!40000 ALTER TABLE `Comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Pemesanan`
--

DROP TABLE IF EXISTS `Pemesanan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Pemesanan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `identity_type` enum('KTP','PASPOR') NOT NULL,
  `identity_number` varchar(50) NOT NULL,
  `country` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `checkin_date` date NOT NULL,
  `checkout_date` date NOT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `room_id` (`room_id`),
  CONSTRAINT `Pemesanan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `Pemesanan_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `Rooms` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pemesanan`
--

LOCK TABLES `Pemesanan` WRITE;
/*!40000 ALTER TABLE `Pemesanan` DISABLE KEYS */;
INSERT INTO `Pemesanan` VALUES
(1,1,1,'Budi Santoso','KTP','1234567890123456','Indonesia','081234567890','Jl. Contoh No. 123','2023-11-01','2023-11-05','confirmed','2025-06-18 16:00:03'),
(2,4,3,'Dewangga','KTP','6237439274923','Indonesia','dnskwjdweuh2','sfmnsdbfkjsbdfksjbksdj','2025-06-24','2025-06-25','cancelled','2025-06-24 22:38:27'),
(3,4,NULL,'Dewangga','KTP','6237439274923','Indonesia','0812882718327938','Yogyakarta','2025-06-28','2025-06-26','confirmed','2025-06-26 18:11:27'),
(4,4,3,'Dewangga','KTP','6237439274923','Indonesia','0812882718327938','Bali','2025-06-25','2025-06-26','confirmed','2025-06-26 18:49:46'),
(5,8,1,'dewangga','KTP','510406200801','Singapura','0819923829312','Yogyakrata, bantul','2025-07-01','2025-07-03','confirmed','2025-07-01 17:21:15'),
(6,8,1,'dewangga','KTP','510406200801','Singapura','081234567890','Ibukota\r\n','2025-07-24','2025-07-25','confirmed','2025-07-25 17:07:28');
/*!40000 ALTER TABLE `Pemesanan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RoomImages`
--

DROP TABLE IF EXISTS `RoomImages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `RoomImages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `room_id` (`room_id`),
  CONSTRAINT `RoomImages_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `Rooms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RoomImages`
--

LOCK TABLES `RoomImages` WRITE;
/*!40000 ALTER TABLE `RoomImages` DISABLE KEYS */;
INSERT INTO `RoomImages` VALUES
(5,1,'std-3.jpg','2025-06-28 01:32:55'),
(6,1,'std-2.jpg','2025-06-28 01:32:55'),
(7,2,'std-5.jpg','2025-06-28 01:36:58'),
(8,2,'std-4.jpg','2025-06-28 01:36:58'),
(9,3,'suite-room4.jpeg','2025-06-28 01:41:34'),
(10,3,'suite-room3.jpeg','2025-06-28 01:41:34'),
(11,3,'suite-room2.jpeg','2025-06-28 01:41:34'),
(15,9,'deluxe-room3.jpeg','2025-06-28 01:45:50'),
(16,9,'deluxe-room2.jpeg','2025-06-28 01:45:50'),
(17,9,'deluxe-room1.jpeg','2025-06-28 01:45:50');
/*!40000 ALTER TABLE `RoomImages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Rooms`
--

DROP TABLE IF EXISTS `Rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `capacity` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Rooms`
--

LOCK TABLES `Rooms` WRITE;
/*!40000 ALTER TABLE `Rooms` DISABLE KEYS */;
INSERT INTO `Rooms` VALUES
(1,'Kamar Standard Tipe Single Bed','Kamar ber-AC, memiliki balkon, area tempat duduk dan minibar. Tersedia TV LED, meja, dan lemari, sementara kamar mandi dalamnya menawarkan shower, bathtub, dan perlengkapan mandi gratis.\r\n\r\n Fasilitas kamar:\r\n 1)  Telepon, TV Led, AC, meja kerja.\r\n 2)  Area tempat duduk, lantai berkarpet, lemari pakaian.\r\n 3)  Shower, bathtub, peralatan mandi, toilet.\r\n 4)  Minibar, air mineral, handuk, kaca rias.\r\n 5) Wi-Fi gratis tersedia di semua kamar.\r\n 6) Ukuran kamar: 7m x 4m.',300000.00,'std-1.jpg',2,'2025-06-18 15:59:34'),
(2,'Kamar Standard Tipe Twin Bed','Kamar ber-AC, memiliki balkon, area tempat duduk dan minibar. Tersedia TV LED, meja, dan lemari, sementara kamar mandi dalamnya menawarkan shower, bathtub, dan perlengkapan mandi gratis.\r\n Fasilitas kamar:\r\n 1) Telepon, TV Led, AC, meja kerja.\r\n 2) Area tempat duduk, lantai berkarpet, lemari pakaian.\r\n 3) Shower, bathtub, peralatan mandi, toilet.\r\n 4) Minibar, air mineral, handuk, kaca rias.\r\n 5) Wi-Fi gratis tersedia di semua kamar.',350000.00,'std-6.jpg',2,'2025-06-18 15:59:34'),
(3,'Kamar Tipe Suite Room','Untuk tamu kami yang menikmati seluruh waktu bersantai dalam privasi kamar mereka, Suite kami menawarkan ruang tamu yang luas dengan lounge dan meja makan untuk membuat Anda merasa seperti di rumah sendiri. Kamar-kamar dirancang dengan indah di mana para tamu menerima perhatian ekstra. \r\nFasilitas kamar Suite termasuk:\r\n• Ruang tamu terpisah\r\n• Kamar mandi pribadi terpisah\r\n• Meja makan\r\n• Penyejuk ruangan dengan kontrol pribadi\r\n• Sambungan telepon IDD\r\n• Televisi kabel\r\n• Televisi LCD\r\n• Pemandangan kolam renang\r\n• Kotak penyimpanan barang berharga\r\n• Fasilitas pembuat kopi dan teh\r\n• Alat pencukur\r\n• I-pod docking port\r\n• Seluruh kamar Suite bebas asap rokok\r\n• Akses internet\r\n• Lemari es mini\r\n• Pengering rambut',600000.00,'suite-room1.jpeg',4,'2025-06-18 15:59:34'),
(9,'Kamar Tipe Deluxe Room','Kamar Deluxe seluas 27 meter persegi ini dilengkapi dengan furnitur eksklusif dan berbagai fasilitas pendukung. Tersedia dalam pilihan tempat tidur ukuran queen atau twin single, dengan pemandangan kota dan kami juga memiliki kamar mandi yang telah diperbaharui.\r\nFasilitas kamar:\r\n• Penyejuk ruangan dengan kontrol pribadi\r\n• Sambungan telepon IDD\r\n• Televisi kabel\r\n• Akses internet 24 jam\r\n• Kotak penyimpanan barang berharga\r\n• Pemandangan kota\r\n• Fasilitas pembuat kopi dan teh\r\n• Mini-bar\r\n• Pengering rambut\r\n• Air panas & dingin\r\n• Kamar mandi dan soket pencukur 100/200 volt',500000.00,'deluxe-room4.jpeg',2,'2025-06-28 01:45:50');
/*!40000 ALTER TABLE `Rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` text NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `profile_photo` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES
(1,'dewaagustina','inagus61@gmail.com','$2y$12$bhqsYrTy/6U7.v1Ty9woZe5Yz1DAmZKG3pyL1p/SfOy3xfonlxV4S','user',NULL,'2025-06-18 15:32:15'),
(2,'budi','budi@example.com','$2y$10$hashedpassword1','user',NULL,'2025-06-18 15:59:42'),
(3,'admin1','admin1@example.com','$2y$10$hashedpassword2','admin',NULL,'2025-06-18 15:59:42'),
(4,'dewangga','dewangga@gmail.com','$2y$12$wgUk.Y87KnhrOxFl.VNTXe7Rxdvzj2yv66ehSkC7YY0EACIXVueha','admin','Screenshot from 2025-06-06 11-52-43.png','2025-06-23 11:42:09'),
(5,'wahyuSIEM','wahyu@gmail.com','$2y$12$tZXyqS9M/5U1Jt8VmtIG.udUBbqejD.nZp64OjHXvjE/BoTfGJ8uu','admin',NULL,'2025-06-24 18:50:32'),
(6,'zaki','zaki123@gmail.com','$2y$12$Lz.w/HNFQOEZLMJHiID6ruPiT7w2b3fQ4NvtP9xIJoXcJq/oO.75u','user',NULL,'2025-06-24 21:44:21'),
(7,'mas dyka','dyka123@gmail.com','$2y$12$kQ8.IeczonU8AVuGfhFNDef98RIzSak10FsmHKnUs.A9Wb9XWwbty','user','Screenshot from 2025-06-24 21-45-19.png','2025-06-24 22:11:43'),
(8,'<script>alert(1)</script>','naren123@gmail.com','$2y$12$qXIFbiueFngcR8eug7Wb4OXGtQj245k8ocbgn18DQrwEtGVeK0KM.','user','Screenshot from 2025-06-08 15-51-10.png','2025-06-26 19:43:34'),
(9,'dewangga','dewa123@gmail.com','$2y$12$53/bfN4weuGZt/yZ2J8S/.FT1613PpQOTZdwhkmtkAnKkiqjdML.C','user','uploads/default-profile.jpg','2025-07-01 18:11:10'),
(10,'dewa','dewa123@gmail.com','$2y$12$H.s2Qy0tW8JyhWVHJH3LNuGiQ7W8s1YlpkzFPzvTk3Sj6xPitKXdW','user','uploads/default-profile.jpg','2025-07-25 08:49:10'),
(11,'dewa12','dewa12@gmail.com','$2y$12$mX999eX.5Gj3aIQcpT4LhOHnSXXqSsbphMAnYb2BtYs3iVRXmd9c6','user','uploads/default-profile.jpg','2025-07-25 08:49:48');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-08-10 14:39:13
