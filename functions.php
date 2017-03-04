<?php

require_once('config.php');

if (empty(DB_SERVER) || empty(DB_USER))
{
	die('Application not configured.');
}

spl_autoload_register(function ($class) {
	$base_dir = __DIR__ . '/Models/';
	$file = $base_dir . str_replace('\\', '/', $class) . '.php';
	if (file_exists($file)) {
		require $file;
	}
});

$mysqli = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
if ($mysqli->connect_error) {
	die('Unable to establish database connection: ' . $mysqli->connect_error);
}
$mysqli->set_charset('utf8');

function assertPost()
{
	if ($_SERVER['REQUEST_METHOD'] != 'POST')
	{
		header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
		header('Allow: POST');
		die(json_encode(['status' => 405, 'response' => 'Must Use POST']));
	}
}

function redirect($to)
{
	header('Location: ' . $to);
	exit;
}
