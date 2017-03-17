<?php

require_once('../functions.php');

header('Content-Type: application/json');

session_start();
assertPost();

$args = [];
$unit_inputs = [];
$category = $_POST['type'];
$difficulty = $_POST['difficulty'];
$name = trim($_POST['name']);
$description = $_POST['description'];
$type = $_POST['returns'];
$unit_out = trim($_POST['unitout']);

foreach ($_POST['unitin'] as $input) { $unit_inputs[] = $input; }

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

$question_id = Question::createQuestion($_SESSION['user_id'], $name, $category, $difficulty, $type, $args, $description);
if ($question_id > 0) {
	$inputs = [];
	foreach ($unit_inputs as $input) {
		$tmp = explode(" ", $input);
		$inputs[] = [
			"type"  => UnitTest::get_type_from(strtolower($tmp[0])),
			"value" => $tmp[1]
		];
	}
	UnitTest::createUnitTest($question_id, $inputs, $unit_out);
}

echo(json_encode(true));
