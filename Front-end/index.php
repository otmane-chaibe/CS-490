<?php

require_once('../functions.php');

session_start();

if (isset($_SESSION['user_id'])) {
	if (isset($_SESSION['role'])) {
		if ($_SESSION['role'] == 1) {
			redirect('instructor.php');
		} else {
			redirect('student.php');
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">
		<link rel="stylesheet" href="style/style.css" />
		<link rel="stylesheet" href="style/controls.css" />
		<link rel="stylesheet" href="style/question.css" />
		<link rel="stylesheet" href="style/instructor.css" />
		<link rel="stylesheet" href="style/student.css" />
		<link rel="stylesheet" href="style/test.css" />
		<title>Online Exam System</title>
	</head>
	<body>
		<header></header>
		<main>
			<div id="login">
				<h1>Authentication Service</h1>
				<p>Please enter your UCID to proceed.</p>
				<div id="status"></div>
				<form method="POST">
					<label for="ucid">UCID</label>
					<input id="ucid" type="text" maxlength="6" placeholder="mma93" />
					<div class="split"></div>
					<label for="pass">Password</label>
					<input id="pass" type="password" maxlength="20" placeholder="required" />
				</form>
				<button id="submit" type="button">Submit</button>
			</div>
<?php require_once('footer.php') ?>
