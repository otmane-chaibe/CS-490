<?php

# Maurice Achtenhagen

require_once('../functions.php');

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

$unit_test_id = http(BACK_END, "create_unit_test", [
	'question_id' => $_POST['question_id'],
	"input"       => $_POST['input'],
	"input_type"  => $_POST['input_type'],
	'output'      => $_POST['output'],
]);

if ($unit_test_id === false) {
	error("cURL request failed");
}

echo $unit_test_id;
