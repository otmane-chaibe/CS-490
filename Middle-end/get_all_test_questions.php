<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (!isset($_POST['test_id'])) {
	error("Missing Parameter: test_id.");
}

$test_id = (int) $_POST['test_id'];

$questions = http(BACK_END, "get_all_test_questions", [
	"test_id" => $test_id
]);

if ($questions === false) {
	error("cURL request failed");
}

echo $questions;
