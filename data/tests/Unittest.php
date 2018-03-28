<?php
/**/use PHPUnit\Framework\TestCase;

/**/

final class test extends TestCase {
	public function setUp() {
		echo sprintf("Testing '%s'", $this->getName());
	}

	public function testWillPass() {
		$this->assertEquals('a', 'a');
	}
}

?>