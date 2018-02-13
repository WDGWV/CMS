<?php
namespace WDGWV\CMS;

class router {
	private $router = array();

	public function set_action($address, $action) {
		global $debugger;

		if (!isset($router[$address])) {
			if (function_exists($action)) {
				$router[$address] = $action;
			} else {
				if (isset($debugger)) {
					$debugger->error(sprintf("Function \"%s\" does not exists", $action))
				}
			}
		}
	}

	public function route() {
		foreach ($router as $addr => $dest) {
			$strLen = strlen($addr);
			if (substr($_SERVER['REQUEST_URI'], 0, $strLen) === $addr) {
				// $dest();
				call_user_func($dest);
			}
		}
	}
}

?>