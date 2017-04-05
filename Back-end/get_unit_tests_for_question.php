<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if(!isset($_POST['q_id']))
{
	error("Missing Parameter");
}

$q_id=(int) $_POST['q_id'];

echo json_encode(UnitTest::getUnitTestsForQuestion($q_id));
