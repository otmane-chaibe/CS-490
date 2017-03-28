<?php

# Maurice Achtenhagen

require_once('../mysql.php');
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

$unit_test_id = UnitTest::createUnitTest($_POST['question_id'], $_POST['inputs'], $_POST['outputs']);

echo json_encode($unit_test_id);
