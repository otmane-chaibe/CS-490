<?php

require_once('../functions.php');

session_start();

header('Content-Type: application/json');

assertPost();

if (!isset($_POST['category'])) {
	error('Missing Parameter: category.');
}

if (!isset($_POST['difficulty'])) {
	error('Missing Parameter: difficulty.');
}

if (!isset($_POST['fname'])) {
	error('Missing Parameter: fname.');
}

if (!isset($_POST['returntype'])) {
	error('Missing Parameter: returntype.');
}

if (!isset($_POST['description'])) {
	error('Missing Parameter: description.');
}

$args = [];
$unit_inputs = [];
$fname = trim($_POST['fname']);
$category = $_POST['category'];
$difficulty = $_POST['difficulty'];
$return_type = $_POST['returntype'];
$description = $_POST['description'];
$unit_out = trim($_POST['unitout']);

foreach ($_POST['unitin'] as $input) {
	$unit_inputs[] = $input;
}

if (empty($fname)) {
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
	$args[] = [
		'type' => $argtype,
		'name' => $argname,
	];
}

$question_id = http(MIDDLE_END, "create_question", [
	"user_id"     => $_SESSION['user_id'],
	"fname"       => $fname,
	"category"    => $category,
	"difficulty"  => $difficulty,
	"returntype"  => $return_type,
	"args"        => $args,
	"description" => $description,
]);

if ($question_id === false) {
	error("cURL request failed");
}

if ($question_id > 0) {
	$inputs = [];
	foreach ($unit_inputs as $input) {
		$tmp = explode(" ", $input);
		$inputs[] = [
			"type"  => get_type_from(strtolower($tmp[0])),
			"value" => $tmp[1],
		];
	}
	$resp = http(MIDDLE_END, "create_unit_test", [
		"question_id" => $question_id,
		"inputs"      => $inputs,
		"outputs"     => $unit_out,
	]);
	if ($resp === false) {
		error("cURL request failed");
	}
}

echo json_encode($question_id);
