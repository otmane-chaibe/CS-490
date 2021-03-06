<?php

# Maurice Achtenhagen

require_once('../functions.php');

session_start();

header('Content-Type: application/json');

assertPost();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
	error("Must be logged in");
}

if (empty($_POST['name'])) {
	error('Test name cannot be empty.');
}

$name = trim($_POST['name']);

$resp = http(MIDDLE_END, "create_test", [
	"user_id" => $_SESSION['user_id'],
	"name"    => $name,
]);

if ($resp === false) {
	error("cURL request failed");
}

echo json_encode($resp);
