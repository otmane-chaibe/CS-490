<?php

# Maurice Achtenhagen

/*
	get_tests_for_user.php
	-----------------------------------------------
	This file is called via a cURL request from the
	front-end. It will hand off the POST parameters
	to the back-end and return its response.
	-----------------------------------------------
*/

require_once('../functions.php');

assertPost();

if (!isset($_POST['user_id'])) {
	error("Bad Request");
}

$user_id = (int) $_POST['user_id'];

# cURL Request -> Back-end -> get_tests_for_user.php
$tests = http(BACK_END, "get_tests_for_user", [
	"user_id" => $user_id
]);

if ($tests === false) {
	error("cURL request failed");
}

echo $tests;
