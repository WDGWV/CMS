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
class Extensions
{
    /**
     * @var array
     */
    private $scan_directorys = array(
        './Data/Extensions/',
        './Data/Modules/',
        './Data/Plugins/',
    );

    /**
     * @var array
     */
    private $load_files = array(
        'Extension.php',
        'Module.php',
        'Plugin.php',
    );

    /**
     * @var array
     */
    private $systemModules = array(
        'ExtensionManagement',
        'DemoMode',
        'WYSIWYG',
        'PageManagement',
        'BlogManagement',
        'ThemeManagement',
        'crossdomain',
        'update',
        // ''
    );

    /**
     * @var string
     */
    private $cache = '';

    /**
     * @var string
     */
    private $cacheDB = './Data/Database/extensionCache.PTdb';

    /**
     * @var string
     */
    private $lockFile = './Data/Database/extensionCache.PTlock';

    /**
     * @var int
     */
    private $cache_life = 3600 * 24; // in Seconds; 3600 = 1h, * 24 = 1d

    /**
     * @var array
     */
    private $loadExtensions = array();

    /**
     * @var array
     */

    private $extensionList = array();
    /**
     * @var mixed
     */

    private $saveOnExit = true;
    /**
     * @var mixed
     */
    private $compressDatabase = true;

    /**
     * Call the sharedInstance
     * @since Version 1.0
     */
    public static function sharedInstance()
    {
        /**
         * @var mixed
         */
        static $inst = null;
        if ($inst === null) {
            $inst = new \WDGWV\CMS\Extensions();
        }
        return $inst;
    }

    /**
     * Private so nobody else can instantiate it
     *
     */
    private function __construct()
    {
        $cacheTime = file_exists($this->cacheDB) ? filemtime($this->cacheDB) : 0;
        if ($cacheTime && (time() - $cacheTime <= $this->cache_life)) {
            $this->loadExtensions();
            return;
        }

        $this->reloadExtensions();
        array_unique($this->loadExtensions);
        array_unique($this->extensionList);

        if (file_exists($this->lockFile)) {
            @unlink($this->lockFile);
        }
    }

    /**
     * @return mixed
     */
    public function displayExtensionList()
    {
        return $this->extensionList;
    }

    /**
     * @return null
     */
    private function loadExtensions()
    {
        $f = json_decode( // Decode JSON
            gzuncompress( // Uncompress
                file_get_contents( // FGC
                    $this->cacheDB
                )
            ),
            true// explicit to Array.
        );

        if (sizeof($f[1]) == 0) {
            $this->reloadExtensions();
            return;
        }

        // Remove Duplicates, if any.
        $f[0] = array_unique($f[0]);
        $f[1] = array_unique($f[1]);

        foreach ($f[0] as $loadFile) {
            Debugger::sharedInstance()->log(sprintf('loading extension: %s', $loadFile));
            if (file_exists($loadFile)) {
                $disabled = explode('/', $loadFile);
                $disabled[sizeof($disabled) - 1] = 'disabled';

                if (!file_exists(implode('/', $disabled))) {
                    require_once $loadFile;
                }
            }
        }

        $this->loadExtensions = $f[0];
        $this->extensionList = $f[1];
    }

