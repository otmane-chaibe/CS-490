<?php

# Maurice Achtenhagen

/*
	Grading Rubric
	---------------------------------------
	Correct function modifier(s)  -> 10 pts
	Correct function type         -> 10 pts
	Correct function name         -> 10 pts
	Correct function parameters   -> 10 pts
	Does the code compile?        -> 10 pts
	Does the code pass unit tests -> 50 pts
	---------------------------------------
	Total                           100 pts
*/

define("INVALID_SIGNATURE", "This is not a valid method signature.");
define("INVALID_MODIFIER", "This is not a valid function modifier.");
define("INVALID_BODY", "This is not a valid function body.");
define("INVALID_NAME", "This is not a valid function name.");

class FunctionCheck {

	private $source_class = "/tmp/MainDriver.class";
	private $source_file  = "/tmp/MainDriver.java";
	private $source_name  = "MainDriver";
	private $student_solution, $function_name, $function_body;
	private $modifiers, $function_params, $unit_tests;
	private $return_type;
	private $solution;
	public $has_correct_function_modifier = false;
	public $has_correct_function_type = false;
	public $has_correct_function_name = false;
	public $has_correct_function_params = false;
	public $does_compile = false;
	public $passes_unit_tests = false;
	public $unit_test_results = [];
	public $score = 0;

	function __construct($student_solution, $question_solution, $unit_tests) {
		$this->student_solution = trim($student_solution);
		$this->solution = $question_solution;
		$this->unit_tests = $unit_tests;
	}

	# (1) Parse function
	# Note: function must always return a value (may not be of type void).
	public function parse() {
		if (empty($this->student_solution)) {
			return INVALID_SIGNATURE;
		}

		$brace_pos = strpos($this->student_solution, "{");
		if (!$brace_pos) {
			return INVALID_SIGNATURE;
		}

		# Match method signature
		$signature = substr($this->student_solution, 0, $brace_pos);
		preg_match('/(public|private)(?: )*(static)?(?: )+(void|int|float|double|string|boolean)(?: )*([a-z](?:\w|\d)*) ?\((.*?)\)/i', $signature, $matches);
		if (empty($matches)) {
			return INVALID_SIGNATURE;
		}

		# Extract function modifiers
		if (empty($matches[1])) {
			return INVALID_MODIFIER;
		}
		$this->modifiers[] = $matches[1];
		if (empty($matches[2])) {
			$this->modifiers[] = $matches[2];
		}

		# Extract function type
		$this->return_type = $matches[3];

		# Extract function name
		if (self::is_valid_name($matches[count($matches)-2]) === false) {
			return INVALID_NAME;
		}
		$this->function_name = $matches[count($matches)-2];

		# Extract function parameters
		$this->function_params = self::parse_params($matches[count($matches)-1]);

		# Extract function body
		$first_brace = strpos($this->student_solution, "{") + 1;
		$last_brace = strrpos($this->student_solution, "}");
		if ($first_brace === false || $last_brace === false) {
			return INVALID_BODY;
		}
		$body = trim(substr($this->student_solution, $first_brace, $last_brace - $first_brace));
		if ($body === false) {
			return INVALID_BODY;
		}
		$this->function_body = $body;
		return true;
	}

	# (2) Compile Java code
	public function compile() {
		if (file_exists($this->source_file)) {
			unlink($this->source_file);
		}
		if (file_exists($this->source_class)) {
			unlink($this->source_class);
		}
		$unit_test_str = "\n\t\t";
		$tests = self::generateUnitTests();
		foreach ($tests as $index => $test) {
			$unit_test_str .= $test;
			if ($index !== count($tests)-1) { $unit_test_str .= "\n\t\t"; }
		}
		$code  = "class MainDriver {\n\tpublic static void main(String[] args) {\n\t\t";
		$code .= "MainDriver main = new MainDriver();" . $unit_test_str . "\n\t}\n\n\t" . $this->student_solution . "\n}";
		$code = trim($code);
		if (!file_put_contents($this->source_file, $code)) {
			throw new FileWriteException("PHP failed to write the file.");
		}
		# Note: (javac -verbose) for details
		$cmd = "javac " . $this->source_file;
		exec($cmd);
	}

