<?php

# Khurshid Sohail

require_once('../functions.php');

assertPost();

if (empty($_POST['user_id'])) {
	error("User id cannot be empty");
}

$user_id = (int) $_POST['user_id'];

echo json_encode(Test::getTestsForUser($user_id));
