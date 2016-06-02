-- MySQL dump 10.16  Distrib 10.1.8-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: majialichen
-- ------------------------------------------------------
-- Server version	10.1.8-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `mj_article`
--

DROP TABLE IF EXISTS `mj_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mj_article` (
  `mj_id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `mj_username` varchar(20) NOT NULL,
  `mj_type` tinyint(2) unsigned NOT NULL,
  `mj_title` varchar(40) NOT NULL,
  `mj_content` varchar(10000) NOT NULL,
  `mj_read` int(8) unsigned NOT NULL COMMENT '阅读量',
  `mj_comment` int(8) unsigned NOT NULL COMMENT '评论量',
  `mj_nice` tinyint(3) unsigned NOT NULL COMMENT '精华帖',
  `mj_last_modify` datetime NOT NULL,
  `mj_date` datetime NOT NULL,
  `mj_reid` int(11) NOT NULL DEFAULT '0' COMMENT '主题id',
  PRIMARY KEY (`mj_id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mj_article`
--

LOCK TABLES `mj_article` WRITE;
/*!40000 ALTER TABLE `mj_article` DISABLE KEYS */;
INSERT INTO `mj_article` VALUES (50,'b',1,'第一次发帖','[b]第一次发帖第一次发帖[/b]',8,0,1,'0000-00-00 00:00:00','2016-03-10 20:42:22',0),(51,'he',3,'数据库第二次发帖','[i]哈哈哈[/i]\r\n[u]underline[/u]',3,0,0,'0000-00-00 00:00:00','2016-03-10 20:43:54',0),(52,'he',1,'<a>第三次发帖</a>','[color=#fe1]黄色[/color]',2,0,0,'0000-00-00 00:00:00','2016-03-10 20:52:15',0),(53,'he',8,'换个新标题','[s]这是删除线[/s]',8,3,0,'0000-00-00 00:00:00','2016-03-10 20:55:16',0),(54,'he',8,'RE:换个新标题','[s]回复这个主题[/s]',0,0,0,'0000-00-00 00:00:00','2016-03-10 20:58:31',53),(55,'huahua',8,'RE:换个新标题','<a>这是html标签</a>',0,0,0,'0000-00-00 00:00:00','2016-03-10 21:13:42',53),(56,'huahua',8,'回复3楼的huahua','asdasdasdasdasda回帖无时间限制',0,0,0,'0000-00-00 00:00:00','2016-03-10 21:14:04',53),(57,'libaobao',5,'woshilibaobao','woshilibaobaowoshilibaobaowoshilibaobao',1,0,0,'0000-00-00 00:00:00','2016-03-11 10:07:08',0),(58,'xin',1,'新人求罩','新人求罩新人求罩新人求罩',3,0,0,'0000-00-00 00:00:00','2016-03-13 23:03:31',0),(59,'贺钧威',1,'asd','asdsad[size=12]adsasd[/size]',2,0,0,'0000-00-00 00:00:00','2016-06-02 19:58:34',0);
/*!40000 ALTER TABLE `mj_article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mj_flower`
--

DROP TABLE IF EXISTS `mj_flower`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mj_flower` (
  `mj_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `mj_touser` varchar(20) CHARACTER SET utf8 NOT NULL,
  `mj_fromuser` varchar(20) CHARACTER SET utf8 NOT NULL,
  `mj_flower_num` int(8) NOT NULL COMMENT '送花数量',
  `mj_content` varchar(200) CHARACTER SET utf8 NOT NULL COMMENT '感言',
  `mj_date` datetime NOT NULL,
  PRIMARY KEY (`mj_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mj_flower`
--

LOCK TABLES `mj_flower` WRITE;
/*!40000 ALTER TABLE `mj_flower` DISABLE KEYS */;
INSERT INTO `mj_flower` VALUES (1,'b','he',0,'??????????~~~','2016-02-22 22:18:01'),(2,'he','he',1,'非常欣赏你，送你花啦~~~','2016-02-22 22:22:10'),(3,'jjjjj','he',9,'非常欣赏你，送你花啦~~~','2016-02-22 22:22:47'),(4,'he','贺钧威',1,'非常欣赏你，送你花啦~~~','2016-02-27 12:27:50');
/*!40000 ALTER TABLE `mj_flower` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mj_friend`
--

DROP TABLE IF EXISTS `mj_friend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mj_friend` (
  `mj_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `mj_tofriend` varchar(20) CHARACTER SET utf8 NOT NULL,
  `mj_fromfriend` varchar(20) CHARACTER SET utf8 NOT NULL,
  `mj_friend_query` varchar(200) CHARACTER SET utf8 NOT NULL,
  `mj_friend_state` tinyint(1) NOT NULL,
  `mj_date` datetime NOT NULL,
  PRIMARY KEY (`mj_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mj_friend`
--

LOCK TABLES `mj_friend` WRITE;
/*!40000 ALTER TABLE `mj_friend` DISABLE KEYS */;
INSERT INTO `mj_friend` VALUES (1,'jjjjj','helei','',0,'2016-02-21 00:00:00'),(7,'make','he','我想添加你为好友',1,'2016-02-22 13:09:00'),(8,'jjjjj','he','我想添加你为好友',1,'2016-02-22 21:59:23'),(9,'he','kubi','我想添加你为好友',1,'2016-02-27 12:13:23'),(10,'贺钧威','he','我想添加你为好友',1,'2016-02-27 12:14:56'),(11,'helei','贺钧威','我想添加你为好友',1,'2016-02-27 12:17:30'),(12,'he','helei','我想添加你为好友',1,'2016-02-27 12:30:16');
/*!40000 ALTER TABLE `mj_friend` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mj_message`
--

DROP TABLE IF EXISTS `mj_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mj_message` (
  `mj_id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '//id',
  `mj_touser` varchar(20) CHARACTER SET utf8 NOT NULL,
  `mj_fromuser` varchar(20) CHARACTER SET utf8 NOT NULL,
  `mj_content` varchar(200) CHARACTER SET utf8 NOT NULL,
  `mj_state` smallint(4) NOT NULL DEFAULT '0' COMMENT '//短信状态',
  `mj_date` datetime NOT NULL,
  PRIMARY KEY (`mj_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mj_message`
--

LOCK TABLES `mj_message` WRITE;
/*!40000 ALTER TABLE `mj_message` DISABLE KEYS */;
INSERT INTO `mj_message` VALUES (3,'make','jjjjj','200',1,'2016-02-19 17:54:29'),(4,'helei','jjjjj','1234567891011121314',2,'2016-02-19 22:06:37'),(7,'he','jjjjj','asdasd',3,'2016-02-20 17:25:59'),(8,'mjlc','jjjjj','123',1,'2016-02-20 17:26:14'),(9,'hejunwei','jjjjj','hahaha',1,'2016-02-20 17:26:22'),(15,'helei','jjjjj','adsad是打发打发',1,'2016-02-21 12:28:29'),(16,'he','jjjjj','asdasd撒发生的非常小美女在空间',1,'2016-02-21 12:29:58'),(17,'fuck','fuck','asdasd',0,'2016-02-21 12:46:14'),(18,'make','fuck','阿萨是多少',8,'2016-02-21 13:14:13'),(19,'jjjjj','jjjjj','asdasd',1,'2016-02-21 14:45:31'),(20,'helei','helei','asdasd',1,'2016-02-21 14:48:39'),(21,'helei','he','非常欣赏你，送你花啦~~~',0,'2016-02-22 22:09:53'),(22,'he','he','非常欣赏你，送你花啦~~~',1,'2016-02-22 22:11:41'),(23,'he','he','非常欣赏你，送你花啦~~~',1,'2016-02-22 22:11:53'),(24,'he','he','非常欣赏你，送你花啦~~~',1,'2016-02-22 22:12:43'),(25,'helei','he','非常欣赏你，送你花啦~~~',0,'2016-02-22 22:12:54'),(26,'helei','he','非常欣赏你，送你花啦~~~',0,'2016-02-22 22:13:30'),(27,'he','he','非常欣赏你，送你花啦~~~',1,'2016-02-22 22:16:45'),(28,'he','贺钧威','啪啪啪啪啪啪啪啪啪·',2,'2016-02-27 12:27:41');
/*!40000 ALTER TABLE `mj_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mj_photo_comment`
--

DROP TABLE IF EXISTS `mj_photo_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mj_photo_comment` (
  `mj_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mj_title` varchar(20) CHARACTER SET utf8 NOT NULL,
  `mj_content` text CHARACTER SET utf8 NOT NULL,
  `mj_sid` int(8) NOT NULL,
  `mj_username` varchar(20) CHARACTER SET utf8 NOT NULL,
  `mj_date` datetime NOT NULL,
  PRIMARY KEY (`mj_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mj_photo_comment`
--

LOCK TABLES `mj_photo_comment` WRITE;
/*!40000 ALTER TABLE `mj_photo_comment` DISABLE KEYS */;
INSERT INTO `mj_photo_comment` VALUES (1,'RE:丹尼斯·里奇','我爱c语言我爱c语言',1,'he','2016-03-05 12:34:46'),(2,'RE:丹尼斯·里奇','我爱c语言我爱c语言我爱c语言我爱c语言我爱c语言',1,'he','2016-03-05 12:35:17'),(3,'RE:丹尼斯·里奇','asdasdasdasd',1,'he','2016-03-05 14:52:49'),(4,'RE:丹尼斯·里奇','丹尼斯丹尼斯丹尼斯丹尼斯',1,'fuck','2016-03-05 15:41:07');
/*!40000 ALTER TABLE `mj_photo_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mj_photo_dir`
--

DROP TABLE IF EXISTS `mj_photo_dir`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mj_photo_dir` (
  `mj_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mj_name` varchar(20) CHARACTER SET utf8 NOT NULL,
  `mj_type` tinyint(1) NOT NULL,
  `mj_password` char(40) CHARACTER SET utf8 NOT NULL,
  `mj_content` varchar(200) CHARACTER SET utf8 NOT NULL,
  `mj_dir` varchar(200) CHARACTER SET utf8 NOT NULL,
  `mj_cover` varchar(200) CHARACTER SET utf8 NOT NULL,
  `mj_date` datetime NOT NULL,
  PRIMARY KEY (`mj_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mj_photo_dir`
--

LOCK TABLES `mj_photo_dir` WRITE;
/*!40000 ALTER TABLE `mj_photo_dir` DISABLE KEYS */;
INSERT INTO `mj_photo_dir` VALUES (3,'动漫',0,'e10adc3949ba59abbe56e057f20f883e','风景动漫','photos/1457016332','image/3.jpg','2016-03-03 22:45:32'),(8,'test',1,'4297f44b13955235245b2497399d7a93','123','photos/1457790701','photos/cover/1457790697.jpg','2016-03-12 21:51:41');
/*!40000 ALTER TABLE `mj_photo_dir` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mj_photos`
--

DROP TABLE IF EXISTS `mj_photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mj_photos` (
  `mj_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mj_name` varchar(20) CHARACTER SET utf8 NOT NULL,
  `mj_url` varchar(200) CHARACTER SET utf8 NOT NULL,
  `mj_content` varchar(200) CHARACTER SET utf8 NOT NULL,
  `mj_sid` int(8) NOT NULL COMMENT '图片对应的相册id',
  `mj_user` varchar(20) CHARACTER SET utf8 NOT NULL,
  `mj_read` int(5) NOT NULL COMMENT '浏览量',
  `mj_comment` int(5) NOT NULL COMMENT '评论量',
  `mj_date` datetime NOT NULL,
  PRIMARY KEY (`mj_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mj_photos`
--

LOCK TABLES `mj_photos` WRITE;
/*!40000 ALTER TABLE `mj_photos` DISABLE KEYS */;
INSERT INTO `mj_photos` VALUES (1,'丹尼斯·里奇','photos/1457016332/1457090006.jpg','c语言之父',3,'he',129,4,'2016-03-04 19:13:49'),(2,'古剑奇谭','photos/1457016332/1457090273.jpg','古剑奇谭',3,'he',5,0,'2016-03-04 19:18:06'),(5,'Twitter','photos/1457016332/1457099762.png','TwitterTwitter',3,'he',3,0,'2016-03-04 21:56:11'),(6,'普通页面','photos/1457016332/1457099842.png','',3,'he',4,0,'2016-03-04 21:57:30'),(7,'人儿','photos/1457016332/1457099924.jpg','',3,'he',6,0,'2016-03-04 21:58:53'),(8,'xampp','photos/1457016332/1457100028.gif','',3,'he',12,0,'2016-03-04 22:00:33'),(9,'sliang','photos/1457016332/1457100225.png','',3,'贺钧威',8,0,'2016-03-04 22:03:49'),(18,'袋鼠','photos/1457016332/1457272183.jpg','',3,'he',0,0,'2016-03-06 21:49:59'),(19,'啊啊啊啊','photos/1457016332/1457272380.jpg','',3,'he',5,0,'2016-03-06 21:53:04'),(20,'123','photos/1457790701/1457790781.jpg','1111',8,'he',4,0,'2016-03-12 21:53:03');
/*!40000 ALTER TABLE `mj_photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mj_system`
--

DROP TABLE IF EXISTS `mj_system`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mj_system` (
  `mj_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mj_webname` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT '网站名称',
  `mj_article` tinyint(2) unsigned NOT NULL COMMENT '文章分页',
  `mj_blog` tinyint(2) unsigned NOT NULL COMMENT '博友分页',
  `mj_photo` tinyint(2) unsigned NOT NULL COMMENT '相册分页',
  `mj_skin` tinyint(2) unsigned NOT NULL COMMENT '网站皮肤',
  `mj_string` varchar(200) CHARACTER SET utf8 NOT NULL COMMENT '敏感字符串过滤',
  `mj_post` tinyint(3) unsigned NOT NULL COMMENT '发帖限制',
  `mj_re` tinyint(3) unsigned NOT NULL COMMENT '回帖限制',
  `mj_code` tinyint(1) unsigned NOT NULL COMMENT '是否有验证码',
  `mj_register` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`mj_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mj_system`
--

LOCK TABLES `mj_system` WRITE;
/*!40000 ALTER TABLE `mj_system` DISABLE KEYS */;
INSERT INTO `mj_system` VALUES (1,'majialichen.com',9,15,12,1,'NND|SB|sb|jb|JB|',60,15,1,1);
/*!40000 ALTER TABLE `mj_system` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mj_user`
--

DROP TABLE IF EXISTS `mj_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mj_user` (
  `mj_id` int(10) NOT NULL AUTO_INCREMENT,
  `mj_uniqid` char(40) DEFAULT NULL,
  `mj_active` char(40) DEFAULT NULL,
  `mj_username` varchar(20) DEFAULT NULL,
  `mj_password` char(40) DEFAULT NULL,
  `mj_question` varchar(20) DEFAULT NULL,
  `mj_answer` varchar(20) DEFAULT NULL,
  `mj_email` varchar(40) DEFAULT NULL,
  `mj_reg_time` datetime DEFAULT NULL,
  `mj_last_time` datetime DEFAULT NULL,
  `mj_last_ip` varchar(20) DEFAULT NULL,
  `mj_gender` varchar(20) DEFAULT NULL,
  `mj_face` varchar(20) DEFAULT NULL,
  `mj_level` tinyint(1) DEFAULT NULL,
  `mj_login_count` smallint(4) unsigned NOT NULL DEFAULT '0',
  `mj_switch` tinyint(1) unsigned NOT NULL COMMENT '个性签名开关',
  `mj_autograph` varchar(200) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '签名内容',
  `mj_post_time` varchar(20) NOT NULL DEFAULT '0' COMMENT '发帖时间',
  `mj_re_time` varchar(20) NOT NULL DEFAULT '0' COMMENT '回帖时间',
  PRIMARY KEY (`mj_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mj_user`
--

LOCK TABLES `mj_user` WRITE;
/*!40000 ALTER TABLE `mj_user` DISABLE KEYS */;
INSERT INTO `mj_user` VALUES (23,'35d07d4f4382e92430f17b8a6023d83108abd2e3','1','class','0b819521e158b8e50e566fbd0c5dfd23','','','405947712@qq.com','2016-02-11 17:47:14','2016-02-11 17:47:14','::1','boy','1',NULL,0,0,NULL,'0','0'),(24,'f8fc04e8ffc0f655e17985fb95d99c34f7ce1a82','1','mjlc','52c69e3a57331081823331c4e69d3f2e','','','hejunweimake@gmail.com','2016-02-11 17:48:26','2016-03-01 02:06:59','::1','girl','13',NULL,2,1,'lalalalala','0','0'),(25,'b90d226e1f30d4368f234e7200336fb5baf1ebcc','1','he','e10adc3949ba59abbe56e057f20f883e','','','hejunweimake@gmail.com','2016-02-11 22:33:15','2016-05-01 10:56:19','::1','girl','11',1,56,0,NULL,'1457623398','0'),(26,'4b8382e8f96a6c3fcda6a3ace0879149d036f12d','1','helei','e10adc3949ba59abbe56e057f20f883e','','','hejunweimake@gmail.com','2016-02-11 22:56:33','2016-02-27 12:29:38','::1','boy','21',NULL,3,0,NULL,'0','0'),(27,'a218b5b5f7285750947be93104b7eb3176eb3c24','1','make','52c69e3a57331081823331c4e69d3f2e','','','7777777@qq.com','2016-02-11 23:09:37','2016-02-29 15:49:38','192.168.1.101','boy','1',1,7,1,'我是贺钧威','0','0'),(30,'fb504afefbd2810ed4e5505279e20b36a45f5cca','1','majia','0b819521e158b8e50e566fbd0c5dfd23','','','majialichen@qq.com','2016-02-19 14:52:52','2016-02-19 14:53:08','192.168.1.101','girl','30',NULL,1,0,NULL,'0','0'),(31,'0331a20d7bf0e596e26be03b4b39d84720ca6549','1','jjjjj','96e79218965eb72c92a549dd5a330112','','','hejunweimake@gmail.com','2016-02-19 17:30:19','2016-03-06 17:51:09','::1','boy','14',NULL,9,0,NULL,'0','0'),(32,'6a0d804589d34c26c29339f22901b96bc8876d37','1','贺磊','0b819521e158b8e50e566fbd0c5dfd23','','','hejunweimake@gmail.com','2016-02-22 23:31:07','2016-02-22 23:31:07','::1','boy','12',NULL,0,0,NULL,'0','0'),(33,'e33569e44e14dd337b4756f547b428b33e8cb400','1','马佳荔晨','e10adc3949ba59abbe56e057f20f883e','','','majialichen@qq.com','2016-02-22 23:34:55','2016-02-22 23:36:17','::1','girl','18',NULL,1,0,NULL,'0','0'),(34,'5bd59d799d8501ca3dddadc42989042f7f2a4b03','1','贺钧威','e10adc3949ba59abbe56e057f20f883e','','','hejunweimake@gmail.com','2016-02-23 13:19:38','2016-06-02 19:58:17','::1','boy','14',1,15,1,'我是马佳荔晨','1464868714','0'),(35,'52cabcc77d78a79220402f9754f6f9bc52fa648a','1','kubi','e10adc3949ba59abbe56e057f20f883e','我家的狗狗','花花','majialichen@qq.com','2016-02-27 10:03:22','2016-02-27 12:19:48','::1','girl','30',NULL,3,0,NULL,'0','0'),(36,'48eba1c285af675d40643517fd029604da3a0cb2','1','oopp','e10adc3949ba59abbe56e057f20f883e','','','7777777@qq.com','2016-03-03 13:40:43','2016-03-03 13:40:43','::1','boy','7',NULL,0,0,NULL,'0','0'),(38,'4c351348f8264f51c2c65b70ee9ccce91e97fd04','1','sb','e10adc3949ba59abbe56e057f20f883e','','','7777777@qq.com','2016-03-03 14:06:49','2016-03-03 14:06:49','::1','boy','27',NULL,0,0,NULL,'0','0'),(39,'c7817624db37639e95f9b7ad37cdc9f0709e9103','1','pooi','e10adc3949ba59abbe56e057f20f883e','','','7777777@qq.com','2016-03-03 14:48:41','2016-03-03 14:48:41','::1','boy','9',NULL,0,0,NULL,'0','0'),(40,'528560cc689ae339167f35e26eddff38c59d539c','1','huahua','e10adc3949ba59abbe56e057f20f883e','','','hejunweimake@gmail.com','2016-03-10 20:59:39','2016-03-10 20:59:57','::1','girl','21',NULL,1,0,NULL,'0','0'),(41,'30268e94f6e6ad571447601252d9528a525f90b1','1','libaobao','e10adc3949ba59abbe56e057f20f883e','','','7777777@qq.com','2016-03-11 10:06:25','2016-03-11 10:06:47','::1','girl','7',NULL,1,0,NULL,'1457662028','0'),(42,'46ff702c1479acb0777efae4f8fdd444ac07d6e1','1','xin','e10adc3949ba59abbe56e057f20f883e','','','majialichen@qq.com','2016-03-13 23:02:45','2016-03-13 23:03:14','::1','boy','28',NULL,1,0,NULL,'1457881411','0');
/*!40000 ALTER TABLE `mj_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-02 20:42:30
