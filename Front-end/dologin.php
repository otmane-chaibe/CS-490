<?php

	header('Content-Type: application/json');

	# Check Request Method
	if ($_SERVER['REQUEST_METHOD'] != "POST") {
		header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
		header('Allow: POST');
		die(json_encode(["status" => 405, "response" => "Must Use POST"]));
	}

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

	# cURL Request - Middle-end
	$curl = curl_init();
	curl_setopt_array($curl, [
	    CURLOPT_RETURNTRANSFER => 1,
	    CURLOPT_URL => 'https://web.njit.edu/~sma76',
	    CURLOPT_USERAGENT => 'NJIT Auth Front-end',
	    CURLOPT_POST => 1,
	    CURLOPT_POSTFIELDS => [
	        "ucid" => $ucid,
	        "pass" => $pass
	    ]
	]);
	$resp = curl_exec($curl);
	curl_close($curl);
	echo json_encode($resp);

?>