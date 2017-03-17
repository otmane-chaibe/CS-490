<?php

/*
	create_test.php
	-----------------------------------------------
	This file is called from the front-end via Ajax
	in instructor.php. It will send a cURL request
	to the middle-end with 1 parameter: name.
	-----------------------------------------------
*/

require_once('../functions.php');

session_start();

header('Content-Type: application/json');

assertPost();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
	error("Must be logged in");
}

if (empty($_POST['name'])) {
	error('Test name cannot be empty.');
}

$name = trim($_POST['name']);

# cURL Request -> Middle-end -> create_test.php
$test = http(MIDDLE_END, "create_test", [
	"user_id" => $_SESSION['user_id'],
	"name"    => $name,
]);

if ($test === false) {
	error("cURL request failed");
}

echo json_encode($test);
