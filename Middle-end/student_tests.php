<?php

# Maurice Achtenhagen

/*
	student_tests.php
	-----------------------------------------------
	This file is called via a cURL request from the
	front-end. It will hand off the request to the
	back-end and return its response.
	-----------------------------------------------
*/

require_once('../functions.php');

header('Content-Type: application/json');

assertPost();

# cURL Request -> Back-end -> student_tests.php
$resp = http(UCID_BACK_END, "student_tests");

if ($resp === false) {
	error("cURL request failed");
}

echo $resp;
