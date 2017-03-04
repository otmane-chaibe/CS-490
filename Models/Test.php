<?php

class Test
{

	public static function getTestsForUser($user_id)
	{
		global $mysqli;

		$sql = 'SELECT id, `name`, created FROM tests WHERE user_id = ?';
		$stmt = null;
		if (!$stmt = $mysqli->prepare($sql)) { return null; }
		$stmt->bind_param('i', $user_id);
		$stmt->execute();
		$stmt->bind_result($id, $name, $created);
		$stmt->fetch();
		$stmt->close();

		if (empty($id)) { return null; }

		$out = [
			'id'      => (int) $id,
			'user_id' => $user_id,
			'name'    => $name,
			'created' => $created,
		];
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

}
