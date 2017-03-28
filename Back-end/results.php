<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if (empty($_POST['user_id'])) {
	error("User id can not be empty");
}

$user_id = (int) $_POST['user_id'];

echo json_encode(Test::getResultsForUser($user_id));
