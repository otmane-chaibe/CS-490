<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if(!isset($_POST['unit_test_id']) || !isset($_POST['output']) || !isset($_POST['expected']))
{
	error("Missing Parameter");
}

$unit_test_id=(int)$_POST['unit_test_id'];
$output=$_POST['output'];
$expected=$_POST['expected'];

echo json_encode(UnitTest::insertUnitTestResult($unit_test_id, $output, $expected));
