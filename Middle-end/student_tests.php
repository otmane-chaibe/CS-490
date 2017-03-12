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
# TODO: replace mma93 with ks492 in url
$curl = curl_init();
curl_setopt_array($curl, [
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_URL            => 'https://web.njit.edu/~mma93/Back-end/student_tests.php',
	CURLOPT_POST           => 1,
	CURLOPT_POSTFIELDS     => []
]);
$resp = curl_exec($curl);
curl_close($curl);
if ($resp === false) {
	error("cURL request failed");
}
echo $resp;
