<?php

mysql_connect ('sql.njit.edu', 'ks492', 'SpqROrOBi');
mysql_select_db ('ks492');


if($_SERVER['REQUEST_METHOD'] != "POST")
{
 header($_SERVER['SERVER_PROTOCOL']. '405 Method Not Allowed');
   header('Allow: POST');
              die(json_encode(["error" => "Must Use POST"]));
	                          }

$test_id = mysql_query("SELECT * FROM `tests` WHERE 1");
$test_id = mysql_insert_id();
$q_id = $_POST['q-id'];
$remark = $_POST['remark'];
$score = $_POST['score'];

$update = mysql_query("INSERT INTO `test_results` (test_id, q_id, remark,
score) VALUES ('$test_id', '$q_id', '$remark', '$score')");


?>
