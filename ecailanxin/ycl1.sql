# Host: localhost  (Version: 5.5.53)
# Date: 2018-11-05 17:43:09
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "ycl_address"
#

DROP TABLE IF EXISTS `ycl_address`;
CREATE TABLE `ycl_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `consignee` varchar(60) NOT NULL DEFAULT '0' COMMENT '收货人',
  `phone` varchar(20) NOT NULL DEFAULT '' COMMENT '联系电话',
  `region` varchar(255) NOT NULL DEFAULT '' COMMENT '地区',
  `street` varchar(200) NOT NULL DEFAULT '' COMMENT '街道',
  `details` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `is_mr` int(11) NOT NULL DEFAULT '0' COMMENT '是否默认',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='收货地址';

#
# Data for table "ycl_address"
#

/*!40000 ALTER TABLE `ycl_address` DISABLE KEYS */;
INSERT INTO `ycl_address` VALUES (8,41,3,'小刘','15621968874','济南','小柳','泰安',1),(9,41,107,'xiaozhang','15621325587','asd','sd安装时','asd',1),(12,39,111,'小弟弟','15621365547','事实上','的方式','地方的风格',1),(13,41,111,'小火花','15621325546','硕士','asd','水电费',1),(14,39,111,'asd','15955421454','asd','山东','阿萨',1),(15,39,112,'asd','15623654548','山东','发给','按时打算',1),(17,0,11,'我','15621325587','山东','撒旦','山东',1),(18,0,11,'是','15677654453','是',' 是','是',1),(19,0,11,'是','15621332254','的','的',' 的阿萨',0),(22,11,11,'是','15621552245','地方d',' 山东','山东',1),(24,11,11,'asd','15621355545','的风格','山东','山东',1);
/*!40000 ALTER TABLE `ycl_address` ENABLE KEYS */;

#
# Structure for table "ycl_admin"
#

DROP TABLE IF EXISTS `ycl_admin`;
CREATE TABLE `ycl_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` int(11) NOT NULL DEFAULT '0' COMMENT '密码',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称',
  `limits` int(11) NOT NULL DEFAULT '0' COMMENT '权限',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='管理员表';

#
# Data for table "ycl_admin"
#

/*!40000 ALTER TABLE `ycl_admin` DISABLE KEYS */;
INSERT INTO `ycl_admin` VALUES (3,'admin',123456,1524295026,'顾初',2);
/*!40000 ALTER TABLE `ycl_admin` ENABLE KEYS */;

#
# Structure for table "ycl_article"
#

DROP TABLE IF EXISTS `ycl_article`;
CREATE TABLE `ycl_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '文章内容',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加的时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文章';

#
# Data for table "ycl_article"
#

/*!40000 ALTER TABLE `ycl_article` DISABLE KEYS */;
/*!40000 ALTER TABLE `ycl_article` ENABLE KEYS */;

#
# Structure for table "ycl_bazaar"
#

DROP TABLE IF EXISTS `ycl_bazaar`;
CREATE TABLE `ycl_bazaar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT NULL COMMENT '商家id',
  `baname` varchar(255) DEFAULT NULL COMMENT '市场名字',
  `bazaar_img` varchar(255) DEFAULT NULL COMMENT '市场图片',
  `place` varchar(255) DEFAULT NULL COMMENT '市场位置',
  `distance` int(11) DEFAULT NULL COMMENT '市场距离',
  `scale` int(11) DEFAULT NULL COMMENT '市场规模',
  `scalesize` varchar(255) DEFAULT NULL COMMENT '规模单位',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '市场简介',
  `parasang` varchar(255) DEFAULT '' COMMENT '距离单位',
  `first` int(11) DEFAULT '0' COMMENT '手动推荐市场',
  `city` varchar(255) DEFAULT NULL COMMENT '市场所在城市',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='批发市场';

#
# Data for table "ycl_bazaar"
#

/*!40000 ALTER TABLE `ycl_bazaar` DISABLE KEYS */;
INSERT INTO `ycl_bazaar` VALUES (1,NULL,'义乌中国小商品城东北市场','20180727\\91d94324d16d2859eba108a220821b38.jpg','遥远的西方',500,250,'9','只有你想不到的没有你买不到的','9',0,'北京市'),(3,NULL,'中国小商品批发市场','20180727\\476c08f1b9fe0cd22e0264c25533497e.jpg','家里蹲',600,5000,'8','小','9',1,'济南市'),(4,NULL,'十里城市场','20180727\\2d6cf2b738e4d841456ae67e72b1f57b.jpg','0m',10,10000,'8','非常小','9',0,'济南市'),(5,NULL,'新土门蔬菜市场','20180727\\0e7f18181d44a2ae1e7a8d1a95fa3790.jpg','20',20,20,'8','我','9',1,'北京市'),(6,NULL,'食品粮油水果批发市场','20180727\\3834d0fa16b4bc39e2e0c83d1d5c4a9b.jpg','山东济南100号',600,50000,'8','没毛病','9',0,'北京市'),(7,NULL,'好莱坞大市场','20181010\\a0a66119ba083aabaa5e49928686efdc.png','大幅度的',105,1000,'9','返回','9',0,'济南市'),(8,NULL,'洪门市场','20181010\\8c008b90adb2d4efa9812809cdef6dd2.png','家里蹲',222,33,'8','风格化','10',0,'济南市'),(9,NULL,'嘿嘿嘿嘿嘿嘿嘿','20181010\\e3f34154736c6c794a9c730c81e2d25c.png','阿萨',333,444,'6','分','6',0,'济南市');
/*!40000 ALTER TABLE `ycl_bazaar` ENABLE KEYS */;

#
# Structure for table "ycl_bill"
#

DROP TABLE IF EXISTS `ycl_bill`;
CREATE TABLE `ycl_bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL COMMENT '订单id',
  `time` varchar(255) DEFAULT NULL COMMENT '订单时间',
  `type_id` int(11) DEFAULT NULL COMMENT '类型id\\',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='账单表';

#
# Data for table "ycl_bill"
#

/*!40000 ALTER TABLE `ycl_bill` DISABLE KEYS */;
/*!40000 ALTER TABLE `ycl_bill` ENABLE KEYS */;

#
# Structure for table "ycl_brand"
#

DROP TABLE IF EXISTS `ycl_brand`;
CREATE TABLE `ycl_brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(255) DEFAULT NULL COMMENT '品牌名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='品牌';

#
# Data for table "ycl_brand"
#

/*!40000 ALTER TABLE `ycl_brand` DISABLE KEYS */;
INSERT INTO `ycl_brand` VALUES (6,'金锣冷鲜肉'),(7,'肯德基');
/*!40000 ALTER TABLE `ycl_brand` ENABLE KEYS */;

#
# Structure for table "ycl_brokerage"
#

DROP TABLE IF EXISTS `ycl_brokerage`;
CREATE TABLE `ycl_brokerage` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='佣金';

#
# Data for table "ycl_brokerage"
#

/*!40000 ALTER TABLE `ycl_brokerage` DISABLE KEYS */;
/*!40000 ALTER TABLE `ycl_brokerage` ENABLE KEYS */;

#
# Structure for table "ycl_button"
#

DROP TABLE IF EXISTS `ycl_button`;
CREATE TABLE `ycl_button` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `evaluate` int(11) DEFAULT NULL COMMENT '0 不评价  1评价',
  `open` varchar(255) DEFAULT NULL COMMENT '0 未营业 1营业',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='按钮';

#
# Data for table "ycl_button"
#

/*!40000 ALTER TABLE `ycl_button` DISABLE KEYS */;
/*!40000 ALTER TABLE `ycl_button` ENABLE KEYS */;

#
# Structure for table "ycl_cash"
#

DROP TABLE IF EXISTS `ycl_cash`;
CREATE TABLE `ycl_cash` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cash` int(11) NOT NULL DEFAULT '0' COMMENT '押金',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='押金';

#
# Data for table "ycl_cash"
#

/*!40000 ALTER TABLE `ycl_cash` DISABLE KEYS */;
/*!40000 ALTER TABLE `ycl_cash` ENABLE KEYS */;

#
# Structure for table "ycl_category_one"
#

DROP TABLE IF EXISTS `ycl_category_one`;
CREATE TABLE `ycl_category_one` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品类型id',
  `catonename` varchar(255) NOT NULL DEFAULT '' COMMENT '类型名字',
  `up_catid` int(11) DEFAULT '0' COMMENT '上级分类id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='商品一级分类表';

#
# Data for table "ycl_category_one"
#

/*!40000 ALTER TABLE `ycl_category_one` DISABLE KEYS */;
INSERT INTO `ycl_category_one` VALUES (7,'蔬菜类',0),(8,'肉食类',0),(9,'水产类',0),(10,'柴米油盐醋类',0),(11,'水果类',0),(12,'动物',0),(13,'哈哈',0);
/*!40000 ALTER TABLE `ycl_category_one` ENABLE KEYS */;

#
# Structure for table "ycl_category_three"
#

DROP TABLE IF EXISTS `ycl_category_three`;
CREATE TABLE `ycl_category_three` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `catthreename` varchar(255) NOT NULL DEFAULT '' COMMENT '商品名字',
  `up_catid` int(11) NOT NULL DEFAULT '0' COMMENT '上级分类id',
  `img` varchar(255) DEFAULT NULL COMMENT '图片',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='商品三级分类表';

#
# Data for table "ycl_category_three"
#

