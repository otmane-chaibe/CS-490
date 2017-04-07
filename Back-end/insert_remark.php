<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if(!isset($_POST['q_id']) || !isset($_POST['remark']))
{
	error("Missing Parameters");
}

$q_id=(int) $_POST['q_id'];
$remark=$_POST['remark'];

echo json_encode(Test::insertRemark($q_id, $remark));
