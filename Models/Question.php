<?php

# Maurice Achtenhagen // Khurshid Sohail

class Question {

	const DIFFICULTY_EASY = 0;
	const DIFFICULTY_MEDIUM = 1;
	const DIFFICULTY_DIFFICULT = 2;

	const CATEGORY_CONDITIONAL = 0;
	const CATEGORY_CONTROL_FLOW = 1;
	const CATEGORY_RECURSION = 2;
	const CATEGORY_OTHER = 3;

	const RETURN_INT = 0;
	const RETURN_FLOAT = 1;
	const RETURN_DOUBLE = 2;
	const RETURN_STRING = 3;
	const RETURN_BOOL = 4;

	public static function getQuestionsForTest($test_id) {
		global $mysqli;
		$out = [];
		$sql = "SELECT
		q.id, q.user_id, q.category, q.function_name, q.function_type,
		q.difficulty, q.description FROM tests
		JOIN test_questions AS tq ON tq.test_id = tests.id
		JOIN questions AS q ON q.id = tq.question_id
		WHERE tests.id = $test_id";
		$result = $mysqli->query($sql);
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$out[(int) $row['id']] = [
				'id'            => (int) $row['id'],
				'user_id'       => (int) $row['user_id'],
				'category'      => (int) $row['category'],
				'function_name' => $row['function_name'],
				'function_type' => $row['function_type'],
				'description'   => $row['description'],
				'difficulty'    => $row['difficulty'],
				'arguments'     => [],
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

	public static function filter($difficulty, $ftype) {
		global $mysqli;

		$sql = "SELECT id, category, function_name, function_type, difficulty FROM questions
		WHERE  difficulty = $difficulty and function_type = $ftype";
		$result = $mysqli->query($sql);
		$out = [];
		while ($row = $result->fetch_array(MYSQLI_ASSOC)){
			$out[(int) $row['id']] = [
				'id' 			=> (int) $row['id'],
			    'category'      => (int) $row['category'],
				'function_name'	=> $row['function_name'],
				'function_type' => $row['function_type'],
				'difficulty'	=> $row['difficulty'],

			];
		}
		return $out;
	}

	public static function listAllQuestions() {
		global $mysqli;

		$sql = "SELECT id, category, function_name, function_type, difficulty FROM questions";
		$result = $mysqli->query($sql);
		$out = [];
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$out[(int) $row['id']] = [
				'id'            => (int) $row['id'],
				'category'      => (int) $row['category'],
				'function_name' => $row['function_name'],
				'function_type' => $row['function_type'],
				'difficulty'    => $row['difficulty'],
			];
		}
		return $out;
	}

	public static function getQuestionSolution($q_id) {
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
				'type' => self::get_str_from_type((int)$row['type']),
				'name' => $row['name'],
			];
		}
		return $out;
	}

	public static function get_str_from_type($int) {
		switch ($int) {
			case 0: return "int";
			case 1: return "float";
			case 2: return "double";
			case 3: return "string";
			case 4: return "bool";
			default: return "int";
		}
	}
}