/*!40000 ALTER TABLE `ycl_category_three` DISABLE KEYS */;
INSERT INTO `ycl_category_three` VALUES (4,'牛排',3,'20180727\\5fca085ba05b3ad9525f1f7279ed7a41.jpg'),(5,'鸡柳',4,'20180727\\7f748098fe6ebee21fee34b40c623054.jpg'),(6,'洋葱',6,'20180727\\7413ba55bad468d8115c9fbfc2323034.jpg'),(7,'芹菜',8,'20180727\\ea1c13c713270aa0c631fd1c2c9de3f2.jpg'),(8,'萝卜',6,'20180727\\c51cdfeb06191c1c8344bea6ef66550c.jpg'),(11,'梦之蓝',11,'20180727\\80730d7f0d059b426fb7bcba040570d2.jpg'),(12,'细菌',7,'20180727\\b4c022e1d6fbaa5028240e2725f71992.jpg'),(13,'冷鲜肉',4,'20180727\\2b8c55882927558c9f32a9c1ad758ec0.jpg'),(15,'老抽',12,'20180727\\82a225d210cde0e06156d56466c11f13.jpg'),(16,'芹菜',3,'20181022\\94130e603866a34e5e3895e05e875e70.png'),(17,'细菌',3,'20181022\\e83a3c31e4ecb65d4adafee789db59ca.png');
/*!40000 ALTER TABLE `ycl_category_three` ENABLE KEYS */;

#
# Structure for table "ycl_category_two"
#

DROP TABLE IF EXISTS `ycl_category_two`;
CREATE TABLE `ycl_category_two` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `cattwoname` varchar(255) NOT NULL DEFAULT '' COMMENT '商品名字',
  `up_catid` int(11) NOT NULL DEFAULT '0' COMMENT '上级分类id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='商品四级分类表';

#
# Data for table "ycl_category_two"
#

/*!40000 ALTER TABLE `ycl_category_two` DISABLE KEYS */;
INSERT INTO `ycl_category_two` VALUES (3,'法式肉',8),(4,'中式肉',8),(5,'美式肉',8),(6,'豆类',7),(7,'菌类',7),(8,'根茎类',7),(9,'死海',9),(10,'咸海',9),(11,'海之蓝类',9),(12,'北京老醋',10),(13,'浆果类',11),(14,'柑橘类',11),(15,'谁I个',7);
/*!40000 ALTER TABLE `ycl_category_two` ENABLE KEYS */;

#
# Structure for table "ycl_chat_group"
#

DROP TABLE IF EXISTS `ycl_chat_group`;
CREATE TABLE `ycl_chat_group` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL COMMENT '聊天人ID',
  `img` varchar(255) DEFAULT NULL COMMENT '聊天图片',
  `content` varchar(255) DEFAULT NULL COMMENT '聊天内容',
  `status` smallint(6) DEFAULT NULL COMMENT '聊天状态  1为普通聊天  2为采购单信息  3为图片消息',
  `group` int(11) DEFAULT NULL COMMENT '聊天所属群组（门店ID）',
  `purchase` int(11) DEFAULT NULL COMMENT '采购单ID',
  `nickname` varchar(255) DEFAULT NULL COMMENT '聊天人昵称',
  `addtime` int(11) DEFAULT NULL COMMENT '添加时间',
  `portrait` varchar(255) DEFAULT NULL COMMENT '用户头像',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

#
# Data for table "ycl_chat_group"
#

INSERT INTO `ycl_chat_group` VALUES (00000000001,11,NULL,'123',1,NULL,NULL,NULL,1534409348,'20180719\\09f8c7fc9c05bfc35327aadb8e40cf3b.png'),(00000000002,11,NULL,'as',1,NULL,NULL,NULL,1534581599,'20180719\\09f8c7fc9c05bfc35327aadb8e40cf3b.png'),(00000000003,11,NULL,'啊大叔',1,NULL,NULL,NULL,1534726149,'20180719\\09f8c7fc9c05bfc35327aadb8e40cf3b.png'),(00000000004,87,NULL,'否',1,87,NULL,NULL,1535016726,NULL),(00000000005,88,NULL,'环境',1,88,NULL,NULL,1535017113,NULL),(00000000006,67,NULL,'辅导',1,88,NULL,NULL,1535017186,NULL),(00000000007,67,NULL,'54',1,88,NULL,NULL,1535017301,NULL),(00000000008,67,NULL,'辅导',1,88,NULL,NULL,1535017652,NULL),(00000000009,11,NULL,'否',1,NULL,NULL,NULL,1535073048,'20180719\\09f8c7fc9c05bfc35327aadb8e40cf3b.png'),(00000000010,11,NULL,'444',1,NULL,NULL,NULL,1535075700,'20180719\\09f8c7fc9c05bfc35327aadb8e40cf3b.png'),(00000000011,11,NULL,'444',1,NULL,NULL,NULL,1535075701,'20180719\\09f8c7fc9c05bfc35327aadb8e40cf3b.png'),(00000000012,11,NULL,'5555',1,NULL,NULL,NULL,1535075708,'20180719\\09f8c7fc9c05bfc35327aadb8e40cf3b.png'),(00000000013,11,NULL,'让特人',1,NULL,NULL,NULL,1535076252,'20180719\\09f8c7fc9c05bfc35327aadb8e40cf3b.png'),(00000000014,11,NULL,'的',1,NULL,NULL,NULL,1535088649,'20180719\\09f8c7fc9c05bfc35327aadb8e40cf3b.png'),(00000000015,11,NULL,'e',1,11,NULL,NULL,1535349462,'20180719\\09f8c7fc9c05bfc35327aadb8e40cf3b.png'),(00000000016,11,NULL,NULL,2,11,254,NULL,1536720666,'20180719\\09f8c7fc9c05bfc35327aadb8e40cf3b.png'),(00000000017,11,NULL,NULL,2,11,NULL,NULL,1539155868,'20180719\\09f8c7fc9c05bfc35327aadb8e40cf3b.png'),(00000000018,11,NULL,NULL,2,11,NULL,NULL,1539155894,'20180719\\09f8c7fc9c05bfc35327aadb8e40cf3b.png'),(00000000019,11,NULL,NULL,2,11,NULL,NULL,1539157306,'20180719\\09f8c7fc9c05bfc35327aadb8e40cf3b.png'),(00000000020,11,NULL,'是',1,11,NULL,NULL,1540186341,'20180719\\09f8c7fc9c05bfc35327aadb8e40cf3b.png');

#
# Structure for table "ycl_check"
#

DROP TABLE IF EXISTS `ycl_check`;
CREATE TABLE `ycl_check` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `user_type` int(11) DEFAULT NULL COMMENT '用户类型',
  `add_time` varchar(255) DEFAULT NULL COMMENT '审核时间',
  `is_pass` int(11) DEFAULT NULL COMMENT '0 否 1是',
  `true_name` varchar(255) DEFAULT NULL COMMENT '真实姓名',
  `phone` char(32) DEFAULT NULL COMMENT '手机号',
  `sfz_zm` varchar(255) DEFAULT NULL COMMENT '身份证正面',
  `sfz_fm` varchar(255) DEFAULT NULL COMMENT 'sfz_fm',
  `addres` varchar(255) DEFAULT NULL COMMENT '地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='审核表';

#
# Data for table "ycl_check"
#

/*!40000 ALTER TABLE `ycl_check` DISABLE KEYS */;
INSERT INTO `ycl_check` VALUES (1,NULL,1,'1524808304',1,'小张子','3838438','20180427\\ea3fe5be6a4c72967436ff551f5242ba.jpg','20180427\\86fd9b0c63c3ffe098ee55f5abd47ccb.jpg','也来寡妇村'),(2,NULL,1,'1524808519',1,'张太监','3838438','20180427\\dadd81ab49c6eeef889aae5aec8a3c95.jpg','20180427\\af6c337b13fce0c4f53a5b5eb6c50dae.jpg','寡妇村'),(4,7,1,'1524903929',0,'一个小白脸','3838438438','20180428\\ccb0f4446194e434c3eba0e4d3ae6409.jpg','20180428\\04f205e0d61269ce27d33c6c075ee245.jpg','夜来香寡妇村'),(5,7,2,'1524903843',1,'小龙女','465465','20180428\\8c489a5932abf67b327f5dfd50c91990.jpg','20180428\\b714517b8f62969dc77a57065b7bb763.jpg','泰安');
/*!40000 ALTER TABLE `ycl_check` ENABLE KEYS */;

#
# Structure for table "ycl_city"
#

DROP TABLE IF EXISTS `ycl_city`;
CREATE TABLE `ycl_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(255) DEFAULT NULL COMMENT '城市名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='市场所属城市';

#
# Data for table "ycl_city"
#

/*!40000 ALTER TABLE `ycl_city` DISABLE KEYS */;
INSERT INTO `ycl_city` VALUES (1,'济南市'),(3,'北京市');
/*!40000 ALTER TABLE `ycl_city` ENABLE KEYS */;

#
# Structure for table "ycl_collect"
#

DROP TABLE IF EXISTS `ycl_collect`;
CREATE TABLE `ycl_collect` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) DEFAULT NULL COMMENT '店铺id',
  `goods_id` int(11) DEFAULT NULL COMMENT '商品id',
  `add_time` varchar(255) DEFAULT NULL COMMENT '收藏时间',
  `uid` int(11) DEFAULT '0' COMMENT '用户id',
  `shopimg` varchar(255) DEFAULT '' COMMENT '店铺图片',
  `goodsimg` varchar(255) DEFAULT NULL COMMENT '商品图片',
  `dizhi` varchar(255) DEFAULT NULL,
  `goodsmoney` varchar(255) DEFAULT NULL,
  `goodsgg` varchar(255) DEFAULT NULL,
  `shopname` varchar(255) DEFAULT NULL,
  `shopid` varchar(255) DEFAULT NULL,
  `goodsid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COMMENT='收藏';

