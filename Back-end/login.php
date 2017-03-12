<?php

require_once('../functions.php');

if ($_SERVER['REQUEST_METHOD'] != "POST")
{
	header($_SERVER['SERVER_PROTOCOL']. '405 Method Not Allowed');
	header('Allow: POST');
	die(json_encode(["error" => "Must Use POST"]));
}

$ucid = $_POST["ucid"];
$pass = $_POST["pass"];

$result = $mysqli->query("SELECT id, role FROM users WHERE ucid = '$ucid' AND password = PASSWORD('$pass')");

if ($row = $result->fetch_array()) {
	echo json_encode([
		"status" => 200,
		"response" => "login successful",
		"user_id" => $row["id"],
		"role" => $row["role"],
	]);
} else {
	echo json_encode([
		"status" => 403,
		"response" => "login not succesful",
	]);
}
