<?php

# Maurice Achtenhagen

require_once('../functions.php');
require_once('../Middle-end/FunctionCheck.php');

session_start();

header('Content-Type: application/json');

assertPost();

if (!isset($_POST['qid'])) {
	error("Missing Parameter: qid.");
}

if (!isset($_POST['test_id'])) {
	error("Missing Parameter: test_id");
}

if (!isset($_POST['solution'])) {
	error("Missing Parameter: solution.");
}

$final_score = 0;
$scores = [];

$student_solutions = [];
$questions = [];
$question_ids = [];
$unit_tests = [];

$test_id = (int) $_POST['test_id'];

foreach ($_POST['solution'] as $solution) {
	$student_solutions[] = $solution;
}

foreach ($_POST['qid'] as $q_id) {
	$question_ids[] = $q_id;
}

foreach ($question_ids as $q_id) {
	$unit_test = http(MIDDLE_END, "get_unit_tests_for_question", [
		"q_id" => $q_id
	]);
	if ($unit_test === false) {
		error("cURL request failed.");
	}
	$unit_tests[] = $unit_test;
}

foreach ($question_ids as $q_id) {
	$question = http(MIDDLE_END, "get_question", [
		"q_id" => $q_id
	]);
	if ($question === false) {
		error("cURL request failed.");
	}
	$questions[] = $question;
}

foreach ($student_solutions as $idx => $solution) {
	try {
		$f_check = new FunctionCheck($solution, $questions[$idx], $unit_tests[$idx]);
		$f_check->parse();
		$f_check->compile();
		$f_check->run_tests();
		$score_id = http(MIDDLE_END, "insert_question_score", [
			"user_id"  => $_SESSION['user_id'],
			"q_id"     => $question_ids[$idx],
			"test_id"  => $test_id,
			"solution" => $solution,
			"score"    => $f_check->score,
		]);
		if ($score_id === false) {
			error("cURL request failed.");
		}
		$scores[] = $f_check->score;
	} catch (InvalidArgumentException $ex) {
		die(json_encode($ex->getMessage()));
	} catch (BadModifierException $ex) {
		die(json_encode($ex->getMessage()));
	} catch (BadFunctionNameException $ex) {
		die(json_encode($ex->getMessage()));
	} catch (FileWriteException $ex) {
		die(json_encode($ex->getMessage()));
	} catch (Exception $ex) {
		die(json_encode($ex->getMessage()));
	}
}

foreach ($scores as $s) {
	$final_score += $s;
}

$score_id = http(MIDDLE_END, "insert_test_score", [
	"user_id" => $_SESSION['user_id'],
	"test_id" => $test_id,
	"score"   => $final_score / count($question_ids),
]);

if ($score_id === false) {
	error("cURL request failed.");
}

echo json_encode($score_id);
