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

function autloadWDGWVCMS($class)
{
    $fileName = str_replace('\\', '/', $class);
    $fileName = sprintf('./Data/%s.php', $fileName);

    if (file_exists($fileName)) {
        require_once $fileName;
    } else {
        if (sizeof(explode('\\', $class)) > 1) {
            echo "<b>WARNING</b><br />";
            echo "Couldn't load class <b>{$class}</b> the required file is missing!<br />";
            echo "Attempted to load: {$fileName}<hr />";

            echo "<pre>";
            debug_print_backtrace();
            echo "</pre>";

            exit(1); // Exit with error
        }
    }

    return;
}

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
    '/setTheme/portal',
    array(
        \WDGWV\CMS\Controllers\Databases\Controller::sharedInstance(),
        'setTheme',
    ),
    array(
        'portal',
    )
);

//TODO: REMOVE ME
$hooks->createHook(
    'url',
    '/setTheme/admin',
    array(
        \WDGWV\CMS\Controllers\Databases\Controller::sharedInstance(),
        'setTheme',
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
$database->createPage('Home', 'Welcome at the homepage!', 'Welcome,WDGWV,CMS', array('user' => 0));

// TODO: REMOVE ME!!!
$database->createPage('About', '<h1>Welcome to WDGWV CMS</h1>
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

if ($_config->debug) {
    $installer->setDebugger($debugger);
}

// Relase after continue
unset($_config);
