<?php

# Maurice Achtenhagen

require_once('../functions.php');

session_start();

header('Content-Type: application/json');

assertPost();

if (!isset($_POST['keyword'])) {
	error('Missing Parameter: keyword.');
}

$keyword = trim($_POST['keyword']);

$search_results = http(MIDDLE_END, "search_for_question", [
	'keyword' => $keyword
]);

if ($search_results === false) {
	error("cURL request failed");
}

echo json_encode($search_results);
