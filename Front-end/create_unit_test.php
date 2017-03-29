<?php

# Maurice Achtenhagen

require_once('../functions.php');

header('Content-Type: application/json');

assertPost();

if (!isset($_POST['question_id'])) {
	error("Missing Parameter: question_id.");
}

if (!isset($_POST['input'])) {
	error("Missing Parameter: input.");
}

if (!isset($_POST['input_type'])) {
	error("Missing Parameter: input_type.");
}

if (!isset($_POST['output'])) {
	error("Missing Parameter: output.");
}

$question_id = (int) $_POST['question_id'];
$inputs = [];
$input_types = [];
foreach ($_POST['input'] as $input) {
	$inputs[] = $input;
}
foreach ($_POST['input_type'] as $type) {
	$input_types[] = $type;
}

var_dump($inputs);
var_dump($input_types);

$unit_test_id = http(MIDDLE_END, "create_unit_test", [
	"question_id" => $question_id,
	"input"       => json_encode($inputs),
	"input_type"  => json_encode($input_type),
	"output"      => $_POST['output'],
]);

if ($unit_test_id === false) {
	error("cURL request failed");
}

echo json_encode($unit_test_id);
