<?php

declare(strict_types=1);
	
class FunctionCheck {
	
	private $source_class = "MainDriver.class";
	private $source_file  = "MainDriver.java";
	private $source_name  = "MainDriver";
	private $function, $function_name, $function_body;
	private $modifiers, $function_params, $unit_tests;
	private $return_type;
	
	function __construct($function, $unit_tests) {
		$this->function = trim($function);
		$this->unit_tests = $unit_tests;
	}
	
	# (1) Parse function
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
		# print_r($matches);
		
		if (empty($matches)) {
			throw new InvalidArgumentException("This is not a valid Java method signature.");
		}
	}
	
	# (2) Compile Java code
	public function compile() {
		
		if (file_exists($this->source_file)) {
			unlink($this->source_file);
		}
		
		if (file_exists($this->source_class)) {
			unlink($this->source_class);
		}
		
		$code  = "class MainDriver {\n\tpublic static void main(String[] args) {\n\t\t";
		$code .= "MainDriver main = new MainDriver();\n\t}\n\n\t" . $this->function . "\n}";
		$code = trim($code);
		
		if (!file_put_contents($this->source_file, $code)) {
			throw new FileWriteException("PHP failed to write the file.");
		}
		
		$cmd = "javac -verbose " . $this->source_file;
		exec($cmd);
	}
	
	# (3) Run unit tests against code
	public function run_tests() {
		$cmd = "java " . $this->source_name;
		exec($cmd, $test_results);
		var_dump($test_results);
	}
	
	# Match all parameters in between parenthesis.
	private static function parse_params($param_str) {
		$params = [];
		foreach (explode(",", $param_str) as $p) {
			$param = explode(" ", trim($p));
			$type = $param[0];
			$name = $param[1];
			$params[] = [
				"type"     => $type,
				"type_val" => self::get_type_from($type),
				"name"     => $name
			];
		}
		return $params;	
	}
	
	public function body() {
		preg_match('#\({.*?}\)#', $this->function_body, $body);
	}
	
	# Match the function modifier (public|private|static|void).
	private function is_modifier($mod) {
		if (empty($mod)) { return false; }
		switch ($mod) {
			case "public":
				return true;
			case "private":
				return true;
			case "static":
				return true;				
			case "void":
				return true;				
			default:
				return false;
		}
	}
	
	# Match the function return type.
	private static function is_type($type) {
		switch ($type) {
			case "int":
				return true;
			case "float":
				return true;
			case "double":
				return true;
			case "string":
				return true;
			case "bool":
				return true;											
			default:
				return false;
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
			case "int":
				return 0;
			case "float":
				return 1;
			case "double":
				return 2;
			case "string":
				return 3;
			case "bool":
				return 4;											
			default:
				return 0;
		}
	}
	
	# String representation of self
	public function __toString() {
		return $this->function;
	}
}
