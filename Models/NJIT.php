<?php

# https://web.njit.edu/~sma76/index.php

class NJIT {

	public static function login($ucid, $pass) {
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL            => 'http://localhost/Middle-end/login.php',
			CURLOPT_POST           => 1,
			CURLOPT_POSTFIELDS     => [
				"ucid" => $ucid,
				"pass" => $pass
			],
		]);
		$resp = curl_exec($curl);
		curl_close($curl);
		return $resp;
	}
}