#
# Data for table "ycl_collect"
#

/*!40000 ALTER TABLE `ycl_collect` DISABLE KEYS */;
INSERT INTO `ycl_collect` VALUES (42,NULL,10009,'1531468510',3,'','20180703\\e2fb980d6cdee2632335bb524d756e16.jpg',NULL,NULL,NULL,NULL,NULL,NULL),(47,15,NULL,'1531532204',3,'20180704\\be2597d083125a3ea1abee04279500bd.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(50,15,NULL,'1531539345',7,'20180704\\be2597d083125a3ea1abee04279500bd.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(52,14,NULL,'1531882891',3,'20180704\\02c1c1c9f4dfe78f9c4f087cd288feb0.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(53,11,NULL,'1531883142',3,'20180704\\02c1c1c9f4dfe78f9c4f087cd288feb0.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(54,10,NULL,'1531883267',3,'20180704\\02c1c1c9f4dfe78f9c4f087cd288feb0.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(57,12,NULL,'1532510683',NULL,'20180704\\02c1c1c9f4dfe78f9c4f087cd288feb0.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(60,19,NULL,'1533885624',41,'20180728\\1d8ae8e68a08f5018865c1d46e6f136f.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(62,11,NULL,'1535012229',11,'20180727\\66c1e70fcaefe3b2b128c4d6f0c9be87.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(63,12,NULL,'1535450677',41,'20180727\\d9be7052de0794d93795456696ff5002.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(64,18,NULL,'1539223231',41,'20180822\\cd6ab5f898139ca758a189a4b0cd8b52.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `ycl_collect` ENABLE KEYS */;

#
# Structure for table "ycl_comment"
#

DROP TABLE IF EXISTS `ycl_comment`;
CREATE TABLE `ycl_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `user_img` varchar(255) DEFAULT NULL COMMENT '用户头像',
  `add_time` varchar(255) DEFAULT NULL COMMENT '评论 时间',
  `content` varchar(255) DEFAULT NULL COMMENT '评论内容',
  `shop_id` int(11) DEFAULT '0' COMMENT '店铺id',
  `username` varchar(255) DEFAULT NULL COMMENT '用户昵称',
  `pingimg` varchar(255) DEFAULT NULL COMMENT '评论图片',
  `di` int(11) DEFAULT NULL COMMENT '店铺最低分排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='店铺评论表';

#
# Data for table "ycl_comment"
#

/*!40000 ALTER TABLE `ycl_comment` DISABLE KEYS */;
INSERT INTO `ycl_comment` VALUES (1,3,'20180705\\90d6f00786fd4e22a382f2ceac9a7046.jpg','1531101503','是',15,'悟空','20180709\\f3a9d3c1c647bf086ce16b030988fd63.jpg',50),(2,3,'20180705\\90d6f00786fd4e22a382f2ceac9a7046.jpg','1531122649','干嘛呢',11,'沙悟净','20180709\\f3a9d3c1c647bf086ce16b030988fd63.jpg',10),(3,3,'20180705\\0c49513e8e81082388c367fbe8478d4b.jpg','1531122908','干嘛呢',12,'白龙马','20180709\\f3a9d3c1c647bf086ce16b030988fd63.jpg',55),(4,7,'20180705\\0c49513e8e81082388c367fbe8478d4b.jpg','1531123137','',12,'佛祖','20180709\\f3a9d3c1c647bf086ce16b030988fd63.jpg',30),(5,3,'20180705\\90d6f00786fd4e22a382f2ceac9a7046.jpg','1531123466','哈哈',15,'八戒','20180709\\f3a9d3c1c647bf086ce16b030988fd63.jpg',20),(6,7,'20180705\\0c49513e8e81082388c367fbe8478d4b.jpg','1531123479','',12,'菩萨',NULL,55),(7,3,'20180705\\90d6f00786fd4e22a382f2ceac9a7046.jpg','1531357514','美中不足',10,'观音',NULL,60),(8,3,'20180705\\90d6f00786fd4e22a382f2ceac9a7046.jpg','1531357677','存',10,'弥勒佛','20180709\\f3a9d3c1c647bf086ce16b030988fd63.jpg',100),(9,7,'20180705\\90d6f00786fd4e22a382f2ceac9a7046.jpg','1531357683','不',11,'金角大王',NULL,6),(10,3,'20180705\\90d6f00786fd4e22a382f2ceac9a7046.jpg','1531365630','',15,'银角大王','20180709\\f3a9d3c1c647bf086ce16b030988fd63.jpg',78),(11,3,'20180705\\90d6f00786fd4e22a382f2ceac9a7046.jpg','1531365637','',12,'牛魔王',NULL,23),(12,3,'20180705\\90d6f00786fd4e22a382f2ceac9a7046.jpg','1531365640','硕士',12,'菩提',NULL,78),(13,3,'20180705\\90d6f00786fd4e22a382f2ceac9a7046.jpg','1531373953','案首',15,'小白','20180712\\f99730004ebb2dead87ca21a09036b03.jpg',35),(14,11,'20180719\\09f8c7fc9c05bfc35327aadb8e40cf3b.png','1534580397','as ',NULL,NULL,'20180818\\6f2c61521d5a9568a20b1bf0f6739a0a.jpg',NULL),(15,11,'20180719\\09f8c7fc9c05bfc35327aadb8e40cf3b.png','1534580863','fd ',13,NULL,'20180818\\46bdddad9e301ca005668add0ab26b7b.jpg',NULL);
/*!40000 ALTER TABLE `ycl_comment` ENABLE KEYS */;

#
# Structure for table "ycl_customer"
#

DROP TABLE IF EXISTS `ycl_customer`;
CREATE TABLE `ycl_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fromid` int(11) DEFAULT NULL COMMENT '发送人ID',
  `fromname` varchar(255) DEFAULT NULL COMMENT '发送人名称',
  `toid` int(11) DEFAULT NULL COMMENT '接收人ID',
  `toname` varchar(255) DEFAULT NULL COMMENT '接收人name',
  `content` varchar(600) DEFAULT NULL COMMENT '聊天内容',
  `addtime` int(11) DEFAULT NULL COMMENT '聊天时间',
  `shopid` int(11) DEFAULT NULL COMMENT '店铺ID',
  `status` smallint(6) DEFAULT NULL COMMENT '聊天格式  1（文字聊天）  2（图片）',
  `issee` smallint(6) DEFAULT NULL COMMENT '是否已读 1（已读） 2（未读）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8;

#
# Data for table "ycl_customer"
#

INSERT INTO `ycl_customer` VALUES (136,11,'511',9,'888','chat_img5b72426c53398.jpg',1534214764,NULL,2,1),(137,11,'511',9,'888','132',1534214835,NULL,1,1),(138,11,'511',9,'888','[em_40]454',1534214845,NULL,1,1);

#
# Structure for table "ycl_distri"
#

DROP TABLE IF EXISTS `ycl_distri`;
CREATE TABLE `ycl_distri` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hors_id` int(11) NOT NULL DEFAULT '0' COMMENT '骑手id',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='配送表';

#
# Data for table "ycl_distri"
#

/*!40000 ALTER TABLE `ycl_distri` DISABLE KEYS */;
/*!40000 ALTER TABLE `ycl_distri` ENABLE KEYS */;

#
# Structure for table "ycl_freight"
#

DROP TABLE IF EXISTS `ycl_freight`;
CREATE TABLE `ycl_freight` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `freight_money` decimal(10,2) DEFAULT '0.00' COMMENT '起步价',
  `priceofkm` decimal(10,2) DEFAULT '0.00' COMMENT '公里价格',
  `city` varchar(255) DEFAULT NULL COMMENT '设置城市所属',
  `withdraw_day` int(11) DEFAULT NULL COMMENT '骑手M天后提现',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='运费表';

#
# Data for table "ycl_freight"
#

/*!40000 ALTER TABLE `ycl_freight` DISABLE KEYS */;
/*!40000 ALTER TABLE `ycl_freight` ENABLE KEYS */;

#
# Structure for table "ycl_goods"
#

DROP TABLE IF EXISTS `ycl_goods`;
CREATE TABLE `ycl_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `shopid` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `catoneid` int(11) NOT NULL DEFAULT '0' COMMENT '一级`分类id',
  `cattwoid` int(11) NOT NULL DEFAULT '0' COMMENT '二级分类id',
  `catthreeid` int(11) NOT NULL DEFAULT '0' COMMENT '三级分类id',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `is_up` int(11) NOT NULL DEFAULT '1' COMMENT '1上架 0下架',
  `goodsname` varchar(255) NOT NULL DEFAULT '' COMMENT '商品名字',
  `goodspic` varchar(255) NOT NULL DEFAULT '' COMMENT '商品图片',
  `goodsprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `goodsarea` varchar(255) NOT NULL DEFAULT '' COMMENT '商品产地',
  `goodsgg` int(11) NOT NULL DEFAULT '0' COMMENT '商品规格',
  `sales` int(11) NOT NULL DEFAULT '0' COMMENT '销量',
  `brand_id` int(11) NOT NULL DEFAULT '0' COMMENT '品牌id',
  `name` varchar(255) DEFAULT NULL,
  `place` varchar(255) DEFAULT NULL COMMENT '位置',
  `distance` int(11) DEFAULT NULL COMMENT '距离',
  `alias` varchar(255) DEFAULT NULL COMMENT '商品别名',
  `oneimg` varchar(255) DEFAULT NULL COMMENT '图片1',
  `twoimg` varchar(255) DEFAULT NULL COMMENT '图片2',
  `threeimg` varchar(255) DEFAULT NULL COMMENT '图片3',
  `fourimg` varchar(255) DEFAULT NULL COMMENT '图片4',
  `introduce` varchar(255) DEFAULT NULL COMMENT '商品介绍',
  `discount` decimal(10,2) DEFAULT NULL COMMENT '折扣价',
  `tail` int(11) DEFAULT NULL COMMENT '尾货标志',
  `stock` varchar(255) DEFAULT NULL COMMENT '库存',
  `is_tj` int(11) DEFAULT '0' COMMENT '1 畅销榜 2肉禽最低价 3冻货专场 4调料专场 5粮油酒饮 6预加工品',
  `stockgg` varchar(255) DEFAULT NULL COMMENT '库存规格',
  `reputation` int(11) DEFAULT NULL COMMENT '好评',
  `city` varchar(255) DEFAULT NULL COMMENT '所售城市',
  `pinyin` varchar(255) DEFAULT NULL COMMENT '商品拼音',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10079 DEFAULT CHARSET=utf8 COMMENT='商品表';

#
# Data for table "ycl_goods"
#

/*!40000 ALTER TABLE `ycl_goods` DISABLE KEYS */;
INSERT INTO `ycl_goods` VALUES (10053,10,7,7,11,1539160054,1,'胡萝卜','20181010\\da636367898ecd38c11696b52757b607.jpg',333.00,'济南',6,0,6,NULL,NULL,NULL,'xiao','20181010\\e4384ce7fdc0c4207d73eed94dcef82a.jpg','20181010\\359330e7b0af4e82b9fbcecee199c03f.jpg','20181010\\5c5f7cc96d9e7b98bf2dd32d9dfbc956.jpg','20181010\\1377f16eec6a8dc3ffbc91acfc7c2096.jpg','好吃不贵',33.20,NULL,'110',0,NULL,NULL,'北京市','HLB'),(10054,11,7,8,8,1539160221,1,'丝瓜','20181010\\73bbc90b82eba5196328bdfcc0b9011c.jpg',111.00,'北京',6,3,7,NULL,NULL,NULL,'小牛犊','20181010\\7847a0be46cfd2f9e1d6ded8e0f8e799.jpg','20181010\\6dfa234affa290e71fbe9ddcb0d01351.jpg','20181010\\b89ccb13b174e87aa152a9bcb09b11be.jpg','20181010\\29b61f8fc83b3d0c1afe6ee30ba0d65a.jpg','可口',22.00,NULL,'52',0,NULL,NULL,'济南市','SG'),(10055,13,7,7,12,1539160359,1,'土豆','20181010\\fd26d2c9052a2fe128a5cb8648904a72.jpg',66.00,'山东',6,0,6,NULL,NULL,NULL,'王','20181010\\b8549ace659342f49efc93b6a8c597ac.jpg','20181010\\a96f356a956e02fc7bd078a9a821e90d.jpg','20181010\\cd0ce86bebf98c0594171d79684f26e1.jpg','20181010\\eb29c9296595790717d59c5367eb82bd.jpg','钱钱钱',55.00,NULL,'45',0,NULL,NULL,'济南市','TD'),(10056,10,7,7,12,1539160446,1,'土豆','20181010\\8a061605f99f4a08933f553238b67797.jpg',666.00,'山东',6,3,6,NULL,NULL,NULL,'小牛犊','20181010\\5982b24271762c017c2f16017007a369.jpg','20181010\\f10795eb04704252f6b61fdc74fe3498.jpg','20181010\\c9d6264a4a085793fa46bd8489d12685.jpg','20181010\\500cb6b7f862c2eacf8e4a094e9cb9ce.jpg','钱钱钱',55.00,NULL,'55',0,NULL,NULL,'北京市','TD'),(10057,13,7,6,7,1539160528,1,'菠菜','20181010\\a77fb9ed880a2604c5dccbd234aeb2ee.jpg',65.00,'北京',6,0,7,NULL,NULL,NULL,'小恒','20181010\\295cbebfa5397aa038ceb8e77e10d5dd.jpg','20181010\\45e6256100d91483abd8b2a36672d2a3.jpg','20181010\\52c792cc089e81581de3d9d37c0a0366.jpg','20181010\\1e2bd23e10140033c6dd10a07541416a.jpg','爱仕达',62.00,NULL,'45',0,NULL,NULL,'济南市','BC'),(10058,14,7,11,8,1539160647,1,'玉米','20181010\\a5068bcd874b16034274d4b124b736f0.jpg',21.00,'东京',6,0,6,NULL,NULL,NULL,'xiao','20181010\\c387f655376f8d7a11c400e521abccc7.jpg','20181010\\8d8579f465113779252a3bfa63d4f273.jpg','20181010\\f09a1204859e314ac28a676d12a38c1c.jpg','20181010\\5c8e6ca3d73615e1d8049a2697247ccc.jpg','可口',19.00,NULL,'254',0,NULL,NULL,'北京市','YM'),(10059,18,7,3,15,1539233824,1,'香蕉','20181010\\eb481084142c58f1a5b1f8086862a650.jpg',34.00,'台湾',6,3,6,NULL,NULL,NULL,'小牛犊','20181010\\858b7cd2c8080ff27e2f693a9bf22bf0.jpg','20181010\\3cc4bd2c79ce136dfef52c1c1e41b57c.jpg','20181010\\d0a3369624f8629e25d119d41a9f6ed1.jpg','20181010\\84951f2dccbaf2089b97784de052ea63.jpg','好吃',33.00,0,'47',0,'6',NULL,'济南市','XJ'),(10060,19,7,8,6,1539160788,1,'茄子','20181010\\7ee1ed296f0e41c6ba90673041824497.jpg',11.00,'北京',6,0,6,NULL,NULL,NULL,'王','20181010\\e611d056fa8f8ce802b808d21e1b17d5.jpg','20181010\\a5fdeeb2fd39309f78af76c7b6030601.jpg','20181010\\131c1bc2871500724bdb336bfe86111f.jpg','20181010\\64b7ac4af32e3ffcfe477f9c9a1ce69a.jpg','可口',1.00,NULL,'25',0,NULL,NULL,'北京市','QZ'),(10061,10,7,6,7,1539160902,1,'菠菜','20181010\\2e2c2c92c172cefbda5c2b3774df3e51.jpg',666.00,'北京',6,1,6,NULL,NULL,NULL,'小老虎','20181010\\812cbb0d88daf201d2cf1b075e2f9195.jpg','20181010\\bd0e2706545cec78d1ae441fe98b2878.jpg','20181010\\b57322a7ffbc4f8bd0bfe6164f3f7282.jpg','20181010\\0eef675a0b6021d445480b49b6f33eef.jpg','可口',66.00,NULL,'76',0,NULL,NULL,'北京市','BC'),(10062,10,8,4,4,1539161080,1,'猪肉','20181010\\f066360bc49432619f62d70207e75f2b.jpg',333.00,'东京',6,0,6,NULL,NULL,NULL,'小老虎','20181010\\297be475d2a8f8a9fc25878f5d78266b.jpg','20181010\\14dc4d67e4bd1e4d13830b9db90c2f4e.jpg','20181010\\9c90de2109a2a2b2e13ecf05ce36c16a.jpg','20181010\\f8c2732b9c5c83124d994d00ee28983c.jpg','爱仕达',234.00,NULL,'56',0,NULL,NULL,'北京市','ZR'),(10064,11,8,3,3,1539161125,1,'羊肉','20181010\\47f4d390f85ce10ee0e86fc476cef10f.jpg',222.00,'济南',6,0,6,NULL,NULL,NULL,'xiao','20181010\\3bbacd49d620493d3128bb5c4ce454fd.jpg','20181010\\a28b31d1c5536f326ef896b68059d75f.jpg','20181010\\0a240250226b930b1b9a0facf62e8f82.jpg','20181010\\ca3d67370e0aaa042dd64a67ffa198e4.jpg','钱钱钱',123.00,NULL,'89',0,NULL,NULL,'济南市','YR'),(10065,14,8,5,4,1539161237,1,'羊肉','20181010\\1bbd1306192644be61e1a9d58c171d57.jpg',22.00,'山东',6,2,6,NULL,NULL,NULL,'小牛犊','20181010\\279dd17c363586a153abbe6f44023ab2.jpg','20181010\\d8afdb33808e8f2f4da6a7900ba5c3cb.jpg','20181010\\fe54391621fe3363e3376c5d16099e27.jpg','20181010\\283e6535db493ca4992ff9bd01e0e3f0.jpg','爱仕达',11.00,NULL,'78',0,NULL,NULL,'北京市','YR'),(10066,18,7,3,0,1539314464,1,'苹果','20181012\\6f1e4b1b67deb76a7c7e577e33d75f5d.jpg',666.00,'台湾',6,3,6,NULL,NULL,NULL,'小牛犊',NULL,NULL,NULL,NULL,'发给',55.00,NULL,'47',0,'6',NULL,'济南市','PG'),(10067,18,7,3,0,1539761214,1,'梨','20181017\\e645a50d1148ac84de67515b57a5a3b8.jpg',13.00,'台湾',6,1,6,NULL,NULL,NULL,'搜',NULL,NULL,NULL,NULL,'搜',11.00,NULL,'32',0,'6',NULL,'济南市','L'),(10068,18,7,3,0,1539761330,1,'黄瓜','20181017\\e90fe120858b8c4dd2a0fbe41f319cfc.png',22.00,'台湾',6,1,6,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'山东',23.00,NULL,'22',0,'6',NULL,'济南市','L'),(10069,18,7,9,0,1539761361,1,'芒果','20181017\\2cf3cb82acf01ca3c2767901f2f894aa.png',34.00,'台湾',6,0,6,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'啊',3.00,NULL,'12',0,'6',NULL,'济南市','XJ'),(10070,18,7,3,0,1539761441,1,'西红柿','20181017\\2bb1ae1ef2b07f5197281008255bf603.png',44.00,'台湾',6,0,6,NULL,NULL,NULL,'兄弟',NULL,NULL,NULL,NULL,'阿萨',22.00,NULL,'22',0,'6',NULL,'济南市','XJ'),(10071,18,7,3,0,1539761460,1,'弥红桃','20181017\\01336dddaaf22699e24d96f210c10777.jpg',55.00,'台湾',6,0,6,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'是',44.00,NULL,'22',0,'6',NULL,'济南市','XJ'),(10072,18,7,3,0,1539761477,1,'火龙果','20181017\\e019453b1d50a472e0df9908aa53d289.jpg',55.00,'台湾',6,0,6,NULL,NULL,NULL,'二',NULL,NULL,NULL,NULL,'是',11.00,NULL,'23',0,'6',NULL,'济南市','XJ'),(10073,18,7,3,11,1540279330,1,'梦之蓝','20181023\\5d7da56e004fd5b469984ed0c08ad4ca.jpg',22.00,'台湾',6,0,6,NULL,NULL,NULL,'卅',NULL,NULL,NULL,NULL,'阿萨',22.00,NULL,'22',0,'6',NULL,'济南市','MZL'),(10078,18,8,4,5,1540286763,1,'鸡柳','20181023\\c10fd2ade7d17092055b0db651203ca8.jpg',22.00,'台湾',6,0,6,NULL,NULL,NULL,'阿萨',NULL,NULL,NULL,NULL,'阿萨',11.00,NULL,'23',0,'6',NULL,'济南市','JL');
/*!40000 ALTER TABLE `ycl_goods` ENABLE KEYS */;

#
# Structure for table "ycl_limits"
#

DROP TABLE IF EXISTS `ycl_limits`;
CREATE TABLE `ycl_limits` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `js_name` varchar(255) DEFAULT NULL COMMENT '角色名称',
  `group_id` varchar(255) DEFAULT NULL COMMENT '所属餐企id',
  `auth` varchar(255) DEFAULT NULL COMMENT '权限（0,1,2,3,4,5)',
  `uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色表';

#
# Data for table "ycl_limits"
#

/*!40000 ALTER TABLE `ycl_limits` DISABLE KEYS */;
/*!40000 ALTER TABLE `ycl_limits` ENABLE KEYS */;

#
# Structure for table "ycl_member"
#

DROP TABLE IF EXISTS `ycl_member`;
CREATE TABLE `ycl_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cost` int(11) NOT NULL DEFAULT '0' COMMENT '收费或免费期',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '会员开始时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员表';

#
# Data for table "ycl_member"
#

/*!40000 ALTER TABLE `ycl_member` DISABLE KEYS */;
/*!40000 ALTER TABLE `ycl_member` ENABLE KEYS */;

#
# Structure for table "ycl_news"
#

DROP TABLE IF EXISTS `ycl_news`;
CREATE TABLE `ycl_news` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) DEFAULT NULL,
  `centent` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='消息';

#
# Data for table "ycl_news"
#

/*!40000 ALTER TABLE `ycl_news` DISABLE KEYS */;
/*!40000 ALTER TABLE `ycl_news` ENABLE KEYS */;

#
# Structure for table "ycl_order"
#

DROP TABLE IF EXISTS `ycl_order`;
CREATE TABLE `ycl_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `buy_id` int(11) DEFAULT '0' COMMENT '购买者的id',
  `order_type` varchar(255) NOT NULL DEFAULT '' COMMENT '订单类型',
  `order_status` int(11) DEFAULT '9' COMMENT '默认9 等待商家接单 用户 骑手订单状态0代付款 1待验货 2待验证  6已巨单 8已完成订单',
  `shop_status` int(11) NOT NULL DEFAULT '0' COMMENT '0代接单 1已接单 2备货中 4待出货也是代取货 5配送中 9已巨单 6历史订单  7是骑手取货中',
  `goods_id` int(11) DEFAULT '0' COMMENT '商品的id',
  `shopid` int(11) DEFAULT NULL COMMENT '店铺的id',
  `good_num` int(11) NOT NULL DEFAULT '0' COMMENT '商品的数量',
  `good_pirce` int(11) NOT NULL DEFAULT '0' COMMENT '商品的价格',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '订单创建时间',
  `complate_time` int(11) NOT NULL DEFAULT '0' COMMENT '订单完成时间',
  `rider_id` int(11) DEFAULT NULL COMMENT '配送员id',
  `rec_time` int(11) NOT NULL DEFAULT '0' COMMENT '接单时间',
  `inmong` int(11) NOT NULL DEFAULT '0' COMMENT '佣金',
  `tax` decimal(10,2) DEFAULT NULL COMMENT '含税',
  `invoice` int(11) DEFAULT '0' COMMENT '0 不开发票 1开发票',
  `delivery_info` int(11) NOT NULL DEFAULT '0' COMMENT '0是配送 1是自取 配送信息',
  `sales_return` int(11) NOT NULL DEFAULT '0' COMMENT '是否退货',
  `take` int(11) NOT NULL DEFAULT '0' COMMENT '完成配送',
  `remark` varchar(255) DEFAULT NULL COMMENT '订单备注',
  `waybill` varchar(255) DEFAULT NULL COMMENT '运单号',
  `cgdh` varchar(50) DEFAULT NULL COMMENT '采购单号',
  `total` decimal(10,2) DEFAULT NULL COMMENT '商品总钱数',
  `goodsgg` int(11) DEFAULT NULL COMMENT '商品规格id',
  `order_id` varchar(50) NOT NULL DEFAULT '0' COMMENT '订单号',
  `th_time` varchar(255) DEFAULT NULL,
  `cq_id` int(11) DEFAULT NULL COMMENT '餐企id',
  `goods_name` varchar(200) DEFAULT NULL COMMENT '商品名称',
  `shop_name` varchar(255) DEFAULT NULL COMMENT '店铺',
  `delivery_time` int(11) DEFAULT '0' COMMENT '送达时间',
  `is_bh` int(11) DEFAULT '0' COMMENT '是否备货',
  `weight` varchar(255) DEFAULT NULL COMMENT '重量',
  `refund` decimal(10,2) DEFAULT NULL COMMENT '退款金额',
  `money` decimal(10,2) DEFAULT NULL COMMENT '订单总金额',
  `freight` decimal(10,2) DEFAULT NULL COMMENT '运费',
  `recede` varchar(255) DEFAULT NULL COMMENT '退货备注',
  `ji` varchar(255) DEFAULT NULL COMMENT '小计',
  `take_time` int(11) DEFAULT NULL COMMENT '骑手取货时间',
  `predict_time` int(11) DEFAULT NULL COMMENT '预计送达时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=366 DEFAULT CHARSET=utf8 COMMENT='订单表';

#
# Data for table "ycl_order"
#

/*!40000 ALTER TABLE `ycl_order` DISABLE KEYS */;
INSERT INTO `ycl_order` VALUES (361,11,'',1,2,10059,18,2,33,1539839036,1539839036,39,1539841062,0,NULL,0,0,1,0,NULL,NULL,'CGDH1539839031293634',66.00,6,'DDH3406821539839036',NULL,11,NULL,NULL,0,0,NULL,NULL,176.00,NULL,'全部退货',NULL,NULL,1539841436),(362,11,'',1,2,10066,18,2,55,1539839036,1539839036,39,1539841062,0,NULL,0,0,1,0,NULL,NULL,'CGDH1539839031293634',110.00,6,'DDH3406821539839036',NULL,11,NULL,NULL,0,0,NULL,NULL,176.00,NULL,'全部退货',NULL,NULL,1539841436),(363,11,'',9,0,10061,13,1,62,1539842740,1539842740,NULL,0,0,NULL,0,0,0,0,NULL,NULL,'CGDH1539839031293634',62.00,6,'DDH1729211539842740',NULL,11,NULL,NULL,0,0,NULL,NULL,117.00,NULL,NULL,NULL,NULL,1539845140),(364,11,'',9,0,10056,13,1,55,1539842740,1539842740,NULL,0,0,NULL,0,0,0,0,NULL,NULL,'CGDH1539839031293634',55.00,6,'DDH1729211539842740',NULL,11,NULL,NULL,0,0,NULL,NULL,117.00,NULL,NULL,NULL,NULL,1539845140),(365,11,'',9,0,10054,11,2,111,1539846658,1539846658,NULL,0,0,NULL,0,0,0,0,NULL,NULL,'CGDH1539841395717156',222.00,6,'DDH6596161539846658',NULL,11,NULL,NULL,0,0,NULL,NULL,222.00,NULL,NULL,NULL,NULL,1539849058);
/*!40000 ALTER TABLE `ycl_order` ENABLE KEYS */;

#
# Structure for table "ycl_purchase"
#

DROP TABLE IF EXISTS `ycl_purchase`;
CREATE TABLE `ycl_purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '新建采购单用户',
  `goods_id` int(11) DEFAULT NULL COMMENT '商品id',
  `goodsname` varchar(30) DEFAULT NULL COMMENT '商品名称',
  `content` varchar(255) DEFAULT NULL COMMENT '购买说明',
  `goodsmoney` decimal(10,2) DEFAULT NULL COMMENT '商品价格',
  `money` decimal(10,2) DEFAULT NULL COMMENT '采购单总钱数',
  `shop` varchar(255) DEFAULT NULL COMMENT '店铺名称',
  `number` int(11) DEFAULT NULL COMMENT '数量',
  `add_time` int(11) DEFAULT NULL COMMENT '采购单创建时间',
  `cgdh` varchar(50) DEFAULT NULL COMMENT '采购单号',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '采购单状态 0去下单 1待接单 2已接单 3已完成 4已巨单',
  `shop_id` int(11) DEFAULT NULL COMMENT '商家id',
  `pron` int(11) DEFAULT '0' COMMENT '我淘的菜标志',
  `suoy` varchar(255) DEFAULT NULL,
  `danwei` varchar(255) DEFAULT NULL COMMENT '临时单位',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='采购';

#
# Data for table "ycl_purchase"
#

/*!40000 ALTER TABLE `ycl_purchase` DISABLE KEYS */;
INSERT INTO `ycl_purchase` VALUES (21,11,10059,'香蕉',NULL,33.00,204.00,NULL,6,1539839031,'CGDH1539839031293634',2,18,1,NULL,NULL),(22,11,10066,'苹果',NULL,55.00,165.00,NULL,3,1539839031,'CGDH1539839031293634',2,18,1,NULL,NULL),(23,11,NULL,'丝瓜','是',111.00,222.00,NULL,2,1539841393,'CGDH1539841395717156',1,11,0,NULL,'箱'),(24,11,10057,'菠菜',NULL,62.00,124.00,NULL,2,1539842680,'CGDH1539839031293634',1,13,1,NULL,NULL),(25,11,10055,'土豆',NULL,55.00,110.00,NULL,2,1539842680,'CGDH1539839031293634',1,13,1,NULL,NULL),(26,11,10059,'香蕉',NULL,34.00,102.00,NULL,3,1539844338,'CGDH1539839031293634',0,18,1,NULL,NULL),(27,11,10057,'菠菜',NULL,62.00,124.00,NULL,2,1539844620,'CGDH1539839031293634',0,13,1,NULL,NULL),(28,11,10055,'土豆',NULL,55.00,110.00,NULL,2,1539844620,'CGDH1539839031293634',0,13,1,NULL,NULL),(29,11,NULL,'西红柿','',NULL,NULL,NULL,2,1539912326,'CGDH1539912328861544',0,NULL,0,NULL,'请选择单位'),(30,11,NULL,'苹果','是',NULL,NULL,NULL,2,1539913585,'CGDH1539913587304180',0,NULL,0,NULL,'箱'),(31,11,NULL,'丝瓜','',NULL,NULL,NULL,2,1539914506,'CGDH1539914508374740',0,NULL,0,NULL,'请选择单位'),(32,11,NULL,'芒果','是',NULL,NULL,NULL,2,1540522842,'CGDH1540522844873767',0,NULL,0,NULL,'件');
/*!40000 ALTER TABLE `ycl_purchase` ENABLE KEYS */;

#
# Structure for table "ycl_review"
#

DROP TABLE IF EXISTS `ycl_review`;
CREATE TABLE `ycl_review` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `shopid` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `username` varchar(255) DEFAULT NULL COMMENT '用户昵称',
  `content` varchar(255) DEFAULT NULL COMMENT '评论内容',
  `add_time` varchar(255) NOT NULL DEFAULT '' COMMENT '评论时间',
  `image` varchar(255) DEFAULT NULL COMMENT '用户头像',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论';

#
# Data for table "ycl_review"
#

/*!40000 ALTER TABLE `ycl_review` DISABLE KEYS */;
/*!40000 ALTER TABLE `ycl_review` ENABLE KEYS */;

#
# Structure for table "ycl_role"
#

DROP TABLE IF EXISTS `ycl_role`;
CREATE TABLE `ycl_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `js_name` varchar(255) DEFAULT NULL COMMENT '角色名称',
  `group_id` int(11) DEFAULT NULL COMMENT '所属餐企id',
  `auth` int(11) DEFAULT NULL COMMENT '权限（0,1,2,3,4,5)',
  `uid` int(11) DEFAULT NULL,
  `content` varchar(60) NOT NULL DEFAULT '' COMMENT '备注',
  `addtime` int(11) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='角色表';

#
# Data for table "ycl_role"
#

/*!40000 ALTER TABLE `ycl_role` DISABLE KEYS */;
INSERT INTO `ycl_role` VALUES (10,'验收',87,3,67,'是',NULL),(11,'总管事',88,NULL,88,'老板',1535017046),(12,'采购',88,2,67,'的风格',NULL),(13,'厨师',41,1,41,'asd',NULL),(18,'厨师',11,1,11,'发给',NULL),(19,'采购',11,2,48,'小李子',1539933744);
/*!40000 ALTER TABLE `ycl_role` ENABLE KEYS */;

#
# Structure for table "ycl_serve"
#

DROP TABLE IF EXISTS `ycl_serve`;
CREATE TABLE `ycl_serve` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `subscribe` int(11) DEFAULT '0' COMMENT '0 未预约  1预约',
  `in` int(11) DEFAULT '0' COMMENT '1预约达  0及时送',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='服务';

#
# Data for table "ycl_serve"
#

/*!40000 ALTER TABLE `ycl_serve` DISABLE KEYS */;
/*!40000 ALTER TABLE `ycl_serve` ENABLE KEYS */;

#
# Structure for table "ycl_shop_info"
#

DROP TABLE IF EXISTS `ycl_shop_info`;
CREATE TABLE `ycl_shop_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bazaarid` int(11) DEFAULT NULL COMMENT '市场id',
  `shop_name` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺名称',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '店铺所属人',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺地址',
  `open_time` varchar(255) DEFAULT NULL COMMENT '营业开始时间',
  `close_time` varchar(255) DEFAULT NULL COMMENT '营业结束时间',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `distance` int(11) DEFAULT NULL COMMENT '距离',
  `shop_img` varchar(255) DEFAULT NULL COMMENT '店铺图片',
  `delivery` decimal(10,2) DEFAULT NULL COMMENT '起送金',
  `content` varchar(255) DEFAULT NULL COMMENT '店铺简介',
  `discount` decimal(10,2) DEFAULT NULL COMMENT '折扣价',
  `original` decimal(10,2) DEFAULT NULL COMMENT '原价',
  `manager_phone` varchar(255) DEFAULT NULL COMMENT '门店负责人电话',
  `point_x` varchar(255) DEFAULT NULL COMMENT '经度',
  `point_y` varchar(255) DEFAULT NULL COMMENT '纬度',
  `cq_id` int(11) DEFAULT NULL COMMENT '所属餐企id',
  `is_sh` varchar(255) DEFAULT '0' COMMENT '0,1',
  `goodsname` varchar(255) DEFAULT '',
  `goodsprice` decimal(10,2) DEFAULT NULL,
  `site` varchar(255) DEFAULT NULL COMMENT '上班地址',
  `shoptype` varchar(255) DEFAULT NULL COMMENT '店铺分类',
  `shopmark` char(32) DEFAULT NULL COMMENT '店铺号',
  `status` varchar(255) DEFAULT NULL COMMENT '营业状态',
  `make` varchar(255) DEFAULT NULL COMMENT '预约达状态',
  `deliver` varchar(255) DEFAULT NULL COMMENT '急时送状态',
  `sales` int(11) DEFAULT NULL COMMENT '销量',
  `reputation` int(11) DEFAULT NULL COMMENT '好评数量',
  `city` varchar(255) DEFAULT NULL COMMENT '所属城市',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='店铺表';

#
# Data for table "ycl_shop_info"
#

/*!40000 ALTER TABLE `ycl_shop_info` DISABLE KEYS */;
INSERT INTO `ycl_shop_info` VALUES (10,1,'老北京炸酱面店',15,'花园路100号','2010-00-00','2021-00-00',1525670091,100,'20180727\\2eeede96f7b7079496db1598af016a27.jpg',15.00,'不好吃不要钱',5.00,NULL,NULL,NULL,NULL,NULL,'0','',NULL,NULL,NULL,'0','营业中',NULL,NULL,81,20,'北京市'),(11,4,'香味大骨盆',11,'爱仕达','14:26','11:24',1525670111,10,'20180727\\66c1e70fcaefe3b2b128c4d6f0c9be87.jpg',20.00,'我呜呜呜呜呜呜呜呜呜呜呜呜呜呜呜呜',5.00,NULL,'123456',NULL,NULL,NULL,'0','',NULL,NULL,'水果','88888888','营业中','不支持','支持',108,50,'济南市'),(12,3,'便宜坊烤鸭店',9,'阒其无人','0000-00-00','0000-00-00',1525670126,30,'20180727\\d9be7052de0794d93795456696ff5002.jpg',40.00,'过了这个村就没这个店啦',10.00,NULL,NULL,NULL,NULL,NULL,'0','',NULL,NULL,NULL,'0','营业中',NULL,NULL,272,40,'济南市'),(13,1,'海福湾',3,'东京华尔街','2009-00-00','2021-00-00',1530665551,50,'20180727\\fe2d474408a40ad3fe42e9fc8b2a1e8a.jpg',30.00,'来来啦',20.00,NULL,NULL,NULL,NULL,NULL,'0','',NULL,NULL,NULL,'0','营业中',NULL,NULL,300,10,'济南市'),(14,4,'聚点串吧',5,'唐人街','08:00','19:00',1530674601,200,'20180727\\ed716f7b8ffb630184f53bf48d921d5d.jpg',50.00,'开业大吉!',10.00,NULL,'123123',NULL,NULL,NULL,'0','',NULL,NULL,'都卖','0','未营业','不支持','不支持',20,30,'北京市'),(18,1,'上海小笼包',41,'上海','07:40','17:00',1532673520,NULL,'20180822\\cd6ab5f898139ca758a189a4b0cd8b52.jpg',49.00,'开业大吉',50.00,NULL,'466666',NULL,NULL,NULL,'0','',NULL,NULL,'蔬菜水果','072719042','营业中','不支持','不支持',26,20,'济南市'),(19,1,'济南肉店',42,'','12:22','14:22',0,NULL,'20180728\\1d8ae8e68a08f5018865c1d46e6f136f.jpg',NULL,'哈哈哈',NULL,NULL,'110',NULL,NULL,NULL,'0','',NULL,NULL,'水果',NULL,'未营业','不支持','不支持',34,33,'北京市');
/*!40000 ALTER TABLE `ycl_shop_info` ENABLE KEYS */;

#
# Structure for table "ycl_slide"
#

DROP TABLE IF EXISTS `ycl_slide`;
CREATE TABLE `ycl_slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slide_one` varchar(255) DEFAULT NULL COMMENT '幻灯片1',
  `slide_two` varchar(255) DEFAULT NULL COMMENT '幻灯片2',
  `slide_three` varchar(255) DEFAULT NULL COMMENT '幻灯片3',
  `slide_four` varchar(255) DEFAULT NULL COMMENT '幻灯片4',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='幻灯片表';

#
# Data for table "ycl_slide"
#

/*!40000 ALTER TABLE `ycl_slide` DISABLE KEYS */;
/*!40000 ALTER TABLE `ycl_slide` ENABLE KEYS */;

#
# Structure for table "ycl_spec"
#

DROP TABLE IF EXISTS `ycl_spec`;
CREATE TABLE `ycl_spec` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名字',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='规格表';

#
# Data for table "ycl_spec"
#

/*!40000 ALTER TABLE `ycl_spec` DISABLE KEYS */;
INSERT INTO `ycl_spec` VALUES (6,'kg'),(7,'g'),(8,'㎡'),(9,'m'),(10,'km');
/*!40000 ALTER TABLE `ycl_spec` ENABLE KEYS */;

#
# Structure for table "ycl_store"
#

DROP TABLE IF EXISTS `ycl_store`;
CREATE TABLE `ycl_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '门店名称',
  `address` varchar(80) NOT NULL DEFAULT '' COMMENT '门店地址',
  `manager_name` varchar(30) DEFAULT '' COMMENT '门店负责人名称',
  `manager_phone` varchar(30) NOT NULL DEFAULT '' COMMENT '门店负责人电话',
  `point_x` varchar(90) NOT NULL DEFAULT '' COMMENT '经度',
  `point_y` varchar(90) NOT NULL DEFAULT '' COMMENT '维度',
  `add_time` int(11) DEFAULT NULL COMMENT '注册时间',
  `is_sh` int(3) NOT NULL DEFAULT '0' COMMENT '是否审核',
  `cq_id` int(11) DEFAULT NULL COMMENT '餐企id',
  `image` varchar(100) DEFAULT NULL COMMENT '门店图片',
  `certificate` varchar(100) DEFAULT NULL COMMENT '营业执照',
  `qtimg` varchar(100) DEFAULT NULL COMMENT '其他图片',
  `house_id` int(11) DEFAULT NULL COMMENT '门牌号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=114 DEFAULT CHARSET=utf8 COMMENT='门店表';

#
# Data for table "ycl_store"
#

/*!40000 ALTER TABLE `ycl_store` DISABLE KEYS */;
INSERT INTO `ycl_store` VALUES (1,'醉排骨','山东济南','王总','15854763713','','',1531447750,1,3,NULL,NULL,NULL,NULL),(2,'城南往事','山东济南','王总','18888888888','','',1531447780,0,3,'20180723\\2d23e21327145d225de60925114aa6f9.png',NULL,NULL,NULL),(4,'黎明科技','上海浦东','王总','778899','','',1531452345,0,3,NULL,NULL,NULL,8899),(5,'火石科技','上海浦东','王总','8989899899','','',1531453440,0,3,NULL,NULL,NULL,6688),(6,'万达','山东济宁','王总','8878788798','','',1531458422,0,3,'20180723\\d7d0acd1df40d9d40a3f68322798b1c5.jpg','20180714\\cec66bd92490ba6a89822cb93fb0b4c9.jpg','20180714\\77676b0dc02c0bf1977e445a72e421ff.jpg',789),(30,'娃娃','萨芬撒','小王','15621329774','','',1531791280,0,NULL,NULL,NULL,NULL,123),(31,'超意兴','济南','小王','15621329887','','',1531797743,0,3,NULL,NULL,NULL,110),(65,'小舅舅','梵蒂冈','阿萨','15621368854','','',1531804573,0,3,NULL,NULL,NULL,1231),(66,'哥','梵蒂冈','阿萨','15621368854','','',1531804613,0,3,NULL,NULL,NULL,1231),(67,'模板','啊','V个','15621329447','','',1531804765,0,3,NULL,NULL,NULL,11111111),(107,'笑荒唐','发生的发','校长','15621329887','','',1531813711,0,3,'20180717\\af8205f6cbdf29ebae846166f90725dd.jpg','20180717\\43a3ba2d11906d2111014e235593820a.jpg','20180717\\332879e2748878c1c0c70aa9f0f2357f.jpg',2147483647),(108,'asd','的','阿萨','15624329985','','',1531875358,0,3,NULL,NULL,NULL,64564),(109,'asd','的','阿萨','15624329985','','',1531876049,0,3,NULL,NULL,NULL,64564),(110,'fghh','sdgh','hhduj','15854763713','','',1532770412,0,5,'20180728\\ec864bfa7742546417b3512c2358f294.jpg','20180728\\c8baac539e94db3ca2cd1678635190d2.jpg','20180728\\4ca39b323b7f8d8832b75ac57a246574.jpg',666666),(111,'大家好小街道','我呜呜呜呜呜呜呜呜呜呜呜呜呜呜呜呜','大哥好','15621325545','','',1533779305,0,39,'20180809\\a8eaf1439981e93b69c8e5dc8bae36c9.png','20180809\\5b8bc60ab295d50a8bc11daba64dddb2.jpg','20180809\\bdcb87f2181f075e32f222d84da3a1b7.png',65656),(112,'哈哈哈','大师傅','弟弟','15621365545','','',1534583742,0,11,'20180818\\b29a9a9387d24f7eb75170e6208336f2.png','20180818\\e87362e2cd20e4a149221deba0fae259.png','20180818\\6ed410843ec1f2d1c3d449466a541ec7.jpg',789),(113,'小莫能','sdfsdf','小秦','13654658852','','',1534909156,0,11,'20180822\\bf974dfa90232fbd3c424b8264af121e.jpg','20180822\\39f2587d5fb5ce99b429ba554ed03557.png','20180822\\c1d979acdee034bd8ccc46ce06fb8a29.png',23232);
/*!40000 ALTER TABLE `ycl_store` ENABLE KEYS */;

#
# Structure for table "ycl_user"
#

DROP TABLE IF EXISTS `ycl_user`;
CREATE TABLE `ycl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL COMMENT '用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `user_type` int(11) NOT NULL DEFAULT '0' COMMENT '用户类型',
  `phone` varchar(255) NOT NULL DEFAULT '0' COMMENT '联系电话',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `contract_name` varchar(255) NOT NULL DEFAULT '' COMMENT '联系人',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `true_name` varchar(255) DEFAULT NULL COMMENT '真实姓名',
  `whether` varchar(255) DEFAULT NULL COMMENT '是否有效',
  `work_id` int(11) DEFAULT NULL COMMENT '所属餐企id',
  `is_sh` int(11) DEFAULT '0' COMMENT '审核状态(0,1)',
  `js_id` int(11) DEFAULT NULL COMMENT '角色id',
  `image` varchar(255) DEFAULT NULL COMMENT '用户头像',
  `register_type` int(11) NOT NULL DEFAULT '0' COMMENT '注册类型',
  `variable` int(11) NOT NULL DEFAULT '0' COMMENT '申请开关',
  `cqname` varchar(30) NOT NULL DEFAULT '' COMMENT '餐企名称',
  `number` char(18) DEFAULT NULL COMMENT '身份证号',
  `dwell` varchar(255) DEFAULT NULL COMMENT '居住地址',
  `site` varchar(255) DEFAULT NULL COMMENT '上班地址',
  `idimg` varchar(255) DEFAULT NULL COMMENT '身份证照片',
  `pic` varchar(255) DEFAULT NULL COMMENT '营业执照',
  `boothimg` varchar(255) DEFAULT NULL COMMENT '摊位照片',
  `cartype` varchar(255) DEFAULT NULL COMMENT '车辆类型',
  `driving` varchar(255) DEFAULT NULL COMMENT '驾驶证号',
  `licence` varchar(255) DEFAULT NULL COMMENT '驾驶证照片',
  `is_kg` int(11) DEFAULT '0' COMMENT '配送员开关',
  `health` varchar(255) DEFAULT NULL COMMENT '健康证',
  `bazaar` int(11) DEFAULT NULL COMMENT '注册类型2 所在市场',
  `nickname` varchar(255) DEFAULT NULL COMMENT '用户昵称',
  `serialno` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=99 DEFAULT CHARSET=utf8 COMMENT='用户表';

#
# Data for table "ycl_user"
#

/*!40000 ALTER TABLE `ycl_user` DISABLE KEYS */;
INSERT INTO `ycl_user` VALUES (7,'','e10adc3949ba59abbe56e057f20f883e',0,' ',0,1532306516,'','',0.00,'事实上身上',NULL,NULL,1,NULL,'20180719\\29bcded620c8aefe08021ecefbc90d06.jpg',2,0,'','233333','asd','大师傅',NULL,NULL,NULL,'小面包','333',NULL,0,NULL,5,NULL,NULL),(9,'888','e10adc3949ba59abbe56e057f20f883e',0,'17615455679',0,1532264315,'','',0.00,'封孺人',NULL,NULL,2,NULL,NULL,2,0,'','75757','好的','个',NULL,NULL,NULL,'规划',NULL,NULL,0,NULL,NULL,NULL,NULL),(11,'511','e10adc3949ba59abbe56e057f20f883e',0,'123456',0,1532141657,'','',5157.66,'小王',NULL,11,1,NULL,'20180719\\09f8c7fc9c05bfc35327aadb8e40cf3b.png',1,0,'','啊是事实是事实','按时打算','山东',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,3,NULL,NULL),(39,'1111','e10adc3949ba59abbe56e057f20f883e',0,'admin',0,1532141679,'','',70.00,'小张',NULL,NULL,1,NULL,'20180822\\4e02bd95804eedba1568a19bbfe9a19b.png',3,0,'','啊是事实是事实','按时打算','山东',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL),(41,'555','e10adc3949ba59abbe56e057f20f883e',0,'456',0,1532150753,'','',50.00,'萨达',NULL,41,1,NULL,'20180719\\09f8c7fc9c05bfc35327aadb8e40cf3b.png',2,0,'','649465','按时打算','水电费',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,5,NULL,NULL),(42,'666','e10adc3949ba59abbe56e057f20f883e',0,'789',0,1532150797,'','',0.00,'萨达',NULL,NULL,1,NULL,NULL,2,0,'','649465','按时打算','水电费',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,4,NULL,NULL),(44,'','',0,'15643278876',0,1532265270,'','',0.00,'现场秩序',NULL,NULL,0,NULL,NULL,0,0,'','3333','现在才','自行车',NULL,NULL,NULL,'自行车','99999',NULL,0,NULL,NULL,NULL,NULL),(45,'','',0,'15643278876',0,1532265434,'','',0.00,'现场秩序',NULL,NULL,0,NULL,NULL,0,0,'','3333','现在才','自行车',NULL,NULL,NULL,'自行车','99999111',NULL,0,NULL,NULL,NULL,NULL),(46,'','',0,'15621365541',0,1532305598,'','',0.00,'asd',NULL,NULL,0,NULL,NULL,0,0,'','234234','水电费','阿萨',NULL,NULL,NULL,'自行车','111',NULL,0,NULL,NULL,NULL,NULL),(48,'搜索','',0,'15621329985',0,1532307164,'','',0.00,'事实上身上',NULL,11,2,NULL,NULL,3,0,'','233333','asd','大师傅',NULL,NULL,NULL,'小面包','333',NULL,0,NULL,NULL,NULL,NULL),(67,'999','e10adc3949ba59abbe56e057f20f883e',0,'111',0,1534908832,'地方个地方','小李子',0.00,NULL,NULL,88,1,NULL,'20180719\\29bcded620c8aefe08021ecefbc90d06.jpg',1,0,'笑话人',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(87,NULL,'e10adc3949ba59abbe56e057f20f883e',0,'999',0,1535016052,'999','999',0.00,NULL,NULL,87,1,NULL,NULL,1,0,'999',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(88,NULL,'e10adc3949ba59abbe56e057f20f883e',0,'5',0,1535017046,'呵呵就回家','大声的',0.00,NULL,NULL,88,1,NULL,NULL,1,0,'反反复复',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL),(97,NULL,'e10adc3949ba59abbe56e057f20f883e',0,'15623658874',0,NULL,'','',0.00,'卅',NULL,11,0,NULL,NULL,3,0,'','213','阿萨','山东','20180905\\142450276662484842ec984cc5386893.png',NULL,NULL,'地方','3333','20180905\\5f9649a1452cee572c7286be10470ebc.png',0,'20180905\\ac7a135d65c42abbc3a0ed6d966806ef.png',NULL,NULL,NULL),(98,NULL,'',0,'23123',0,NULL,'','',0.00,'ooo',NULL,NULL,1,NULL,NULL,2,0,'','11111','是','辅导','20181015\\d98438794373584e0d1db27c72caa1bc.png','20181015\\b025b9b847c04589dc9b43d998949e11.png','20181015\\17b023e149ca067981192bbc2c735827.png',NULL,NULL,NULL,0,NULL,4,NULL,NULL);
/*!40000 ALTER TABLE `ycl_user` ENABLE KEYS */;

#
# Structure for table "ycl_user_money"
#

DROP TABLE IF EXISTS `ycl_user_money`;
CREATE TABLE `ycl_user_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `cash` int(11) NOT NULL DEFAULT '0' COMMENT '押金',
  `pledge` int(11) NOT NULL DEFAULT '0' COMMENT '保证金',
  `integral` int(11) NOT NULL DEFAULT '0' COMMENT '积分',
  `class` int(11) NOT NULL DEFAULT '0' COMMENT '用户等级',
  `guaranteed_time` int(11) NOT NULL DEFAULT '0' COMMENT '保证时间',
  `deposit_time` int(11) NOT NULL DEFAULT '0' COMMENT '押金时间',
  `code` int(11) NOT NULL DEFAULT '0' COMMENT '条形码',
  `penalty_time` int(11) NOT NULL DEFAULT '0' COMMENT '处罚时间',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '处罚内容',
  `punish_money` int(11) NOT NULL DEFAULT '0' COMMENT '处罚金',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户钱';

#
# Data for table "ycl_user_money"
#

/*!40000 ALTER TABLE `ycl_user_money` DISABLE KEYS */;
/*!40000 ALTER TABLE `ycl_user_money` ENABLE KEYS */;

#
# Structure for table "ycl_wallet"
#

DROP TABLE IF EXISTS `ycl_wallet`;
CREATE TABLE `ycl_wallet` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `bank` char(32) DEFAULT NULL COMMENT '银行卡',
  `bill_id` int(11) DEFAULT NULL COMMENT '账单id',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='我的钱包.';

#
# Data for table "ycl_wallet"
#

/*!40000 ALTER TABLE `ycl_wallet` DISABLE KEYS */;
/*!40000 ALTER TABLE `ycl_wallet` ENABLE KEYS */;

#
# Structure for table "ycl_withdraw"
#

DROP TABLE IF EXISTS `ycl_withdraw`;
CREATE TABLE `ycl_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '提现用户',
  `tx_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现金额',
  `yhkh` varchar(30) NOT NULL DEFAULT '' COMMENT '银行卡号',
  `khh` varchar(60) NOT NULL DEFAULT '' COMMENT '开户行',
  `is_sh` int(11) NOT NULL DEFAULT '0' COMMENT '是否审核',
  `add_time` int(11) DEFAULT NULL COMMENT '提现时间',
  `username` varchar(60) NOT NULL DEFAULT '' COMMENT '账户名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='提现明细表';

#
# Data for table "ycl_withdraw"
#

/*!40000 ALTER TABLE `ycl_withdraw` DISABLE KEYS */;
INSERT INTO `ycl_withdraw` VALUES (4,39,20.00,'6212262201023557228','工商',2,1541054763,'小张'),(5,39,20.00,'6212262201023557228','功夫高手',2,1541054918,'小张'),(6,41,20.00,'6212262201023557228','公升',2,1541057491,'萨达'),(7,11,1000.00,'6212262201023557228','阿萨',1,1541058577,'小王'),(8,11,47.00,'6212262201023557228','的',2,1541058639,'小王');
/*!40000 ALTER TABLE `ycl_withdraw` ENABLE KEYS */;

#
# Structure for table "ycl_withdrawday"
#

DROP TABLE IF EXISTS `ycl_withdrawday`;
CREATE TABLE `ycl_withdrawday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `withdraw_day` int(11) DEFAULT NULL COMMENT '设置配送员M天后可提现',
  `status` int(11) DEFAULT '0' COMMENT '应用标志',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='设置配送员M天后可体现';

#
# Data for table "ycl_withdrawday"
#

/*!40000 ALTER TABLE `ycl_withdrawday` DISABLE KEYS */;
INSERT INTO `ycl_withdrawday` VALUES (1,0,0),(3,4,0),(6,55,0),(7,55,1);
/*!40000 ALTER TABLE `ycl_withdrawday` ENABLE KEYS */;
