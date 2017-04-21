<?php

# Maurice Achtenhagen

require_once('../functions.php');

session_start();

if (!isset($_SESSION['user_id'])) {
	error("Must be logged in.", 403);
}

header('Content-Type: application/json');

assertPost();

if (!isset($_POST['id'])) {
	error("Missing Parameter: id.");
}

if (!isset($_POST['remark'])) {
	error("Missing Parameter: remark.");
}

$id = (int) $_POST['id'];
$remark = $_POST['remark'];

$resp = http(MIDDLE_END, "insert_remark", [
	'id'     => $id,
	'remark' => $remark,
]);

if ($resp === false) {
	error("cURL request failed.");
}

echo json_encode($resp);
