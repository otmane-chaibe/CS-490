<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (!isset($_POST['q_id'])) {
	error("Missing Parameter: q_id.");
}

$q_id = (int) $_POST['q_id'];

$unit_tests = http(BACK_END, "get_unit_tests_for_question", [
	"q_id" => $q_id
]);

if ($unit_tests === false) {
	error("cURL request failed.");
}

echo $unit_tests;
