<?php

# Maurice Achtenhagen

/*
	create_test.php
	-----------------------------------------------
	This file is called via a cURL request from the
	front-end. It will hand off the POST parameters
	to the back-end and return its response.
	-----------------------------------------------
*/

require_once('../functions.php');

assertPost();

if (empty($_POST['name'])) {
	error('Test name cannot be empty.');
}

$user_id = (int) $_POST['user_id'];
$name = trim($_POST['name']);

# cURL Request -> Back-end -> create_test.php
$test = http(BACK_END, "create_test", [
	"user_id" => $user_id,
	"name"    => $name,
]);

if ($test === false) {
	error("cURL request failed");
}

echo $test;
