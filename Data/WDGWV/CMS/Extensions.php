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
        'Data/Extensions/',
        'Data/Modules/',
        'Data/Plugins/',
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
        'UserManagement',
        'Crossdomain',
        'IPban',
        'Update',
        '_.js',
    );

    /**
     * Cache database file.
     *
     * @var string
     */
    private $cacheDB = '/Data/Database/extensionCache.PTdb';

    /**
     * the 'lock' file.
     *
     * @var string
     */
    private $lockFile = '/Data/Database/extensionCache.PTlock';

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
     * Call the shared
     *
     * @since Version 1.0
     */
    public static function shared()
    {
        /**
         * Shared Instance
         * @var class
         */
        static $inst = null;

        /**
         * If not have a instance, create one.
         */
        if ($inst === null) {
            /**
             * Initialisize Shared Instance
             * @var class
             */
            $inst = new \WDGWV\CMS\Extensions();
        }

        /**
         * Return Shared Instance
         */
        return $inst;
    }

    /**
     * Log to the logfile!
     *
     * @param string $anything mixed
     */
    private function log($anything)
    {
        if (\WDGWV\General\WDGWV::shared()->debug()) {
            file_put_contents(
                $f = getcwd() . '/ExtensionsLog.log',
                sprintf(
                    "%s[%s] [%s(...)] %s%s",
                    @file_get_contents($f),
                    date("Y-m-d H:i:s"),
                    debug_backtrace()[1]['function'],
                    $anything,
                    PHP_EOL
                )
            );
        }
    }

    /**
     * Private so nobody else can instantiate it
     */
    private function __construct()
    {
        $this->log("Debugging started.");
        /**
         * What is the current time of the cache.
         * Default: 0
         *
         * @var integer
         */
        $cacheTime = 0;
        $this->cacheDB = getcwd() . '/Data/Database/extensionCache.PTdb';
        $this->lockFile = getcwd() . '/Data/Database/extensionCache.PTlock';
        /**
         * Check if the file exists
         */
        if (file_exists($this->cacheDB)) {
            $this->log("Cache exists");
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
            $this->log("Cache time ok.");
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

        $this->log("Reloading extensions.");
        /**
         * Reload extensions
         */
        $this->reloadExtensions();

        $this->log("Removing duplicates (loadExtensions).");
        /**
         * Remove duplicates in $this->loadExtensions
         */
        array_unique($this->loadExtensions);

        $this->log("Removing duplicates (extensionList).");
        /**
         * Remove duplicates in $this->extensionList
         */
        array_unique($this->extensionList);

        $this->log("Checking for a lock file..");
        /**
         * Check if there is a 'lock' file.
         */
        if (file_exists($this->lockFile)) {
            $this->log("Removing lock file.");
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
        $this->log("Loading extensions");
        /* JSON Decode */
        $loadFile = json_decode(
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
        if (sizeof($loadFile[0]) < 5) {
            $this->log("RELoading extensions, loaded extension count is " . sizeof($loadFile[0]) . " (" . @implode(",", $loadFile[0]) . ")");

            /**
             * No extensions loaded.
             * Reload extensions
             */
            $this->forceReloadExtensions('FORCE SAVE, EXTENSION DATABASE MISSING!!!');

            /**
             * Do not run the rest of the code.
             */
            return;
        }

        $this->log("removing duplicates");
        /**
         * Remove duplicates in loaded extensions
         */
        if (is_array($loadFile[0])) {
            $loadFile[0] = array_unique($loadFile[0]);
        }

        /**
         * Remove duplicates in extensionList
         */
        if (is_array($loadFile[1])) {
            $loadFile[1] = array_unique($loadFile[1]);
        }

        $this->log("removed duplicates");
        /**
         * Load the files
         */
        if (is_array($loadFile[0])) {
            foreach ($loadFile[0] as $fileToLoad) {
                $this->log("Loading extension {$fileToLoad}");

                /**
                 * Append loading text to debugger
                 */
                Debugger::shared()->log(
                    sprintf(
                        'loading extension: %s',
                        $fileToLoad
                    )
                );

                /**
                 * Checks if extension exists
                 */
                if (file_exists($fileToLoad)) {
                    /**
                     * Check if the extension is disabled?
                     * @var string
                     */
                    $disabled = explode('/', $fileToLoad);

                    /**
                     * Append disabled to the array
                     */
                    $disabled[sizeof($disabled) - 1] = 'disabled';

                    /**
                     * Checks debugmode status
                     */
                    if (!\WDGWV\CMS\Config::shared()->debug()) {
                        /**
                         * Checks if there is not a file called 'disabled'.
                         * And we are in debugmode
                         */
                        if (!file_exists(implode('/', $disabled))) {
                            /**
                             * No disabled parameter, so load it!
                             */
                            require_once $fileToLoad;
                        }
                    } else {
                        /**
                         * In production mode,
                         * We don't block files due 'disabled' files
                         */
                        require_once $fileToLoad;
                    }
                }
            }
        }

        $this->log("Saving values...");
        /**
         * Save loaded extensions
         * @var [string]
         */
        $this->loadExtensions = $loadFile[0];

        /**
         * Save extensions
         * @var [string]
         */
        $this->extensionList = $loadFile[1];

        $this->log("Extensions loaded!");
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
                /* Data/Extensions/Extensionname/Extension.php */
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
     * integrityCheck
     *
     * @param $extension
     * @return bool
     */
    public function integrityCheck($extension)
    {
        $check = unserialize(CMS_INTEGIRITY_CHECK);
        if (isset($check[$this->getExtensionPath($extension)])) {
            if ($check[$this->getExtensionPath($extension)] === md5(file_get_contents($this->getExtensionPath($extension)))) {
                return true;
            }
        }

        /**
         * Integrity check could not continue, failing
         */
        return false;
    }

    /**
     * Hash Check
     *
     * @param $extension
     * @return bool
     */
    public function checkHash($extension)
    {
        /**
         * Load information about the extension, and loop trough it
         */
        foreach ($this->information($extension) as $info => $value) {
            /**
             * Check if we've found the hash
             */
            if ($info === 'hash') {
                /**
                 * Check validatity of the hash.
                 */
                return (
                    /**
                     * Actual logic is simple
                     * md5(path) == value
                     * value needs to be equal to md5(path)
                     */
                    md5($extension) == $value || // For PHP < 5.7
                    $this->getExtensionPath($extension) == $value
                );
            }
        }

        /**
         * Hash not found. Failed.
         */
        return false;
    }

    /**
     * Enable a extension
     *
     * @param $extensionPathOrName
     * @return null
     */
    public function enableExtension($extensionPathOrName)
    {
        /**
         * Check if a path is defined
         */
        if (sizeof(explode('/', $extensionPathOrName)) == 0) {
            /**
             * Search the path.
             */
            $extensionPathOrName = $this->getExtensionPath($extensionPathOrName);
        }

        /**
         * Explode the name.
         */
        if (sizeof(explode('/', $extensionPathOrName)) > 1) {
            /**
             * Check if the file exists
             */
            if (file_exists($extensionPathOrName)) {
                /**
                 * If not already loaded, then load it.
                 */
                if (!in_array($extensionPathOrName, $this->loadExtensions)) {
                    /**
                     * Load the extension
                     */
                    require_once $extensionPathOrName;

                    /**
                     * Append them to the loaded extensions array
                     */
                    $this->loadExtensions[] = $extensionPathOrName;
                }

                /**
                 * Checks if a lockfile exists
                 */
                if (file_exists($this->lockFile)) {
                    /**
                     * Unlink (remove) lockfile
                     */
                    @unlink($this->lockFile);
                }

                /**
                 * Save the database
                 */
                $this->saveDatabase(sprintf('Extension \'%s\' enabled', $extensionPathOrName));

                /**
                 * Return, so don't run more from this function
                 */
                return;
            }
        }

        /**
         * Checks if a lockfile exists
         */
        if (file_exists($this->lockFile)) {
            /**
             * Unlink (remove) lockfile
             */
            @unlink($this->lockFile);
        }

        /**
         * Save the database
         */
        $this->saveDatabase(
            sprintf(
                'Extension \'%s\' enabled',
                $extensionPathOrName
            )
        );
    }

    /**
     * Disable an extension
     *
     * @param $extensionPathOrName
     * @return null
     */
    public function disableExtension($extensionPathOrName)
    {
        /**
         * Check if a path is defined
         */
        if (sizeof(explode('/', $extensionPathOrName)) == 0) {
            /**
             * Search the path.
             */
            $extensionPathOrName = $this->getExtensionPath($extensionPathOrName);
        }

        /**
         * Explode the name.
         */
        if (sizeof(explode('/', $extensionPathOrName)) > 1) {
            /**
             * Check if the file exists
             */
            for ($i = 0; $i < sizeof($this->loadExtensions); $i++) {
                /**
                 * If not already loaded.
                 */
                if (isset($this->loadExtensions[$i])) {
                    /**
                     * If extension name is in the array
                     */
                    if ($this->loadExtensions[$i] == $extensionPathOrName) {
                        /**
                         * Remove it from the loaded extensions array
                         */
                        unset($this->loadExtensions[$i]);

                        /**
                         * Checks if a lockfile exists
                         */
                        if (file_exists($this->lockFile)) {
                            /**
                             * Unlink (remove) lockfile
                             */
                            @unlink($this->lockFile);
                        }

                        /**
                         * Save to the database
                         */
                        $this->saveDatabase(
                            sprintf(
                                'Extension \'%s\' disabled',
                                $extensionPathOrName
                            )
                        );

                        /**
                         * Return.
                         */
                        return;
                    }
                }
            }
        }
    }

    /**
     * extension path information
     *
     * @param $extensionName
     * @return bool|string
     */
    public function getExtensionPath($extensionName)
    {
        if (substr($extensionName, 0, 6) == './Data') {
            return file_exists($extensionName) ? $extensionName : false;
        }

        /**
         * Loop trough known directories
         */
        foreach ($this->scan_directories as $checkDirectory) {
            /**
             * Loop trough known extensions
             */
            foreach ($this->load_files as $fileName) {
                /**
                 * Remove spaces from the extension name
                 */
                $extensionName = preg_replace("/ /", null, $extensionName);

                /**
                 * Merge the directories and extensions to a file path
                 */
                $filePath = sprintf(
                    /**
                     * filePath
                     */
                    '%s%s/%s',
                    /**
                     * Current scanning directory
                     */
                    $checkDirectory,
                    /**
                     * Extension name
                     */
                    $extensionName,
                    /**
                     * Check for the filename
                     */
                    $fileName
                );

                /**
                 * Check if there is a file at the file path
                 */
                if (file_exists($filePath)) {
                    /**
                     * Load information about the module
                     */
                    return $filePath;
                }
            }
        }

        /**
         * Nothing found, return false.
         */
        return false;
    }

    /**
     * extension information
     *
     * @param $ofExtensionPath
     * @return mixed
     */
    public function information($ofExtensionPath, $deep = false)
    {
        /**
         * Checks if the path exists
         */
        if (!file_exists($ofExtensionPath)) {
            /**
             * Check if we have found the path.
             */
            if ($this->getExtensionPath($ofExtensionPath) !== false) {
                /**
                 * Checks if we had already searched
                 */
                if ($deep) {
                    /**
                     * Yes, we did, and now we're not searching again.
                     */
                    return;
                }

                /**
                 * Load the information about a Extension
                 */
                return $this->information(
                    /**
                     * Get the extension path
                     */
                    $this->getExtensionPath($ofExtensionPath),
                    /**
                     * Say that we already searched
                     */
                    true
                );
            }

            /**
             * File does not exists.
             */
            echo "Unknown file ($ofExtensionPath).";

            /**
             * return, don't run more from this function
             */
            return;
        }

        /**
         * Return parseInformation(aboutthisextension)
         */
        return $this->parseInformation($ofExtensionPath);
    }

    /**
     * Does expressions match?
     *
     * @param $exp1
     * @param $exp2
     * @return bool
     */
    private function match($exp1, $exp2)
    {
        /**
         * Fixed expression (1)
         * @var string
         */
        $fixedExpression = $exp1;

        /**
         * If expression (1) starts with a space ' '
         */
        if (substr($fixedExpression, 0, 1) === ' ') {
            /**
             * Ignore the first whitespace
             */
            $fixedExpression = substr($fixedExpression, 1);
        }

        /**
         * Return, if they match!
         */
        return (
            substr($fixedExpression, 0, strlen($exp2)) == $exp2
        );
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

        /**
         * Create an array for the extension information
         * @var array
         */
        $extensionInfo = array();

        /**
         * Check if the file exists
         */
        if (file_exists($ofExtensionFilePath)) {
            /**
             * Load the contents
             * @var string
             */
            $fileContents = file_get_contents($ofExtensionFilePath);

            /**
             * Check if there is any content
             */
            if (!empty($fileContents)) {
                /**
                 * Check for the end of the comment string.
                 * And pick the contents before the end.
                 * @var string
                 */
                $fileExploded = explode('*/', $fileContents)[0];

                /**
                 * Check for the begin of the comment string.
                 * And pick the contents after the begin.
                 * @var string
                 */
                $fileExploded = explode('/*', $fileExploded)[1];

                /**
                 * Explode newlines
                 * @var [string]
                 */
                $fileExploded = explode(PHP_EOL, $fileExploded);

                /**
                 * Loop trough the information dictionary.
                 */
                foreach ($fileExploded as $informationDict) {
                    /**
                     * Checks if the information matches the information we'll search for.
                     * And the length is more then 3 characters.
                     */
                    if ($this->match($informationDict, "* ") && strlen($informationDict) > 3) {
                        /**
                         * Explode the information
                         * @var [string]
                         */
                        $exploded = explode(": ", $informationDict);

                        /**
                         * Checks if the information exists
                         */
                        if (!isset($exploded[1])) {
                            /**
                             * Nope, continue with a new value.
                             */
                            continue;
                        }

                        /**
                         * Explode the information to a safe name
                         * ' * '
                         * @var [string]
                         */
                        $safeName = explode(' * ', $exploded[0])[1];

                        /**
                         * replace the information to a safe name ' ' to '_'
                         * @var string
                         */
                        $safeName = preg_replace('/ /', '_', $safeName);

                        /**
                         * replace the information to a safe name ':' to '_'
                         * @var string
                         */
                        $safeName = preg_replace('/:/', '_', $safeName);

                        /**
                         * lowercase the string
                         * @var string
                         */
                        $safeName = strtolower($safeName);

                        /**
                         * Append information to array
                         */
                        $extensionInfo[$safeName] = $exploded[1];
                    }
                }

                /**
                 * Return extension information
                 */
                return $extensionInfo;
            } else {
                /**
                 * There was an error with reading the file
                 */
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
        $this->log("Force reloading extensions");
        /**
         * Unset extension list
         */
        unset($this->extensionList);

        /**
         * create empty extension list
         */
        $this->extensionList = array();

        /**
         * Unset loaded extension list
         */
        unset($this->loadExtensions);

        /**
         * create empty loaded extension list
         */
        $this->loadExtensions = array();

        /**
         * Checks if we can remove the cache database
         */
        if (!unlink($this->cacheDB)) {
            /**
             * Failed to remove cache database
             */
            exit('Failed to remove database');
        }

        /**
         * Trigger a force reload.
         */
        $this->reloadExtensions('FORCE SAVE, EXTENSION DATABASE RESET');

        /**
         * Disable save on exit
         * @var boolean
         */
        $this->saveOnExit = false;

        /**
         * Touch (if not exists) a new lockfile
         */
        @touch($this->lockFile);
    }

    /**
     * reload extensions
     *
     * @param $message message 'Default rescan.'
     */
    private function reloadExtensions($message = 'Default rescan.')
    {
        /**
         * Create an empty loaded extension array
         * @var [string]
         */
        $this->loadExtensions = array();

        /**
         * Create an empty extension array
         * @var [string]
         */
        $this->extensionList = array();

        /**
         * Walk trough the directories
         */
        foreach ($this->scan_directories as $readDirectory) {
            /**
             * Checks if the file exists, and is readable.
             */
            if (file_exists($readDirectory) && is_readable($readDirectory)) {
                /**
                 * Open the directory
                 * @var [string]
                 */
                $_d = opendir($readDirectory);

                /**
                 * Read the directory contents
                 * @var string
                 */
                while (($current = readdir($_d)) !== false) {
                    /**
                     * Checks if the file is a directory, and not this directory, and not the parent directory.
                     */
                    if ($current != '.' && /* File is not '.' this directory */
                        $current != '..' && /* File is not '..' this directory */
                        is_dir($readDirectory . $current) /* File an directory */
                    ) {
                        /**
                         * Walk trough the possible file extensions.
                         */
                        foreach ($this->load_files as $tryFile) {
                            /**
                             * Check if the file exists
                             */
                            if (file_exists($readDirectory . $current . '/' . $tryFile)) {
                                /**
                                 * Checks if the file is not already loaded.
                                 */
                                if (!in_array($readDirectory . $current . '/' . $tryFile, $this->loadExtensions)) {
                                    /**
                                     * Checks if the file is a system extension
                                     */
                                    if (in_array($current, $this->systemExtensions)) {
                                        /**
                                         * Force load it, it is a system extension
                                         */
                                        $this->loadExtensions[] = $readDirectory . $current . '/' . $tryFile;
                                    }

                                    /**
                                     * It's a extension, append it to the extensionlist
                                     */
                                    $this->extensionList[] = $readDirectory . $current . '/' . $tryFile;

                                    /**
                                     * Load the extension
                                     */
                                    require_once $readDirectory . $current . '/' . $tryFile;
                                }
                            }
                        }
                    }
                }
            }
        }

        if (sizeof($this->loadExtensions) < 5) {
            exit("WARNING: Extensions system corrupted.");
        }

        /**
         * Save the database!
         */
        $this->saveDatabase($message);
    }

    /**
     * save database
     *
     * @param $message message
     * @return null
     */
    private function saveDatabase($message = 'Default save action on exit')
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
