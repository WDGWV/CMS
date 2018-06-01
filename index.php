<?php
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
if (Installer::sharedInstance()->isInstalled()) {
    /**
     * If the CMS is installed, then serve.
     */
    Base::sharedInstance()->serve();
} else {
    /**
     * Check for a 'offline' install file.
     */
    if (Installer::sharedInstance()->canOfflineInstall()) {
        /**
         * Install 'offline'
         */
        Installer::sharedInstance()->beginOfflineInstall();
    } else {
        /**
         * Install 'online'
         */
        Installer::sharedInstance()->beginOnlineInstall();
    }
}

/**
 * If debugmode is on, then debug.
 */
if (Config::sharedInstance()->debug()) {
    echo "<hr>";
    $debugger->log(
        array(
            "Hooks" => Hooks::sharedInstance()->dumpDatabase(),
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
if (Config::sharedInstance()->debug()) {
    echo sprintf("Generated this page in %.2fμs.", ($CMSEndTime - $CMSStartTime));
}
