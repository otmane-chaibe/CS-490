<?php

# Maurice Achtenhagen // Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if (empty($_POST['ucid']) || empty($_POST['pass'])) {
	error("Bad Request");
}

$ucid = $_POST['ucid'];
$pass = $_POST['pass'];

if (strlen($ucid) > 6 || strlen($pass) > 20) {
	error("Bad Request");
}

$result = $mysqli->query("SELECT id, role FROM users WHERE ucid = '$ucid' AND password = PASSWORD('$pass')");
if ($row = $result->fetch_array()) {
	echo json_encode([
		"status"   => 200,
		"response" => "login successful",
		"user_id"  => $row["id"],
		"role"     => $row["role"]
	]);
} else {
	echo json_encode([
		"status"   => 403,
		"response" => "login not succesful"
	]);
}
