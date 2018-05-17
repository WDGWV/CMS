<?php
/** Loader
 *
 * Loads everything you'll ever need.
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

/**
 * Autoload WDGWV CMS class
 * @param  string $class The class name
 * @return void
 */
function autloadWDGWVCMS($class)
{
    /**
     * Replace \ to /
     * @var string
     */
    $fileName = str_replace('\\', '/', $class);

    /**
     * sprintf ./Data/$filename.php
     * @var string
     */
    $fileName = sprintf('./Data/%s.php', $fileName);

    /**
     * Check if the file exists, otherwise fail.
     */
    if (file_exists($fileName)) {
        /**
         * Load $class.
         */
        require_once $fileName;
    } else {
        /**
         * Check if the $class is using a namespace, otherwise, ignore
         */
        if (sizeof(explode('\\', $class)) > 1) {
            /**
             * Show the error
             */
            echo "<b>WARNING</b><br />";
            echo "Couldn't load class <b>{$class}</b> the required file is missing!<br />";
            echo "Attempted to load: {$fileName}<hr />";

            /**
             * debug_print_backtrace, show debug logs
             */
            echo "<pre>";
            debug_print_backtrace();
            echo "</pre>";

            /**
             * Exit with error (1)
             */
            exit(1);
        }
    }

    /**
     * return, becouse the class is loaded, and we don't need to do anything anymore.
     */
    return;
}

/**
 * Add class to spl autload register
 */
spl_autoload_register('autloadWDGWVCMS');

/**
 * Define Template directory
 */
define('CMS_TEMPLATE_DIR', './Data/Themes/');

/**
 * Initialize the configuration
 * @param $_config class The configuration class
 */
$_config = new WDGWV\CMS\Config();

/**
 * Initialize the debugger
 * @param $debugger class The debugger class
 */
$debugger = \WDGWV\CMS\Debugger::sharedInstance();

/**
 * Initialize the hooks system
 * @param $hooks the hooks system
 */
$hooks = \WDGWV\CMS\Hooks::sharedInstance();

/**
 * Initialize the extensions system
 * @param $extensions the extensions system
 */
$extensions = \WDGWV\CMS\Extensions::sharedInstance();

/**
 * Initialize the installer
 * @param $installer class The installer class
 */
$installer = \WDGWV\CMS\Installer::sharedInstance();

/**
 * Initialize the database
 * @param $database class The database class
 */
$database = \WDGWV\CMS\Controllers\Databases\Controller::sharedInstance();

//TODO: REMOVE ME
$hooks->createHook(
    'url',
    '/themeSet/portal',
    array(
        \WDGWV\CMS\Controllers\Databases\Controller::sharedInstance(),
        'themeSet',
    ),
    array(
        'portal',
    )
);

//TODO: REMOVE ME
$hooks->createHook(
    'url',
    '/themeSet/admin',
    array(
        \WDGWV\CMS\Controllers\Databases\Controller::sharedInstance(),
        'themeSet',
    ),
    array(
        'admin',
    )
);

/**
 * Initialize the CMS
 * @param $CMS class The CMS class
 */
$CMS = \WDGWV\CMS\Base::sharedInstance();

// TODO: REMOVE ME!!!
$regi = $database->userRegister('wdg', 'test', 'wes@vista.aero', array('userlevel' => 'admin', 'is_admin' => true));
// echo ($regi) ? 'Created user' : 'Failed to create';
if ($regi) {
    if ($database->userLogin('wdg', 'test')) {
        $_SESSION['CMS_USER_LOGIN'] = 'Wes';
        $_SESSION['SITE_TITLE'] = 'WDGWV';
    } else {
        echo "Password Incorrect";
    }
}
//$pageTitle, $pageContents, $pageKeywords, $pageOptions = array(), $pageID = 0

// TODO: REMOVE ME!!!
$database->pageCreate('Home', 'Welcome at the homepage!', 'Welcome,WDGWV,CMS', array('user' => 0));

// TODO: REMOVE ME!!!
$database->pageCreate('About', '<h1>Welcome to WDGWV CMS</h1>
Some stats:<br />
<script type="text/javascript" src="http://www.ohloh.net/p/642938/widgets/project_factoids_stats.js"></script>
<br />
<script type="text/javascript" src="http://www.ohloh.net/p/642938/widgets/project_users.js?style=blue"></script>
<br /><br />
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- ONDERAAN -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-5555094756467155"
     data-ad-slot="1975252506"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>', 'WDGWV,CMS', array('user' => 0));
// /TEMPORARY

/**
 * If in debug mode, hook debugger to the installer.
 */
if ($_config->debug) {
    /**
     * Hook debugger to installer.
     */
    $installer->setDebugger($debugger);
}

/**
 * Relase $_config before continue...
 */
unset($_config);
