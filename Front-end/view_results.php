<?php

# Maurice Achtenhagen

require_once('header.php');

# if ($_SESSION['role'] == 0) {}

$test_id = $_GET['id'];

$test_results = http(MIDDLE_END, "get_test_solutions", [
	'test_id' => $test_id
]);

if ($test_result === false) {
	error("cURL request failed.");
}

var_dump($test_results);
