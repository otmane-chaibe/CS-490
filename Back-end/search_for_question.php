<?php

# Maurice Achtenhagen

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if (!isset($_POST['keyword'])) {
	error('Missing Parameter: keyword.');
}

$keyword = trim($_POST['keyword']);

echo json_encode(Question::search($keyword));
