<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

$questions = http(BACK_END, "get_all_test_questions");

if ($questions === false) {
	error("cURL request failed");
}

echo $questions;
