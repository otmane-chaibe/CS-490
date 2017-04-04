<?php

# Maurice Achtenhagen

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if (!isset($_POST['test_id'])) {
	error("Missing Parameter: test_id.");
}

$test_id = (int) $_POST['test_id'];

echo json_encode(Test::getTestById($test_id));
