<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (!isset($_POST['user_id'])) {
	error("Missing Parameter: user_id.");
}

$user_id = (int) $_POST['user_id'];

$resp = http(BACK_END, "student_tests", [
	'user_id' => $user_id
]);

if ($resp === false) {
	error("cURL request failed");
}

echo $resp;
