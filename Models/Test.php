<?php

class Test
{

	public static function getTestsForUser($user_id)
	{
		global $mysqli;

		$sql = 'SELECT id, user_id, `name`, created FROM tests WHERE user_id = ?';
		$stmt = null;
		if (!$stmt = $mysqli->prepare($sql)) { return null; }
		$stmt->bind_param('i', $user_id);
		$stmt->execute();
		$result = $stmt->get_result();
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
		$stmt->close();
		return $out;
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
