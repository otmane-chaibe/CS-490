<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (!isset($_POST['q_id'])) {
	error("Missing Parameter: q_id.");
}

if (!isset($_POST['remark'])) {
	error("Missing Parameter: remark.");
}

$q_id = (int) $_POST['q_id'];
$remark = $_POST['remark'];

$resp = http(BACK_END, "insert_remark", [
	'q_id'   => $q_id,
	'remark' => $remark,
]);

if ($resp === false) {
	error("cURL request failed.");
}

echo json_encode(true);
