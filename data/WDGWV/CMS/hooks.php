<?php
namespace WDGWV\CMS;

class hooks extends \WDGWV\CMS\baseProtected {
	private $hookDatabase = array();

	/**
	 * Call the database
	 * @since Version 1.0
	 */
	public static function sharedInstance() {
		static $inst = null;
		if ($inst === null) {
			$inst = new \WDGWV\CMS\hooks();
		}
		return $inst;
	}

	protected function __construct() {

	}

	public function getUBBHooks() {
		return;
	}

	public function loopHooks($which) {
		if (is_array($which)) {
			for ($i = 0; $i < sizeof($which); $i++) {
				$this->loopHook($which[$i]);
			}
		}
	}

	public function haveHooksFor($which) {
		if (is_array($which)) {
			for ($i = 0; $i < sizeof($which); $i++) {
				if (sizeof($this->loopHook($which[$i])) > 0) {
					return true;
				}
			}
		}
	}

	public function loadPageFor($which) {
		if (is_array($which)) {
			for ($i = 0; $i < sizeof($which); $i++) {
				if (sizeof(($x = $this->loopHook($which[$i]))) > 0) {
					return $x;
				}
			}
		}
	}

	public function loopHook($at) {
		switch ($at) {
		case 'url':
			if (isset($this->hookDatabase['url'])) {
				for ($i = 0; $i < sizeof($this->hookDatabase['url']); $i++) {
					$safeMatch = $this->hookDatabase['url'][$i]['name'];
					$safeMatch = preg_replace("/\//", "\\\\/", $safeMatch);
					$safeMatch = preg_replace("/\*/", "(.*)", $safeMatch);
					if (isset($_SERVER['REQUEST_URI'])) {
						if (preg_match("/" . $safeMatch . "$/", $_SERVER['REQUEST_URI'])) {
							if (is_callable($this->hookDatabase['url'][$i]['action'])) {
								return call_user_func_array(
									$this->hookDatabase['url'][$i]['action'],
									$this->hookDatabase['url'][$i]['params']
								);
							} else {
								echo sprintf('"%s" is not a function!', $this->hookDatabase['url'][$i]['action'][1]);
							}
						}
					}
				}
			}
			break;

		case 'get':
			if (isset($this->hookDatabase['get'])) {
				for ($i = 0; $i < sizeof($this->hookDatabase['get']); $i++) {
					if (isset($_GET[$this->hookDatabase['get'][$i]['name']])) {
						if (is_callable($this->hookDatabase['get'][$i]['action'])) {
							return call_user_func_array(
								$this->hookDatabase['get'][$i]['action'],
								$this->hookDatabase['get'][$i]['params']
							);
						} else {
							echo sprintf('"%s" is not a function!', $this->hookDatabase['get'][$i]['action'][1]);
						}
					}
				}
			}
			break;

		case 'post':
			if (isset($this->hookDatabase['post'])) {
				for ($i = 0; $i < sizeof($this->hookDatabase['post']); $i++) {
					if (isset($_POST[$this->hookDatabase['post'][$i]['name']])) {
						if (is_callable($this->hookDatabase['post'][$i]['action'])) {
							return call_user_func_array(
								$this->hookDatabase['post'][$i]['action'],
								$this->hookDatabase['post'][$i]['params']
							);
						} else {
							echo sprintf('"%s" is not a function!', $this->hookDatabase['post'][$i]['action'][1]);
						}
					}
				}
			}
			break;

		case 'menu':
			$_temporaryArray = array();
			if (sizeof($this->hookDatabase['menu']) > 0) {
				for ($i = 0; $i < sizeof($this->hookDatabase['menu']); $i++) {
					$_temporaryArray[] = $this->hookDatabase['menu'][$i]['action'];
				}
			}
			return $_temporaryArray;
			break;

		default:
			return;
			break;
		}
	}

	public function createHook($at, $name, $action, $params = array()) {
		$this->hookDatabase[$at][] = array(
			'name' => $name,
			'action' => $action,
			'params' => $params,
		);
	}

	public function dumpDatabase() {
		return $this->hookDatabase;
	}
}
?>