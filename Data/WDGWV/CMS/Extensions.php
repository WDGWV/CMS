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
-       (c) WDGWV. 2018, http://www.wdgwv.com              -
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
     * Scan this directories for Extensions
     *
     * @var array
     */
    private $scan_directories = array(
        './Data/Extensions/',
        './Data/Modules/',
        './Data/Plugins/',
    );

    /**
     * Define possible Extension filenames
     *
     * @var array
     */
    private $load_files = array(
        'Extension.php',
        'Module.php',
        'Plugin.php',
    );

    /**
     * Define system Extensions/Modules
     *
     * @var array
     */
    private $systemExtensions = array(
        'ExtensionManagement',
        'DemoMode',
        'WYSIWYG',
        'PageManagement',
        'BlogManagement',
        'ThemeManagement',
        'crossdomain',
        'Update',
        // ''
    );

    /**
     * The Cache.
     *
     * @var string
     */
    private $cache = '';

    /**
     * Cache database file.
     *
     * @var string
     */
    private $cacheDB = './Data/Database/extensionCache.PTdb';

    /**
     * the 'lock' file.
     *
     * @var string
     */
    private $lockFile = './Data/Database/extensionCache.PTlock';

    /**
     * Cache lifetime (in seconds)
     *
     * @var int
     */
    private $cache_lifetime = (3600 * 24) * 365; // in Seconds; 3600 = 1h, * 24 = 1d
    // Temporary 1y, solution needed for every day reset.

    /**
     * Load this extensions
     *
     * @var array
     */
    private $loadExtensions = array();

    /**
     * Extensions list
     *
     * @var array
     */
    private $extensionList = array();

    /**
     * Save on Exit.
     * @var bool
     */
    private $saveOnExit = true;

    /**
     * @var bool
     */
    private $compressDatabase = true;

    /**
     * Call the sharedInstance
     *
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
     */
    private function __construct()
    {
        /**
         * What is the current time of the cache.
         * Default: 0
         *
         * @var integer
         */
        $cacheTime = 0;

        /**
         * Check if the file exists
         */
        if (file_exists($this->cacheDB)) {
            /**
             * What is the current time of the cache.
             * @var int
             */
            $cacheTime = filemtime($this->cacheDB);
        }

        /**
         * Check if the time - cachetime is less then the cache lifetime
         */
        if ((time() - $cacheTime) <= $this->cache_lifetime) {
            /**
             * Cache lifetime is not exeed.
             * load cache
             */
            $this->loadExtensions();

            /**
             * Do not run the rest of the function.
             */
            return;
        }

        /**
         * Reload extensions
         */
        $this->reloadExtensions();

        /**
         * Remove duplicates in $this->loadExtensions
         */
        array_unique($this->loadExtensions);

        /**
         * Remove duplicates in $this->extensionList
         */
        array_unique($this->extensionList);

        /**
         * Check if there is a 'lock' file.
         */
        if (file_exists($this->lockFile)) {
            /**
             * Unlink the 'lock' file
             */
            @unlink($this->lockFile);
        }
    }

    /**
     * Display extension list
     *
     * @return mixed
     */
    public function displayExtensionList()
    {
        /**
         * Load extension list
         */
        return $this->extensionList;
    }

    /**
     * Load extensions database
     *
     * @return null
     */
    private function loadExtensions()
    {
        /* JSON Decode */
        $f = json_decode(
            /* Uncompress */
            gzuncompress(
                /* Read cache file */
                file_get_contents(
                    /* Cache filepath */
                    $this->cacheDB
                )
            ),
            /* explicit to Array. */
            true
        );

        /**
         * Check if there are extensions loaded.
         */
        if (sizeof($f[1]) == 0) {
            /**
             * No extensions loaded.
             * Reload extensions
             */
            $this->reloadExtensions();

            /**
             * Do not run the rest of the code.
             */
            return;
        }

        /**
         * Remove duplicates in loaded extensions
         */
        $f[0] = array_unique($f[0]);

        /**
         * Remove duplicates in extensionList
         */
        $f[1] = array_unique($f[1]);

        /**
         * Load the files
         */
        foreach ($f[0] as $loadFile) {
            /**
             * Append loading text to debugger
             */
            Debugger::sharedInstance()->log(
                sprintf(
                    'loading extension: %s',
                    $loadFile
                )
            );

            /**
             * Checks if extension exists
             */
            if (file_exists($loadFile)) {
                /**
                 * Check if the extension is disabled?
                 * @var string
                 */
                $disabled = explode('/', $loadFile);
                /**
                 * Append disabled to the array
                 */
                $disabled[sizeof($disabled) - 1] = 'disabled';

                /**
                 * Checks debugmode status
                 */
                if (!\WDGWV\CMS\Config::sharedInstance()->debug()) {
                    /**
                     * Checks if there is not a file called 'disabled'.
                     * And we are in debugmode
                     */
                    if (!file_exists(implode('/', $disabled))) {
                        /**
                         * No disabled parameter, so load it!
                         */
                        require_once $loadFile;
                    }
                } else {
                    /**
                     * In production mode,
                     * We don't block files due 'disabled' files
                     */
                    require_once $loadFile;
                }
            }
        }

        /**
         * Save loaded extensions
         * @var [string]
         */
        $this->loadExtensions = $f[0];

        /**
         * Save extensions
         * @var [string]
         */
        $this->extensionList = $f[1];
    }

    /**
     * Is it a system Extension
     *
     * @param $ext
     * @return bool is it a system extension?
     */
    public function isSystem($ext)
    {
        /**
         * Explode the name.
         */
        if (sizeof(explode('/', $ext)) > 1) {
            /**
             * If the name of the extension is in the system array, then return true
             */
            return in_array(
                /* ./Data/Extensions/Extensionname/Extension.php */
                /* 0  1       2          3             4         */
                /* Fetch extension name */
                explode('/', $ext)[3],
                /* System extensions array */
                $this->systemExtensions
            );
        }

        /**
         * Walk trough system extensions.
         */
        foreach ($this->systemExtensions as $checkExtension) {
            /**
             * Get information about this extension
             */
            foreach ($this->information($checkExtension) as $info => $value) {
                /**
                 * If type is extension
                 */
                if ($info === 'extension') {
                    /**
                     * And Extensionname equals $ext
                     */
                    if ($value === $ext) {
                        /**
                         * It is a system extension!
                         */
                        return true;
                    }
                }
            }
        }

        /**
         * It's a normal extension.
         */
        return false;
    }

    /**
     * is it an active Extension?
     *
     * @param $ext
     * @return bool active?
     */
    public function isActive($ext)
    {
        /**
         * Explode the name.
         */
        if (sizeof(explode('/', $ext)) > 1) {
            /**
             * If the name of the extension is in the loaded array, then return true
             */
            return in_array(
                /* Extension name */
                $ext,
                /* loaded extensions */
                $this->loadExtensions
            );
        }

        /**
         * Walk trough loaded extensions.
         */
        foreach ($this->loadExtensions as $checkExtension) {
            /**
             * Get information about this extension
             */
            foreach ($this->information($checkExtension) as $info => $value) {
                /**
                 * If type is extension
                 */
                if ($info === 'extension') {
                    /**
                     * And Extensionname equals $ext
                     */
                    if ($value === $ext) {
                        /**
                         * It is a loaded extension!
                         */
                        return true;
                    }
                }
            }
        }

        /**
         * It's a unloaded extension.
         */
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
        foreach ($this->scan_directories as $readDirectory) {
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
     * Disable an extension
     *
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
        foreach ($this->scan_directories as $readDirectory) {
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
     * extension information
     *
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
     * parse information of an extension
     *
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

    /**
     * Force reload extensions
     * @return void
     */
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
     * reload extensions
     * @param $m message
     */
    private function reloadExtensions($m = 'Default rescan.')
    {
        $this->loadExtensions = array();
        $this->extensionList = array();

        // Check for 'DemoMode' first.
        $current = 'DemoMode';
        foreach ($this->scan_directories as $readDirectory) {
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

        foreach ($this->scan_directories as $readDirectory) {
            if (file_exists($readDirectory) && is_readable($readDirectory)) {
                $_d = opendir($readDirectory);
                while (($current = readdir($_d)) !== false) {
                    if ($current != '.' && $current != '..' && is_dir($readDirectory . $current)) {
                        foreach ($this->load_files as $tryFile) {
                            if (file_exists($readDirectory . $current . '/' . $tryFile)) {
                                if (!in_array($readDirectory . $current . '/' . $tryFile, $this->loadExtensions)) {
                                    if (in_array($current, $this->systemExtensions)) {
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

        /**
         * Save the database!
         */
        $this->saveDatabase($m);
    }

    /**
     * save database
     *
     * @param $m message
     * @return null
     */
    private function saveDatabase($m = 'Default save action on exit')
    {
        /**
         * Check if the 'lockfile' exists.
         */
        if (file_exists($this->lockFile)) {
            /**
             * Lockfile exists, don't save
             */
            return;
        }

        /**
         * Check if the 'cacheDB' exists
         */
        if (!file_exists($this->cacheDB)) {
            /**
             * Create it.
             */
            touch($this->cacheDB);
        }

        /**
         * Check if 'cacheDB' is writeable
         */
        if (is_writable($this->cacheDB)) {
            /**
             * Save to 'cacheDB'
             */
            file_put_contents(
                $this->cacheDB,
                gzcompress(
                    json_encode(
                        array(
                            $this->loadExtensions,
                            $this->extensionList,
                        ) // Create the array
                    ), // JSON Encode
                    9// Maximum compression
                )
            );
        } else {
            /**
             * Warning ExtensionCache not writeable.
             * continue running.
             */
            echo "Warning 'ExtensionCache' database not writeable";
        }
    }

    /**
     * Bye!
     */
    public function __destruct()
    {
        /**
         * Save on exit
         */
        if ($this->saveOnExit) {
            /**
             * Save database
             */
            $this->saveDatabase();
        }
    }
}
