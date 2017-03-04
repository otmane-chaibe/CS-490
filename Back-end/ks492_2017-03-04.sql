#
# SQL Export
# Created by Querious (1068)
# Created: March 4, 2017 at 15:14:03 EST
# Encoding: Unicode (UTF-8)
#


CREATE DATABASE IF NOT EXISTS `ks492` DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_unicode_ci;
USE `ks492`;




SET @PREVIOUS_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS;
SET FOREIGN_KEY_CHECKS = 0;


DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `unit_tests`;
DROP TABLE IF EXISTS `tests`;
DROP TABLE IF EXISTS `test_results`;
DROP TABLE IF EXISTS `test_questions`;
DROP TABLE IF EXISTS `student_tests`;
DROP TABLE IF EXISTS `released_tests`;
DROP TABLE IF EXISTS `questions`;
DROP TABLE IF EXISTS `args`;


CREATE TABLE `args` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `type` enum('0','1','2','3','4') NOT NULL DEFAULT '0',
  `name` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `questions` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `category` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '(0) Conditional (1) Control Flow (2) Recursion',
  `function_name` varchar(25) NOT NULL DEFAULT '',
  `function_type` enum('0','1','2','3') NOT NULL DEFAULT '0' COMMENT 'The datatype of the function.',
  `difficulty` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '(0) Easy (1) Medium (2) Difficult',
  `description` varchar(128) NOT NULL DEFAULT '' COMMENT 'Additional description of the question.',
  `solution` text NOT NULL COMMENT 'Proposed solution.',
  `template` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


CREATE TABLE `released_tests` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `test_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `user_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `student_tests` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `test_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `test_grade` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `test_questions` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `test_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `question_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


CREATE TABLE `test_results` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `test_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `question_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `remark` text NOT NULL,
  `score` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `tests` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `name` varchar(75) NOT NULL DEFAULT '',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


CREATE TABLE `unit_tests` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `unit_text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `users` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `ucid` varchar(6) NOT NULL DEFAULT '',
  `password` varchar(256) NOT NULL DEFAULT '',
  `name` varchar(75) NOT NULL DEFAULT '',
  `role` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '(0) Student (1) Instructor',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;




SET FOREIGN_KEY_CHECKS = @PREVIOUS_FOREIGN_KEY_CHECKS;


