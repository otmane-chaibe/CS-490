<?php

# Maurice Achtenhagen

/*
	login.php
	-----------------------------------------------
	This file is called via a cURL request from the
	front-end. It will hand off the POST parameters
	to the back-end and return its response.
	-----------------------------------------------
*/

require_once('../functions.php');

header('Content-Type: application/json');

assertPost();

if (empty($_POST['ucid']) || empty($_POST['pass'])) {
	error("Bad Request");
}

$ucid = $_POST['ucid'];
$pass = $_POST['pass'];

if (strlen($ucid) > 6 || strlen($pass) > 20) {
	error("Bad Request");
}

# cURL Request -> Back-end -> login.php
# TODO: replace mma93 with ks492 in url
$curl = curl_init();
curl_setopt_array($curl, [
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_URL            => 'https://web.njit.edu/~mma93/Back-end/login.php',
	CURLOPT_POST           => 1,
	CURLOPT_POSTFIELDS     => [
		'ucid' => $ucid,
		'pass' => $pass
	]
]);
$resp = curl_exec($curl);
curl_close($curl);
if ($resp === false) {
	error("cURL request failed");
}
echo $resp;
