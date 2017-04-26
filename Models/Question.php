<?php

# Maurice Achtenhagen // Khurshid Sohail

class Question {

	const DIFFICULTY_EASY = 0;
	const DIFFICULTY_MEDIUM = 1;
	const DIFFICULTY_DIFFICULT = 2;
	const DIFFICULTY_ANY = 3;

	const CATEGORY_CONDITIONAL = 0;
	const CATEGORY_CONTROL_FLOW = 1;
	const CATEGORY_RECURSION = 2;
	const CATEGORY_OTHER = 3;
	const CATEGORY_ALL = 4;

	const RETURN_INT = 0;
	const RETURN_FLOAT = 1;
	const RETURN_DOUBLE = 2;
	const RETURN_STRING = 3;
	const RETURN_BOOL = 4;

	private static function formatQuestion($row) {
		return [
			'id'                => isset($row['id']) ? (int) $row['id'] : null,
			'user_id'           => isset($row['user_id']) ? (int) $row['user_id'] : null,
			'category'          => isset($row['category']) ? (int) $row['category'] : null,
			'function_name'     => isset($row['function_name']) ? $row['function_name'] : null,
			'function_type'     => isset($row['function_type']) ? $row['function_type'] : null,
			'function_type_str' => isset($row['function_type']) ? self::type_to_string((int) $row['function_type']) : null,
			'description'       => isset($row['description']) ? $row['description'] : null,
			'difficulty'        => isset($row['difficulty']) ? (int) $row['difficulty'] : null,
			'difficulty_str'    => isset($row['difficulty']) ? self::difficulty_to_string((int) $row['difficulty']) : null,
			'weight'            => isset($row['weight']) ? (double) $row['weight'] : null,
			'arguments'         => [],
		];
	}

