<?php

class Test
{

	public static function getAllTests()
	{
		global $mysqli;

		$sql = 'SELECT id, user_id, `name`, created FROM tests';
		$result = $mysqli->query($sql);
		$out = [];
		while ($row = $result->fetch_array(MYSQLI_ASSOC))
		{
			$out[] = [
				'id'      => (int) $row['id'],
				'user_id' => (int) $row['user_id'],				
				'name'    => $row['name'],
				'created' => (int) $row['created']
			];
		}
		return $out;
	}

	public static function getTestsForUser($user_id)
	{
		global $mysqli;
		
		$out = [];
		$sql = 'SELECT id, user_id, `name`, created FROM tests WHERE user_id = ' . $user_id;
		$result = $mysqli->query($sql);
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$out[] = [
				'id'      => (int) $row['id'],
				'user_id' => (int) $row['user_id'],				
				'name'    => $row['name'],
				'created' => (int) $row['created']
			];
		}
		
		return $out;
	}

	public static function getTestById($test_id)
	{
		global $mysqli;

		$sql = 'SELECT user_id, `name`, created FROM tests WHERE id = ?';
		$stmt = null;
		if (!$stmt = $mysqli->prepare($sql)) { return null; }
		$stmt->bind_param('i', $test_id);
		$stmt->execute();
		$stmt->bind_result($user_id, $name, $created);
		$stmt->fetch();
		$stmt->close();

		if (empty($user_id)) { return null; }

		return [
			'id'      => $test_id,
			'user_id' => (int) $user_id,
			'name'    => $name,
			'created' => $created,
		];
	}

	public static function addQuestionToTest($test_id, $question_id)
	{
		global $mysqli;

		$sql = 'INSERT INTO test_questions (test_id, question_id) VALUES (?, ?)';
		$stmt = null;
		if (!$stmt = $mysqli->prepare($sql)) { return null; }
		$stmt->bind_param('ii', $test_id, $question_id);
		$stmt->execute();
		$stmt->close();
	}

	public static function removeQuestionFromTest($test_id, $question_id)
	{
		global $mysqli;

		$sql = 'DELETE FROM test_questions WHERE test_id = ? AND question_id = ?';
		$stmt = null;
		if (!$stmt = $mysqli->prepare($sql)) { return null; }
		$stmt->bind_param('ii', $test_id, $question_id);
		$stmt->execute();
		$stmt->close();
	}

	public static function releaseTest($test_id, $user_id)
	{
		global $mysqli;

		$mysqli->query('START TRANSACTION');

		$sql = 'SELECT COUNT(id) FROM released_tests WHERE test_id = ? AND user_id = ?';
		$stmt = null;
		if (!$stmt = $mysqli->prepare($sql)) { return null; }
		$stmt->bind_param('ii', $test_id, $user_id);
		$stmt->execute();
		$stmt->bind_result($count);
		$stmt->fetch();
		$stmt->close();
		if ($count > 0) {
			$mysqli->query('ROLLBACK');
			return false;
		}

		$sql = 'INSERT INTO released_tests (test_id, user_id) VALUES (?, ?)';
		$stmt = null;
		if (!$stmt = $mysqli->prepare($sql)) {
			$mysqli->query('ROLLBACK');
			return null;
		}
		$stmt->bind_param('ii', $test_id, $user_id);
		$stmt->execute();
		$stmt->close();

		$mysqli->query('COMMIT');
	}

	public static function createTest($name)
	{
		global $mysqli;

		$sql = 'INSERT INTO tests (user_id, name, created) VALUES (?, ?, ?)';
		$stmt = null;
		if (!$stmt = $mysqli->prepare($sql)) { return null; }
		$time = time();
		$user = $_SESSION['user_id'];
		$stmt->bind_param('isi', $user, $name, $time);
		$stmt->execute();
		$stmt->close();

		return $mysqli->insert_id;
	}

	public static function getResultsForUser($user)
	{
		global $mysqli;

		$sql = '
			SELECT
				st.test_id, t.name, st.test_grade, st.completed
			FROM student_tests AS st
			JOIN released_tests AS rt ON rt.test_id = st.test_id
			JOIN tests AS t ON t.id = rt.test_id
			WHERE st.user_id = ?
		';

		$stmt = null;
		if (!$stmt = $mysqli->prepare($sql)) { return null; }
		$stmt->bind_param('i', $user);
		$stmt->execute();
		$result = $stmt->get_result();
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
	
	# Insert question score
	public static function insertQuestionScore($user_id, $test_id, $question_id, $score, $remark = "") {
		global $mysqli;
		$sql = "INSERT INTO test_results (user_id, test_id, question_id, remark, score) VALUES (?, ?, ?, ?, ?)";
		$stmt = null;
		if (!$stmt = $mysqli->prepare($sql)) {
			return;
		}
		$stmt->bind_param('iiisi', $user_id, $test_id, $question_id, $remark, $score);
		$stmt->execute();
		$stmt->close();
	}
	
	# Insert test score
	public static function insertTestScore($user_id, $test_id, $score) {
		global $mysqli;
		$sql = "INSERT INTO student_tests (user_id, test_id, test_grade) VALUES (?, ?, ?)";
		$stmt = null;
		if (!$stmt = $mysqli->prepare($sql)) {
			return;
		}
		$stmt->bind_param('iii', $user_id, $test_id, $score);
		$stmt->execute();
		$stmt->close();		
	}

}
