<?php

declare(strict_types=1);
	
class FunctionCheck {
	
	const MAX_MODIFIERS = 2;
	
	private $function;
	private $modifiers, $return_type, $function_name, $function_parameters, $function_body;
	
	function __construct($function) {
		$this->function = trim($function);
	}
	
	# Check the entire signature of the function.
	public function signature() {
		if (empty($this->function)) {
			throw new InvalidArgumentException("This is not a valid Java method signature.");
		}
		
		$components = explode(" ", $this->function);
		foreach($components as $c) {
			
		}
		
		$modifier = $components[0];
		if (!self::match_modifier($modifier)) {
			throw new BadModifierException("Illegal modifier. Expected public, private or void.");
		}
		
		$return_type = $components[1];
		$method_name = $components[2];
		# preg_match('#\((.*?)\)#', $this->function_body, $param_str);
		# $param_str = $param_str[1];
		$params = [];
		foreach (explode(",", $param_str) as $p) {
			# var_dump(trim($p));
			$param = explode(" ", trim($p));
			$type = $param[0];
			$name = $param[1];
			$params[] = [
				"type"     => $type,
				"type_val" => self::get_type_from($type),
				"name"     => $name
			];
		}
//		$function = [
//			"modifier"    => $modifier,
//			"return_type" => $return_type,
//			"method_name" => $method_name,
//			"parameters"  => $params
//		];
	}
	
	public function body() {
		preg_match('#\({.*?}\)#', $this->function_body, $body);
	}
	
	# Match the function modifier (public|private|static|void)
	private function match_modifier($mod) {
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
	
	# Get the argument type from string
	private function get_type_from($str) {
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
		return $this->function_body;
	}
}
