# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.16)
# Database: ks492
# Generation Time: 2017-03-06 00:27:16 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table args
# ------------------------------------------------------------

DROP TABLE IF EXISTS `args`;

CREATE TABLE `args` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `type` enum('0','1','2','3','4') NOT NULL DEFAULT '0',
  `name` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table questions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `category` enum('0','1','2','3') NOT NULL DEFAULT '0' COMMENT '(0) Conditional (1) Control Flow (2) Recursion',
  `function_name` varchar(25) NOT NULL DEFAULT '',
  `function_type` enum('0','1','2','3') NOT NULL DEFAULT '0' COMMENT 'The datatype of the function.',
  `difficulty` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '(0) Easy (1) Medium (2) Difficult',
  `description` varchar(128) NOT NULL DEFAULT '' COMMENT 'Additional description of the question.',
  `solution` text NOT NULL COMMENT 'Proposed solution.',
  `template` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table released_tests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `released_tests`;

CREATE TABLE `released_tests` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `test_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `user_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table student_tests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `student_tests`;

CREATE TABLE `student_tests` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `test_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `test_grade` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `completed` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table test_questions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `test_questions`;

CREATE TABLE `test_questions` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `test_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `question_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table test_results
# ------------------------------------------------------------

DROP TABLE IF EXISTS `test_results`;

CREATE TABLE `test_results` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` tinyint(3) unsigned NOT NULL,
  `test_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `question_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `remark` text NOT NULL,
  `score` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tests`;

CREATE TABLE `tests` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `name` varchar(75) NOT NULL DEFAULT '',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table unit_test_inputs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `unit_test_inputs`;

CREATE TABLE `unit_test_inputs` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` tinyint(3) unsigned NOT NULL,
  `input` tinyint(3) unsigned NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table unit_tests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `unit_tests`;

CREATE TABLE `unit_tests` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `output` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `ucid` varchar(6) NOT NULL DEFAULT '',
  `password` varchar(256) NOT NULL DEFAULT '',
  `name` varchar(75) NOT NULL DEFAULT '',
  `role` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '(0) Student (1) Instructor',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
