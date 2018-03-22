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

class WDGWVFramework extends WDGWV {
}

namespace WDGWV\CMS;
class FileLoader extends \WDGWV\General\WDGWV {
	private $fileDirectory = '';
	private $controllersDirectory = 'controllers/';
	private $modulesDirectory = 'modules/';
	private $extensionsDirectory = 'extensions/';
	private $classesDirectory = 'classes/';
	private $fallbackDirectory = './';

	public function __construct($fileDirectory = './data/system/') {
		$this->fileDirectory = $fileDirectory;
	}

	public function setControllersDirectory($directoryAtPath = 'controllers/') {
		$this->controllersDirectory = $directoryAtPath;
	}

	public function setModulesDirectory($directoryAtPath = 'modules/') {
		$this->modulesDirectory = $directoryAtPath;
	}

	public function setExtensionsDirectory($directoryAtPath = 'extensions/') {
		$this->extensionsDirectory = $directoryAtPath;
	}

	public function setClassesDirectory($directoryAtPath = 'classes/') {
		$this->classesDirectory = $directoryAtPath;
	}

	public function load($fileName) {
		if (is_array($fileName)) {
			$this->loadArray($fileName);
			return;
		}

		$isFound = false;

		$tryAtPath = array(
			sprintf(
				'%s%s/%s.php',
				$this->fileDirectory,
				$this->controllersDirectory,
				$fileName
			),
			sprintf(
				'%s%s/%s/module.php',
				$this->fileDirectory,
				$this->modulesDirectory,
				$fileName
			),
			sprintf(
				'%s%s/%s/extension.php',
				$this->fileDirectory,
				$this->extensionsDirectory,
				$fileName
			),
			sprintf(
				'%s%s/%s.php',
				$this->fileDirectory,
				$this->classesDirectory,
				$fileName
			),
			sprintf(
				'%s%s/%s.php',
				$this->fileDirectory,
				$this->fallbackDirectory,
				$fileName
			),
		);

		for ($i = 0; $i < sizeof($tryAtPath); $i++) {
			if (file_exists($tryAtPath[$i])) {
				include_once $tryAtPath[$i];
				$GLOBALS += get_defined_vars();
				$isFound = true;
			}
		}

		if (!$isFound) {
			exit(sprintf('Fatal error could not load "%s".', $fileName));
		}
	}

	private function loadArray($arrayContainingFilenames) {
		if (is_array($arrayContainingFilenames)) {
			for ($i = 0; $i < sizeof($arrayContainingFilenames); $i++) {
				if (!is_array($arrayContainingFilenames[$i])) {
					$this->load($arrayContainingFilenames[$i]);
				}
			}
		}
	}

	public function __destruct() {
		unset($this->fileDirectory);
		unset($this->controllersDirectory);
		unset($this->modulesDirectory);
		unset($this->extensionsDirectory);
		unset($this->classesDirectory);
		unset($this->fallbackDirectory);
	}
}
?>