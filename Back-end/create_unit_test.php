<?php

# Maurice Achtenhagen

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if (!isset($_POST['question_id'])) {
	error("Missing Parameter: question_id.");
}

if (!isset($_POST['input'])) {
	error("Missing Parameter: inputs.");
}

if (!isset($_POST['input_type'])) {
	error("Missing Parameter: input_type.");
}

if (!isset($_POST['output'])) {
	error("Missing Parameter: output.");
}

$inputs = json_decode($_POST['input']);
$input_types = json_decode($_POST['input_type']);

$unit_test_id = UnitTest::createUnitTest($_POST['question_id'], $inputs, $input_types, $_POST['output']);

echo json_encode($unit_test_id);
