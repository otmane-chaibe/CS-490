<?php

# Maurice Achtenhagen

require_once('../mysql.php');
require_once('header.php');

$test_id = (int) $_GET['id'];
if (empty($test_id)) {
        redirect("student.php");
}

$test = Test::getTestById($test_id);
$questions = Question::getQuestionsForTest($test_id);

function get_args($args) {
        $str_out = array_map(function($value) { return type_to_string($value); }, $args);
        return implode(', ', $str_out);
}
