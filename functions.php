<?php

# Maurice Achtenhagen

/*
	functions.php
	-----------------------------------------------
	This file is included by everyone and contains
	global functions we all use. Not including this
	file will result in a fatal error. Add anything
	global into this file.
	-----------------------------------------------
*/

error_reporting(E_ALL);
ini_set('display_errors', 'On');

# Base URL used in every cURL request
define("BASE_URL", "https://web.njit.edu/~");

# UCID constants for testing purposes
define("BACK_END", "mma93/Back-end/"); #ks492
define("MIDDLE_END", "mma93/Middle-end/"); #sma76

spl_autoload_register(function ($class) {
	$base_dir = __DIR__ . '/Models/';
	$file = $base_dir . str_replace('\\', '/', $class) . '.php';
	if (file_exists($file)) {
		require $file;
	}
});

# Global function to assert POST is used
function assertPost() {
	if ($_SERVER['REQUEST_METHOD'] != 'POST') {
		header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
		header('Allow: POST');
		die(json_encode(['status' => 405, 'response' => 'Must Use POST']));
	}
}

# Global function to send cURL requests
# The response object will be returned in JSON format
function http($dest, $fname, $params = [], $ext = ".php") {
	$url = BASE_URL . $dest . $fname . $ext;
	if (filter_var($url, FILTER_VALIDATE_URL) === false) { return false; }
	curl_setopt_array($curl = curl_init(), [
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL            => $url,
		CURLOPT_POST           => 1,
		CURLOPT_POSTFIELDS     => $params,
		CURLOPT_TIMEOUT        => 5,
	]);
	$resp = curl_exec($curl);
	curl_close($curl);
	return $dest == MIDDLE_END ? json_decode($resp, true) : $resp;
}

# Global secure redirect
function redirect($to) {
	header('Location: ' . $to);
	exit;
}

# Global error function
function error($error) {
	header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
	die(json_encode([
		'status'   => 400,
		'response' => $error,
	]));
}

# Global type to string function
function type_to_string($type) {
	switch ($type) {
		case 0: return "Int";
		case 1: return "Float";
		case 2: return "Double";
		case 3; return "String";
		case 4: return "Boolean";
		default: return "Int";
	}
}

# Get the argument type from string
function get_type_from($str) {
	if (empty($str)) { return 0; }
	switch ($str) {
		case "int": return 0;
		case "float": return 1;
		case "double": return 2;
		case "string": return 3;
		case "bool": return 4;
		default: return 0;
	}
}
