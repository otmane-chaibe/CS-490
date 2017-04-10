<?php

# Maurice Achtenhagen

/*
	header.php
	-----------------------------------------------
	This file is to be included by every page in
	the front-end. It will provide access to the
	navigation bar, the session and functions.php.
	Note that this excludes dologin.php.
	-----------------------------------------------
*/

require_once('../functions.php');

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
	redirect('index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
		<link rel="stylesheet" href="style/style.css" />
		<link rel="stylesheet" href="style/controls.css" />
		<link rel="stylesheet" href="style/question.css" />
		<link rel="stylesheet" href="style/sidebar.css" />
		<link rel="stylesheet" href="style/instructor.css" />
		<link rel="stylesheet" href="style/results.css" />
		<link rel="stylesheet" href="style/student.css" />
		<link rel="stylesheet" href="style/take_test.css" />
		<link rel="stylesheet" href="style/test.css" />
		<link rel="stylesheet" href="style/view_results.css" />
		<title>Online Exam System</title>
	</head>
	<body>
		<header></header>
		<main>
			<nav>
				<ul>
					<?php if ($_SESSION['role'] == 1) { ?>
					<li><a href="instructor.php">Tests</a></li>
					<li><a href="question.php">Create Question</a></li>
					<?php } else { ?>
					<li><a href="student.php">Take Tests</a></li>
					<li><a href="results.php">Test Results</a></li>
					<?php } ?>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</nav>
