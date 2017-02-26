<?php

mysql_connect ('sql.njit.edu', 'ks492', 'SpqROrOBi');
mysql_select_db ('ks492');

if($_SERVER['REQUEST_METHOD'] != "POST")
{
 header($_SERVER['SERVER_PROTOCOL']. '405 Method Not Allowed');
 header('Allow: POST');
	 die(json_encode(["error" => "Must Use POST"]));
	 }

$ucid = $_POST['ucid'];

$methodName = $_POST['methodName'];
$argNum = $_POST['argNum'];
$conType = $_POST['conType'];
$methodInput = $_POST['methodInput'];
$methodOutput = $_POST['methodOutput'];
//need ftype
//need arg types
//arg names
//need difficulty
//description
//

$n = mysql_num_rows(mysql_query("SELECT * FROM `questions` WHERE 1"));
$n++;

$user = mysql_query("SELECT FROM `ids` WHERE ucid='$ucid'");
 if($row = mysql_fetch_array($user))
 {
  $user_id = $row["id"];
 }

$question = mysql_query("INSERT INTO `questions` (id, user_id, category,
function_name, function_type, difficulty, description, solution, template)
VALUES ('$n', '$user_id', '$conType', '$methodName', '$ftype', '$diff', '$desc',
'$methodOutput', '$methodInput')");

$arg = mysql_query("INSERT INTO `args` (id, q_id, type, name) VALUES ('$n',
'$n', '$atype', '$aname')");

$res = ["status" => 200, "response" => "question submitted"];
$display = ["description" = $desc];

echo json_encode(["db" => $res]);
echo json_encode(["db" => $display]);



?>
