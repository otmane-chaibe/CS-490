<?php

require_once('../functions.php');

assertPost();

if (empty($_POST['user_id'])) {
	error("User id can not be empty");
}

$user_id = (int) $_POST['user_id'];

$results = http(BACK_END, "results", [
	"user_id" => $user_id,
]);

if ($results === false) {
	error("cURL request failed");
}

echo $results;
