<?php

# Maurice Achtenhagen // Khurshid Sohail

class Test {

	public static function getAllTests() {
		global $mysqli;
		$out = [];
		$sql = "SELECT id, user_id, `name`, created FROM tests";
		$result = $mysqli->query($sql);
		$out = [];
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$out[] = [
				'id'      => (int) $row['id'],
				'user_id' => (int) $row['user_id'],
				'name'    => $row['name'],
				'created' => (int) $row['created'],
			];
		}
		return $out;
	}

	public static function getPendingTests($user_id) {
		global $mysqli;
		$out = [];
		$sql = "
			SELECT student_tests.id, student_tests.user_id, student_tests.test_id, tests.name AS `name`, student_tests.score
			FROM student_tests JOIN tests ON student_tests.test_id = tests.id AND tests.user_id = $user_id WHERE student_tests.released = 0
		";
		$result = $mysqli->query($sql);
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$out[] = [
				'id'	  => (int) $row['id'],
				'user_id' => (int) $row['user_id'],
				'test_id' => (int) $row['test_id'],
				'name'    => $row['name'],
				'score'   => (int) $row['score'],
			];
		}
		return $out;
	}

	public static function getAvailableStudentTests($user_id) {
		global $mysqli;
		$out = [];
		$sql = "
			SELECT id, `name`, created FROM tests
			WHERE id NOT IN (SELECT test_id FROM student_tests WHERE user_id = $user_id)
		";
		$result = $mysqli->query($sql);
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$out[] = [
				'id'	  => (int) $row['id'],
				'name'    => $row['name'],
				'created' => $row['created'],
			];
		}

		if (empty($out)) {
		#	$out = self::getAllTests();
			return $out;
		}

		return $out;
	}

	# User here is professor
	public static function getTestsForUser($user_id) {
		global $mysqli;
		$out = [];
		$sql = "SELECT id,user_id,`name`,created FROM tests WHERE user_id = $user_id ORDER BY id DESC";
		$result = $mysqli->query($sql);
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$out[] = [
				'id'      => (int) $row['id'],
				'user_id' => (int) $row['user_id'],
				'name'    => $row['name'],
				'created' => (int) $row['created'],
			];
		}
		return $out;
	}

	public static function getTestById($test_id) {
		global $mysqli;
		$sql = "SELECT user_id,`name`,created FROM tests WHERE id = $test_id LIMIT 1";
		$result = $mysqli->query($sql);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		if (empty($row['user_id'])) { return []; }
		return [
			'id'      => $test_id,
			'user_id' => (int) $row['user_id'],
			'name'    => $row['name'],
			'created' => $row['created'],
		];
	}

	public static function getTestSolutions($test_id) {
		global $mysqli;
		$out = [];
		$sql = "
			SELECT DISTINCT ss.id, ss.question_id, ss.solution, ss.has_correct_function_modifier,
			ss.has_correct_function_type, ss.has_correct_function_name,
			ss.has_correct_function_params, ss.does_compile, ss.passes_unit_tests,
			ss.score, ss.remark, test_questions.weight
			FROM student_solutions AS ss
			JOIN test_questions ON test_questions.question_id = ss.question_id
			WHERE ss.test_id = $test_id
		";
		$result = $mysqli->query($sql);
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$out[(int) $row['question_id']] = [
				'id'                            => (int) $row['id'],
				'question_id'	                => (int) $row['question_id'],
				'solution'	                    => $row['solution'],
				'has_correct_function_modifier' => (int) $row['has_correct_function_modifier'],
				'has_correct_function_type'     => (int) $row['has_correct_function_type'],
				'has_correct_function_name'     => (int) $row['has_correct_function_name'],
				'has_correct_function_params'   => (int) $row['has_correct_function_params'],
				'does_compile'	                => (int) $row['does_compile'],
				'passes_unit_tests'             => (int) $row['passes_unit_tests'],
				'score'		                    => (int) $row['score'],
				'weight'		                => (double) $row['weight'],
				'remark'	                    => $row['remark'],
			];
		}
		return $out;
	}

	public static function addQuestionToTest($test_id, $question_id, $weight = 1.0) {
		global $mysqli;
		$sql = "INSERT INTO test_questions (test_id, question_id, weight) VALUES ($test_id, $question_id, $weight)";
		$mysqli->query($sql);
	}

	public static function removeQuestionFromTest($test_id, $question_id) {
		global $mysqli;
		$sql = "DELETE FROM test_questions WHERE test_id = $test_id AND question_id = $question_id";
		$mysqli->query($sql);
	}

	public static function createTest($name, $user_id) {
		global $mysqli;
		$time = time();
		$sql = "INSERT INTO tests (user_id, name, created) VALUES ($user_id, '$name', $time)";
		$mysqli->query($sql);
		return [
			'test_id' => $mysqli->insert_id,
			'name'    => $name,
		];
	}

	public static function getResultsForUser($user_id) {
		global $mysqli;
		$out = [];
		$sql = "
			SELECT users.name AS user_name,st.test_id, t.name AS test_name, st.score, st.released
			FROM student_tests AS st JOIN tests AS t ON t.id = st.test_id
			JOIN users ON st.user_id = users.id
			WHERE st.user_id = $user_id
		";
		$result = $mysqli->query($sql);
		$out = [];
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$out[] = [
				'user_name'  => $row['user_name'],
				'test_id'    => (int) $row['test_id'],
				'test_name'  => $row['test_name'],
				'score'      => (int) $row['score'],
				'released'   => ($row['released'] == 1),
			];
		}
		return $out;
	}

	public static function insertQuestionSolution($user_id, $test_id, $question_id, $solution, $results, $score) {
		global $mysqli;
		$has_correct_function_modifier = (int) $results->has_correct_function_modifier;
		$has_correct_function_type = (int) $results->has_correct_function_type;
		$has_correct_function_name = (int) $results->has_correct_function_name;
		$has_correct_function_params = (int) $results->has_correct_function_params;
		$does_compile = (int) $results->does_compile;
		$passes_unit_tests = (int) $results->passes_unit_tests;
		$sql = "
			INSERT INTO student_solutions (user_id, test_id, question_id, solution, has_correct_function_modifier, has_correct_function_type,
			has_correct_function_name, has_correct_function_params, does_compile, passes_unit_tests, score)
			VALUES ($user_id, $test_id, $question_id, '$solution', $has_correct_function_modifier, $has_correct_function_type, $has_correct_function_name,
			$has_correct_function_params, $does_compile, $passes_unit_tests, $score)
			";
		$mysqli->query($sql);
		return $mysqli->insert_id;
	}

	public static function updateQuestionScore($id, $test_id, $score) {
		global $mysqli;
		$sql = "
			UPDATE `student_solutions` SET `score` = $score
			WHERE `student_solutions`.`id` = $id
		";
		$mysqli->query($sql);
		$sql = "
		    UPDATE `student_tests`
		    SET score=(SELECT SUM(score)
			FROM `student_solutions`
			WHERE `test_id` = $test_id)
			WHERE `test_id`= $test_id
		";
		$mysqli->query($sql);
	}

	public static function getQuestionScore($test_id) {
		global $mysqli;
		$sql = "
			SELECT `id`, `score` FROM `student_solutions`
			WHERE `test_id` = $test_id
		";
		$result = $mysqli->query($sql);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		return [
			'id' 	=> (int) $row['id'],
			'score' => (int) $row['score'],
		];
	}

	public static function getQuestionWeight($test_id, $q_id) {
		global $mysqli;
		$sql = "SELECT weight FROM test_questions WHERE test_id = $test_id AND question_id = $q_id";
		$result = $mysqli->query($sql);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		return $row['weight'];
	}

	public static function updateExamScore($test_id) {
		global $mysqli;
		$sql = "
			UPDATE `student_tests`
			SET score=(SELECT SUM(score) FROM `student_solutions`
			WHERE `test_id` = $test_id) WHERE `test_id`= $test_id
		";
	}

	public static function updateTestScore($test_id, $score) {
		global $mysqli;
		$sql = "
			UPDATE `student_tests` SET `score` = $score
			WHERE `test_id` = $test_id
		";
		$mysqli->query($sql);
	}

	public static function insertRemark($id, $remark) {
		global $mysqli;
		$sql = "UPDATE `student_solutions` SET `remark` = '$remark' WHERE `id` = $id";
		$mysqli->query($sql);
	}

	public static function insertTestScore($user_id, $test_id, $score) {
		global $mysqli;
		$sql = "INSERT INTO student_tests (user_id, test_id, score, completed, released) VALUES ($user_id, $test_id, $score, 1, 0)";
		$mysqli->query($sql);
		return $mysqli->insert_id;
	}

	public static function releaseTest($test_id) {
		global $mysqli;
		$sql = "UPDATE student_tests SET released = 1 WHERE id = $test_id";
		$mysqli->query($sql);
	}

	public static function getReleasedTests() {
		global $mysqli;
		$out = [];
		$sql = "
			SELECT `id`, `user_id`, `test_id`, `score`
			FROM `student_tests`
			WHERE `released` = 1
		";
		$result = $mysqli->query($sql);
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$out[] = [
				'id'	  => (int) $row['id'],
				'user_id' => (int) $row['user_id'],
				'test_id' => (int) $row['test_id'],
				'score'   => (int) $row['score'],
			];
	    }
	    return $out;
	}
}
