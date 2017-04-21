<?php

# Maurice Achtenhagen

require_once('../functions.php');

session_start();

if (!isset($_SESSION['user_id'])) {
	error("Must be logged in.", 403);
}

assertPost();

if (!isset($_POST['id'])) {
	error("Missing Parameter: id.");
}

$id = (int) $_POST['id'];

$resp = http(MIDDLE_END, "release_test", [
	'id' => $id,
]);

if ($resp === false) {
	error("cURL request failed.");
}

echo json_encode(true);
