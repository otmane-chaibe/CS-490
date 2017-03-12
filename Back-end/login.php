<?php

/*
	login.php
	-----------------------------------------------
	This file is called via a cURL request from the
	middle-end. It will query the db with the given
	credentials and return a response object.
	-----------------------------------------------
*/

require_once('../config.php');

if (empty(DB_SERVER) || empty(DB_USER)) {
	die('Application not configured.');
}

require_once('../functions.php');

$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
if ($mysqli->connect_error) {
	die('Unable to establish database connection: ' . $mysqli->connect_error);
}
$mysqli->set_charset('utf8');

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
