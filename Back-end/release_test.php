<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if (!isset($_POST['test_id'])) {
	error("Missing Parameter: test_id.");
}

$test_id=(int)$_POST['test_id'];

Test::releaseTest($test_id);

echo json_encode(true);
