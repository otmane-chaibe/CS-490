<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (empty($_POST['name'])) {
	error('Test name cannot be empty.');
}

$user_id = (int) $_POST['user_id'];
$name = trim($_POST['name']);

$resp = http(BACK_END, "create_test", [
	"user_id" => $user_id,
	"name"    => $name,
]);

if ($resp === false) {
	error("cURL request failed");
}

echo $resp;
