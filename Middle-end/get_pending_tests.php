<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (!isset($_POST['user_id'])) {
	error("Missing Parameter: user_id");
}

$user_id = (int) $_POST['user_id'];

$pending_tests = http(BACK_END, "get_pending_tests", [
	'user_id' => $user_id
]);

echo $pending_tests;
