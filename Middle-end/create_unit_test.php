<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (!isset($_POST['question_id'])) {
	error("Missing Parameter: question_id.");
}

if (!isset($_POST['inputs'])) {
	error("Missing Parameter: inputs.");
}

if (!isset($_POST['outputs'])) {
	error("Missing Parameter: outputs.");
}

$unit_test_id = http(BACK_END, "create_unit_test", [
	'question_id' => $_POST['question_id'],
	'inputs'      => $_POST['inputs'],
	'outputs'     => $_POST['outputs'],
]);

var_dump($_POST['inputs']);

if ($unit_test_id === false) {
	error("cURL request failed");
}

echo $unit_test_id;
