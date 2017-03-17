<?php

/*
	get_tests_for_user.php
	-----------------------------------------------
	This file is called via a cURL request from the
	middle-end. It will query the db and return its
	response. Note the call to the model here.
	-----------------------------------------------
*/

require_once('../mysql.php');
require_once('../functions.php');

header('Content-Type: application/json');

assertPost();

if (empty($_POST['user_id'])) {
	error("User ID cannot be empty");
}

$user_id = (int) $_POST['user_id'];

echo json_encode(Test::getTestsForUser($user_id));
