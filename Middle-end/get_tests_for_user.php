<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (!isset($_POST['user_id'])) {
	error("Bad Request");
}

$user_id = (int) $_POST['user_id'];

$resp = http(BACK_END, "get_tests_for_user", [
	"user_id" => $user_id
]);

if ($resp === false) {
	error("cURL request failed");
}

echo $resp;
