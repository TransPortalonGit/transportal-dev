# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: transportal-dev.informatik.uni-bremen.de (MySQL 5.5.32)
# Database: transportal
# Generation Time: 2015-03-17 22:28:48 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table answers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `answers`;

CREATE TABLE `answers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `best_answer` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table appointments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `appointments`;

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `title` text CHARACTER SET utf8 NOT NULL,
  `notes` text CHARACTER SET utf8 NOT NULL,
  `color` text CHARACTER SET utf8 NOT NULL,
  `start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table boxes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `boxes`;

CREATE TABLE `boxes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table cabinets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cabinets`;

CREATE TABLE `cabinets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `columns` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `groups_name_unique` (`name`) COMMENT '(null)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;



# Dump of table history_comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `history_comments`;

CREATE TABLE `history_comments` (
  `id` bigint(20) NOT NULL,
  `comment_id` bigint(20) NOT NULL,
  `body` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `quantity` bigint(20) NOT NULL,
  `condition` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `category` tinyint(4) NOT NULL,
  `image` text NOT NULL,
  `description` text NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;



# Dump of table itemsusers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `itemsusers`;

CREATE TABLE `itemsusers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `due_at` date NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `borrowed_at` date NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table listing_tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `listing_tags`;

CREATE TABLE `listing_tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `listing_id` int(11) unsigned NOT NULL,
  `tag_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table listings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `listings`;

CREATE TABLE `listings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `is_offer` tinyint(1) NOT NULL,
  `is_service` tinyint(1) NOT NULL,
  `title` varchar(60) NOT NULL DEFAULT '',
  `description` varchar(1023) NOT NULL DEFAULT '',
  `image_path` varchar(255) DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `ends_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table machines
# ------------------------------------------------------------

DROP TABLE IF EXISTS `machines`;

CREATE TABLE `machines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `type` text NOT NULL,
  `available` tinyint(1) NOT NULL,
  `color` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;



# Dump of table project_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `project_users`;

CREATE TABLE `project_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `owner` tinyint(1) unsigned NOT NULL,
  `manager` tinyint(1) unsigned NOT NULL,
  `accepted_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table projects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `projects`;

CREATE TABLE `projects` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `files` text NOT NULL,
  `docs` text NOT NULL,
  `docnames` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `favorite` bigint(20) NOT NULL,
  `views` bigint(20) NOT NULL,
  `comment_count` bigint(20) NOT NULL,
  `icon` varchar(50) CHARACTER SET utf8 NOT NULL,
  `color` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;



# Dump of table projects_comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `projects_comments`;

CREATE TABLE `projects_comments` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) NOT NULL,
  `comment_id` bigint(20) NOT NULL,
  `reply_id` bigint(20) NOT NULL,
  `up_votes` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table projectsessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `projectsessions`;

CREATE TABLE `projectsessions` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `project_id` int(9) NOT NULL,
  `step` varchar(100) NOT NULL,
  `duration` varchar(50) NOT NULL,
  `technology` varchar(50) NOT NULL,
  `material` varchar(100) NOT NULL,
  `costs` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `description` varchar(1000) NOT NULL,
  `files` text NOT NULL,
  `docs` text NOT NULL,
  `docnames` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table qrhash
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qrhash`;

CREATE TABLE `qrhash` (
  `hash` varchar(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table question_tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `question_tags`;

CREATE TABLE `question_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` int(10) unsigned DEFAULT NULL,
  `tag_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table questions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table relations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `relations`;

CREATE TABLE `relations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ref_id` int(11) NOT NULL,
  `type` enum('item','box','surface','cabinet','room') COLLATE utf8_unicode_ci NOT NULL,
  `parent_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table repairs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `repairs`;

CREATE TABLE `repairs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table rooms
# ------------------------------------------------------------

DROP TABLE IF EXISTS `rooms`;

CREATE TABLE `rooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table surfaces
# ------------------------------------------------------------

DROP TABLE IF EXISTS `surfaces`;

CREATE TABLE `surfaces` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `column` int(11) NOT NULL,
  `row` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) NOT NULL,
  `parent` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table throttle
# ------------------------------------------------------------

DROP TABLE IF EXISTS `throttle`;

CREATE TABLE `throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attempts` int(11) NOT NULL DEFAULT '0',
  `suspended` tinyint(4) NOT NULL DEFAULT '0',
  `banned` tinyint(4) NOT NULL DEFAULT '0',
  `last_attempt_at` timestamp NULL DEFAULT NULL,
  `suspended_at` timestamp NULL DEFAULT NULL,
  `banned_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;



# Dump of table transactions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `transactions`;

CREATE TABLE `transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` enum('lend','return') COLLATE utf8_unicode_ci NOT NULL,
  `due_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table tutorials
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tutorials`;

CREATE TABLE `tutorials` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `content` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Role` tinyint(1) NOT NULL DEFAULT '2',
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `activated` tinyint(4) NOT NULL DEFAULT '0',
  `activation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activated_at` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `incognito` tinyint(1) NOT NULL,
  `inlab` tinyint(4) NOT NULL DEFAULT '0',
  `enteredlab_at` datetime NOT NULL,
  `leftlab_at` datetime NOT NULL,
  `persist_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_password_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zipcode` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `QRkey` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `profile_pic` text COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `github` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `homepage` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `googleplus` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `xing` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `threedplatform` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `academia` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`) COMMENT '(null)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;



# Dump of table users_comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users_comments`;

CREATE TABLE `users_comments` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `body` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table users_favorites
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users_favorites`;

CREATE TABLE `users_favorites` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `project_id` int(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table users_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users_groups`;

CREATE TABLE `users_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;



# Dump of table wanted_tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wanted_tags`;

CREATE TABLE `wanted_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wanted_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table wanteds
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wanteds`;

CREATE TABLE `wanteds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `description` varchar(1000) NOT NULL,
  `wanted_count` tinyint(3) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
