<?php

# Khurshid Sohail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if(!isset($_POST['id']) || !isset($_POST['remark']))
{
	error("Missing Parameters");
}

$id=(int) $_POST['id'];
$remark=$_POST['remark'];

Test::insertRemark($id, $remark);

echo json_encode(true);
