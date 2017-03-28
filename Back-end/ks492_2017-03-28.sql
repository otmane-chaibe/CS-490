-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: sql1.njit.edu
-- Generation Time: Mar 28, 2017 at 03:34 PM
-- Server version: 5.5.29-log
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ks492`
--

-- --------------------------------------------------------

--
-- Table structure for table `args`
--

CREATE TABLE IF NOT EXISTS `args` (
`id` tinyint(4) unsigned NOT NULL,
  `question_id` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `type` enum('0','1','2','3','4') NOT NULL DEFAULT '0',
  `name` varchar(25) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
`id` tinyint(4) unsigned NOT NULL,
  `user_id` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `category` enum('0','1','2','3') NOT NULL DEFAULT '0' COMMENT '(0) Conditional (1) Control Flow (2) Recursion',
  `function_name` varchar(25) NOT NULL DEFAULT '',
  `function_type` enum('0','1','2','3') NOT NULL DEFAULT '0' COMMENT 'The datatype of the function.',
  `difficulty` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '(0) Easy (1) Medium (2) Difficult',
  `description` varchar(128) NOT NULL DEFAULT '' COMMENT 'Additional description of the question.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `released_tests`
--

CREATE TABLE IF NOT EXISTS `released_tests` (
`id` tinyint(3) unsigned NOT NULL,
  `test_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `user_id` tinyint(3) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `student_tests`
--

CREATE TABLE IF NOT EXISTS `student_tests` (
`id` tinyint(3) unsigned NOT NULL,
  `user_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `test_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `test_grade` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `completed` tinyint(3) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE IF NOT EXISTS `tests` (
`id` tinyint(3) unsigned NOT NULL,
  `user_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `name` varchar(75) NOT NULL DEFAULT '',
  `created` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `user_id`, `name`, `created`) VALUES
(1, 2, 'Sample Exam', 1489773450),
(2, 2, 'Midterm Exam', 1489773548),
(3, 2, '123', 1489792102),
(4, 2, 'New', 1489942155);

-- --------------------------------------------------------

--
-- Table structure for table `test_questions`
--

CREATE TABLE IF NOT EXISTS `test_questions` (
`id` tinyint(3) unsigned NOT NULL,
  `test_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `question_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `weight` decimal(10,0) unsigned NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `test_questions`
--

INSERT INTO `test_questions` (`id`, `test_id`, `question_id`, `weight`) VALUES
(1, 4, 0, 1),
(2, 4, 0, 1),
(3, 4, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `test_results`
--

CREATE TABLE IF NOT EXISTS `test_results` (
`id` tinyint(3) unsigned NOT NULL,
  `user_id` tinyint(3) unsigned NOT NULL,
  `test_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `question_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `solution` varchar(128) NOT NULL,
  `remark` text,
  `score` tinyint(3) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `unit_tests`
--

CREATE TABLE IF NOT EXISTS `unit_tests` (
`id` tinyint(3) unsigned NOT NULL,
  `question_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `output` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `unit_test_inputs`
--

CREATE TABLE IF NOT EXISTS `unit_test_inputs` (
`id` tinyint(3) unsigned NOT NULL,
  `question_id` tinyint(3) unsigned NOT NULL,
  `input` enum('0','1','2','3') NOT NULL DEFAULT '0',
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` tinyint(4) unsigned NOT NULL,
  `ucid` varchar(6) NOT NULL DEFAULT '',
  `password` varchar(256) NOT NULL DEFAULT '',
  `name` varchar(75) NOT NULL DEFAULT '',
  `role` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '(0) Student (1) Instructor'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ucid`, `password`, `name`, `role`) VALUES
(1, 'mma93', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', 'Maurice A.', 0),
(2, 'prof', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', 'John Smith', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `args`
--
ALTER TABLE `args`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `released_tests`
--
ALTER TABLE `released_tests`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_tests`
--
ALTER TABLE `student_tests`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_questions`
--
ALTER TABLE `test_questions`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_results`
--
ALTER TABLE `test_results`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit_tests`
--
ALTER TABLE `unit_tests`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit_test_inputs`
--
ALTER TABLE `unit_test_inputs`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `args`
--
ALTER TABLE `args`
MODIFY `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
MODIFY `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `released_tests`
--
ALTER TABLE `released_tests`
MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_tests`
--
ALTER TABLE `student_tests`
MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `test_questions`
--
ALTER TABLE `test_questions`
MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `test_results`
--
ALTER TABLE `test_results`
MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `unit_tests`
--
ALTER TABLE `unit_tests`
MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `unit_test_inputs`
--
ALTER TABLE `unit_test_inputs`
MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
