<?php

//$servername = "sql.njit.edu";
//$username = "ks492";
//$password = "SpqROrOBi";
//$dbname = "ks492";
mysql_connect ('sql.njit.edu', 'ks492', 'SpqROrOBi');
mysql_select_db ('ks492');

//$conn = new mysqli($servername, $username, $password, $dbname);

//if ($conn->connect_error)
//{
// die("Connection Failed: " . $conn->connect_error);
//}


if($_SERVER['REQUEST_METHOD'] != "POST")
{
 header($_SERVER['SERVER_PROTOCOL']. '405 Method Not Allowed');
 header('Allow: POST');
	 die(json_encode(["error" => "Must Use POST"]));
	 }

$ucid = $_POST['ucid'];

$methodName = $_POST['methodName'];
$argNum = $_POST['argNum'];
$qType = $_POST['qType'];
$qDiff = $_POST['dDiff']
$methodInput = $_POST['methodInput'];
$methodOutput = $_POST['methodOutput'];
//need ftype
//need arg types
//arg names
//description
//

//$n = mysql_num_rows(mysql_query("SELECT * FROM `questions` WHERE 1"));
//$n++;

$user = mysql_query("SELECT FROM `ids` WHERE ucid='$ucid'");
 if($row = mysql_fetch_array($user))
 {
  $user_id = $row["id"];
  //$role
 }

$question = mysql_query("INSERT INTO `questions` (user_id, category,
function_name, function_type, difficulty, description, solution, template)
VALUES ('$user_id', '$qType', '$methodName', '$ftype', '$qDiff', '$desc',
'$methodOutput', '$methodInput')");

$q_id = mysql_insert_id();

$arg = mysql_query("INSERT INTO `args` (q_id, type, name) VALUES ('$q_id', '$atype', '$aname')");

$unit = mysql_query("INSERT INTO `unitTest` (q_id, unit_test) VALUES ('$q_id',
$methodOutput)")

$res = ["status" => 200, "response" => "question submitted"];
$display = ["description" = $desc];

echo $res;
echo json_encode(["db" => $display]);



?>
