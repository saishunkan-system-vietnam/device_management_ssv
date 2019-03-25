-- MySQL dump 10.16  Distrib 10.3.9-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: inventory_management
-- ------------------------------------------------------
-- Server version	10.3.9-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `borrow_devices`
--

LOCK TABLES `borrow_devices` WRITE;
/*!40000 ALTER TABLE `borrow_devices` DISABLE KEYS */;
/*!40000 ALTER TABLE `borrow_devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `borrow_devices_detail`
--

LOCK TABLES `borrow_devices_detail` WRITE;
/*!40000 ALTER TABLE `borrow_devices_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `borrow_devices_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'HP','bgarfath0','hdyke0','2019-02-22 21:01:10','2018-09-09 18:07:04',0),(2,'Dell','efiddymont1','dcorringham1','2018-06-30 23:50:27','2018-08-31 04:00:50',0),(3,'Samsung','qrenforth2','cdimberline2','2019-03-02 17:53:34','2018-09-01 10:55:26',0),(4,'Apple','crough3','lleblanc3','2018-10-03 12:52:52','2018-12-19 00:56:01',0),(5,'Xiaomi','cwitch4','rskeath4','2018-07-10 17:41:32','2018-04-18 23:30:44',0),(6,'Lenovo','dcreamen5','rlovekin5','2018-09-28 01:21:17','2018-11-13 17:45:07',0),(7,'HTC','cpuller6','jcrees6','2018-11-10 21:10:20','2018-09-20 14:13:11',0),(8,'Sony','ealves7','epetraitis7','2018-05-08 05:00:33','2018-05-08 18:01:19',0),(9,'Alphabet','hthurlbourne8','mmillmoe8','2018-08-09 06:01:40','2018-04-12 07:37:54',0),(10,'Google','bbullerwell9','ncampe9','2018-09-22 05:39:33','2019-01-18 00:45:04',0);
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,0,'Mobile','fdomoni0','rhanne0','2018-04-17 16:24:11','2018-11-19 17:30:14',0),(2,1,'Android','pgoney1','frisbrough1','2018-12-25 16:06:47','2018-05-18 08:58:03',0),(3,1,'Iphone','cserfati2','cgodard2','2018-06-28 16:27:51','2019-01-12 07:29:29',0),(4,1,'Windows Phone','rdorrington3','kbrimmicombe3','2019-01-21 02:25:04','2018-04-18 07:22:37',0),(5,0,'Computer','dheadon4','stirone4','2018-07-23 08:15:21','2018-05-22 12:29:52',0),(6,5,'PC Desktop','ebould5','bschaffler5','2019-01-27 18:17:52','2018-08-03 23:06:19',0),(7,5,'PC Laptop','dmcgarrity6','alaise6','2018-10-31 04:58:06','2018-12-02 15:21:40',0),(8,0,'Tablet','lmacquire7','fslavin7','2018-12-30 09:06:40','2018-06-14 07:43:20',0),(9,8,'Android','mdebrett8','dlehrian8','2018-03-31 16:23:03','2019-02-21 11:36:41',0),(10,8,'IPad','oemeline9','abroodes9','2019-01-11 11:18:02','2018-12-20 15:12:48',0),(11,8,'Windows Surface','llebarra','tblasiusa','2019-02-08 00:23:04','2018-10-30 18:49:40',0),(12,0,'Printer','rofeenyb','ldungateb','2019-02-24 21:06:50','2018-06-14 05:49:52',0),(13,0,'Mouse','rbombc','hjarlmannc','2019-03-07 02:20:41','2018-11-30 02:32:26',0),(14,0,'Keyboard','ibotwoodd','jharrowelld','2018-10-31 15:59:10','2018-04-01 03:03:57',0),(15,0,'Ram','ascampione','nabbadoe','2019-03-14 11:22:59','2018-04-28 15:47:44',0),(16,15,'Ram laptop','oraouxf','mthompsonf','2018-04-30 16:49:57','2018-12-22 22:17:27',0),(17,15,'Ram desktop','rrutledgeg','htoteng','2018-11-27 00:09:24','2019-01-27 09:29:09',0),(18,0,'Monitor','wbendellh','igirardoth','2018-11-04 14:09:43','2018-08-05 17:41:46',0),(19,0,'Other','tsandsallani','scummingsi','2019-01-23 05:42:51','2018-11-18 17:56:46',0),(20,0,'Hard Disk','mthompsonf','wbendellh','2018-08-05 17:41:46','2019-01-23 05:42:51',0),(21,20,'Hard Disk Drive','igirardoth','tsandsallani','2018-04-30 16:49:57','2018-11-30 02:32:26',0),(22,20,'Solid State Drive','ibotwoodd','nabbadoe','2018-04-30 16:49:57','2018-04-30 16:49:57',0);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `devices`
--

LOCK TABLES `devices` WRITE;
/*!40000 ALTER TABLE `devices` DISABLE KEYS */;
INSERT INTO `devices` VALUES (1,0,7,'IPD320S000000001','Lenovo ideapad 320s','Lenovo ideapad 320s',6,'Chip: Intel Core i5-8250U\r RAM: 8GB DDR4 2400MHz\r Ổ cứng: 256GB SSD M.2 PCIe\r Chipset đồ họa: Intel UHD Graphics 620\r Màn hình: 13.3 inch Full HD (1920 x 1080) LED, IPS, Anti-Glare\r Hệ điều hành: Windows 10 Home\r Pin: 3 Cell 36 Whrs',0,'2018-09-12 00:00:00','2019-09-12 00:00:00','bgarfath0','hdyke0','2019-02-22 21:01:10','2019-02-22 21:01:10',0),(2,0,7,'IPD320S000000002','Lenovo ideapad 320s','Lenovo ideapad 320s',6,'Chip: Intel Core i5-8250U\r RAM: 8GB DDR4 2400MHz\r Ổ cứng: 256GB SSD M.2 PCIe\r Chipset đồ họa: Intel UHD Graphics 620\r Màn hình: 13.3 inch Full HD (1920 x 1080) LED, IPS, Anti-Glare\r Hệ điều hành: Windows 10 Home\r Pin: 3 Cell 36 Whrs',0,'2018-09-12 00:00:00','2019-09-12 00:00:00','bgarfath0','hdyke0','2019-02-22 21:01:10','2019-02-22 21:01:10',0),(3,0,7,'IPD320S000000003','Lenovo ideapad 320s','Lenovo ideapad 320s',6,'Chip: Intel Core i5-8250U\r RAM: 8GB DDR4 2400MHz\r Ổ cứng: 256GB SSD M.2 PCIe\r Chipset đồ họa: Intel UHD Graphics 620\r Màn hình: 13.3 inch Full HD (1920 x 1080) LED, IPS, Anti-Glare\r Hệ điều hành: Windows 10 Home\r Pin: 3 Cell 36 Whrs',0,'2018-09-12 00:00:00','2019-09-12 00:00:00','bgarfath0','hdyke0','2019-02-22 21:01:10','2019-02-22 21:01:10',0),(4,0,7,'IPD320S000000004','Lenovo ideapad 320s','Lenovo ideapad 320s',6,'Chip: Intel Core i5-8250U\r RAM: 8GB DDR4 2400MHz\r Ổ cứng: 256GB SSD M.2 PCIe\r Chipset đồ họa: Intel UHD Graphics 620\r Màn hình: 13.3 inch Full HD (1920 x 1080) LED, IPS, Anti-Glare\r Hệ điều hành: Windows 10 Home\r Pin: 3 Cell 36 Whrs',0,'2018-09-12 00:00:00','2019-09-12 00:00:00','bgarfath0','hdyke0','2019-02-22 21:01:10','2019-02-22 21:01:10',0),(5,0,7,'IPD320S000000005','Lenovo ideapad 320s','Lenovo ideapad 320s',6,'Chip: Intel Core i5-8250U\r RAM: 8GB DDR4 2400MHz\r Ổ cứng: 256GB SSD M.2 PCIe\r Chipset đồ họa: Intel UHD Graphics 620\r Màn hình: 13.3 inch Full HD (1920 x 1080) LED, IPS, Anti-Glare\r Hệ điều hành: Windows 10 Home\r Pin: 3 Cell 36 Whrs',0,'2018-09-12 00:00:00','2019-09-12 00:00:00','bgarfath0','hdyke0','2019-02-22 21:01:10','2019-02-22 21:01:10',0),(6,0,7,'HPDK660000001','HP Prodesk 660','HP Prodesk 660',1,'Chip: Intel Core i5-3250U\r RAM: 16GB DDR3 2400MHz\r Ổ cứng: 256GB SSD M.2 PCIe\r Chipset đồ họa: Intel UHD Graphics 4000',0,'2018-09-12 00:00:00','2019-09-12 00:00:00','bgarfath0','hdyke0','2019-02-22 21:01:10','2019-02-22 21:01:10',0),(7,6,17,'SSR3000000001','Ram DDR3','Ram DDR3 4GB',3,'Ram DDR3 4GB Bus 12800',0,'2018-09-12 00:00:00','2019-09-12 00:00:00','bgarfath0','hdyke0','2019-02-22 21:01:10','2019-02-22 21:01:10',0),(8,6,17,'SSR3000000002','Ram DDR3','Ram DDR3 4GB',3,'Ram DDR3 4GB Bus 12800',0,'2018-09-12 00:00:00','2019-09-12 00:00:00','bgarfath0','hdyke0','2019-02-22 21:01:10','2019-02-22 21:01:10',0),(9,6,17,'SSR3000000003','Ram DDR3','Ram DDR3 4GB',3,'Ram DDR3 4GB Bus 12800',0,'2018-09-12 00:00:00','2019-09-12 00:00:00','bgarfath0','hdyke0','2019-02-22 21:01:10','2019-02-22 21:01:10',0),(10,6,17,'SSR3000000004','Ram DDR3','Ram DDR3 4GB',3,'Ram DDR3 4GB Bus 12800',0,'2018-09-12 00:00:00','2019-09-12 00:00:00','bgarfath0','hdyke0','2019-02-22 21:01:10','2019-02-22 21:01:10',0),(11,0,7,'HPDK660000002','HP Prodesk 660','HP Prodesk 660',1,'Chip: Intel Core i5-3250U\r RAM: 16GB DDR3 2400MHz\r Ổ cứng: 256GB SSD M.2 PCIe\r Chipset đồ họa: Intel UHD Graphics 4000',0,'2018-09-12 00:00:00','2019-09-12 00:00:00','bgarfath0','hdyke0','2019-02-22 21:01:10','2019-02-22 21:01:10',0),(12,11,17,'SSR3000000005','Ram DDR3','Ram DDR3 4GB',3,'Ram DDR3 4GB Bus 12800',0,'2018-09-12 00:00:00','2019-09-12 00:00:00','bgarfath0','hdyke0','2019-02-22 21:01:10','2019-02-22 21:01:10',0),(13,11,17,'SSR3000000006','Ram DDR3','Ram DDR3 4GB',3,'Ram DDR3 4GB Bus 12800',0,'2018-09-12 00:00:00','2019-09-12 00:00:00','bgarfath0','hdyke0','2019-02-22 21:01:10','2019-02-22 21:01:10',0),(14,11,17,'SSR3000000007','Ram DDR3','Ram DDR3 4GB',3,'Ram DDR3 4GB Bus 12800',0,'2018-09-12 00:00:00','2019-09-12 00:00:00','bgarfath0','hdyke0','2019-02-22 21:01:10','2019-02-22 21:01:10',0),(15,11,17,'SSR3000000008','Ram DDR3','Ram DDR3 4GB',3,'Ram DDR3 4GB Bus 12800',0,'2018-09-12 00:00:00','2019-09-12 00:00:00','bgarfath0','hdyke0','2019-02-22 21:01:10','2019-02-22 21:01:10',0),(16,6,22,'SSDM000000001','SSD Evo680','SSD Evo680-6 256GB',3,'Loại SSD: Giao tiếp Sata III',0,'2018-09-12 00:00:00','2019-09-12 00:00:00','bgarfath0','hdyke0','2019-02-22 21:01:10','2019-02-22 21:01:10',0),(17,11,22,'SSDM000000002','SSD Evo680','SSD Evo680-6 256GB',3,'Loại SSD: Giao tiếp Sata III',0,'2018-09-12 00:00:00','2019-09-12 00:00:00','bgarfath0','hdyke0','2019-02-22 21:01:10','2019-02-22 21:01:10',0),(18,0,22,'SSDM000000003','SSD Evo680','SSD Evo680-6 256GB',3,'Loại SSD: Giao tiếp Sata III',0,'2018-09-12 00:00:00','2019-09-12 00:00:00','bgarfath0','hdyke0','2019-02-22 21:01:10','2019-02-22 21:01:10',0),(19,0,22,'SSDM000000004','SSD Evo680','SSD Evo680-6 256GB',3,'Loại SSD: Giao tiếp Sata III',0,'2018-09-12 00:00:00','2019-09-12 00:00:00','bgarfath0','hdyke0','2019-02-22 21:01:10','2019-02-22 21:01:10',0),(20,0,22,'SSDM000000005','SSD Evo680','SSD Evo680-6 256GB',3,'Loại SSD: Giao tiếp Sata III',0,'2018-09-12 00:00:00','2019-09-12 00:00:00','bgarfath0','hdyke0','2019-02-22 21:01:10','2019-02-22 21:01:10',0);
/*!40000 ALTER TABLE `devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'tienpv','Phạm Văn Tiến','Programmer',1,'egeraldo0','egeraldo0','2018-03-20 19:56:32','2019-03-06 10:16:59',0),(2,'hanhtv','Trần Văn Hạnh','Programmer',1,'mmongain1','mmongain1','2019-01-17 16:12:37','2018-07-07 11:04:29',0),(3,'thinhbt','Bùi Trung Thịnh','Programmer',1,'scorneck2','scorneck2','2018-09-25 07:37:06','2018-11-01 00:00:08',0),(4,'giangdv','Đoàn Văn Giang','Programmer',1,'rinder3','rinder3','2018-07-15 14:42:57','2018-07-18 06:39:38',0),(5,'trungnq','Nguyễn Quang Trung','Programmer',1,'norring4','norring4','2018-09-30 20:54:48','2018-10-08 22:07:49',0),(6,'trungdq','Đặng Quang Trung','Programmer',1,'cchurm5','cchurm5','2018-10-16 20:28:33','2019-01-20 19:21:19',0),(7,'thaipd','Phạm Duy Thái','Leader Project',1,'bdunk6','bdunk6','2018-10-20 02:19:42','2018-10-05 03:47:51',0),(8,'hungdh','Đỗ Huy Hùng','Project Manager',2,'tmarchington7','tmarchington7','2018-04-05 07:08:39','2018-05-02 03:12:39',0),(9,'nhaitt','Trịnh Thị Nhài','Accounting',3,'kteaz8','kteaz8','2018-06-22 15:03:04','2019-03-02 09:49:34',0),(10,'haitt','Trịnh Thị Hải','Administrator',3,'cface9','cface9','2018-04-16 11:29:38','2018-09-15 07:53:34',0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-21 15:50:35
