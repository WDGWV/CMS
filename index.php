<?php /** This is the /index.php file for WDGWV CMS. */

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

/**
 * Set the namespace to WDGWV\CMS
 */
namespace WDGWV\CMS;

/**
 * Set error reporting to E_ALL
 */
error_reporting(E_ALL);

/**
 * CMS Start time
 * @var int time in microseconds
 */
$CMSStartTime = microtime(true);

/**
 * Check if loader is present, otherwise fail with error(1)
 */
if (file_exists('./Data/WDGWV/CMS/Loader.php') &&
    is_readable('./Data/WDGWV/CMS/Loader.php')) {
    /**
     * Include the class loader.
     */
    include_once './Data/WDGWV/CMS/Loader.php';
} else {
    /**
     * File not found, exit(1).
     */
    trigger_error('Loader class un-loadable.', E_USER_ERROR);
    exit(1);
}

/**
 * Check if the CMS is installed.
 */
if (Installer::shared()->isInstalled()) {
    /**
     * If the CMS is installed, then serve.
     */
    Base::shared()->serve();
} else {
    /**
     * Check for a 'offline' install file.
     */
    if (Installer::shared()->canOfflineInstall()) {
        /**
         * Install 'offline'
         */
        Installer::shared()->beginOfflineInstall();
    } else {
        /**
         * Install 'online'
         */
        Installer::shared()->beginOnlineInstall();
    }
}

/**
 * If debugmode is on, then debug.
 */
if (Config::shared()->debug()) {
    echo "<hr>";
    $debugger->log(
        array(
            "Hooks" => Hooks::shared()->dumpDatabase(),
        )
    );
    $debugger->logdump();
    echo "<hr>";
    $debugger->dumpAllClasses();
}

/**
 * CMS End time
 * @var int time in microseconds
 */
$CMSEndTime = microtime(true);

/**
 * If in debug mode, then say "Generated this page in 000μs."
 */
if (Config::shared()->debug()) {
    /**
     * Output "Generated this page in ...μs."
     */
    echo sprintf("Generated this page in %.2fμs.", ($CMSEndTime - $CMSStartTime));
}
