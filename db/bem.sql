-- --------------------------------------------------------
-- Host:                         local.db
-- Server version:               5.5.34-log - MySQL Community Server (GPL) by Remi
-- Server OS:                    Linux
-- HeidiSQL Version:        mysqltest     8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table gim_wap.active_package
DROP TABLE IF EXISTS `active_package`;
CREATE TABLE IF NOT EXISTS `active_package` (
  `cp` varchar(50) DEFAULT '',
  `subcp` varchar(50) DEFAULT '',
  `os` varchar(50) DEFAULT '',
  `package_name` varchar(50) DEFAULT '',
  UNIQUE KEY `cp_subcp_os_package_name` (`cp`,`subcp`,`os`,`package_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.active_user
DROP TABLE IF EXISTS `active_user`;
CREATE TABLE IF NOT EXISTS `active_user` (
  `date_login` date NOT NULL,
  `login_time` int(11) NOT NULL DEFAULT '0',
  `mau` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`date_login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.active_user_detail
DROP TABLE IF EXISTS `active_user_detail`;
CREATE TABLE IF NOT EXISTS `active_user_detail` (
  `date_login` date NOT NULL,
  `type` tinyint(4) NOT NULL,
  `name1` varchar(20) NOT NULL DEFAULT '',
  `name2` varchar(20) NOT NULL DEFAULT '',
  `dau` int(11) NOT NULL,
  `mau` int(11) NOT NULL,
  UNIQUE KEY `date_login_type_name1_name2` (`date_login`,`type`,`name1`,`name2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.admin_add_koin
DROP TABLE IF EXISTS `admin_add_koin`;
CREATE TABLE IF NOT EXISTS `admin_add_koin` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `admin_pass` varchar(50) DEFAULT NULL,
  `koin` int(11) NOT NULL DEFAULT '0',
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `cause` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.auth_event
DROP TABLE IF EXISTS `auth_event`;
CREATE TABLE IF NOT EXISTS `auth_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time_stamp` datetime DEFAULT NULL,
  `client_ip` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `description` longtext,
  PRIMARY KEY (`id`),
  KEY `user_id__idx` (`user_id`),
  CONSTRAINT `auth_event_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `auth_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.auth_group
DROP TABLE IF EXISTS `auth_group`;
CREATE TABLE IF NOT EXISTS `auth_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) DEFAULT NULL,
  `description` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.auth_membership
DROP TABLE IF EXISTS `auth_membership`;
CREATE TABLE IF NOT EXISTS `auth_membership` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id__idx` (`user_id`),
  KEY `group_id__idx` (`group_id`),
  CONSTRAINT `auth_membership_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `auth_user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `auth_membership_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `auth_group` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.auth_permission
DROP TABLE IF EXISTS `auth_permission`;
CREATE TABLE IF NOT EXISTS `auth_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `table_name` varchar(255) DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id__idx` (`group_id`),
  CONSTRAINT `auth_permission_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `auth_group` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.auth_user
DROP TABLE IF EXISTS `auth_user`;
CREATE TABLE IF NOT EXISTS `auth_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `registration_key` varchar(255) DEFAULT NULL,
  `reset_password_key` varchar(255) DEFAULT NULL,
  `registration_id` varchar(255) DEFAULT NULL,
  `koin` bigint(20) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `password_hash` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ix_username_uniq` (`username`),
  KEY `ix_koin` (`koin`),
  KEY `ix_mobile` (`mobile`),
  KEY `ix_created_on` (`created_on`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.auth_user_partner
DROP TABLE IF EXISTS `auth_user_partner`;
CREATE TABLE IF NOT EXISTS `auth_user_partner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auth_user_id` int(11) NOT NULL,
  `partner` varchar(20) DEFAULT NULL,
  `test` tinyint(1) DEFAULT '0',
  `service` varchar(10) NOT NULL,
  `message` varchar(50) NOT NULL,
  `reqid` bigint(20) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `sender` varchar(13) DEFAULT NULL,
  `recipient` varchar(4) DEFAULT NULL,
  `koin_added` int(11) DEFAULT NULL,
  `telco` tinyint(4) DEFAULT NULL,
  `ret` varchar(255) DEFAULT NULL,
  `subpartner` varchar(255) DEFAULT NULL,
  `client_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_partner` (`partner`),
  KEY `ix_authuserid` (`auth_user_id`),
  KEY `ix_service` (`service`),
  KEY `ix_test` (`test`),
  KEY `ix_recipient` (`recipient`),
  KEY `ix_reqid` (`reqid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.auth_user_partner_log
DROP TABLE IF EXISTS `auth_user_partner_log`;
CREATE TABLE IF NOT EXISTS `auth_user_partner_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_on` datetime DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `sender` varchar(13) DEFAULT NULL,
  `recipient` varchar(4) DEFAULT NULL,
  `service` varchar(10) NOT NULL,
  `message` varchar(50) NOT NULL,
  `reqid` bigint(20) NOT NULL,
  `partner` varchar(10) DEFAULT NULL,
  `test` tinyint(1) DEFAULT '0',
  `errcode` int(11) DEFAULT '-1',
  `subpartner` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.auth_user_vip
DROP TABLE IF EXISTS `auth_user_vip`;
CREATE TABLE IF NOT EXISTS `auth_user_vip` (
  `auth_user_id` bigint(20) unsigned NOT NULL,
  `vip_type` int(10) unsigned NOT NULL DEFAULT '0',
  `sum_money` bigint(20) unsigned NOT NULL DEFAULT '0',
  `sum_exp` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`auth_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.avatar
DROP TABLE IF EXISTS `avatar`;
CREATE TABLE IF NOT EXISTS `avatar` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `price` int(10) NOT NULL,
  `images` varchar(500) NOT NULL,
  `type` varchar(20) NOT NULL,
  `gender` tinyint(2) NOT NULL,
  `imgid` tinyint(2) NOT NULL,
  `level` tinyint(2) NOT NULL,
  `hire_day` tinyint(2) NOT NULL DEFAULT '30',
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.avatar_copy
DROP TABLE IF EXISTS `avatar_copy`;
CREATE TABLE IF NOT EXISTS `avatar_copy` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `price` int(10) NOT NULL,
  `images` varchar(500) NOT NULL,
  `type` varchar(20) NOT NULL,
  `gender` tinyint(2) NOT NULL,
  `imgid` tinyint(2) NOT NULL,
  `level` tinyint(2) NOT NULL,
  `hire_day` tinyint(2) NOT NULL DEFAULT '30',
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.check_hack
DROP TABLE IF EXISTS `check_hack`;
CREATE TABLE IF NOT EXISTS `check_hack` (
  `username` varchar(500) DEFAULT '',
  `hehe` varchar(500) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.config
DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `key` varchar(50) DEFAULT NULL,
  `value` longtext,
  UNIQUE KEY `ix_key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.config_1
DROP TABLE IF EXISTS `config_1`;
CREATE TABLE IF NOT EXISTS `config_1` (
  `key` varchar(50) DEFAULT NULL,
  `value` text,
  UNIQUE KEY `ix_key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.config_8x69
DROP TABLE IF EXISTS `config_8x69`;
CREATE TABLE IF NOT EXISTS `config_8x69` (
  `key` varchar(50) DEFAULT NULL,
  `value` text,
  UNIQUE KEY `ix_key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.config_8x85
DROP TABLE IF EXISTS `config_8x85`;
CREATE TABLE IF NOT EXISTS `config_8x85` (
  `key` varchar(50) DEFAULT NULL,
  `value` text,
  UNIQUE KEY `ix_key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.config_backup
DROP TABLE IF EXISTS `config_backup`;
CREATE TABLE IF NOT EXISTS `config_backup` (
  `key` varchar(50) DEFAULT NULL,
  `value` text,
  UNIQUE KEY `ix_key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for view gim_wap.cong_bu_koin_130921
DROP VIEW IF EXISTS `cong_bu_koin_130921`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `cong_bu_koin_130921` (
	`username` VARCHAR(255) NULL COLLATE 'utf8_general_ci',
	`sum_koin` DECIMAL(32,0) NULL,
	`sum_koin_x3` DECIMAL(33,0) NULL
) ENGINE=MyISAM;


-- Dumping structure for table gim_wap.conversation
DROP TABLE IF EXISTS `conversation`;
CREATE TABLE IF NOT EXISTS `conversation` (
  `user_id` int(10) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_created` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.event_complete
DROP TABLE IF EXISTS `event_complete`;
CREATE TABLE IF NOT EXISTS `event_complete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET latin1 NOT NULL,
  `eventid` int(11) NOT NULL,
  `koin` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.event_text_details
DROP TABLE IF EXISTS `event_text_details`;
CREATE TABLE IF NOT EXISTS `event_text_details` (
  `user_id` bigint(20) unsigned NOT NULL,
  `content` text,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.facebook_fanpage
DROP TABLE IF EXISTS `facebook_fanpage`;
CREATE TABLE IF NOT EXISTS `facebook_fanpage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `username` int(11) NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.facebook_friend
DROP TABLE IF EXISTS `facebook_friend`;
CREATE TABLE IF NOT EXISTS `facebook_friend` (
  `user_id` int(11) NOT NULL,
  `friend` text NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.facebook_gift
DROP TABLE IF EXISTS `facebook_gift`;
CREATE TABLE IF NOT EXISTS `facebook_gift` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL,
  `sender` varchar(50) NOT NULL,
  `koin_added` int(11) NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id_date_created` (`user_id`,`date_created`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.farm_item
DROP TABLE IF EXISTS `farm_item`;
CREATE TABLE IF NOT EXISTS `farm_item` (
  `farm_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `farm_type` varchar(20) NOT NULL,
  `image_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`farm_item_id`),
  KEY `farm_item_id` (`farm_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.feedback
DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `user` varchar(50) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `feedback` varchar(500) DEFAULT NULL,
  `platform` varchar(50) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.feedback_call
DROP TABLE IF EXISTS `feedback_call`;
CREATE TABLE IF NOT EXISTS `feedback_call` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL DEFAULT '',
  `feedback` varchar(500) NOT NULL DEFAULT '',
  `call_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ix_username` (`username`),
  KEY `ix_call_time` (`call_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.guild
DROP TABLE IF EXISTS `guild`;
CREATE TABLE IF NOT EXISTS `guild` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `owner` varchar(100) NOT NULL,
  `level` int(11) DEFAULT '1',
  `experience` bigint(20) DEFAULT '0',
  `balance` int(11) DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.imei_lock
DROP TABLE IF EXISTS `imei_lock`;
CREATE TABLE IF NOT EXISTS `imei_lock` (
  `passport` varchar(100) NOT NULL DEFAULT '',
  `cause` varchar(500) NOT NULL DEFAULT '',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `passport` (`passport`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.item
DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `quantity` tinyint(4) NOT NULL,
  `expire` tinyint(4) NOT NULL,
  `price` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.koin_charge
DROP TABLE IF EXISTS `koin_charge`;
CREATE TABLE IF NOT EXISTS `koin_charge` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `created_on` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `koin` int(11) NOT NULL,
  `partner` varchar(20) NOT NULL,
  `type` int(11) NOT NULL,
  `money` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.koin_request
DROP TABLE IF EXISTS `koin_request`;
CREATE TABLE IF NOT EXISTS `koin_request` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `koin_added` int(11) NOT NULL DEFAULT '0',
  `old_koin` int(11) NOT NULL DEFAULT '0',
  `new_koin` int(11) NOT NULL DEFAULT '0',
  `type` varchar(100) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.koin_tmp
DROP TABLE IF EXISTS `koin_tmp`;
CREATE TABLE IF NOT EXISTS `koin_tmp` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `username` varchar(100) NOT NULL DEFAULT '',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password` varchar(50) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `koin` int(11) DEFAULT NULL,
  `balance` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.logkoin
DROP TABLE IF EXISTS `logkoin`;
CREATE TABLE IF NOT EXISTS `logkoin` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `created_on` datetime NOT NULL,
  `sender` varchar(13) NOT NULL,
  `recipient` varchar(6) NOT NULL,
  `sms` varchar(255) NOT NULL,
  `old_koin` int(11) NOT NULL,
  `koin_added` int(11) NOT NULL DEFAULT '0',
  `new_koin` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.logsubkoin
DROP TABLE IF EXISTS `logsubkoin`;
CREATE TABLE IF NOT EXISTS `logsubkoin` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `created_on` datetime NOT NULL,
  `ua` text NOT NULL,
  `ip` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `code` bigint(20) DEFAULT NULL,
  `koin` int(11) DEFAULT NULL,
  `old_koin` int(11) DEFAULT NULL,
  `new_koin` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.log_nap_koin
DROP TABLE IF EXISTS `log_nap_koin`;
CREATE TABLE IF NOT EXISTS `log_nap_koin` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `created_on` datetime DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `money` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `koin_added` int(11) DEFAULT NULL,
  `old_koin` int(11) DEFAULT NULL,
  `new_koin` int(11) DEFAULT NULL,
  `flag1` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ix_username` (`username`),
  KEY `ix_created_on` (`created_on`),
  KEY `ix_flag1` (`flag1`),
  KEY `ix_type` (`type`),
  KEY `ix_money` (`money`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.moregame
DROP TABLE IF EXISTS `moregame`;
CREATE TABLE IF NOT EXISTS `moregame` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `imei` varchar(100) NOT NULL,
  `game_id` varchar(100) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.ngl_request
DROP TABLE IF EXISTS `ngl_request`;
CREATE TABLE IF NOT EXISTS `ngl_request` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `created_on` datetime NOT NULL,
  `ua` varchar(100) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `issuer` varchar(10) NOT NULL,
  `cardcode` varchar(30) NOT NULL,
  `serial` varchar(100) NOT NULL,
  `cardvalue` int(11) NOT NULL DEFAULT '0',
  `username` varchar(255) NOT NULL,
  `koin_added` int(11) NOT NULL DEFAULT '0',
  `old_koin` int(11) NOT NULL DEFAULT '0',
  `new_koin` int(11) NOT NULL DEFAULT '0',
  `success` tinyint(1) NOT NULL DEFAULT '0',
  `response_raw` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `cp` varchar(255) DEFAULT NULL,
  `subcp` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CONNECTION='mysql://dong:12345654321@127.0.0.1:3308/ngl_card/request';

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.notification
DROP TABLE IF EXISTS `notification`;
CREATE TABLE IF NOT EXISTS `notification` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `token` varchar(200) NOT NULL DEFAULT '',
  `version` varchar(10) NOT NULL DEFAULT '',
  `os_type` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ix_token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.prize_code
DROP TABLE IF EXISTS `prize_code`;
CREATE TABLE IF NOT EXISTS `prize_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_on` datetime NOT NULL,
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.questions
DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idLevel` smallint(11) DEFAULT '0',
  `Question` text,
  `caseA` text,
  `caseB` text,
  `caseC` text,
  `caseD` text,
  `trueCase` int(11) DEFAULT NULL,
  `Money` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.questions_lichsu
DROP TABLE IF EXISTS `questions_lichsu`;
CREATE TABLE IF NOT EXISTS `questions_lichsu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idLevel` smallint(11) DEFAULT '0',
  `Question` text,
  `caseA` text,
  `caseB` text,
  `caseC` text,
  `caseD` text,
  `trueCase` int(11) DEFAULT NULL,
  `Money` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.quick_login
DROP TABLE IF EXISTS `quick_login`;
CREATE TABLE IF NOT EXISTS `quick_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` varchar(100) NOT NULL,
  `device_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `device_id` (`device_id`),
  KEY `device_name` (`device_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.rating
DROP TABLE IF EXISTS `rating`;
CREATE TABLE IF NOT EXISTS `rating` (
  `user_id` bigint(20) unsigned NOT NULL,
  `imei` varchar(255) NOT NULL,
  `mission_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.revenue
DROP TABLE IF EXISTS `revenue`;
CREATE TABLE IF NOT EXISTS `revenue` (
  `date_created` date DEFAULT NULL,
  `type` tinyint(4) DEFAULT '0',
  `partner` varchar(50) DEFAULT NULL,
  `k2` bigint(20) DEFAULT '0',
  `mv` bigint(20) DEFAULT '0',
  `total` bigint(20) DEFAULT '0',
  UNIQUE KEY `date_created_type_partner` (`date_created`,`type`,`partner`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.room
DROP TABLE IF EXISTS `room`;
CREATE TABLE IF NOT EXISTS `room` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `number` varchar(100) NOT NULL DEFAULT '0',
  `type` int(10) NOT NULL,
  `game` varchar(100) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_room_room_type` (`type`),
  CONSTRAINT `FK_room_room_type` FOREIGN KEY (`type`) REFERENCES `room_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.room_item
DROP TABLE IF EXISTS `room_item`;
CREATE TABLE IF NOT EXISTS `room_item` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `price` int(10) NOT NULL,
  `price_all` int(10) NOT NULL,
  `image_url` varchar(500) NOT NULL DEFAULT '',
  `image_id` tinyint(2) NOT NULL,
  `type` tinyint(2) NOT NULL,
  `hire_day` int(11) NOT NULL,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.room_type
DROP TABLE IF EXISTS `room_type`;
CREATE TABLE IF NOT EXISTS `room_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `min_level` int(10) DEFAULT NULL,
  `max_level` int(10) DEFAULT NULL,
  `min_blind` int(10) DEFAULT NULL,
  `max_blind` int(10) DEFAULT NULL,
  `max_player` int(10) DEFAULT NULL,
  `table_number` int(10) DEFAULT NULL,
  `game` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.server_koin
DROP TABLE IF EXISTS `server_koin`;
CREATE TABLE IF NOT EXISTS `server_koin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `koin` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.server_koin_daily
DROP TABLE IF EXISTS `server_koin_daily`;
CREATE TABLE IF NOT EXISTS `server_koin_daily` (
  `datecreate` date NOT NULL DEFAULT '0000-00-00',
  `data` text,
  `diff_server_koin` varchar(50) DEFAULT '0',
  `reg_koin` varchar(50) DEFAULT '0',
  `sms_koin` varchar(50) DEFAULT '0',
  `card_koin` varchar(50) DEFAULT '0',
  `admin_koin` varchar(50) DEFAULT '0',
  PRIMARY KEY (`datecreate`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.server_koin_trace
DROP TABLE IF EXISTS `server_koin_trace`;
CREATE TABLE IF NOT EXISTS `server_koin_trace` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_created` date DEFAULT NULL,
  `game` varchar(20) DEFAULT NULL,
  `farm` varchar(20) DEFAULT NULL,
  `zombie` varchar(20) DEFAULT NULL,
  `buy_item` varchar(20) DEFAULT NULL,
  `event` varchar(20) DEFAULT NULL,
  `daily_bonus` varchar(20) DEFAULT NULL,
  `lucky` varchar(20) DEFAULT NULL,
  `private_room` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.smartphone_imei
DROP TABLE IF EXISTS `smartphone_imei`;
CREATE TABLE IF NOT EXISTS `smartphone_imei` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `imei` varchar(100) DEFAULT NULL,
  `number` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `imei` (`imei`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.special_vip_add_koin
DROP TABLE IF EXISTS `special_vip_add_koin`;
CREATE TABLE IF NOT EXISTS `special_vip_add_koin` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(255) NOT NULL,
  `money` int(10) unsigned NOT NULL,
  `koin` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_created_on` (`created_on`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.system_message
DROP TABLE IF EXISTS `system_message`;
CREATE TABLE IF NOT EXISTS `system_message` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `content` varchar(2000) DEFAULT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  `message_type` int(10) NOT NULL DEFAULT '0',
  `bonus` int(10) NOT NULL DEFAULT '0',
  `url` varchar(500) NOT NULL DEFAULT '',
  `cp` varchar(1000) NOT NULL DEFAULT '',
  `not_cp` varchar(1000) NOT NULL DEFAULT '',
  `os_type` varchar(1000) NOT NULL DEFAULT '',
  `version` int(11) NOT NULL DEFAULT '1000',
  `date_begin` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `cp_os_type_version_date_begin_date_end` (`cp`(255),`os_type`(255),`version`,`date_begin`,`date_end`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL,
  `guild_id` int(10) DEFAULT '0',
  `username` varchar(100) NOT NULL,
  `screen_name` varchar(100) DEFAULT '',
  `invite_money` int(11) DEFAULT '0',
  `farm_koin` int(11) NOT NULL DEFAULT '0',
  `status` varchar(1000) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `avatar` varchar(500) DEFAULT NULL,
  `birthday` varchar(20) DEFAULT NULL,
  `gender` tinyint(4) NOT NULL DEFAULT '0',
  `event_text` tinyint(4) DEFAULT '0',
  `no_charging` tinyint(4) NOT NULL DEFAULT '0',
  `register_charging` tinyint(4) NOT NULL DEFAULT '0',
  `private_room` tinyint(4) NOT NULL DEFAULT '0',
  `vip` tinyint(4) NOT NULL DEFAULT '0',
  `address` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `passport` varchar(200) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `charging_mobile` varchar(15) DEFAULT NULL,
  `relationship` varchar(50) DEFAULT NULL,
  `addition_infor` varchar(1000) DEFAULT NULL,
  `notify_message` int(11) NOT NULL DEFAULT '0',
  `notify_friend` int(11) NOT NULL DEFAULT '0',
  `message_config` int(11) NOT NULL DEFAULT '1',
  `service_infor` text,
  `cp` varchar(50) NOT NULL DEFAULT 'k2tek',
  `client_version` varchar(50) NOT NULL DEFAULT '1.0.2',
  `platform` varchar(500) DEFAULT '',
  `os_type` varchar(10) DEFAULT '',
  `os_register` varchar(50) DEFAULT '',
  `client_ip` varchar(500) DEFAULT NULL,
  `login_times` int(11) NOT NULL DEFAULT '0',
  `koin_begin` bigint(20) NOT NULL DEFAULT '0',
  `koin_added` bigint(20) NOT NULL DEFAULT '0',
  `daily_bonus` tinyint(4) DEFAULT '0',
  `mute_time` timestamp NULL DEFAULT NULL,
  `lock_time` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ix_username_uniq` (`username`),
  KEY `ix_mobile` (`mobile`),
  KEY `ix_guild_id` (`guild_id`),
  KEY `ix_last_login` (`last_login`),
  KEY `ix_daily_bonus` (`daily_bonus`),
  KEY `koin_added` (`koin_added`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.user_avatar
DROP TABLE IF EXISTS `user_avatar`;
CREATE TABLE IF NOT EXISTS `user_avatar` (
  `user_id` int(10) NOT NULL DEFAULT '0',
  `avatar_id` int(10) NOT NULL DEFAULT '0',
  `avatar_type` varchar(10) NOT NULL,
  `is_used` tinyint(4) NOT NULL DEFAULT '0',
  `buy_time` timestamp NULL DEFAULT NULL,
  `expire_time` timestamp NULL DEFAULT NULL,
  KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.user_balance
DROP TABLE IF EXISTS `user_balance`;
CREATE TABLE IF NOT EXISTS `user_balance` (
  `id` int(10) NOT NULL,
  `balance` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.user_block
DROP TABLE IF EXISTS `user_block`;
CREATE TABLE IF NOT EXISTS `user_block` (
  `id` int(11) unsigned NOT NULL,
  `cause` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.user_blog_album
DROP TABLE IF EXISTS `user_blog_album`;
CREATE TABLE IF NOT EXISTS `user_blog_album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` varchar(50) CHARACTER SET latin1 NOT NULL,
  `title` varchar(500) NOT NULL,
  `description` varchar(1000) CHARACTER SET latin1 NOT NULL,
  `image` varchar(500) CHARACTER SET latin1 DEFAULT NULL,
  `image_count` int(11) DEFAULT '0',
  `plus_count` int(11) DEFAULT NULL,
  `is_default` tinyint(4) NOT NULL DEFAULT '0',
  `date_modify` datetime NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.user_blog_album_image
DROP TABLE IF EXISTS `user_blog_album_image`;
CREATE TABLE IF NOT EXISTS `user_blog_album_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` varchar(50) NOT NULL,
  `album_id` int(11) NOT NULL DEFAULT '0',
  `status_id` int(11) NOT NULL DEFAULT '0',
  `plus1` text NOT NULL,
  `plus_count` int(11) NOT NULL,
  `comment_count` int(11) NOT NULL,
  `image` varchar(500) NOT NULL,
  `date_modify` datetime NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.user_blog_album_image_comment
DROP TABLE IF EXISTS `user_blog_album_image_comment`;
CREATE TABLE IF NOT EXISTS `user_blog_album_image_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) NOT NULL DEFAULT '0',
  `owner` varchar(50) NOT NULL,
  `writer` varchar(50) NOT NULL,
  `content` varchar(500) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.user_blog_wall
DROP TABLE IF EXISTS `user_blog_wall`;
CREATE TABLE IF NOT EXISTS `user_blog_wall` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `writer` varchar(50) NOT NULL,
  `owner` varchar(50) NOT NULL,
  `notifier` mediumtext,
  `feed_notifier` mediumtext,
  `content` varchar(500) NOT NULL,
  `image` varchar(500) DEFAULT NULL,
  `plus1` mediumtext,
  `plus_count` int(11) NOT NULL DEFAULT '0',
  `comment_count` int(11) NOT NULL DEFAULT '0',
  `album_id` int(11) DEFAULT NULL,
  `date_modified` datetime NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.user_blog_wall_comment
DROP TABLE IF EXISTS `user_blog_wall_comment`;
CREATE TABLE IF NOT EXISTS `user_blog_wall_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_id` int(11) NOT NULL DEFAULT '0',
  `writer` varchar(50) NOT NULL,
  `content` varchar(500) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.user_daily_win
DROP TABLE IF EXISTS `user_daily_win`;
CREATE TABLE IF NOT EXISTS `user_daily_win` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `koin_begin` bigint(20) NOT NULL,
  `koin_max` bigint(20) NOT NULL,
  `koin_topup` bigint(20) NOT NULL,
  `koin_win` bigint(20) NOT NULL,
  `currentdate` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `koin_topup` (`koin_topup`),
  KEY `currentdate` (`currentdate`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.user_farm
DROP TABLE IF EXISTS `user_farm`;
CREATE TABLE IF NOT EXISTS `user_farm` (
  `user_id` int(11) NOT NULL,
  `farm_info` text NOT NULL,
  `content_item` text NOT NULL,
  `content_farm` text NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.user_friend
DROP TABLE IF EXISTS `user_friend`;
CREATE TABLE IF NOT EXISTS `user_friend` (
  `id` int(10) NOT NULL,
  `friend_id` int(10) NOT NULL,
  `status` int(4) NOT NULL COMMENT '0:wait response, 1:wait answer, 2:friend',
  PRIMARY KEY (`id`,`friend_id`),
  KEY `FK_user_friend_user` (`friend_id`),
  CONSTRAINT `FK_user_friend_user` FOREIGN KEY (`friend_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.user_item
DROP TABLE IF EXISTS `user_item`;
CREATE TABLE IF NOT EXISTS `user_item` (
  `user_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `quantity` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.user_message
DROP TABLE IF EXISTS `user_message`;
CREATE TABLE IF NOT EXISTS `user_message` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `sender_id` int(10) NOT NULL,
  `sender_name` varchar(50) DEFAULT '',
  `sender_screen_name` varchar(50) DEFAULT '',
  `title` varchar(1000) DEFAULT '',
  `content` varchar(1000) DEFAULT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  `message_type` int(10) NOT NULL DEFAULT '0',
  `bonus` int(10) NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_user_message_user_2` (`user_id`),
  KEY `ix_sender_id` (`sender_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.user_mission
DROP TABLE IF EXISTS `user_mission`;
CREATE TABLE IF NOT EXISTS `user_mission` (
  `user_id` int(10) NOT NULL,
  `infor` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.user_more
DROP TABLE IF EXISTS `user_more`;
CREATE TABLE IF NOT EXISTS `user_more` (
  `id` int(10) NOT NULL,
  `win` int(10) NOT NULL DEFAULT '0',
  `deuce` int(10) NOT NULL DEFAULT '0',
  `loose` int(10) NOT NULL DEFAULT '0',
  `level` int(10) NOT NULL DEFAULT '0',
  `experience` int(10) NOT NULL DEFAULT '0',
  `game` varchar(50) NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `ix_id_game` (`id`,`game`),
  KEY `FK_user_more_user` (`id`),
  KEY `ix_game_exp` (`game`,`experience`),
  CONSTRAINT `__FK_user_more_user` FOREIGN KEY (`id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.user_new_mission
DROP TABLE IF EXISTS `user_new_mission`;
CREATE TABLE IF NOT EXISTS `user_new_mission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `fb_id` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ix_userId` (`username`),
  UNIQUE KEY `ix_fb_id` (`fb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.user_new_year
DROP TABLE IF EXISTS `user_new_year`;
CREATE TABLE IF NOT EXISTS `user_new_year` (
  `id` int(10) NOT NULL,
  `infor` varchar(100) DEFAULT NULL,
  `last_modify` timestamp NULL DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.user_notify
DROP TABLE IF EXISTS `user_notify`;
CREATE TABLE IF NOT EXISTS `user_notify` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `owner` varchar(50) DEFAULT NULL,
  `type` int(11) DEFAULT '0',
  `writer` varchar(50) DEFAULT '0',
  `content` varchar(1000) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `read_status` tinyint(4) DEFAULT '0',
  `date_created` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_owner` (`owner`),
  KEY `ix_read_status` (`read_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.user_online_history
DROP TABLE IF EXISTS `user_online_history`;
CREATE TABLE IF NOT EXISTS `user_online_history` (
  `type` varchar(50) NOT NULL,
  `dateOnline` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `online` int(10) DEFAULT NULL,
  `times` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`type`,`dateOnline`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.user_room_item
DROP TABLE IF EXISTS `user_room_item`;
CREATE TABLE IF NOT EXISTS `user_room_item` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `item_id` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `expired_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.user_wall
DROP TABLE IF EXISTS `user_wall`;
CREATE TABLE IF NOT EXISTS `user_wall` (
  `wall_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `detail` text NOT NULL,
  `type` varchar(10) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`wall_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.user_wall_album
DROP TABLE IF EXISTS `user_wall_album`;
CREATE TABLE IF NOT EXISTS `user_wall_album` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `wall_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `detail` text NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.vfun_vip
DROP TABLE IF EXISTS `vfun_vip`;
CREATE TABLE IF NOT EXISTS `vfun_vip` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `created_on` datetime NOT NULL,
  `modified_on` datetime DEFAULT NULL,
  `expired_on` datetime NOT NULL,
  `username` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `mobile` varchar(13) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  `flag1` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_username` (`username`),
  KEY `idx_expired_on` (`expired_on`),
  KEY `idx_enabled` (`enabled`),
  KEY `idx_mobile` (`mobile`),
  KEY `idx_flag1` (`flag1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.vfun_vip_queue
DROP TABLE IF EXISTS `vfun_vip_queue`;
CREATE TABLE IF NOT EXISTS `vfun_vip_queue` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `created_on` datetime NOT NULL,
  `json` text,
  `pop_id` int(11) NOT NULL DEFAULT '0',
  `return_code` int(11) DEFAULT NULL,
  `json0` text,
  PRIMARY KEY (`id`),
  KEY `idx_pop_id` (`pop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.vms_vip
DROP TABLE IF EXISTS `vms_vip`;
CREATE TABLE IF NOT EXISTS `vms_vip` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `created_on` datetime NOT NULL,
  `modified_on` datetime DEFAULT NULL,
  `expired_on` datetime NOT NULL,
  `username` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `mobile` varchar(13) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  `flag1` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_username` (gim_wap`username`),
  KEY `idx_expired_on` (`expired_on`),
  KEY `idx_enabled` (`enabled`),
  KEY `idx_mobile` (`mobile`),
  KEY `idx_flag1` (`flag1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table gim_wap.vnptg_vip
DROP TABLE IF EXISTS `vnptg_vip`;
CREATE TABLE IF NOT EXISTS `vnptg_vip` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `created_on` datetime NOT NULL,
  `modified_on` datetime DEFAULT NULL,
  `expired_on` datetime NOT NULL,
  `username` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `mobile` varchar(13) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  `flag1` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_username` (`username`),
  KEY `idx_expired_on` (`expired_on`),
  KEY `idx_enabled` (`enabled`),
  KEY `idx_mobile` (`mobile`),
  KEY `idx_flag1` (`flag1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for view gim_wap.cong_bu_koin_130921
DROP VIEW IF EXISTS `cong_bu_koin_130921`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `cong_bu_koin_130921`;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;