	public static function getQuestionsForTest($test_id) {
		global $mysqli;
		$out = [];
		$sql = "SELECT tq.id, q.id AS question_id, q.user_id, q.category, q.function_name, q.function_type, q.difficulty,
				q.description, tq.weight FROM tests
				JOIN test_questions AS tq ON tq.test_id = tests.id
				JOIN questions AS q ON q.id = tq.question_id WHERE tests.id = $test_id";
		$result = $mysqli->query($sql);
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$out[(int) $row['question_id']] = [
				'id'                => (int) $row['id'],
				'question_id'       => (int) $row['question_id'],
				'user_id'           => (int) $row['user_id'],
				'category'          => (int) $row['category'],
				'function_name'     => $row['function_name'],
				'function_type'     => $row['function_type'],
				'function_type_str' => self::type_to_string((int) $row['function_type']),
				'description'       => $row['description'],
				'difficulty'        => (int) $row['difficulty'],
				'weight'            => (double) $row['weight'],
			];
		}
		if (!empty($out)) {
			$sql = "
				SELECT question_id, type, `name` FROM args
				WHERE question_id IN (" . implode(',', array_keys($out)) . ")
			";
			$result = $mysqli->query($sql);
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$out[(int) $row['question_id']]['arguments'][] = [
					'type' => (int) $row['type'],
					'name' => $row['name'],
				];
			}
		}
		return $out;
	}

	public static function createQuestion($user_id, $fname, $category = 0, $difficulty = 0, $type = 0, $description = "", $args = []) {
		global $mysqli;
		$question_id = 0;
		$sql = "
			INSERT INTO questions (user_id, category, function_name, function_type, difficulty, description)
			VALUES ($user_id, '$category', '$fname', '$type', '$difficulty', '$description')
		";
		$mysqli->query($sql);
		$question_id = $mysqli->insert_id;
		if ($question_id > 0 && count($args) > 0) {
			foreach ($args as $arg) {
				$type = $arg['type'];
				$name = $arg['name'];
				$sql = "INSERT INTO args (question_id, type, name) VALUES ($question_id, '$type', '$name')";
				$mysqli->query($sql);
			}
		}
		return $question_id;
	}

	public static function filter($category, $difficulty) {
		global $mysqli;
		$sql = " SELECT id, category, function_name, function_type, difficulty, description FROM questions WHERE category";
		if ($category !== 4) { $sql .= " = '$category'"; }
		$sql .= " AND ";
		if ($difficulty === 3) {
			$sql .= "difficulty";
		} else {
			$sql .= "difficulty = '$difficulty'";
		}
		$sql .= " ORDER BY difficulty";
		$result = $mysqli->query($sql);
		$out = [];
		while ($row = $result->fetch_array(MYSQLI_ASSOC)){
			$out[(int) $row['id']] = self::formatQuestion($row);
		}
		if (!empty($out)) {
			$sql = "
				SELECT question_id, type, `name` FROM args
				WHERE question_id IN (" . implode(',', array_keys($out)) . ")
			";
			$result = $mysqli->query($sql);
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$out[(int) $row['question_id']]['arguments'][] = [
					'type' => type_to_string((int) $row['type']),
					'name' => $row['name'],
				];
			}
		}
		return $out;
	}

	public static function search($keyword) {
		global $mysqli;
		$sql = "
			SELECT id, category, function_name, function_type, difficulty, description
			FROM questions WHERE function_name like \"%" . $keyword . "%\" OR description like \"%" . $keyword . "%\"
		";
		$result = $mysqli->query($sql);
		$out = [];
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$out[(int) $row['id']] = self::formatQuestion($row);
		}
		if (!empty($out)) {
			$sql = "
				SELECT question_id, type, `name` FROM args
				WHERE question_id IN (" . implode(',', array_keys($out)) . ")
			";
			$result = $mysqli->query($sql);
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$out[(int) $row['question_id']]['arguments'][] = [
					'type' => type_to_string((int) $row['type']),
					'name' => $row['name'],
				];
			}
		}
		return $out;
	}

	public static function listAllQuestions() {
		global $mysqli;
		$sql = "SELECT id, category, function_name, function_type, difficulty, description FROM questions";
		$result = $mysqli->query($sql);
		$out = [];
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$out[(int) $row['id']] = self::formatQuestion($row);
		}
		if (!empty($out)) {
			$sql = "
				SELECT question_id, type, `name` FROM args
				WHERE question_id IN (" . implode(',', array_keys($out)) . ")
			";
			$result = $mysqli->query($sql);
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$out[(int) $row['question_id']]['arguments'][] = [
					'type' => (int) $row['type'],
					'name' => $row['name'],
				];
			}
		}
		return $out;
	}

	public static function getQuestion($q_id) {
		global $mysqli;
		$sql = "SELECT function_type,function_name FROM questions WHERE id = $q_id LIMIT 1";
		$result = $mysqli->query($sql);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$out = [
			'modifiers' => ["public", "static"],
			'name'      => $row['function_name'],
			'type'      => self::get_str_from_type($row['function_type']),
			'params'    => self::getQuestionArgs($q_id)
		];
		return $out;
	}

	private static function getQuestionArgs($question_id) {
		global $mysqli;
		$out = [];
		$sql = "SELECT question_id, type, `name` FROM args WHERE question_id  = $question_id";
		$result = $mysqli->query($sql);
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$out[] = [
				'type' => self::get_str_from_type((int) $row['type']),
				'name' => $row['name'],
			];
		}
		return $out;
	}

	public static function updateQuestionWeight($test_question_id, $weight) {
		global $mysqli;
		$sql = "
			UPDATE `ks492`.`test_questions`  SET `weight` = $weight
			WHERE `test_questions`.`question_id` = $test_question_id
		";
		$mysqli->query($sql);
	}

	private static function get_str_from_type($type) {
		switch ($type) {
			case 0: return "int";
			case 1: return "float";
			case 2: return "double";
			case 3: return "string";
			case 4: return "bool";
			default: return "int";
		}
	}

	private static function difficulty_to_string($difficulty) {
		switch ($difficulty) {
			case 0: return "easy";
			case 1: return "medium";
			case 2: return "difficult";
			default: return "easy";
		}
	}

	private static function type_to_string($type) {
		switch ($type) {
			case 0: return "Int";
			case 1: return "Float";
			case 2: return "Double";
			case 3; return "String";
			case 4: return "Boolean";
			default: return "Int";
		}
	}
}
