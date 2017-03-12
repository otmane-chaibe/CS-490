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

$result = $mysqli->query("SELECT id, role FROM users WHERE ucid = '$ucid' AND password = PASSWORD('$pass')");

if ($row = $result->fetch_array()) {
	$_SESSION['user_id'] = $row['id'];
	$_SESSION['role'] = $row['role'];
	echo json_encode([
		"status"   => 200,
		"response" => "login successful"
	]);
} else {
	echo json_encode([
		"status"   => 403,
		"response" => "login not succesful",
	]);
}

# cURL Request - Middle-end
# $resp = \NJIT::login($ucid, $pass);

//if (!isset($resp['user_id'])) {
//	die($resp);
//}
//
//if (!isset($resp['role'])) {
//	die($resp);
//}
