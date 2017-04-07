<?php

# Khurshid SOhail

require_once('../mysql.php');
require_once('../functions.php');

assertPost();

if(!isset($_POST['id']) || !isset($_POST['remark']))
{
	error("Missin Parameters");
}

$id=(int) $_POST['id'];
$remark=$_POST['remark'];

echo json_encode(Test::insertRemark($id, $remark));
