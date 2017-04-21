<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (!isset($_POST['q_id'])) {
	error("Missing Parameter: q_id.");
}

$q_id = (int) $_POST['q_id'];

$weight = http(BACK_END, "get_question_weight", [
	'q_id' => $q_id
]);

if ($weight === false) {
	error("cURL request failed.");
}

echo $weight;
