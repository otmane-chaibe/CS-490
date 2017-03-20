<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

$questions = http(BACK_END, "get_all_test_questions", [
	"test_id" => $test_id,
]);

if ($questions === false) {
	error("cURL request failed");
}

echo $questions;
