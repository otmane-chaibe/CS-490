<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if(!isset($_POST['test_id']) || !isset($_POST['unit_test_id']) ||
	!isset($_POST['output']) || !isset($_POST['expected'])) {
	error("Missing Parameters");
}

$test_id = (int) $_POST['test_id'];
$unit_test_id=(int)$_POST['unit_test_id'];
$output=$_POST['output'];
$expected=$_POST['expected'];

echo json_encode(UnitTest::insertUnitTestResult($test_id, $unit_test_id, $output, $expected));
