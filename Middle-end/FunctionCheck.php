<?php

# Maurice Achtenhagen

class FunctionCheck {

	private $source_class = "MainDriver.class";
	private $source_file  = "MainDriver.java";
	private $source_name  = "MainDriver";
	private $function, $function_name, $function_body;
	private $modifiers, $function_params, $unit_tests;
	private $return_type;
	private $solution;
	public $score = 0;

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

	function __construct($function, $solution, $unit_tests) {
		$this->function = trim($function);
		$this->solution = $solution;
		$this->unit_tests = $unit_tests;
	}

	# (1) Parse function
	# Note: function may not be of type void
	public function parse() {
		if (empty($this->function)) {
			throw new InvalidArgumentException("This is not a valid Java method signature.");
		}
		$brace_pos = strpos($this->function, "{");
		if (!$brace_pos) {
			throw new InvalidArgumentException("This is not a valid Java method signature.");
		}
		$signature = substr($this->function, 0, $brace_pos);
		preg_match('/(public|private)(?: )*(static)?(?: )+(void|int|float|double|string|boolean)(?: )*([a-z](?:\w|\d)*) ?\((.*?)\)/i', $signature, $matches);

		if (empty($matches)) {
			throw new InvalidArgumentException("This is not a valid Java method signature.");
		}

		# Extract function modifiers
		$this->modifiers[] = $matches[1];
		if (!empty($matches[2])) { $this->modifiers[] = $matches[2]; }

		# Extract function type
		$this->return_type = $matches[3];

		# Extract function name
		$this->function_name = $matches[count($matches)-2];

		# Extract function parameters
		$this->function_params = self::parse_params($matches[count($matches)-1]);

		# Extract function body
		$first_brace = strpos($this->function, "{") + 1;
		$last_brace = strrpos($this->function, "}");
		$this->function_body = trim(substr($this->function, $first_brace, $last_brace - $first_brace));
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
		$code .= "MainDriver main = new MainDriver();" . $unit_test_str . "\n\t}\n\n\t" . $this->function . "\n}";
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
		$cmd = "java " . $this->source_name;
		exec($cmd, $test_results);
		self::verify_tests($test_results);
	}

	# (4) Check code output against expected output
	# Todo: $result should be type casted to the return type of the function
	private function verify_tests($results) {
		$test_pass = true;
		foreach ($this->unit_tests as $test) {
			if (in_array($test["output"], $results) === false) { $test_pass = false; }
		}
		if ($test_pass) { $this->score += 50; }
		self::score();
	}

	# (5) Assign score to solution
	public function score() {
		if (strcasecmp($this->solution["modifiers"][0], $this->modifiers[0]) == 0) { $this->score += 10; }
		$param_names = $s_param_names = [];
		$param_types = $s_param_types = [];
		foreach($this->function_params as $param) { $param_names[] = strtolower($param["name"]); }
		foreach ($this->solution["params"] as $param) { $s_param_names[] = strtolower($param["name"]); }
		foreach($this->function_params as $param) { $param_types[] = strtolower($param["type"]); }
		foreach ($this->solution["params"] as $param) { $s_param_types[] = strtolower($param["type"]); }
		if ($param_names == $s_param_names && $param_types == $s_param_types) { $this->score += 10; }
		if (file_exists($this->source_class)) { $this->score += 10; }
		if (strcasecmp($this->return_type, $this->solution["type"]) == 0)   { $this->score += 10; }
		if (strcasecmp($this->function_name, $this->solution["name"]) == 0) { $this->score += 10; }
	}

	# Generate the unit test(s) to be injected
	private function generateUnitTests() {
		$tests = [];
		foreach ($this->unit_tests as $test) {
			$params = implode(",", $test["inputs"]);
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
			case "public": return true;
			case "private": return true;
			case "static": return true;
			case "void": return true;
			default: return false;
		}
	}

	# Match the function return type.
	private static function is_type($type) {
		switch ($type) {
			case "int": return true;
			case "float": return true;
			case "double": return true;
			case "string": return true;
			case "bool": return true;
			default: return false;
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
			case "int": return 0;
			case "float": return 1;
			case "double": return 2;
			case "string": return 3;
			case "bool": return 4;
			default: return 0;
		}
	}

	public function __toString() {
		return $this->function;
	}
}
