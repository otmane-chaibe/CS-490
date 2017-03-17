<?php

/*
	dologin.php
	-----------------------------------------------
	This file is called from the front-end via Ajax
	in index.php. It will send a cURL request to
	the middle-end with 2 parameters ucid and pass.
	The session is only used by the front-end and
	should only be set in this file.
	-----------------------------------------------
*/

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

# cURL Request -> Middle-end -> login.php
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
