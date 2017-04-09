<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../funcions.php');

assertPost();

if(!isset($_POST['released']))
{
	error("Missing Parameters");
}

$released = (int) $_POST['released'];

echo json_encode(Test::getReleasedTests($released));
