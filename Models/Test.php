<?php

# Maurice Achtenhagen // Khurshid Sohail

class Test {

	public static function getAllTests() {
		global $mysqli;
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

	public static function getTestsForUser($user_id) {
		global $mysqli;
		$out = [];
		$sql = "SELECT id, user_id, `name`, created FROM tests WHERE user_id = $user_id ORDER BY id DESC";
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
		$sql = "SELECT user_id, `name`, created FROM tests WHERE id = $test_id LIMIT 1";
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

	public static function releaseTest($test_id, $user_id) {
		global $mysqli;
		$sql = "SELECT COUNT(id) FROM released_tests WHERE test_id = $test_id AND user_id = $user_id";
		$mysqli->query($sql);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$count = $row['COUNT(id)'];
		if ($count == 0) {
			$sql = "INSERT INTO released_tests (test_id, user_id) VALUES ($test_id, $user_id)";
			$mysqli->query($sql);
		}
	}

	public static function createTest($name, $user_id) {
		global $mysqli;
		$time = time();
		$sql = "INSERT INTO tests (user_id, name, created) VALUES ($user_id, '$name', $time)";
		$mysqli->query($sql);
		return [
			"test_id" => $mysqli->insert_id,
			"name"    => $name,
		];
	}

	public static function getResultsForUser($user) {
		global $mysqli;
		$sql = "
			SELECT st.test_id, t.name, st.test_grade, st.completed
			FROM student_tests AS st
			JOIN released_tests AS rt ON rt.test_id = st.test_id
			JOIN tests AS t ON t.id = rt.test_id
			WHERE st.user_id = $user
		";
		$mysqli->query($sql);
		$out = [];
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$out[] = [
				'test_id'    => (int) $row['test_id'],
				'test_name'  => $row['name'],
				'test_grade' => (int) $row['test_grade'],
				'completed'  => ($row['completed'] == 1),
			];
		}
		return $out;
	}

	public static function insertQuestionScore($user_id, $test_id,
	$question_id, $score, $solution, $remark = "") {
		global $mysqli;
		$sql = "INSERT INTO test_results (user_id, test_id,
		question_id, solution, remark, score) VALUES ($user_id,
		$test_id, $question_id, '$solution', '$remark', $score)";
		$mysqli->query($sql);
	}

	public static function insertTestScore($user_id, $test_id, $score) {
		global $mysqli;
		$sql = "INSERT INTO student_tests (user_id, test_id, test_grade) VALUES ($user_id, $test_id, $score)";
		$mysqli->query($sql);
	}
}
