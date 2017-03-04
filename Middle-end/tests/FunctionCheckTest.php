<?php

use PHPUnit\Framework\TestCase;

final class FunctionCheckTest extends TestCase {
	
	public function testCanBeCreatedFromBody(): void {
		$this->assertInstanceOf(
			FunctionCheck::class,
			FunctionCheck::fromString("public static int sum (int a, int b)")
		);
	}

	public function testCannotBeCreatedFromInvalidBody(): void {
		$this->expectException(InvalidArgumentException::class);
		FunctionCheck::signature('invalid');
	}
}