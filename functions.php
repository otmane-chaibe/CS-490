<?php

# Maurice Achtenhagen

/*
	functions.php
	-----------------------------------------------
	This file is included by everyone and contains
	global functions we all use. Not including this
	file will result in a fatal error.
	Add anything global into this file.
	-----------------------------------------------
*/

spl_autoload_register(function ($class) {
	$base_dir = __DIR__ . '/Models/';
	$file = $base_dir . str_replace('\\', '/', $class) . '.php';
	if (file_exists($file)) {
		require $file;
	}
});

# Global function to assure POST is used
function assertPost() {
	if ($_SERVER['REQUEST_METHOD'] != 'POST') {
		header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
		header('Allow: POST');
		die(json_encode(['status' => 405, 'response' => 'Must Use POST']));
	}
}

# Global secure redirect function
function redirect($to) {
	header('Location: ' . $to);
	exit;
}

# Global error function
function error($error) {
	header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
	die(json_encode([
		'status'   => 400,
		'response' => $error
	]));
}

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
