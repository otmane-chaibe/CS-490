<?php

# Maurice Achtenhagen

require_once('../functions.php');

session_start();

header('Content-Type: application/json');

assertPost();

$ucid = $_POST['ucid'];
$pass = $_POST['pass'];

# Check POST Variables
if (empty($ucid) || empty($pass)) {
	header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
	die(json_encode(["status" => 400, "response" => "Bad Request"]));
}
if (strlen($ucid) > 6 || strlen($pass) > 20) {
	header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
	die(json_encode(["status" => 400, "response" => "Bad Request"]));
}

# cURL Request - Middle-end
$resp = \NJIT::login($ucid, $pass);

if (!isset($resp['user_id'])) {
	die($resp);
}

if (!isset($resp['role'])) {
	die($resp);
}

$_SESSION['user_id'] = $resp['user_id'];
$_SESSION['role'] = $resp['role'];
