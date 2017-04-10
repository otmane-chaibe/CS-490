<?php

# Maurice Achtenhagen

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if(!isset($_POST['unit_test_id'])) {
	error("Missing Parameter: unit_test_id.");
}

$unit_test_id=(int) $_POST['unit_test_id'];

$results = http(BACK_END, "get_unit_test_results", [
	'unit_test_id' => $unit_test_id
]);

if ($results === false) {
	error("cURL request failed.");
}

echo $results;
