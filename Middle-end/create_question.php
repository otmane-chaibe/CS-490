<?php

require_once('../functions.php');

header('Content-Type: application/json');

session_start();
assertPost();

$category = $_POST['type'];
$difficulty = $_POST['difficulty'];
$name = trim($_POST['name']);
$type = $_POST['returns'];
$solution = $_POST['solution'];
$args = [];

if (empty($name)) {
	error('Function name cannot be empty.');
}

foreach ($_POST['argname'] as $offset => $argname) {
	$argname = trim($argname);
	if (empty($argname)) {
		error("Argument #" . ($offset + 1) . ": name cannot be empty.");
	}

	$argtype = $_POST['argtype'][$offset];
	if ($argtype == "-1") {
		error("Argument #" . ($offset + 1) . ": type must be set.");
	}

	$args[] = [ 'type' => $argtype, 'name' => $argname ];
}

Question::createQuestion($_SESSION['user_id'], $name, $category, $difficulty, $type, $args, $solution);

echo(json_encode(true));
