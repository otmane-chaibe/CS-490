
<?php
	# Check Request Method
	if ($_SERVER['REQUEST_METHOD'] != "POST") {
		header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
		header('Allow: POST');
		die(json_encode(["error" => "Must Use POST"]));
	}
	$ucid = $_POST['ucid'];
	$pass = $_POST['pass'];
	# Check POST Variables
	if (empty($ucid) || empty($pass)) {
		header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
		die(json_encode(["error" => "Missing Paramater"]));
	}
	$curl = curl_init();
	curl_setopt_array($curl, [
	    CURLOPT_RETURNTRANSFER => 1,
	    CURLOPT_URL => 'http://www.njit.edu/cp/login.php',
	    CURLOPT_USERAGENT => '<form name= "cplogin" action="https://cp4.njit.edu/cp/home/login" onsubmit="login(); return false;" method="post">
								<label class="blocklabel" for="pass"  accesskey="p">...</label>
								<input type="hidden" name="user" value>
								<input type="hidden" name="uuid" value="0xAC021">
								</form>',
	    CURLOPT_POST => 1,
	    CURLOPT_POSTFIELDS => [
	        "ucid" => $ucid,
	        "pass" => $pass
	    ]
	]);
	$resp = curl_exec($curl);
	print_r($resp);
	var_dump($resp);
	# echo json_encode($resp);
	curl_close($curl);
	
	
?>
