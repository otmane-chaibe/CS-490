<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if(!isset($_POST['unit_test_id']))
{
	error("Missing Parameter");
}

$unit_test_id=(int) $_POST['unit_test_id'];

echo json_encode(UnitTest::getUnitTestResults($unit_test_id));
