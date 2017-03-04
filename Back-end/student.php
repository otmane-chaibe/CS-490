<?php

mysql_connect ('sql.njit.edu', 'ks492', 'SpqROrOBi');
mysql_select_db ('ks492');


if($_SERVER['REQUEST_METHOD'] != "POST")
{
 header($_SERVER['SERVER_PROTOCOL']. '405 Method Not Allowed');
   header('Allow: POST');
              die(json_encode(["error" => "Must Use POST"]));
	                    }
			  
$user_id = $_POST['user_id'];
$num = mysql_query("SELECT * FROM `tests` WHERE 1");
$num = mysql_insert_id();
$grade = $_POST['grade'];

$ins = mysql_query("INSERT INTO `student_tests` (user_id, test_id,
test_grade) VALUES ('$user_id', '$num', '$grade')");


?>
