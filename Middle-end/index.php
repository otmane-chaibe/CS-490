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
		$methodName = $_POST['methodName'];
		$argNum = $_POST['argNum'];
		$conType = $_POST['ConType'];				//condition type
		$methodInput = $_POST['methodInput'];		//input to the method
		$methodOutput = $_POST['methodOutput'];		//expected answer
		
		if (empty($methodName) || empty($argNum) || empty($conType) || empty($methodInput) || empty($methodOutput)) {
			header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
			die(json_encode(["status" => 400, "response" => "Bad Request"]));
		}
		
		# cURL Request - Back-end = For Question
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL            => 'https://web.njit.edu/~ks492/searchform.php',
			CURLOPT_USERAGENT      => 'NJIT Auth Middle-end',
			CURLOPT_POST           => 1,
			CURLOPT_POSTFIELDS     => [
				"argNum" => $argNum,
				"methodName" => $methodName,
				"conType" => $conType,
				"methodInput" => $methodInput,
				"methodOutput" =>  $methodOutput
			]
		]);
		
		$resp = curl_exec($curl);
		curl_close($curl);
		
		# Verify cURL response
		$resp = json_decode($resp, true);
		$db = ["status" => 403, "response" => "Login not successful"];
		if (!empty($resp["db"]) && $resp["db"]["status"] == 200) {
			$db = ["status" => 200, "response" => "Login successful"];
		}
		
		# Return Results
		echo json_encode([
			"db"   => $db
		]);
	
	
	}
	else{
		
		# cURL Request - Back-end - For Login
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL            => 'https://web.njit.edu/~ks492/searchform.php',
			CURLOPT_USERAGENT      => 'NJIT Auth Middle-end',
			CURLOPT_POST           => 1,
			CURLOPT_POSTFIELDS     => [
				"ucid" => $ucid,
				"pass" => $pass
			]
		]);
		$resp = curl_exec($curl);
		curl_close($curl);
		
		# Verify cURL response
		$resp = json_decode($resp, true);
		$db = ["status" => 403, "response" => "Login not successful"];
		if (!empty($resp["db"]) && $resp["db"]["status"] == 200) {
			$db = ["status" => 200, "response" => "Login successful"];
		}
		
		# Return Results
		echo json_encode([
			"db"   => $db
		]);
	}

?>
	