<?php
/** CMS Modules
 *
 * it makes the best extensions for you!
 */

/*
------------------------------------------------------------
-                :....................,:,                  -
-              ,.`,,,::;;;;;;;;;;;;;;;;:;`                 -
-            `...`,::;:::::;;;;;;;;;;;;;::'                -
-           ,..``,,,::::::::::::::::;:;;:::;               -
-          :.,,``..::;;,,,,,,,,,,,,,:;;;;;::;`             -
-         ,.,,,`...,:.:,,,,,,,,,,,,,:;:;;;;:;;             -
-        `..,,``...;;,;::::::::::::::'';';';:''            -
-        ,,,,,``..:;,;;:::::::::::::;';;';';;'';           -
-       ,,,,,``....;,,:::::::;;;;;;;;':'''';''+;           -
-       :,::```....,,,:;;;;;;;;;;;;;;;''''';';';;          -
-      `,,::``.....,,,;;;;;;;;;;;;;;;;'''''';';;;'         -
-      :;:::``......,;;;;;;;;:::::;;;;'''''';;;;:-         -
-      ;;;::,`.....,::;;::::::;;;;;;;;'''''';;,;;,         -
-      ;:;;:;`....,:::::::::::::::::;;;;'''':;,;;;         -
-      ';;;;;.,,,,::::::::::::::::::;;;;;''':::;;'         -
-      ;';;;;.;,,,,::::::::::::::::;;;;;;;''::;;;'         -
-      ;'';;:;..,,,;;;:;;:::;;;;;;;;;;;;;;;':::;;'         -
-      ;'';;;;;.,,;:;;;;;;;;;;;;;;;;;;;;;;;;;:;':;         -
-      ;''';;:;;.;;;;;;;;;;;;;;;;;;;;;;;;;;;''';:.         -
-      :';';;;;;;::,,,,,,,,,,,,,,:;;;;;;;;;;'''';          -
-       '';;;;:;;;.,,,,,,,,,,,,,,,,:;;;;;;;;'''''          -
-       '''';;;;;:..,,,,,,,,,,,,,,,,,;;;;;;;''':,          -
-       .'''';;;;....,,,,,,,,,,,,,,,,,,,:;;;''''           -
-        ''''';;;;....,,,,,,,,,,,,,,,,,,;;;''';.           -
-         '''';;;::.......,,,,,,,,,,,,,:;;;''''            -
-         `''';;;;:,......,,,,,,,,,,,,,;;;;;''             -
-          .'';;;;;:.....,,,,,,,,,,,,,,:;;;;'              -
-           `;;;;;:,....,,,,,,,,,,,,,,,:;;''               -
-             ;';;,,..,.,,,,,,,,,,,,,,,;;',                -
-               '';:,,,,,,,,,,,,,,,::;;;:                  -
-                 `:;'''''''''''''''';:.                   -
-                                                          -
- ,,,::::::::::::::::::::::::;;;;,:::::::::::::::::::::::: -
- ,::::::::::::::::::::::::::;;;;,:::::::::::::::::::::::: -
- ,:; ## ## ##  #####     ####      ## ## ##  ##   ##  ;:: -
- ,,; ## ## ##  ## ##    ##         ## ## ##  ##   ##  ;:: -
- ,,; ## ## ##  ##  ##  ##   ####   ## ## ##   ## ##   ;:: -
- ,,' ## ## ##  ## ##    ##    ##   ## ## ##   ## ##   ::: -
- ,:: ########  ####      ######    ########    ###    ::: -
- ,,,:,,:,,:::,,,:;:::::::::::::::;;;:::;:;::::::::::::::: -
- ,,,,,,,,,,,,,,,,,,,,,,,,:,::::::;;;;:::::;;;;::::;;;;::: -
-                                                          -
-       (c) WDGWV. 2013, http://www.wdgwv.com              -
-    Websites, Apps, Hosting, Services, Development.       -
------------------------------------------------------------
 */

namespace WDGWV\CMS;

/**
 * WDGWV CMS Module loader
 *
 * This is the WDGWV CMS Module loader
 *
 * @version Version 1.0
 * @author Wesley de Groot / WDGWV
 * @copyright 2017 Wesley de Groot / WDGWV
 * @package WDGWV/CMS
 * @subpackage Debugger
 * @link http://www.wesleydegroot.nl © Wesley de Groot
 * @link https://www.wdgwv.com © WDGWV
 */
class modules {
	private $scan_directorys = array(
		'./data/modules/',
		'./data/plugins/',
		'./data/extensions/',
	);

