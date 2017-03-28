<?php

# Maurice Achtenhagen

require_once('../functions.php');

session_start();

header('Content-Type: application/json');

assertPost();

$ucid = $_POST['ucid'];
$pass = $_POST['pass'];

if (empty($ucid) || empty($pass)) {
	error("Bad Request");
}

if (strlen($ucid) > 6 || strlen($pass) > 20) {
	error("Bad Request");
}

$cred = http(MIDDLE_END, "login", [
	"ucid" => $ucid,
	"pass" => $pass,
]);

if ($cred === false) {
	error("cURL request failed");
}

if (isset($cred['user_id']) && isset($cred['role'])) {
	$_SESSION['user_id'] = $cred['user_id'];
	$_SESSION['role'] = $cred['role'];
}

echo json_encode($cred);
