<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if(!isset($_POST['test_id']))
{
	error("Missing Parameters");
}

$test_id = (int) $_POST['test_id'];

echo json_encode(Test::getTestSolutions($test_id));