	# (3) Run unit tests against code
	public function run_tests() {
		chdir("/tmp");
		$cmd = "java " . $this->source_name;
		exec($cmd, $test_results);
		self::verify_tests($test_results);
	}

	# (4) Check code output against expected output
	# Todo: $result should be type casted to the return type of the function
	private function verify_tests($results) {
		$test_pass = true;
		foreach ($this->unit_tests as $idx => $test) {
			$this->unit_test_results[] = [
				'output'   => $results[$idx],
				'expected' => $test["output"],
			];
			if (in_array($test["output"], $results) === false) {
				$test_pass = false;
			}
		}
		if ($test_pass) {
			$this->passes_unit_tests = true;
			$this->score += 50;
		}
		self::score();
	}

	# (5) Assign score to solution
	public function score() {
		if (strcasecmp($this->solution["modifiers"][0], $this->modifiers[0]) == 0) {
			$this->has_correct_function_modifier = true;
			$this->score += 10;
		}

		$param_names = $s_param_names = [];
		$param_types = $s_param_types = [];

		foreach($this->function_params as $param) {
			$param_names[] = strtolower($param["name"]);
		}

		foreach ($this->solution["params"] as $param) {
			$s_param_names[] = strtolower($param["name"]);
		}

		foreach($this->function_params as $param) {
			$param_types[] = strtolower($param["type"]);
		}

		foreach ($this->solution["params"] as $param) {
			$s_param_types[] = strtolower($param["type"]);
		}

		if ($param_names == $s_param_names && $param_types == $s_param_types) {
			$this->has_correct_function_params = true;
			$this->score += 10;
		}

		if (file_exists($this->source_class)) {
			$this->does_compile = true;
			$this->score += 10;
		}

		if (strcasecmp($this->return_type, $this->solution["type"]) == 0)   {
			$this->has_correct_function_type = true;
			$this->score += 10;
		}

		if (strcasecmp($this->function_name, $this->solution["name"]) == 0) {
			$this->has_correct_function_name = true;
			$this->score += 10;
		}
	}

	# Generate the unit test(s) to be injected
	private function generateUnitTests() {
		$tests = [];
		$inputs = [];
		foreach ($this->unit_tests as $test) {
			foreach ($test["inputs"] as $input) {
				$inputs[] = ($input["type"] === 3 ? "\"" . $input["value"] . "\"" : (int) $input["value"]);
			}
			$params = implode(",", $inputs);
			$tests[] = "System.out.println(main." . $this->function_name . "(" . $params . "));";
		}
		return $tests;
	}

	# Match all parameters in between parenthesis
	private static function parse_params($param_str) {
		$params = [];
		foreach (explode(",", $param_str) as $p) {
			$param = explode(" ", trim($p));
			$type = $param[0];
			$name = $param[1];
			$params[] = [
				"type"     => $type,
				"type_val" => self::get_type_from(strtolower($type)),
				"name"     => $name,
			];
		}
		return $params;
	}

	# Match the function modifier (public|private|static|void)
	private function is_modifier($mod) {
		if (empty($mod)) { return false; }
		switch ($mod) {
			case "public":  return true;
			case "private": return true;
			case "static":  return true;
			case "void":    return true;
			default:        return false;
		}
	}

	# Match the function return type.
	private static function is_type($type) {
		switch ($type) {
			case "int":    return true;
			case "float":  return true;
			case "double": return true;
			case "string": return true;
			case "bool":   return true;
			default:       return false;
		}
	}

	# Match the function to a valid name
	private static function is_valid_name($name) {
		if (!ctype_alnum($name)) { return false; }
		if (is_numeric(substr($name, 0, 1))) { return false; }
		return true;
	}

	# Get the argument type from string
	private static function get_type_from($str) {
		if (empty($str)) { return 0; }
		switch ($str) {
			case "int":    return 0;
			case "float":  return 1;
			case "double": return 2;
			case "string": return 3;
			case "bool":   return 4;
			default:       return 0;
		}
	}

	# String representation of class
	public function __toString() {
		return $this->student_solution;
	}
}
