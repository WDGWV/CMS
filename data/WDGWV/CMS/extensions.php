<?php
/** CMS Extensions
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
 * WDGWV CMS Extension loader
 *
 * This is the WDGWV CMS Extension loader
 *
 * @version Version 1.0
 * @author Wesley de Groot / WDGWV
 * @copyright 2017 Wesley de Groot / WDGWV
 * @package WDGWV/CMS
 * @subpackage extensions
 * @link http://www.wesleydegroot.nl © Wesley de Groot
 * @link https://www.wdgwv.com © WDGWV
 */
class extensions {
	private $scan_directorys = array(
		'./data/extensions/',
		'./data/modules/',
		'./data/plugins/',
	);

	private $load_files = array(
		'extension.php',
		'module.php',
		'plugin.php',
	);

	private $cache = '';
	private $cacheDB = './data/database/extensionCache.db';
	private $cache_life = 3600 * 24; // in Seconds; 3600 = 1h, * 24 = 1d
	private $loadExtensions = array();

	/**
	 * Call the sharedInstance
	 * @since Version 1.0
	 */
	public static function sharedInstance() {
		static $inst = null;
		if ($inst === null) {
			$inst = new \WDGWV\CMS\extensions();
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
			$this->_loadExtensions();
			return;
		}

		$this->_reloadExtensions();
	}

	public function _displayExtensionList() {
		return $this->loadExtensions;
	}

	private function _loadExtensions() {
		$f = json_decode(
			gzuncompress(
				file_get_contents(
					$this->cacheDB
				)
			), true
		);

		if (sizeof($f) == 0) {
			$this->_reloadExtensions();
			return;
		}

		foreach ($f as $loadFile) {
			Debugger::sharedInstance()->log(sprintf('loading %s', $loadFile));
			if (file_exists($loadFile)) {
				require_once $loadFile;
			}
		}

		$this->loadExtensions = $f;
	}

	public function information($ofExtensionOrFilePath) {
		if (!file_exists($ofExtensionOrFilePath)) {
			// Scanning files.
			echo "Unown file.";
			return;
		}

		return $this->parseInformation($ofExtensionOrFilePath);
	}

	private function match($exp1, $exp2) {
		$fixedExpression = $exp1;
		if (substr($fixedExpression, 0, 1) === ' ') {
			$fixedExpression = substr($fixedExpression, 1);
		}

		return (substr($fixedExpression, 0, strlen($exp2)) == $exp2);
	}

	private function parseInformation($ofExtensionFilePath) {
		/**
		 * (EXAMPLE)
		 *
		 * WDGWV CMS Required file.
		 * Full access: true
		 * Extension: Update
		 * Version: 1.0
		 * Description: Updates WDGWV CMS
		 * Hash: * INSERT HASH HERE *
		 */// Needs to be on top of the file.

		$extensionInfo = array();
		if (file_exists($ofExtensionFilePath)) {
			$fc = file_get_contents($ofExtensionFilePath);
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

						$extensionInfo[$safeName] = $ex[1];
					}
				}

				return $extensionInfo;
			} else {
				echo "Error reading file";
			}
		}
	}
	public function _forceReloadExtensions() {
		unset($this->loadExtensions);
		unlink($this->cacheDB);
		$this->_reloadExtensions();
	}

	private function _reloadExtensions() {
		$this->loadExtensions = array();

		foreach ($this->scan_directorys as $readDirectory) {
			if (file_exists($readDirectory) && is_readable($readDirectory)) {
				$_d = opendir($readDirectory);
				while (($current = readdir($_d)) !== false) {
					if ($current != '.' && $current != '..' && is_dir($readDirectory . $current)) {
						foreach ($this->load_files as $tryFile) {
							if (file_exists($readDirectory . $current . '/' . $tryFile)) {
								$this->loadExtensions[] = $readDirectory . $current . '/' . $tryFile;
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
						$this->loadExtensions
					), 9
				)
			);
		} else {
			echo "Warning 'extensionCache' database not writeable";
		}
	}
}

?>