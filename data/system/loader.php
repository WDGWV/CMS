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
 * Define System directory
 */
define('CMS_SYSTEM_DIR', './data/system/');

/**
 * Define Template directory
 */
define('CMS_TEMPLATE_DIR', './data/themes/');

/**
 * Define Controleers directory
 */
define('CMS_CONTROLLERS_DIR', './data/controllers/');

/**
 * Define Compatibility directory
 */
define('CMS_COMPATIBILITY_DIR', './data/compatibility/');

/**
 * Define Database Controllers directory
 */
define('CMS_DBCONTROLLERS_DIR', './data/controllers/databases/');

/**
 * Load up the main class
 */
require_once CMS_SYSTEM_DIR . 'WDGWV.php';

/**
 * Load the configuration
 */
require_once CMS_SYSTEM_DIR . 'CMSConfig.php';

/**
 * Initialize the configuration
 * @param $_config class The configuration class
 */
$_config = new WDGWV\CMS\Config();

/**
 * Load the debugger
 */
require_once CMS_SYSTEM_DIR . 'Debugger.php';

/**
 * Initialize the debugger
 * @param $debugger class The debugger class
 */
$debugger = \WDGWV\CMS\Debugger::sharedInstance();

/**
 * Load the installer
 */
require_once CMS_SYSTEM_DIR . 'Installer.php';

/**
 * Initialize the installer
 * @param $installer class The installer class
 */
$installer = \WDGWV\CMS\Installer::sharedInstance();

/**
 * Load the Base Controller?
 */
require_once CMS_CONTROLLERS_DIR . 'base.php';

/**
 * Load the Database Controller
 */
require_once CMS_CONTROLLERS_DIR . 'database.php';

/**
 * Load the Plain Text Database Controller
 */
require_once CMS_DBCONTROLLERS_DIR . 'plainTextDatabase.php';

/**
 * Load the SQLite Database Controller
 */
require_once CMS_DBCONTROLLERS_DIR . 'SQLiteDatabase.php';

/**
 * Load the MySQL Database Controller
 */
require_once CMS_DBCONTROLLERS_DIR . 'MySQLdatabase.php';

/**
 * Load the templateparser
 */
require_once CMS_SYSTEM_DIR . 'templateParser.php';

/**
 * Load the MySQL Class (old one)
 */
require_once CMS_SYSTEM_DIR . 'MySQL.php';

/**
 * Load Emulation class for Blogger support
 */
require_once CMS_COMPATIBILITY_DIR . 'blogger.php';

/**
 * Load Emulation class for WordPress support
 */
require_once CMS_COMPATIBILITY_DIR . 'wordpress.php';

/**
 * Load the Base Controller
 */
require_once CMS_CONTROLLERS_DIR . 'base.php';

/**
 * Load the API Controller
 */
require_once CMS_CONTROLLERS_DIR . 'APIController.php';

/**
 * Load the Content Controller
 */
require_once CMS_CONTROLLERS_DIR . 'ContentController.php';

/**
 * Load the Future Controller (experimental features)
 */
require_once CMS_CONTROLLERS_DIR . 'FutureController.php';

/**
 * Load the Layout Controller
 */
require_once CMS_CONTROLLERS_DIR . 'LayoutController.php';

/**
 * Load the Menu Controller
 */
require_once CMS_CONTROLLERS_DIR . 'MenuController.php';

/**
 * Load the User Controller
 */
require_once CMS_CONTROLLERS_DIR . 'UserController.php';

/**
 * Load the Page Controller
 */
require_once CMS_CONTROLLERS_DIR . 'pageController.php';

/**
 * Load the Shop Controller
 */
require_once CMS_CONTROLLERS_DIR . 'ShopController.php';

/**
 * Load the CMS Class (System)
 */
require_once CMS_SYSTEM_DIR . 'WDGWV_Cms.php';
$database = \WDGWV\CMS\controllers\databases\plainText::sharedInstance();
$CMS = new WDGWV\CMS\base($_config);

// TEMPORARY
// TODO: REMOVE ME!!!
$database->userRegister('wdg', 'test', 'wes@vista.aero', array('userLevel' => 100, 'is_admin' => true));
if ($database->userLogin('wdg', 'test')) {
	$_SESSION['CMS_USER_LOGIN'] = 'Wes';
	$_SESSION['SITE_TITLE'] = 'WDGWV';
} else {
	echo "Password Incorrect";
}
//$pageTitle, $pageContents, $pageKeywords, $pageOptions = array(), $pageID = 0

$database->createPage('home', 'Welcome at the homepage!', 'Welcome,WDGWV,CMS', array('user' => 0));
$database->createPage('about', '
<h1>Welcome to WDGWV CMS</h1>
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
?>