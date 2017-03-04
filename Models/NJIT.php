<?php

class NJIT
{

	public static function login($ucid, $pass)
	{
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL            => 'https://web.njit.edu/~sma76/index.php',
			CURLOPT_USERAGENT      => 'NJIT Auth Front-end',
			CURLOPT_POST           => 1,
			CURLOPT_POSTFIELDS     => [
				"ucid" => $ucid,
				"pass" => $pass,
			],
		]);
		$resp = curl_exec($curl);
		curl_close($curl);
		return $resp;
	}

}
