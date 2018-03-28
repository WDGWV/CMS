<?php
/**/use PHPUnit\Framework\TestCase;

/**/

final class test extends TestCase {
	public function setUp() {
		echo sprintf("%sTested '%s'.%s", PHP_EOL, $this->getName(), PHP_EOL);
	}

	public function testWillPass() {
		$this->assertEquals('a', 'a');
	}
}

?>