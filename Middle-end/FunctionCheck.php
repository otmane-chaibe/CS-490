<?php

declare(strict_types=1);
	
final class FunctionCheck {
	
	private $function_body;
	
	private function __construct($function_body) {
		$this->$function_body = $function_body;
	}
	
	public static function fromString(string $function_body) {
		return new self($function_body);
	}
	
	# Check the entire signature of the function.
	public static function signature() {
		throw new InvalidArgumentException("This is not a valid Java method signature.");
	}
	
	# Get the number of arguments and their type.
	public static function args() {
		
	}
}