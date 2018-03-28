<?php
/**/use PHPUnit\Framework\TestCase;

/**/

final class test extends TestCase {
	public function setUp() {
		echo sprintf("Testing '%s'.%s", $this->getName(), PHP_EOL);
	}

	public function testWillPass() {
		$this->assertEquals('a', 'a');
	}
}

?>