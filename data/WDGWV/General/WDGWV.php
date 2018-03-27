<?php
namespace WDGWV\General;

class WDGWV {
	public $version = '0.75';
	// DEBUG PARAMETER
	static private $release = 'debug';
	public $debug = false;

	public function __construct() {
		$this->debug = ('debug' == \WDGWV\General\WDGWV::$release) ? true : false;
	}

	private function debug() {
		return ('debug' == static::$release) ? true : false;
	}
}
?>