    /**
     * @param $ext
     */
    public function isSystem($ext)
    {
        if (sizeof(explode('/', $ext)) > 1) {
            return in_array(explode('/', $ext)[3], $this->systemModules);
        }

        foreach ($this->systemModules as $checkExtension) {
            foreach ($this->information($checkExtension) as $info => $value) {
                if ($info === 'extension') {
                    if ($value === $ext) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * @param $ext
     */
    public function isActive($ext)
    {
        if (sizeof(explode('/', $ext)) > 1) {
            return in_array($ext, $this->loadExtensions);
        }

        foreach ($this->loadExtensions as $checkExtension) {
            foreach ($this->information($checkExtension) as $info => $value) {
                if ($info === 'extension') {
                    if ($value === $ext) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * @param $extensionPathOrName
     * @return null
     */
    public function enableExtension($extensionPathOrName)
    {
        if (sizeof(explode('/', $extensionPathOrName)) > 1) {
            if (file_exists($extensionPathOrName)) {
                if (!in_array($extensionPathOrName, $this->loadExtensions)) {
                    require_once $extensionPathOrName;
                    $this->loadExtensions[] = $extensionPathOrName;
                }

                if (file_exists($this->lockFile)) {
                    @unlink($this->lockFile);
                }

                $this->saveDatabase(sprintf('Extension \'%s\' enabled', $extensionPathOrName));
                return;
            }
        }

        // Search it...
        $extensionPathOrName = 'DemoMode';
        foreach ($this->scan_directorys as $readDirectory) {
            if (file_exists($readDirectory) && is_readable($readDirectory)) {
                if (file_exists($readDirectory . $extensionPathOrName)) {
                    foreach ($this->load_files as $tryFile) {
                        if (file_exists($readDirectory . $extensionPathOrName . '/' . $tryFile)) {
                            if (!file_exists($readDirectory . $extensionPathOrName . '/' . 'disabled')) {
                                require_once $readDirectory . $extensionPathOrName . '/' . $tryFile;
                                if (!in_array(
                                    $readDirectory . $extensionPathOrName . '/' . $tryFile,
                                    $this->loadExtensions
                                )) {
                                    $this->loadExtensions[] = $readDirectory . $extensionPathOrName . '/' . $tryFile;
                                }
                            }
                        }
                    }
                }
            }
        }

        if (file_exists($this->lockFile)) {
            @unlink($this->lockFile);
        }

        $this->saveDatabase(sprintf('Extension \'%s\' enabled', $extensionPathOrName));
    }

    /**
     * @param $extensionPathOrName
     * @return null
     */
    public function disableExtension($extensionPathOrName)
    {
        if (sizeof(explode('/', $extensionPathOrName)) > 1) {
            for ($i = 0; $i < sizeof($this->loadExtensions); $i++) {
                if (isset($this->loadExtensions[$i])) {
                    if ($this->loadExtensions[$i] == $extensionPathOrName) {
                        unset($this->loadExtensions[$i]);

                        if (file_exists($this->lockFile)) {
                            @unlink($this->lockFile);
                        }

                        $this->saveDatabase(sprintf('Extension \'%s\' disabled', $extensionPathOrName));
                        return;
                    }
                }
            }
        }

        // Search it...
        $extensionPathOrName = 'DemoMode';
        foreach ($this->scan_directorys as $readDirectory) {
            if (file_exists($readDirectory) && is_readable($readDirectory)) {
                if (file_exists($readDirectory . $extensionPathOrName)) {
                    foreach ($this->load_files as $tryFile) {
                        if (file_exists($readDirectory . $extensionPathOrName . '/' . $tryFile)) {
                            if (!file_exists($readDirectory . $extensionPathOrName . '/' . 'disabled')) {
                                for ($i = 0; $i < sizeof($this->loadExtensions); $i++) {
                                    $fp = $readDirectory . $extensionPathOrName . '/' . $tryFile;
                                    if ($this->loadExtensions[$i] == $fp) {
                                        unset($this->loadExtensions[$i]);
                                        if (file_exists($this->lockFile)) {
                                            @unlink($this->lockFile);
                                        }

                                        $this->saveDatabase(sprintf('Extension \'%s\' disabled', $extensionPathOrName));
                                        return;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * @param $ofExtensionOrFilePath
     * @return mixed
     */
    public function information($ofExtensionOrFilePath)
    {
        if (!file_exists($ofExtensionOrFilePath)) {
            // Scanning files.
            echo "Unown file.";
            return;
        }

        return $this->parseInformation($ofExtensionOrFilePath);
    }

    /**
     * @param $exp1
     * @param $exp2
     */
    private function match($exp1, $exp2)
    {
        $fixedExpression = $exp1;
        if (substr($fixedExpression, 0, 1) === ' ') {
            $fixedExpression = substr($fixedExpression, 1);
        }

        return (substr($fixedExpression, 0, strlen($exp2)) == $exp2);
    }

    /**
     * @param $ofExtensionFilePath
     * @return mixed
     */
    private function parseInformation($ofExtensionFilePath)
    {
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

    public function forceReloadExtensions()
    {
        unset($this->extensionList);
        $this->extensionList = array();
        unset($this->loadExtensions);
        $this->loadExtensions = array();

        if (!unlink($this->cacheDB)) {
            exit('Failed to remove database');
        }

        $this->reloadExtensions('FORCE SAVE, EXTENSION DATABASE RESET');
        $this->saveOnExit = false;
        @touch($this->lockFile);
    }

    /**
     * @param $m
     */
    private function reloadExtensions($m = 'Default rescan.')
    {
        $this->loadExtensions = array();
        $this->extensionList = array();

        // Check for 'DemoMode' first.
        $current = 'DemoMode';
        foreach ($this->scan_directorys as $readDirectory) {
            if (file_exists($readDirectory) && is_readable($readDirectory)) {
                if (file_exists($readDirectory . $current)) {
                    foreach ($this->load_files as $tryFile) {
                        if (file_exists($readDirectory . $current . '/' . $tryFile)) {
                            $this->loadExtensions[] = $readDirectory . $current . '/' . $tryFile;
                            $this->extensionList[] = $readDirectory . $current . '/' . $tryFile;
                            if (!file_exists($readDirectory . $current . '/' . 'disabled')) {
                                require_once $readDirectory . $current . '/' . $tryFile;
                            }
                        }
                    }
                }
            }
        }

        foreach ($this->scan_directorys as $readDirectory) {
            if (file_exists($readDirectory) && is_readable($readDirectory)) {
                $_d = opendir($readDirectory);
                while (($current = readdir($_d)) !== false) {
                    if ($current != '.' && $current != '..' && is_dir($readDirectory . $current)) {
                        foreach ($this->load_files as $tryFile) {
                            if (file_exists($readDirectory . $current . '/' . $tryFile)) {
                                if (!in_array($readDirectory . $current . '/' . $tryFile, $this->loadExtensions)) {
                                    if (in_array($current, $this->systemModules)) {
                                        $this->loadExtensions[] = $readDirectory . $current . '/' . $tryFile;
                                    }

                                    $this->extensionList[] = $readDirectory . $current . '/' . $tryFile;
                                    if (!file_exists($readDirectory . $current . '/' . 'disabled')) {
                                        require_once $readDirectory . $current . '/' . $tryFile;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $this->saveDatabase($m);
    }

    /**
     * @param $m
     * @return null
     */
    private function saveDatabase($m = 'Default save action on exit')
    {
        if (file_exists($this->lockFile)) {
            return;
        }

        if (!file_exists($this->cacheDB)) {
            touch($this->cacheDB);
        }

        if (is_writable($this->cacheDB)) {
            file_put_contents(
                $this->cacheDB,
                gzcompress(
                    json_encode(
                        array(
                            $this->loadExtensions,
                            $this->extensionList,
                        )
                    ),
                    9
                )
            );
        } else {
            echo "Warning 'ExtensionCache' database not writeable";
        }
    }

    public function __destruct()
    {
        if ($this->saveOnExit) {
            $this->saveDatabase();
        }
    }
}
