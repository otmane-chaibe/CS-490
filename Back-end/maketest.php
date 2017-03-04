<?php


mysql_connect ('sql.njit.edu', 'ks492', 'SpqROrOBi');
mysql_select_db ('ks492');


if($_SERVER['REQUEST_METHOD'] != "POST")
{
 header($_SERVER['SERVER_PROTOCOL']. '405 Method Not Allowed');
  header('Allow: POST');
           die(json_encode(["error" => "Must Use POST"]));
	            }

$q_id = $_POST['q_id'];
$user_id = $_POST['user_id '];
$created = $_POST['created'];

$getName = mysql_query("SELECT * FROM `ids` WHERE id ='$user_id'");
if($x = mysql_fetch_array($getName))
 {
 do{
   $name = $x['name'];
   }
   while($x=mysql_fetch_array($getName));
 }

$makeTest = mysql_query("INSERT INTO `tests` (user_id, name, created) VALUES
('$user_id', '$name', '$created')");

$num = mysql_insert_id();

//$ins_q = mysql_query("INSERT INTO `test_questions` (q_id, test_id) VALUES
//('$q_id', '$num')");



?>
