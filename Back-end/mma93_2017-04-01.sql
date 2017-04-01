# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: sql2.njit.edu (MySQL 5.5.29-log)
# Database: mma93
# Generation Time: 2017-04-01 20:55:00 +0000
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
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Row ID',
  `question_id` tinyint(4) unsigned NOT NULL COMMENT 'Question ID',
  `type` enum('0','1','2','3','4') NOT NULL DEFAULT '0' COMMENT '(0) Int (1) Float (2) Double (3) String (4) Boolean',
  `name` varchar(25) NOT NULL DEFAULT '' COMMENT 'Argument name',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table questions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Row ID',
  `user_id` tinyint(4) unsigned NOT NULL COMMENT 'User ID (professor)',
  `category` enum('0','1','2','3') NOT NULL DEFAULT '0' COMMENT '(0) Conditional (1) Control Flow (2) Recursion (3) Other',
  `function_name` varchar(25) NOT NULL DEFAULT '' COMMENT 'Name of the function',
  `function_type` enum('0','1','2','3','4') NOT NULL DEFAULT '0' COMMENT '(0) Int (1) Float (2) Double (3) String (4) Boolean',
  `difficulty` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '(0) Easy (1) Medium (2) Difficult',
  `description` text NOT NULL COMMENT 'Additional description of the question',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table student_solutions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `student_solutions`;

CREATE TABLE `student_solutions` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Row ID',
  `q_id` tinyint(3) unsigned NOT NULL COMMENT 'Question ID',
  `solution` text NOT NULL COMMENT 'Question solution (student)',
  `has_correct_function_modifier` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Grading rubric - 1 (10 pts)',
  `has_correct_function_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Grading rubric - 2 (10 pts)',
  `has_correct_function_name` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Grading rubric - 3 (10 pts)',
  `has_correct_function_params` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Grading rubric - 4 (10 pts)',
  `does_compile` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Grading rubric - 5 (10 pts)',
  `passes_unit_tests` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Grading rubric - 6 (50 pts)',
  `remark` text COMMENT 'Optional remark by professor',
  `score` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Question score (out of 100)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table student_tests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `student_tests`;

CREATE TABLE `student_tests` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Row ID',
  `user_id` tinyint(3) unsigned NOT NULL COMMENT 'User ID (student)',
  `test_id` tinyint(3) unsigned NOT NULL COMMENT 'Test ID',
  `score` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Test Score (out of 100)',
  `completed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '(0) Open (1) Completed / Read-only',
  `released` tinyint(1) NOT NULL DEFAULT '0' COMMENT '(0) Unreleased (1) Released',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table test_questions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `test_questions`;

CREATE TABLE `test_questions` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Row ID',
  `test_id` tinyint(3) unsigned NOT NULL COMMENT 'Test ID',
  `question_id` tinyint(3) unsigned NOT NULL COMMENT 'Question ID',
  `weight` decimal(10,0) unsigned NOT NULL DEFAULT '1' COMMENT 'Question weight (0.0 - 1.0)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tests`;

CREATE TABLE `tests` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Row ID',
  `user_id` tinyint(3) unsigned NOT NULL COMMENT 'User ID',
  `name` varchar(75) NOT NULL DEFAULT '' COMMENT 'Test name',
  `created` int(10) unsigned NOT NULL COMMENT 'Date created (unix timestamp)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table unit_test_inputs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `unit_test_inputs`;

CREATE TABLE `unit_test_inputs` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Row ID',
  `unit_test_id` tinyint(3) unsigned NOT NULL COMMENT 'Unit test ID',
  `type` enum('0','1','2','3','4') NOT NULL DEFAULT '0' COMMENT '(0) Int (1) Float (2) Double (3) String (4) Boolean',
  `input` varchar(128) NOT NULL DEFAULT '' COMMENT 'Input for the unit test',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table unit_tests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `unit_tests`;

CREATE TABLE `unit_tests` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Row ID',
  `question_id` tinyint(3) unsigned NOT NULL COMMENT 'Question ID',
  `output` text NOT NULL COMMENT 'Output of the unit test',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Row ID (user ID)',
  `ucid` varchar(6) NOT NULL DEFAULT '' COMMENT 'UCID (similar to NJIT UCID)',
  `password` varchar(256) NOT NULL DEFAULT '' COMMENT 'User password',
  `name` varchar(75) NOT NULL DEFAULT '' COMMENT 'User name (first + last)',
  `role` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '(0) Student (1) Instructor',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
