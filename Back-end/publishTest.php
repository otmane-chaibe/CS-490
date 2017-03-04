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
$num = mysql_query("SELECT * FROM `tests` WHERE 1");
$num = mysql_insert_id();

$ins_q = mysql_query("INSERT INTO `test_questions` (q_id, test_id) VALUES
('$q_id', '$num')");

?>
