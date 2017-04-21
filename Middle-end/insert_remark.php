<?php

# Maurice Achtenhagen

require_once('../functions.php');

assertPost();

if (!isset($_POST['id'])) {
	error("Missing Parameter: id.");
}

if (!isset($_POST['remark'])) {
	error("Missing Parameter: remark.");
}

$id = (int) $_POST['id'];
$remark = $_POST['remark'];

$resp = http(BACK_END, "insert_remark", [
	'id'     => $id,
	'remark' => $remark,
]);

if ($resp === false) {
	error("cURL request failed.");
}

echo $resp;
