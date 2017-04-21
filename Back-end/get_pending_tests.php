<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if (!isset($_POST['user_id'])) {
	error("Missing Parameter: user_id");
}

$user_id = (int) $_POST['user_id'];

echo json_encode(Test::getPendingTests($user_id));
