<?php

declare(strict_types=1);
	
class FunctionCheck {
	
	private $function, $function_name, $function_body;
	private $modifiers, $function_params;
	private $return_type;
	
	function __construct($function) {
		$this->function = trim($function);
	}
	
	public function parse() {
		if (empty($this->function)) {
			throw new InvalidArgumentException("This is not a valid Java method signature.");
		}
		$brace_pos = strpos($this->function, "{");
		if (!$brace_pos) {
			throw new InvalidArgumentException("This is not a valid Java method signature.");
		}
		$signature = substr($this->function, 0, $brace_pos);
		preg_match('/(public|private)(?: )*(static)?(?: )+(void|int|float|double|string boolean)(?: )*([a-z](?:\w|\d)*) ?\((.*?)\)/i', $signature, $matches);
		# print_r($matches);
		
		if (empty($matches)) {
			throw new InvalidArgumentException("This is not a valid Java method signature.");
		}
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
