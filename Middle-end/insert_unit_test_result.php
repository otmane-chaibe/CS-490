<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (!isset($_POST['unit_test_id'])) {
	error("Missing Parameter: unit_test_id.");
}

if (!isset($_POST['output'])) {
	error("Missing Parameter: output.");
}

if (!isset($_POST['expected'])) {
	error("Missing Parameter: expected.");
}

$unit_test_id = (int) $_POST['unit_test_id'];
$output = $_POST['output'];
$expected = $_POST['expected'];

$unit_test_result_id = http(BACK_END, "insert_unit_test_result", [
	'unit_test_id' => $unit_test_id,
	'output'       => $output,
	'expected'     => $expected,
]);

if ($unit_test_result_id === false) {
	error("cURL request failed.");
}

echo $unit_test_result_id;
