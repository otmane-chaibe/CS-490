<?php

require_once('../functions.php');

header('Content-Type: application/json');

session_start();
assertPost();

$name = trim($_POST['name']);
if (empty($name)) {
	error('Test name cannot be empty.');
}

echo(json_encode(Test::createTest($name)));
