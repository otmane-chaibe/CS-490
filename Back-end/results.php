<?php

require_once('../functions.php');

header('Content-Type: application/json');

assertPost()
$user_id=$_POST['user_id'];

$results = Test::getResultsForUser($user_id);

echo json_encode($results)
?>

