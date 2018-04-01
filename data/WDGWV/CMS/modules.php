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