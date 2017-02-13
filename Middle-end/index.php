
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
	
	$curl = curl_init();
	curl_setopt_array($curl, [
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTPHEADER     => ['Content-Type: application/x-www-form-urlencoded'],
	    CURLOPT_POST           => 1,
	    CURLOPT_POSTFIELDS     => "user=" . $ucid . "&pass=" . $pass . "&uuid=0xACA021",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_URL            => 'https://cp4.njit.edu/cp/home/login',
		CURLOPT_USERAGENT      => 'NJIT Authentication System',
	]);
	
	# Verify cURL response
	$resp = curl_exec($curl);
	curl_close($curl);
	if (!strpos($resp, "Login Successful")) {
		die(json_encode(["status" => 403, "response" => "Unauthorized"]));
	}
	echo json_encode([
		"njit" => ["status" => 200, "response" => "Login successful"],
		"db"   => ["status" => 403, "response" => "Login not successful"]
	]);
