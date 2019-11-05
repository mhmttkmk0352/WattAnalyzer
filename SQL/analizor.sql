# Host: 185.122.200.117  (Version 5.5.0-m2-community)
# Date: 2019-11-05 09:28:53
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# Structure for table "demo_posts"
#

DROP TABLE IF EXISTS `demo_posts`;
CREATE TABLE `demo_posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `category` varchar(255) COLLATE utf8_bin NOT NULL,
  `tag` varchar(255) COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

#
# Data for table "demo_posts"
#


#
# Structure for table "failed_jobs"
#

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8_bin NOT NULL,
  `queue` text COLLATE utf8_bin NOT NULL,
  `payload` longtext COLLATE utf8_bin NOT NULL,
  `exception` longtext COLLATE utf8_bin NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

#
# Data for table "failed_jobs"
#


#
# Structure for table "main_d_b_s"
#

DROP TABLE IF EXISTS `main_d_b_s`;
CREATE TABLE `main_d_b_s` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

#
# Data for table "main_d_b_s"
#


#
# Structure for table "migrations"
#

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_bin NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

#
# Data for table "migrations"
#

INSERT INTO `migrations` VALUES (1,'2019_10_16_135420_create_users_table',1),(2,'2014_10_12_000000_create_users_table',2),(3,'2014_10_12_100000_create_password_resets_table',2),(4,'2019_08_19_000000_create_failed_jobs_table',2),(5,'2019_10_18_133226_create_main_d_b_s_table',3),(6,'2019_10_21_075308_create_demo_posts_table',4);

#
# Structure for table "password_resets"
#

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `token` varchar(255) COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

#
# Data for table "password_resets"
#


#
# Structure for table "users"
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

#
# Data for table "users"
#

INSERT INTO `users` VALUES (1,'x','x@gmail.com',NULL,'$2y$10$rFWzak9JFY8xgOQv7NN/Su15vzrcJ0ALS0o8Bdr/dNMN076i0LVGW',NULL,'2019-10-25 04:12:25','2019-10-25 04:12:25'),(2,'m','m@gmail.com',NULL,'$2y$10$J2srKmtnnXipNIcRoLtyc.JsmqsrmmVRD6viU1cJGBZmgjuySpPQO','33AmkVmVy7IOl45xCY3yes84Uvsj5DfVncrPm4taBjwKfFMS7pZnT96nFYEt','2019-10-31 09:51:49','2019-10-31 09:51:49');

#
# Structure for table "watt_cihazlar"
#

DROP TABLE IF EXISTS `watt_cihazlar`;
CREATE TABLE `watt_cihazlar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `cihaz_id` varchar(300) COLLATE utf8_bin NOT NULL,
  `cihaz_adi` varchar(300) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

#
# Data for table "watt_cihazlar"
#

INSERT INTO `watt_cihazlar` VALUES (1,2,'izmir',''),(2,2,'kayseri',''),(3,2,'ankara','');

#
# Structure for table "watt_eszamanli"
#

DROP TABLE IF EXISTS `watt_eszamanli`;
CREATE TABLE `watt_eszamanli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `tarih` int(16) NOT NULL,
  `anlikdeger` longtext COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

#
# Data for table "watt_eszamanli"
#

INSERT INTO `watt_eszamanli` VALUES (1,2,1572931804,'{\"izmir\":{\"user_id\":2,\"cihaz_id\":\"izmir\",\"voltaj\":600,\"amper\":1,\"watt\":600,\"tarih\":1572931802},\"kayseri\":{\"user_id\":2,\"cihaz_id\":\"kayseri\",\"voltaj\":60,\"amper\":1,\"watt\":60,\"tarih\":1572931804}}'),(2,2,1572931839,'{\"izmir\":{\"user_id\":2,\"cihaz_id\":\"izmir\",\"voltaj\":650,\"amper\":1,\"watt\":650,\"tarih\":1572931836},\"kayseri\":{\"user_id\":2,\"cihaz_id\":\"kayseri\",\"voltaj\":68,\"amper\":1,\"watt\":68,\"tarih\":1572931839}}'),(3,2,1572931903,'{\"izmir\":{\"user_id\":2,\"cihaz_id\":\"izmir\",\"voltaj\":650,\"amper\":1,\"watt\":650,\"tarih\":1572931901},\"kayseri\":{\"user_id\":2,\"cihaz_id\":\"kayseri\",\"voltaj\":68,\"amper\":1,\"watt\":68,\"tarih\":1572931903}}'),(4,2,1572932188,'{\"izmir\":{\"user_id\":2,\"cihaz_id\":\"izmir\",\"voltaj\":65,\"amper\":1,\"watt\":65,\"tarih\":1572932184},\"kayseri\":{\"user_id\":2,\"cihaz_id\":\"kayseri\",\"voltaj\":88,\"amper\":1,\"watt\":88,\"tarih\":1572932188}}'),(5,2,1572933371,'{\"izmir\":{\"user_id\":2,\"cihaz_id\":\"izmir\",\"voltaj\":65,\"amper\":1,\"watt\":65,\"tarih\":1572933369},\"kayseri\":{\"user_id\":2,\"cihaz_id\":\"kayseri\",\"voltaj\":88,\"amper\":1,\"watt\":88,\"tarih\":1572933371}}');

#
# Structure for table "watt_eszamanlikarsilastir"
#

DROP TABLE IF EXISTS `watt_eszamanlikarsilastir`;
CREATE TABLE `watt_eszamanlikarsilastir` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `cihaz_id` varchar(200) COLLATE utf8_bin NOT NULL,
  `voltaj` float NOT NULL,
  `amper` float NOT NULL,
  `watt` float NOT NULL,
  `tarih` int(16) NOT NULL,
  `eszamanli_tarih` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

#
# Data for table "watt_eszamanlikarsilastir"
#

INSERT INTO `watt_eszamanlikarsilastir` VALUES (1,2,'izmir',650,1,650,1572931836,1572931839),(2,2,'kayseri',68,1,68,1572931839,1572931839),(3,2,'izmir',650,1,650,1572931901,1572931903),(4,2,'kayseri',68,1,68,1572931903,1572931903),(5,2,'izmir',65,1,65,1572932184,1572932188),(6,2,'kayseri',88,1,88,1572932188,1572932188),(7,2,'izmir',65,1,65,1572933369,1572933371),(8,2,'kayseri',88,1,88,1572933371,1572933371);

#
# Structure for table "watt_karsilastir"
#

DROP TABLE IF EXISTS `watt_karsilastir`;
CREATE TABLE `watt_karsilastir` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `cihaz_id` varchar(200) COLLATE utf8_bin NOT NULL,
  `voltaj` float NOT NULL,
  `amper` float NOT NULL,
  `watt` float NOT NULL,
  `tarih` int(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

#
# Data for table "watt_karsilastir"
#

INSERT INTO `watt_karsilastir` VALUES (1,2,'izmir',600,1,600,1572931802),(2,2,'kayseri',60,1,60,1572931804),(3,2,'izmir',650,1,650,1572931836),(4,2,'kayseri',68,1,68,1572931839),(5,2,'izmir',650,1,650,1572931846),(6,2,'kayseri',68,1,68,1572931848),(7,2,'izmir',650,1,650,1572931901),(8,2,'kayseri',68,1,68,1572931903),(9,2,'izmir',65,1,65,1572932184),(10,2,'kayseri',88,1,88,1572932188),(11,2,'izmir',65,1,65,1572933369),(12,2,'kayseri',88,1,88,1572933371),(13,2,'izmir',65,1,65,1572933798),(14,2,'ankara',33,1,33,1572933814);
