<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if(!isset($_POST[$question_id]))
{
	error("Missing Parameter");
}

$q_id=(int) $_POST['question_id'];

echo json_encode(UnitTest::getUnitTestsForQuestion($q_id));


