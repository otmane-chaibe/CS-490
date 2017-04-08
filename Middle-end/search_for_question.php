<?php

# Maurice Achtenhagen

require_once('../functions.php');

session_start();

assertPost();

if (!isset($_POST['keyword'])) {
	error('Missing Parameter: keyword.');
}

$keyword = trim($_POST['keyword']);

$search_results = http(BACK_END, "search_for_question", [
	'keyword' => $keyword
]);

if ($search_results === false) {
	error("cURL request failed");
}

echo $search_results;
