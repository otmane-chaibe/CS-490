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

# Check POST Variables
if (empty($ucid) || empty($pass)) {
	error("Bad Request");
}
if (strlen($ucid) > 6 || strlen($pass) > 20) {
	error("Bad Request");
}

# cURL Request -> Middle-end -> login.php
# The response object will already be in JSON format
# TODO: replace mma93 with sma76 in url
$curl = curl_init();
curl_setopt_array($curl, [
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_URL            => 'https://web.njit.edu/~mma93/Middle-end/login.php',
	CURLOPT_POST           => 1,
	CURLOPT_POSTFIELDS     => [
		"ucid" => $ucid,
		"pass" => $pass
	]
]);
$resp = curl_exec($curl);
curl_close($curl);
if ($resp === false) {
	error("cURL request failed");
}
$cred = json_decode($resp, true);
if (isset($cred['user_id']) && isset($cred['role'])) {
	$_SESSION['user_id'] = $cred['user_id'];
	$_SESSION['role'] = $cred['role'];
}
echo $resp;