	private $load_files = array(
		'module.php',
		'plugin.php',
		'extension.php',
	);

	private $cache = '';
	private $cacheDB = './data/database/moduleCache.db';
	private $cache_life = 3600 * 24; // in Seconds; 3600 = 1h, * 24 = 1d
	private $loadModules = array();

	/**
	 * Call the sharedInstance
	 * @since Version 1.0
	 */
	public static function sharedInstance() {
		static $inst = null;
		if ($inst === null) {
			$inst = new \WDGWV\CMS\modules();
		}
		return $inst;
	}

	/**
	 * Private so nobody else can instantiate it
	 *
	 */
	private function __construct() {
		$cacheTime = file_exists($this->cacheDB) ? filemtime($this->cacheDB) : 0;
		if ($cacheTime && (time() - $cacheTime <= $this->cache_life)) {
			$this->_loadModules();
			return;
		}

		$this->_reloadModules();
	}

	public function _displayModuleList() {
		return $this->loadModules;
	}

	private function _loadModules() {
		$f = json_decode(
			gzuncompress(
				file_get_contents(
					$this->cacheDB
				)
			), true
		);

		if (sizeof($f) == 0) {
			$this->_reloadModules();
			return;
		}

		foreach ($f as $loadFile) {
			Debugger::sharedInstance()->log(sprintf('loading %s', $loadFile));
			if (file_exists($loadFile)) {
				require_once $loadFile;
			}
		}

		$this->loadModules = $f;
	}

	public function information($ofModuleNameOrFilePath) {
		if (!file_exists($ofModuleNameOrFilePath)) {
			// Scanning files.
			echo "Unown file.";
			return;
		}

		return $this->parseInformation($ofModuleNameOrFilePath);
	}

	private function match($exp1, $exp2) {
		$fixedExpression = $exp1;
		if (substr($fixedExpression, 0, 1) === ' ') {
			$fixedExpression = substr($fixedExpression, 1);
		}

		return (substr($fixedExpression, 0, strlen($exp2)) == $exp2);
	}

	private function parseInformation($ofModulePath) {
		/**
		 * (EXAMPLE)
		 *
		 * WDGWV CMS Required file.
		 * Full access: true
		 * Module: Update
		 * Version: 1.0
		 * Description: Updates WDGWV CMS
		 * Hash: * INSERT HASH HERE *
		 */// Needs to be on top of the file.

		$moduleInfo = array();
		if (file_exists($ofModulePath)) {
			$fc = file_get_contents($ofModulePath);
			if ($fc) {
				$fe = explode('*/', $fc)[0];
				$fe = explode('/*', $fe)[1];
				$fe = explode(PHP_EOL, $fe);
				foreach ($fe as $informationDict) {
					if ($this->match($informationDict, "* ") && strlen($informationDict) > 3) {
						$ex = explode(": ", $informationDict);
						if (!isset($ex[1])) {
							continue;
						}

						$safeName = explode(' * ', $ex[0])[1];
						$safeName = preg_replace('/ /', '_', $safeName);
						$safeName = preg_replace('/:/', '_', $safeName);
						$safeName = strtolower($safeName);

						$moduleInfo[$safeName] = $ex[1];
					}
				}

				return $moduleInfo;
			} else {
				echo "Error reading file";
			}
		}
	}
	public function _forceReloadModules() {
		unset($this->loadModules);
		unlink($this->cacheDB);
		$this->_reloadModules();
	}

	private function _reloadModules() {
		$this->loadModules = array();

		foreach ($this->scan_directorys as $readDirectory) {
			if (file_exists($readDirectory) && is_readable($readDirectory)) {
				$_d = opendir($readDirectory);
				while (($current = readdir($_d)) !== false) {
					if ($current != '.' && $current != '..' && is_dir($readDirectory . $current)) {
						foreach ($this->load_files as $tryFile) {
							if (file_exists($readDirectory . $current . '/' . $tryFile)) {
								$this->loadModules[] = $readDirectory . $current . '/' . $tryFile;
								require_once $readDirectory . $current . '/' . $tryFile;
							}
						}
					}
				}
			}
		}
	}

	public function __destruct() {
		if (!file_exists($this->cacheDB)) {
			touch($this->cacheDB);
		}

		if (is_writable($this->cacheDB)) {
			file_put_contents(
				$this->cacheDB,
				gzcompress(
					json_encode(
						$this->loadModules
					), 9
				)
			);
		} else {
			echo "Warning 'moduleCache' database not writeable";
		}
	}
}

?>