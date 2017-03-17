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
$cred = http(BACK_END, "login", [
	"ucid" => $ucid,
	"pass" => $pass,
]);

if ($cred === false) {
	error("cURL request failed");
}

echo $cred;
